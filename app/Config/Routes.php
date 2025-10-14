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
$routes->get('fetch-permission','Administrator::fetchPermission');

$routes->group('',['filter'=>'AdminCheck'],function($routes)
{
    $routes->get('dashboard','Administrator::index');
    //cadets
    $routes->get('cadets','Administrator::cadetInformation');
    $routes->get('cadet/view/(:any)','Administrator::cadetView/$1');
    //schedules
    $routes->get('schedules','Administrator::trainingSchedule');
    $routes->get('schedules/create','Administrator::createSchedule');
    $routes->get('schedules/edit/(:any)','Administrator::editSchedule/$1');
    //attendance
    $routes->get('attendance','Administrator::attendance');
    $routes->get('attendance/view/(:any)','Administrator::viewAttendance/$1');
    //grades
    $routes->get('grades','Administrator::gradingSystem');
    //announcement
    $routes->get('announcement','Administrator::announcement');
    //reports
    $routes->get('reports','Administrator::report');
    //maintenance
    $routes->get('maintenance/accounts','Administrator::accounts');
    $routes->get('maintenance/create-account','Administrator::createAccount');
    $routes->get('maintenance/edit-account/(:any)','Administrator::editAccount/$1');
    $routes->get('maintenance/recovery','Administrator::recovery');
    $routes->get('maintenance/settings','Administrator::settings');
    $routes->get('maintenance/permission/create','Administrator::createPermission');
    $routes->get('maintenance/edit-permission/(:any)','Administrator::editPermission/$1');
    //profile
    $routes->get('my-account','Administrator::myAccount');
});
$routes->group('',['filter'=>'AdminAlreadyLoggedIn'],function($routes)
{
    $routes->get('auth','Administrator::auth');
    $routes->get('reset-password', 'Administrator::resetPassword');
});