<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the 'Database Connection'
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|				 NOTE: For MySQL and MySQLi databases, this setting is only used
| 				 as a backup if your server is running PHP < 5.2.3 or MySQL < 5.0.7.
| 				 There is an incompatibility in PHP with mysql_real_escape_string() which
| 				 can make your site vulnerable to SQL injection if you are using a
| 				 multi-byte character set and are running versions lower than these.
| 				 Sites using Latin-1 or UTF-8 database character set and collation are unaffected.
|	['swap_pre'] A default table prefix that should be swapped with the dbprefix
|	['autoinit'] Whether or not to automatically initialize the database.
|	['stricton'] TRUE/FALSE - forces 'Strict Mode' connections
|							- good for ensuring strict SQL while developing
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the 'default' group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'default';
$active_record = TRUE;
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


// connection for slave for read only

$db['read']['hostname'] = '10.10.10.5';
$db['read']['username'] = 'postgres';
$db['read']['password'] = '8899-hijk';
$db['read']['database'] = 'test';
$db['read']['dbdriver'] = 'postgre';
$db['read']['port'] = '5432';
$db['read']['dbprefix'] = 'cc_';
$db['read']['pconnect'] = FALSE;
$db['read']['db_debug'] = TRUE;
$db['read']['cache_on'] = FALSE;
$db['read']['cachedir'] = '';
$db['read']['char_set'] = 'utf8';
$db['read']['dbcollat'] = 'utf8_general_ci';
$db['read']['swap_pre'] = '';
$db['read']['autoinit'] = FALSE;
$db['read']['stricton'] = FALSE;
	
/* End of file database.php */
/* Location: ./application/config/database.php */
