<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
//student
$routes->post('validateUser','Home::validateUser');
$routes->post('new-password','Home::newPassword');
$routes->get('logout','Home::logout');

$routes->group('',['filter'=>'AlreadyLoggedIn'],function($routes)
{
    $routes->get('/', 'Home::index');
    $routes->get('forgot-password', 'Home::forgotPassword');
});

$routes->group('',['filter'=>'AuthCheck'],function($routes)
{
    $routes->get('cadet/dashboard','Home::studentDashboard');
});

//admin
$routes->post('checkAuth','Administrator::checkAuth');
$routes->get('sign-out','Administrator::logout');
$routes->get('download','Download::downloadFile');
$routes->post('restore','Restore::restoreFile');
//ajax
$routes->get('fetch-account','Administrator::fetchAccount');
$routes->post('save-account','Administrator::saveAccount');
$routes->post('save-cadet','Administrator::saveCadet');

$routes->group('',['filter'=>'AdminCheck'],function($routes)
{
    $routes->get('dashboard','Administrator::index');
    $routes->get('cadet-information','Administrator::cadetInformation');
    $routes->get('cadet/view/(:any)','Administrator::cadetView/$1');
    $routes->get('training-schedule','Administrator::trainingSchedule');
    $routes->get('attendance','Administrator::attendance');
    $routes->get('announcement','Administrator::announcement');
    $routes->get('accounts','Administrator::accounts');
    $routes->get('create-account','Administrator::createAccount');
    $routes->get('register','Administrator::register');
    $routes->get('recovery','Administrator::recovery');
    $routes->get('settings','Administrator::settings');
    $routes->get('my-account','Administrator::myAccount');
});
$routes->group('',['filter'=>'AdminAlreadyLoggedIn'],function($routes)
{
    $routes->get('auth','Administrator::auth');
    $routes->get('reset-password', 'Administrator::resetPassword');
});