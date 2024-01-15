<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */
session_start();
/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/Core/Validation.php';
require_once dirname(__DIR__) . '/Core/CheckSession.php';
/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{id:\d+}');

$router->dispatch($_SERVER['QUERY_STRING']);
