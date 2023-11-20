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
|	https://codeigniter.com/user_guide/general/routing.html
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

$route['driver/(:any)'] = 'driver/index/$1';
$route['car/(:any)'] = 'car/index/$1';
$route['home/(:any)'] = 'home/index/$1';

$route['v/(:any)'] = 'v/index/$1';
// $route['aff/(:num)'] = 'home/aff/$1';

$route['api/(:any)'] = 'api/$1';

$route['faq'] = 'home/faq';
$route['faq/data'] = 'home/faq_data';
$route['faq/(:num)'] = 'home/faq/$1';

$route['news'] = 'news';
$route['news/data'] = 'news/data';
$route['news/detail/(:num)'] = 'news/detail/$1';

$route['product'] = 'product';
$route['product/(:any)'] = 'product/$1';
$route['product/(:any)/(:any)'] = 'product/$1/$2';
$route['search'] = 'product/search';

$route['applications'] = 'applications';
$route['applications/(:any)'] = 'applications/$1';
$route['applications/(:any)/(:any)'] = 'applications/$1/$2';

$route['solution'] = 'solution';
$route['solution/(:any)'] = 'solution/$1';
$route['solution/(:any)/(:any)'] = 'solution/$1/$2';

$route['revenue_report/(:num)'] = 'home/revenue_report/$1';

$route['mgr'] = 'mgr/Dashboard/index';
$route['mgr/login'] = 'mgr/Dashboard/login';
$route['mgr/logout'] = 'mgr/Dashboard/logout';
$route['mgr/lock'] = 'mgr/Dashboard/lock';
$route['mgr/unlock'] = 'mgr/Dashboard/unlock';

$route['mgr/(:any)'] = 'mgr/$1';
$route['mgr/(:any)/(:any)'] = 'mgr/$1/$2';
$route['mgr/(:any)/(:any)/(:any)'] = 'mgr/$1/$2/$3';
$route['mgr/(:any)/(:any)/(:any)/(:any)'] = 'mgr/$1/$2/$3/$4';

$route['(:any)'] = 'home/$1';
$route['(:any)/(:any)'] = 'home/$1_$2';

$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

