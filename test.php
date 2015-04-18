<?php
$staging: 94.242.251.14
$live: 94.242.254.30

if(ENVIRONMENT=='testing'){
	$db['default']['hostname'] = 'localhost';
}elseif(ENVIRONMENT=='production'){
	$db['default']['hostname'] = 'localhost';
}else{
	$db['default']['hostname'] = '10.10.10.2';
	//$db['default']['hostname'] = '94.242.254.30';

}
$db['default']['port'] 	= '5432';
$db['default']['username'] = 'postgres';
$db['default']['password'] = '8899-hijk';
$db['default']['database'] = 'toadsquare';
//$db['default']['database'] = 'test';
$db['default']['dbdriver'] = 'postgre';
$db['default']['dbprefix'] = 'TDS_';
$db['default']['pconnect'] = FALSE;
$db['default']['db_debug'] = TRUE;
$db['default']['cache_on'] = FALSE;
$db['default']['cachedir'] = '';
$db['default']['char_set'] = 'utf8';
$db['default']['dbcollat'] = 'utf8_general_ci';
$db['default']['swap_pre'] = '';
$db['default']['autoinit'] = TRUE;
$db['default']['stricton'] = FALSE;
phpinfo();
?>
