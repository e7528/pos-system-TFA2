<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Landing & About Pages
$routes->get('/', 'Pages::index');
$routes->get('about', 'Pages::about');

// MySQL-Backed Account Listing Pages
$routes->get('customers', 'Customers::index');
$routes->get('users', 'Users::index');
