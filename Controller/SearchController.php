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

App::import('Services', 'CacheService');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class SearchController extends AppController {

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
    
    public function search() {
		if (!$this->IsAuthorized()) return;
        $results = CacheService::Search(strtolower($this->request->params['keyword']));
        $this->set(array(
            'results' => $results,
            '_serialize' => array('results')
        ));
    }
}
