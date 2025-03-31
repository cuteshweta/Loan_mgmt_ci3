<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// Authentication Routes
$route['default_controller'] = 'Auth';
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['logout'] = 'auth/logout';

// Customer Routes
$route['customer/dashboard'] = 'customer/dashboard';
$route['customer/apply-loan'] = 'customer/apply_loan';
$route['customer/repayments'] = 'customer/repayments';
$route['customer/make-payment'] = 'customer/make_payment';


// Admin Routes
$route['admin/dashboard'] = 'admin/dashboard';
$route['admin/dashboard/(:status)'] = 'admin/dashboard/$status';
$route['admin/loans/(:num)'] = 'admin/loan_detail/$1';
$route['admin/loans/update-status'] = 'admin/update_loan_status';

// Default Routes
$route['default_controller'] = 'auth';
$route['404_override'] = 'errors/page_not_found';
$route['translate_uri_dashes'] = FALSE;

$route['customer/(:any)'] = function ($method) {
    return 'customer/'.$method;
};

$route['admin/(:any)'] = function ($method) {
    return 'admin/'.$method;
};

