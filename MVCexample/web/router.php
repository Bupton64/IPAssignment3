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
        '/account/create/',
        array(
        '_controller' => 'agilman\a2\controller\AccountController::createAction',
        'methods' => 'GET',
        'name' => 'accountCreate'
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

$router = new Router($collection);
$router->setBasePath('/');
