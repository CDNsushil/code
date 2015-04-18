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

$route['default_controller'] = "home";

//$route['404_override'] = '';
$route['404_override'] = 'my404/index'; //Here my404 is my controller

$route['^(en|de|fr|nl)/(:any)/dashboard/(:any)']				= "dashboard/$3"; // en/username/dashboard/mathod
$route['^(en|de|fr|nl)/(:any)/mediafrontend/(:any)/(:any)/(:any)/(:any)/(:any)/(:any)']				= "mediafrontend/$3/$4/$5/$6/$7/$8"; // en/username/mediafrontend/mathod
$route['^(en|de|fr|nl)/(:any)/mediafrontend/(:any)/(:any)/(:any)/(:any)/(:any)']				= "mediafrontend/$3/$4/$5/$6/$7"; // en/username/mediafrontend/mathod
$route['^(en|de|fr|nl)/(:any)/mediafrontend/(:any)/(:any)/(:any)/(:any)']				= "mediafrontend/$3/$4/$5/$6"; // en/username/mediafrontend/mathod
$route['^(en|de|fr|nl)/(:any)/mediafrontend/(:any)/(:any)/(:any)']				= "mediafrontend/$3/$4/$5"; // en/username/mediafrontend/mathod
$route['^(en|de|fr|nl)/(:any)/mediafrontend/(:any)/(:any)']				= "mediafrontend/$3/$4"; // en/username/mediafrontend/mathod
$route['^(en|de|fr|nl)/(:any)/mediafrontend/(:any)']				= "mediafrontend/$3"; // en/username/mediafrontend/mathod


// URI like '/en/about' -> use controller 'about'
$route['^(en|de|fr|nl)/(.+)$'] = "$2";

// '/en', '/de', '/fr' and '/nl' URIs -> use default controller
$route['^(en|de|fr|nl)$'] = $route['default_controller'];  

// Contexts
$route[SITE_AREA .'/([a-z_]+)/(:any)/(:any)/(:any)/(:any)/(:any)']		= "$2/$1/$3/$4/$5/$6";
$route[SITE_AREA .'/([a-z_]+)/(:any)/(:any)/(:any)/(:any)']		= "$2/$1/$3/$4/$5";
$route[SITE_AREA .'/([a-z_]+)/(:any)/(:any)/(:any)']		= "$2/$1/$3/$4";
$route[SITE_AREA .'/([a-z_]+)/(:any)/(:any)'] 		= "$2/$1/$3";
$route[SITE_AREA .'/([a-z_]+)/(:any)']				= "$2/$1/index";
$route[SITE_AREA .'/manage_users']				= "admin/manage_users/index";
$route[SITE_AREA .'/reports']				= "admin/reports/index";
$route[SITE_AREA .'/developer']				= "admin/developer/index";
$route[SITE_AREA .'/settings']				= "settings/index";

$route[SITE_AREA]	= SITE_AREA .'/home';


/* End of file routes.php */
/* Location: ./application/config/routes.php */
