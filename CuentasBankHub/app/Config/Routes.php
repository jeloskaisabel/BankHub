<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('testdb', 'TestDB::index');
$routes->get('cuentas', 'CuentasController::index');
$routes->get('cuentas/eliminar/(:num)', 'CuentasController::eliminar/$1');
