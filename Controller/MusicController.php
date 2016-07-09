<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MusicController extends AppController {

    /**
     * This controller does not use a model
     *
     * @var array
     */
	    public $uses = array();
    
    /**
     * Displays a view
     *
     * @return void
     * @throws NotFoundException When the view file could not be found
     *   or MissingViewException in debug mode.
     */
    public $components = array('RequestHandler', 'PhpThumb.PhpThumb');
    public $helpers = array('Html');
	
    private $fullpath_music_sorted = "/net/council/home/www/dev/cake/api/media/music/tagged_complete";

    public function beforeFilter(){
		if ($this->request->accepts('application/xml')) {
			$this->RequestHandler->renderAs($this, 'xml');
		} else {
			$this->RequestHandler->renderAs($this, 'json');
		}
		parent::beforeFilter();
    } 
    
    public function index() {
        $this->set(array(
            'artists' => $this->GetArtists(),
            '_serialize' => array('artists')
        ));
    }

    public function artist() {
        $artist_folder = $this->GetArtistReleases($this->request->params['artist']);
        $this->set(array(
            'releases' => $artist_folder,
            '_serialize' => array('releases')
        ));
    }
	
	public function release() {
		$release_folder = $this->GetRelease($this->request->params['artist'], $this->request->params['release']);
        $this->set(array(
            'release' => $release_folder,
            '_serialize' => array('release')
        ));
	}
   
    public function image() {
		//if ($this->RequestHandler->accepts('image/jpeg', 'image/png'))
		{
			$path_pics = "/media/pics/PERSONAL/";
			$img_path = "$path_pics{$this->request->params['artist']}/{$this->request->params['release']}";
			$this->response->file($img_path);
			return $this->response;
		}
    }

    public function tn() {
		$not_found_path = "/net/council/home/www/dev/cake/api/webroot/img/not_found.jpg";
		$uri_release = "/api/music/complete/{$this->request->params['artist']}/{$this->request->params['release']}";
		$path_release = "$this->fullpath_music_sorted/{$this->request->params['artist']}/{$this->request->params['release']}";
		$filter = '/\.jpeg$|\.jpg$|\.gif$|\.png$/i';
        $dirArray = self::ReadFiles($path_release, $uri_release, "self::SizeAsc", $filter);
		if (sizeof($dirArray) > 0) {
			return $this->CreateTN($path_release . '/' . $dirArray[0]['name'], 200, 200);
		}
		else {
			return $this->CreateTN($not_found_path, 200, 200);
		}
    }
    
    public function tnlarge() {
		$not_found_path = "/net/council/home/www/dev/cake/api/webroot/img/not_found.jpg";
		$uri_release = "/api/music/complete/{$this->request->params['artist']}/{$this->request->params['release']}";
		$path_release = "$this->fullpath_music_sorted/{$this->request->params['artist']}/{$this->request->params['release']}";
		$filter = '/\.jpeg$|\.jpg$|\.gif$|\.png$/i';
        $dirArray = self::ReadFiles($path_release, $uri_release, "self::SizeAsc", $filter);
		if (sizeof($dirArray) > 0) {
			return $this->CreateTN($path_release . '/' . $dirArray[0]['name'], 400, 400);
		}
		else {
			return $this->CreateTN($not_found_path, 400, 400);
		}
    }
    
    public function info() {
		//if ($this->RequestHandler->accepts('image/jpeg', 'image/png'))
		{
			$img_path = "$this->fullpath_music_sorted{$this->request->params['artist']}/{$this->request->params['release']}";
			$info = new stdClass();
			
			$exif = exif_read_data($img_path, 0, true);
			if ($exif!==false) {
				$info = $exif;
			}
			
			$this->set(array(
				'file' => array_key_exists('FILE', $info) ? $info['FILE'] : null,
				'computed' =>  array_key_exists('COMPUTED', $info) ? $info['COMPUTED'] : null,
				'ifd0' => array_key_exists('IFD0', $info) ? $info['IFD0'] : null,
				'thumbnail' => array_key_exists('THUMBNAIL', $info) ? $info['THUMBNAIL'] : null,
				//'exif' => array_key_exists('EXIF', $info) ? $info['EXIF'] : null,
				'gps' => array_key_exists('GPS', $info) ? $info['GPS'] : null,
				'_serialize' => array('file','computed','ifd0','thumbnail','gps')
			));
		}
    }
	
	public function file() {
		if (!$this->IsAuthorized()) return;
		//if ($this->RequestHandler->accepts('audio/mpeg', 'audio/mpeg3', 'audio/x-mpeg-3', 'audio/mp3'))
        {
            $path = PATHBASE::MUSICCOMPLETE;
            $fullpath = "$path/{$this->request->params['artist']}/{$this->request->params['release']}/{$this->request->params['file']}";
			if (!file_exists($fullpath)) {
				throw new NotFoundException();
			}
            $this->response->file($fullpath);
            return $this->response;
        }
	}

    private function CreateTN($path, $width, $height) {
	$this->PhpThumb->width = $width;
	$this->PhpThumb->height = $height;
	$this->PhpThumb->displayThumbnail($path, true, "path");
	if ($this->PhpThumb->thumbnailIsCreated($path) && $thumb_path = $this->PhpThumb->getThumbnailPath($path)) {
	    $this->response->file($thumb_path);
	    return $this->response;
	}
	return null;
    }

    private function GetArtists() {
        $dirArray = self::ReadFiles(PATHBASE::MUSICCOMPLETE, APIBASE::MUSICCOMPLETE, "self::AlphaAsc");

        return($dirArray);
    }
    
    private function GetArtistReleases($id) {
        $ary_blocked = [];
        $ary_allowedexts = array("jpg", "jpeg", "gif", "png");
        
        if (in_array("$id", $ary_blocked)) {
          print("NOT DECLASSIFIED");
          return;
        }
        
        $dirArray = [];
		$tn_base = "/tn/%s/%s";
		$tnlarge_base = "/tnlarge/%s/%s";
        $path_artist_folder = PATHBASE::MUSICCOMPLETE . "/$id/";
        $href_music_baseshort = APIBASE::MUSICCOMPLETE . "/$id";
		$href_short_tn = APIBASE::MUSICCOMPLETE . $tn_base;
		$href_short_tnl = APIBASE::MUSICCOMPLETE . $tnlarge_base;
		$href_full = URLBASE::MUSICCOMPLETE . '/%s/%s';
		$href_full_tn = URLBASE::MUSICCOMPLETE . $tn_base;
		$href_full_tnl = URLBASE::MUSICCOMPLETE . $tnlarge_base;
        
        if ($id != "") {
            $dirArray = self::ReadFiles($path_artist_folder, $href_music_baseshort, "self::AlphaAsc");
            
            foreach($dirArray as &$file) {
                $file = array_merge($file, ['uritn' => sprintf($href_short_tn, $id, $file['name']),
								            'uritnlarge' => sprintf($href_short_tnl, $id, $file['name']),
								            'url' => sprintf($href_full, $id, $file['name']),
								            'urltn' => sprintf($href_full_tn, $id, $file['name']),
								            'urltnlarge' => sprintf($href_full_tnl, $id, $file['name'])]);
            }
	    }
        
        return $dirArray;
    }

    private function GetRelease($artist, $release) {
        $ary_blocked = [];
        
        $dirArray = [];
        $path_release_folder = PATHBASE::MUSICCOMPLETE . "/$artist/$release/";
        $href_music_baseshort = APIBASE::MUSICCOMPLETE . "/$artist/$release";
		$href_full = URLBASE::MUSICCOMPLETE . "/%s/%s/%s";
        
        if ($artist != "" && $release != "") {
            $dirArray = self::ReadFiles($path_release_folder, $href_music_baseshort, "self::AlphaAsc", "/\.mp3$/");
            
            foreach($dirArray as &$file) {
				$file_parts = preg_split("/ - |\.mp3$/", $file['name']);
                $file = array_merge($file, ['url' => sprintf($href_full, $artist, $release, $file['name']),
											'tracknum' => $file_parts[0],
											'trackname' => $file_parts[sizeof($file_parts)-2]
											]);
            }
	    }
        
        return $dirArray;
    }

    private static function FolderCompare($r, $l) {
            return strcmp($r['name'], $l['name']);
    }
}
