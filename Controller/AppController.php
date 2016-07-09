<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

App::import('Services', 'AuthService');

session_start();

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
    protected $authenticator;
    
    public function beforeFilter() {
        $authenticator = new AuthService();
        $authenticator->CheckLogin();
        $this->authenticator = $authenticator;
        $this->set('authenticator', $authenticator);
    }
    
    protected function IsAuthorized() {
		if (!$this->authenticator->IsAuthorized()) {
			$this->response->statusCode(401);
			$this->set('_serialize', array());
            return false;
		}
        return true;
    }
}
