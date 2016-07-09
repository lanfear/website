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
class TemplatesController extends AppController {

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
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			return $this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));

		try {
			$this->render(implode('/', $path));
		} catch (MissingViewException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException();
		}
	}
	
	public function player() {
		// do nothing, view is driven by angular
	}
	public function playlist() {
		// do nothing, view is driven by angular
	}
	public function mainmenuitem() {
		// do nothing, view is driven by angular
	}
	
	public function menulogin() {
		// do nothing, view is driven by angular
	}
	public function menuphotos() {
		// do nothing, view is driven by angular
	}
	public function menumusic() {
		// do nothing, view is driven by angular
	}
	public function menutv() {
		// do nothing, view is driven by angular
	}
	public function menumovies() {
		// do nothing, view is driven by angular
	}
	public function menuplayer() {
		// do nothing, view is driven by angular
	}
	public function menuplaylist() {
		// do nothing, view is driven by angular
	}
	public function contentplayer() {
		// do nothing, view is driven by angular
	}
	public function contentplaylist() {
		// do nothing, view is driven by angular
	}
	public function contentslideshow() {
		// do nothing, view is driven by angular
	}
	public function contentphotos() {
		// do nothing, view is driven by angular
	}
	public function contentartists() {
		// do nothing, view is driven by angular
	}
	public function contentreleases() {
		// do nothing, view is driven by angular
	}
	public function contenttv() {
		// do nothing, view is driven by angular
	}
	public function contentmovies() {
		// do nothing, view is driven by angular
	}
}
