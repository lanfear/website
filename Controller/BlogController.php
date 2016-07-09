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

App::import('Services', 'DrupalService');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class BlogController extends AppController {

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
    public $components = array('RequestHandler');
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
		if (!$this->IsAuthorized()) return;

// THIS IS WORKING, COMMENTED OUT NOT TO EXPOSE
//        $this->set(array(
//            'results' => DrupalService::$field_data_body,
//            '_serialize' => array('results')
//        ));
    }
}
