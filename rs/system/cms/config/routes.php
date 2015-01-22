<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
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
| There are two reserved routes:
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

$route['default_controller']                = 'home/home';
$route['404_override']                      = 'pages';

$route['admin/help/([a-zA-Z0-9_-]+)']       = 'admin/help/$1';
$route['admin/([a-zA-Z0-9_-]+)/(:any)']	    = '$1/admin/$2';
$route['admin/(login|logout|remove_installer_directory)'] = 'admin/$1';
$route['admin/([a-zA-Z0-9_-]+)']            = '$1/admin/index';

$route['api/ajax/(:any)']          			= 'api/ajax/$1';
$route['api/([a-zA-Z0-9_-]+)/(:any)']	    = '$1/api/$2';
$route['api/([a-zA-Z0-9_-]+)']              = '$1/api/index';

$route['register/([a-zA-Z0-9_-]+)/(:any)']	= 'users/register/$2';
$route['register']							= 'users/register/';
$route['user/(:any)']	                    = 'users/view/$1';
$route['users/my-profile']	                = 'users/index';
$route['users/my-profile/edit']	            = 'users/edit';
$route['sitemap.xml']                       = 'sitemap/xml';
$route['home']                       		= 'users/home';
$route['users/forgot-password/(:any)']      = 'users/reset_pass/$1';

/*mercahant section url */

$route['merchant/banner/add']      			= 'merchant/addbanner';

$route['merchant/feedback/add']      		= 'merchant/addfeedback';
$route['merchant/feedback']      			= 'merchant/addfeedback';
$route['merchant/view-feedback/(:any)']     = 'merchant/viewfeedback/$1';
$route['merchant/feedback/view/(:any)']     = 'merchant/viewfeedback/$1';

$route['merchant/upload-CSV']     			= 'merchant/upload_csv';
$route['merchant/banner/view/(:any)']     	= 'merchant/viewbanner/$1';
$route['merchant/banner/edit/(:any)']     	= 'merchant/editbanner/$1';

/*affiliate section url */
$route['affiliate/feedback']      = 'affiliate/merchantfeedback/';
$route['affiliate/feedback/view/(:any)']   = 'affiliate/viewfeedback/$1';
$route['affiliate/testimonial']       = 'affiliate/addtestimonial';
$route['affiliate/request']       = 'affiliate/paymentrequest';
$route['affiliate/testimonial/view/(:any)']  = 'affiliate/viewtestimonial/$1';
$route['affiliate/banners/view/(:any)']  = 'affiliate/viewbanner/$1';
$route['affiliate/payment']  = 'affiliate/affiliatepayment';
$route['affiliate/payment/view/(:any)']  = 'affiliate/paymentview/$1';
$route['affiliate/request/view/(:any)']  = 'affiliate/requestview/$1';


/*user section url */
$route['users/testimonial/view/(:any)']   = 'users/viewtestimonial/$1';
$route['users/email/verification']  	= 'users/emailverification';

/*membership section url */
$route['users/membership/view/(:any)']   = 'membership/packageview/$1';


/* End of file routes.php */
