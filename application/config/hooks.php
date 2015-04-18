<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/
// --- AUTO LOAD Aana Library same as SPAK Library ---
$hook['pre_controller'][] = array(
                                'function' => 'init',
                                'filename' => 'Loadlibrary.php',
                                'filepath' => 'aana',
                                'params'   => array()
                                );

// --- ANOOP ERROR Handler ---
$hook['post_controller_constructor'][] = array(
                   'class'    => 'ExceptionHook',
                   'function' => 'SetExceptionHandler',
                   'filename' => 'ExceptionHook.php',
                   'filepath' => 'hooks'
                  );
// --- ANOOP ERROR Handler ---

//------ANOOP for Payment Pages ---
$hook['post_controller_constructor'][] = array(
                                'function' => 'check_ssl',
                                'filename' => 'ssl.php',
                                'filepath' => 'hooks'
                                );
//------ANOOP for Payment Pages ---    

// --- fans authentigation  ---


$hook['post_controller_constructor'][] = array(
                   'class'    => 'fans_authentication',
                   'function' => 'fans_user_action',
                   'filename' => 'fans_authentication.php',
                   'filepath' => 'hooks'
                  );
// ---  fans authentigation  ---


// --- user stay login ---
$hook['post_controller_constructor'][] = array(
                   'class'    => 'stay_login',
                   'function' => 'user_stay_login',
                   'filename' => 'stay_login.php',
                   'filepath' => 'hooks'
                  );
// ---  user stay login  ---
                            

// --- OVERLOAD display class to send AJAX request ---								
/*$hook['display_override'] = array(
                                'class'    => 'Autoajax',
                                'function' => 'gen_output',
                                'filename' => 'Autoajax.php',
                                'filepath' => 'aana'
                                );
	*/
$hook['display_override'] = array( 'class' => 'debug_toolbar', 'function' => 'render', 'filename' => 'debug_toolbar.php', 'filepath' => 'hooks' );
                            
$hook['post_controller'] = array(
                                'class'    => 'query_filter',
                                'function' => 'filter',
                                'filename' => 'query_filter.php',
                                'filepath' => 'hooks'
                            );
// --- SUSHIL QUERY FINDER ---
/*
*	PLEASE DO NOT EDIT ANYTING BELOW THIS
*/
/*
// --- Performance Loggin for Codeigniter ---																
$hook['post_controller_constructor'][] = array(
    'class'    => 'Firestick',
    'function' => 'pre_application',
    'filename' => 'Firestick.php',
    'filepath' => 'libraries'
);

$hook['post_controller'] = array(
    'class'    => 'Firestick',
    'function' => 'post_application',
    'filename' => 'Firestick.php',
    'filepath' => 'libraries'
);

$hook['post_system'] = array(
    'class'    => 'Firestick',
    'function' => 'resolve_profiling',
    'filename' => 'Firestick.php',
    'filepath' => 'libraries'
);
*/

/* End of file hooks.php */
/* Location: ./application/config/hooks.php */
