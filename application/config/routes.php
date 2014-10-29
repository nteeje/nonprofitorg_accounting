<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
$route['default_controller'] = 'user/index';
$route['404_override'] = '';

/*admin*/
$route['admin'] = 'user/index';
$route['admin/signup'] = 'user/signup';
$route['admin/create_member'] = 'user/create_member';
$route['admin/login'] = 'user/index';
$route['admin/logout'] = 'user/logout';
$route['admin/login/validate_credentials'] = 'user/validate_credentials';

$route['admin/products'] = 'admin_products/index';
$route['admin/products/add'] = 'admin_products/add';
$route['admin/products/update'] = 'admin_products/update';
$route['admin/products/update/(:any)'] = 'admin_products/update/$1';
$route['admin/products/delete/(:any)'] = 'admin_products/delete/$1';
$route['admin/products/(:any)'] = 'admin_products/index/$1'; //$1 = page number

$route['admin/manufacturers'] = 'admin_manufacturers/index';
$route['admin/manufacturers/add'] = 'admin_manufacturers/add';
$route['admin/manufacturers/update'] = 'admin_manufacturers/update';
$route['admin/manufacturers/update/(:any)'] = 'admin_manufacturers/update/$1';
$route['admin/manufacturers/delete/(:any)'] = 'admin_manufacturers/delete/$1';
$route['admin/manufacturers/(:any)'] = 'admin_manufacturers/index/$1'; //$1 = page number

$route['admin/members'] = 'admin_members/index';
$route['admin/members/home'] = 'admin_members/home';
$route['admin/members/add'] = 'admin_members/add';
$route['admin/members/update'] = 'admin_members/update';
$route['admin/members/update/(:any)'] = 'admin_members/update/$1';
$route['admin/members/delete/(:any)'] = 'admin_members/delete/$1';
$route['admin/members/(:any)'] = 'admin_members/index/$1'; //$1 = page number

$route['admin/journals'] = 'admin_journals/index';
$route['admin/journals/add'] = 'admin_journals/add';
$route['admin/journals/update'] = 'admin_journals/update';
$route['admin/journals/update/(:any)'] = 'admin_journals/update/$1';
$route['admin/journals/delete/(:any)'] = 'admin_journals/delete/$1';
$route['admin/journals/(:any)'] = 'admin_journals/index/$1'; //$1 = page number

$route['admin/ledgers'] = 'admin_ledgers/index';
$route['admin/ledgers/add'] = 'admin_ledgers/add';
$route['admin/ledgers/update'] = 'admin_ledgers/update';
$route['admin/ledgers/update/(:any)'] = 'admin_ledgers/update/$1';
$route['admin/ledgers/delete/(:any)'] = 'admin_ledgers/delete/$1';
$route['admin/ledgers/(:any)'] = 'admin_ledgers/index/$1'; //$1 = page number

$route['admin/reports'] = 'admin_reports/index';
$route['admin/reports/searchCredit'] = 'admin_reports/searchCredit';
$route['admin/reports/searchShare'] = 'admin_reports/searchShare';
$route['admin/reports/creditInfo/(:any)'] = 'admin_reports/creditInfo/$1';
$route['admin/reports/shareInfo/(:any)'] = 'admin_reports/shareInfo/$1';
$route['admin/reports/creditaccount'] = 'admin_reports/creditaccount';//sharesaccount
$route['admin/reports/sharesaccount'] = 'admin_reports/sharesaccount';//sharesaccount
$route['admin/reports/cashaccount'] = 'admin_reports/cashaccount';//sharesaccount




 $route['admin/systems'] = 'admin_systems/index';    
 $route['admin/systems/backupLJs'] = 'admin_systems/backupLJs';    
 $route['admin/systems/getBackupDB'] = 'admin_systems/getBackupDB';    
 



/* End of file routes.php */
/* Location: ./application/config/routes.php */