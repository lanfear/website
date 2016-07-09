<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 */

/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
	Router::connect('/', array('controller' => 'pages', 'action' => 'display', 'home'));
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
	//Router::connect('/pages/*', array('controller' => 'pages', 'action' => 'display'));
/**
 * my custom
 */
	Router::connect(
           '/photos/:collection/:image/tnlarge',
           ['controller' => 'photos', 'action' => 'tnlarge'],
           ['collection' => '[^\\/]+', 'image' => '[^\\/]+']
        );
	Router::connect(
           '/photos/:collection/:image/tn',
           ['controller' => 'photos', 'action' => 'tn'],
           ['collection' => '[^\\/]+', 'image' => '[^\\/]+']
        );
	Router::connect(
           '/photos/:collection/:image/info',
           ['controller' => 'photos', 'action' => 'info'],
           ['collection' => '[^\\/]+', 'image' => '[^\\/]+']
        );
 	Router::connect(
            '/photos/:collection/:image',
            ['controller' => 'photos', 'action' => 'image'],
            ['collection' => '[^\\/]+', 'image' => '[^\\/]+']
        );

	Router::connect(
           '/music/complete/tnlarge/:artist/:release',
           ['controller' => 'music', 'action' => 'tnlarge'],
           ['artist' => '[^\\/]+', 'release' => '[^\\/]+']
        );
	Router::connect(
           '/music/complete/tn/:artist/:release',
           ['controller' => 'music', 'action' => 'tn'],
           ['artist' => '[^\\/]+', 'release' => '[^\\/]+']
        );
 	Router::connect(
            '/music/complete/:artist/:release/:file',
            ['controller' => 'music', 'action' => 'file'],
            ['artist' => '[^\\/]+', 'release' => '[^\\/]+', 'file' => '[^\\/]+']
        );
	Router::connect(
           '/music/complete/info/:artist/:release',
           ['controller' => 'music', 'action' => 'info'],
           ['artist' => '[^\\/]+', 'release' => '[^\\/]+']
        );
        
 	Router::connect(
            '/search/:keyword',
            ['controller' => 'search', 'action' => 'search'],
            ['keyword' => '[^\\/]+']
        );
        
 	Router::connect(
            '/tv/cache',
            ['controller' => 'media', 'action' => 'cachetv'],
            []
        );
        
 	Router::connect(
            '/tv/:collection',
            ['controller' => 'media', 'action' => 'tvcollection'],
            ['collection' => '[^\\/]+']
        );
        
 	Router::connect(
            '/tv',
            ['controller' => 'media', 'action' => 'tvcollections', '[method]' => 'POST'],
            ['collection' => '[^\\/]+']
        );
        
    Router::connect(
            '/tv/:endpoint',
            ['controller' => 'media', 'action' => 'file'],
            ['endpoint' => '.*']
        );
        
 	Router::connect(
            '/tv',
            ['controller' => 'media', 'action' => 'tv'],
            []
        );
    
 	Router::connect(
            '/music/complete/:artist/:release',
            ['controller' => 'music', 'action' => 'release'],
            ['artist' => '[^\\/]+', 'release' => '[^\\/]+']
        );
        
 	Router::connect(
            '/music/complete/:artist',
            ['controller' => 'music', 'action' => 'artist'],
            ['artist' => '[^\\/]+']
        );
        
  	Router::connect(
             '/blog/',
             ['controller' => 'blog', 'action' => 'index'],
             []
         );

   Router::resourceMap(array(
        array('action' => 'index', 'method' => 'GET', 'id' => false),
        array('action' => 'view', 'method' => 'GET', 'id' => true),
        array('action' => 'add', 'method' => 'POST', 'id' => false),
        array('action' => 'edit', 'method' => 'PUT', 'id' => true),
        array('action' => 'delete', 'method' => 'DELETE', 'id' => true),
        array('action' => 'update', 'method' => 'POST', 'id' => true)
    ));
    Router::mapResources('photos', ['id' => '[^\\/]+']);
    Router::mapResources('music', ['id' => '[^\\/]+']);
    Router::mapResources('media', ['id' => '[^\\/]+']);
    Router::parseExtensions('json');


        Router::connect('/pages/:action', array('controller' => 'pages'));
/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
