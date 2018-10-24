<?php
use PHPRouter\RouteCollection;
use PHPRouter\Router;
use PHPRouter\Route;

$collection = new RouteCollection();

// example of using a redirect to another route
$collection->attachRoute(
    new Route(
        '/',
        array(
            '_controller' => 'agilman\a2\controller\AccountController::indexAction',
            'methods' => 'GET',
            'name' => 'home'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/welcome',
        array(
            '_controller' => 'agilman\a2\controller\HomeController::indexAction',
            'methods' => 'GET',
            'name' => 'welcome'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/search',
        array(
            '_controller' => 'agilman\a2\controller\HomeController::searchIndexAction',
            'methods' => 'GET',
            'name' => 'search'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/browse',
        array(
            '_controller' => 'agilman\a2\controller\HomeController::browseIndexAction',
            'methods' => 'GET',
            'name' => 'browse'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/register',
        array(
            '_controller' => 'agilman\a2\controller\AccountController::registerAction',
            'methods' => 'GET',
            'name' => 'accountCreate'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/create/complete',
        array(
        '_controller' => 'agilman\a2\controller\AccountController::createAction',
        'methods' => 'POST',
        'name' => 'accountCreated'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/account/home/',
        array(
            '_controller' => 'agilman\a2\controller\AccountController::loginAction',
            'methods' => 'POST',
            'name' => 'loginAttempt'
        )
    )
);


$collection->attachRoute(
    new Route(
        '/logout',
        array(
            '_controller' => 'agilman\a2\controller\AccountController::logoutAction',
            'methods' => 'GET',
            'name' => 'logout'
        )
    )
);


$collection->attachRoute(
    new Route(
        '/livesearch.php',
        array(
            '_controller' => 'agilman\a2\controller\SearchController::liveSearchAction',
            'methods' => 'GET',
            'name' => 'liveSearch'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/registrationValidation.php',
        array(
            '_controller' => 'agilman\a2\controller\HomeController::registrationAction',
            'methods' => 'GET',
            'name' => 'registration'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/browseQuery.php',
        array(
            '_controller' => 'agilman\a2\controller\BrowseController::browseAction',
            'methods' => 'GET',
            'name' => 'browseQuery'
        )
    )
);

$collection->attachRoute(
    new Route(
        '/error',
        array(
            '_controller' => 'agilman\a2\controller\HomeController::errorAction',
            'methods' => 'GET',
            'name' => 'error'
        )
    )
);

$router = new Router($collection);
$router->setBasePath('/');
