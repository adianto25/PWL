<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --- PROJECT 2: LOKASI KULINER ---

// Auth Routes
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::login');
$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::register');
$routes->get('logout', 'AuthController::logout');

// Pengunjung (Tanpa Login)
$routes->get('/', 'KulinerController::index');
$routes->get('kuliner', 'KulinerController::index');
$routes->get('kuliner/detail/(:num)', 'KulinerController::detail/$1');

// Kontributor (Login Required)
$routes->group('kontributor', ['filter' => 'auth'], static function ($routes) {
    $routes->get('dashboard', 'KontributorController::index');
    $routes->get('submit', 'KontributorController::submit');
    $routes->post('submit', 'KontributorController::processSubmit');
    $routes->get('geocode', 'KontributorController::geocode');
    $routes->post('review/(:num)', 'KontributorController::postReview/$1');
    $routes->post('review/update/(:num)', 'KontributorController::updateReview/$1');
    $routes->post('favorit/(:num)', 'KontributorController::toggleFavorit/$1');
    $routes->post('tutup/(:num)', 'KontributorController::tandaiTutup/$1');
});

// Admin (Admin Login Required)
$routes->group('admin', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'AdminController::index');
    $routes->post('approve/(:num)', 'AdminController::approve/$1');
    $routes->post('reject/(:num)', 'AdminController::reject/$1');

    // Kategori CRUD
    $routes->get('kategori', 'AdminController::kategori');
    $routes->post('kategori/add', 'AdminController::kategoriAdd');
    $routes->post('kategori/edit/(:num)', 'AdminController::kategoriEdit/$1');
    $routes->get('kategori/delete/(:num)', 'AdminController::kategoriDelete/$1');

    // Tag CRUD
    $routes->get('tag', 'AdminController::tag');
    $routes->post('tag/add', 'AdminController::tagAdd');
    $routes->post('tag/edit/(:num)', 'AdminController::tagEdit/$1');
    $routes->get('tag/delete/(:num)', 'AdminController::tagDelete/$1');

    // Tempat CRUD tambahan
    $routes->get('tempat/delete/(:num)', 'AdminController::tempatDelete/$1');
    $routes->get('tempat/edit/(:num)', 'AdminController::tempatEdit/$1');
    $routes->post('tempat/update/(:num)', 'AdminController::tempatUpdate/$1');

    // Moderasi Review
    $routes->get('review/delete/(:num)', 'AdminController::reviewDelete/$1');
});

// Webservice API
$routes->get('api/kuliner', 'Api\KulinerController::index');
