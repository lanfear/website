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
class PhotosController extends AppController {

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
    
    public function index() {
        $this->set(array(
            'galleries' => $this->GetGalleryFolders(),
            '_serialize' => array('galleries')
        ));
    }

    public function view($id) {
        
        $gallery = $this->GetGallery($id);
        $this->set(array(
            'gallery' => $gallery,
            '_serialize' => array('gallery')
        ));
    }
   
    public function image() {
        //if ($this->RequestHandler->accepts('image/jpeg', 'image/png'))
        {
            $path_pics = "/media/pics/PERSONAL/";
            $img_path = "$path_pics{$this->request->params['collection']}/{$this->request->params['image']}";
            $this->response->file($img_path);
            return $this->response;
        }
    }

    public function tn() {
        $path_pics = "/net/council/home/www/dev/cake/api/media/pics/PERSONAL/";
        $uri_pics = "photos/";
        $img_path = "$path_pics{$this->request->params['collection']}/{$this->request->params['image']}";
        return $this->CreateTN($img_path, 200, 200);
    }
    
    public function tnlarge() {
        $path_pics = "/net/council/home/www/dev/cake/api/media/pics/PERSONAL/";
        $uri_pics = "photos/";
        $img_path = "$path_pics{$this->request->params['collection']}/{$this->request->params['image']}";
        return $this->CreateTN($img_path, 1024, 1024);
    }
    
    public function info() {
        //if ($this->RequestHandler->accepts('image/jpeg', 'image/png'))
        {
            $path_pics = "/net/council/home/www/dev/cake/api/media/pics/PERSONAL/";
            $img_path = "$path_pics{$this->request->params['collection']}/{$this->request->params['image']}";
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

    private function GetGalleryFolders() {
        $path_pics = "/net/council/home/www/dev/cake/api/media/pics/PERSONAL";
        $href_gallery_base = "/api/photos";
        
        $dirArray = self::ReadFiles($path_pics, $href_gallery_base, "self::AlphaAsc");

        return($dirArray);
    }
    
    private function GetGallery($id) {
        $ary_blocked = array("2009-08", "2009-07");
        $ary_allowedexts = array("jpg", "jpeg", "gif", "png");
        
        if (in_array("$id", $ary_blocked)) {
          print("NOT DECLASSIFIED");
          return;
        }
        
        $dirArray = [];
        $href_pics_baseshort = "/api/photos/$id";
		$href_siteurl = "http://dev.josephdeming.net/cake";
        $path_pics = "/net/council/home/www/dev/cake/api/media/pics/PERSONAL/$id/";
        
        if ($id != "") {
			$filter = '/\.jpeg$|\.jpg$|\.gif$|\.png$/i';
            $dirArray = self::ReadFiles($path_pics, $href_pics_baseshort, "self::AlphaAsc", $filter);
            
            foreach($dirArray as &$file) {
                $rel_path = $file['uri'];
                $tn_path = "$rel_path/tn";
                $tn_large_path = $tn_path . 'large';
                $info_path = "$rel_path/info";
                $full_path = "$href_siteurl$rel_path";
                $full_tn_path = "$href_siteurl$tn_path";
                $full_tn_large_path = "$href_siteurl$tn_large_path";
                $full_info_path = "$href_siteurl$info_path";
                $file = array_merge($file, ['uritn' => $tn_path,
								            'uritnlarge' => $tn_large_path,
								            'uriinfo' => $info_path,
								            'url' => $full_path,
								            'urltn' => $full_tn_path,
								            'urltnlarge' => $full_tn_large_path,
								            'urlinfo' => $full_info_path ]);
            }
	    }
        
        return $dirArray;
    }

}
