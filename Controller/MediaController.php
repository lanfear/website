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

App::import('Services', 'FileService');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MediaController extends AppController {

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
    
    public function beforeFilter(){
        if ($this->request->accepts('application/xml')) {
            $this->RequestHandler->renderAs($this, 'xml');
        } else {
            $this->RequestHandler->renderAs($this, 'json');
        }
        parent::beforeFilter();
    } 
    
    public function tv() {
        $this->set(array(
            'collections' => $this->GetTvLibrary(),
            '_serialize' => array('collections')
        ));
    }
    
    public function cachetv() {
        $tv_paths = $this->RReadFiles(PATHBASE::TV, APIBASE::TV);
		$cache_search = $this->GetCacheProvider(CACHEDBS::$SEARCH);
		$cache_files = $this->GetCacheProvider(CACHEDBS::$FILES);
		foreach($tv_paths as $tv_path) {
			$rel_path = preg_replace("/\/api\/tv\//", "", $tv_path['uri']);
			$path_parts = preg_replace("/\..*$/", "", $rel_path);
			$path_parts = preg_split('/\/| - /', $path_parts);
			$key = $this->GetCacheKey('tv', $tv_path['uri'], $tv_path['name']);
			$cache_search->set(strtolower(implode(' ', $path_parts)), $key);
			$cache_files->set($key, "{$this->fullpath_tv}/$rel_path");
		}
    }
	
	public function tvcollection() {
		$tv_paths = $this->RReadFiles(PATHBASE::TV . '/' . $this->request->params['collection'], APIBASE::TV);
        $this->set(array(
            'collection' => $tv_paths,
            '_serialize' => array('collection')
        ));
	}
	
	public function tvcollections() {
		$paths = $this->request->input('json_decode');
		$retinfo = [];
		foreach ($paths as $path) {
			$retItem = FileService::FileInfo($path);
			$retItem['url'] = preg_replace('|\Q'.PATHBASE::TV.'\E|', URLBASE::TV, $path);
			$retinfo[] = $retItem;
		}
        $this->set(array(
            'collection' => $retinfo,
            '_serialize' => array('collection')
        ));
	}
	
	public function file() {
		if (!$this->IsAuthorized()) return;
		//if ($this->RequestHandler->accepts('video/mp4'))
        {
			var_dump($this->request->params['endpoint']);
            $path = PATHBASE::TV;
            $fullpath = "$path/{$this->request->params['endpoint']}";
			if (!file_exists($fullpath)) {
				throw new NotFoundException();
			}
            $this->response->file($fullpath);
            return $this->response;
        }
	}	

    /*
    public function view($id) {
        
        $artist_folder = $this->GetArtistReleases($id);
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
    
    */

    private function GetTvLibrary() {
        $relative_tv = "/api/tv";
        
        $dirArray = FileService::ReadFiles(PATHBASE::TV, APIBASE::TV, "self::AlphaAsc");

        return($dirArray);
    }
    
    /*
    
    private function GetArtistReleases($id) {
        $ary_blocked = [];
        $ary_allowedexts = array("jpg", "jpeg", "gif", "png");
        
        if (in_array("$id", $ary_blocked)) {
          print("NOT DECLASSIFIED");
          return;
        }
        
        $dirArray = [];
        $href_short_base = "/api/music/complete";
        $path_artist_folder = "$this->fullpath_music_sorted/$id/";
        $href_siteurl = "http://dev.josephdeming.net/cake";
        $href_music_baseshort = "/api/music/complete/$id";
        $href_short_tn = "$href_short_base/tn/%s/%s";
        $href_short_tnl = "$href_short_base/tnlarge/%s/%s";
        $href_full_tn = "$href_siteurl$href_short_tn";
        $href_full_tnl = "$href_siteurl$href_short_tnl";
        //$href_fullpic_base = "http://www.josephdeming.net/sites/all/pics/PERSONAL/$id/";
        
        if ($id != "") {
            $dirArray = self::ReadFiles($path_artist_folder, $href_music_baseshort, "self::AlphaAsc");
            
            foreach($dirArray as &$file) {
                $rel_path = $file['uri'];
                $tn_path = sprintf($href_short_tn, $id, $file['name']);
                $tn_large_path = sprintf($href_short_tnl, $id, $file['name']);
                $full_path = "$href_siteurl$rel_path";
                $full_tn_path = sprintf($href_full_tn, $id, $file['name']);
                $full_tn_large_path = sprintf($href_full_tnl, $id, $file['name']);
                $file = array_merge($file, ['uritn' => $tn_path,
                                            'uritnlarge' => $tn_large_path,
                                            'url' => $full_path,
                                            'urltn' => $full_tn_path,
                                            'urltnlarge' => $full_tn_large_path]);
            }
        }
        
        return $dirArray;
    }

    private function GetRelease($artist, $release) {
        $ary_blocked = [];
        
        $dirArray = [];
        $href_short_base = "/api/music/complete";
        $path_release_folder = "$this->fullpath_music_sorted/$artist/$release/";
        $href_siteurl = "http://dev.josephdeming.net/cake";
        $href_music_baseshort = "/api/music/complete/$artist/$release";
        
        if ($artist != "" && $release != "") {
            $dirArray = self::ReadFiles($path_release_folder, $href_music_baseshort, "self::AlphaAsc", "/\.mp3$/");
            
            foreach($dirArray as &$file) {
                $file_parts = preg_split("/ - |\.mp3$/", $file['name']);
                $rel_path = $file['uri'];
                $full_path = "$href_siteurl$rel_path";
                $file = array_merge($file, ['url' => $full_path,
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
    */
	
	private static function GetCacheKey($prefix, $base_path, $file_name) {
		return $prefix . '_' . md5($base_path) . '_' . md5($file_name);
	}
}
