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
$route['default_controller'] = 'auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['fund_admin_wallet/get_user_details'] = 'fund_admin_wallet/get_user_details';
$route['fund_admin_wallet/add_fund'] = 'fund_admin_wallet/add_fund';
$route['fund_admin_wallet'] = 'fund_admin_wallet/fund_admin_wallet';
$route['fund_admin_wallet/index'] = 'fund_admin_wallet/index';
$route['auth/sign_out'] = 'auth/sign_out';
$route['fetch-user-type'] = 'auth/fetch_user_type';
$route['auth/reset_password_update'] = 'auth/reset_password_update';
$route['auth/reset_password'] = 'auth/reset_password';
$route['auth/login'] = 'auth/login';
$route['auth/sign_up'] = 'auth/sign_up';
$route['dashboard/index'] = 'dashboard/index';
$route['fund_type/index'] = 'fund_type/index';
$route['fund_type/adds_security_answer'] = 'fund_type/adds_security_answer';