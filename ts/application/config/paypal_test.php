<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['Sandbox'] = FALSE;

$config['APIVersion'] = '94.0';
$config['APIUsername'] = 'accounts_api1.toadsquare.com';
$config['APIPassword'] = 'VDX9V5CPUGAARJF8';
$config['APISignature'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31ADJTKr7LS5OkGqfsP8A4V85v7TeB';

/*
$config['APIVersion'] = '66.0';
$config['APIUsername'] = 'accounts-facilitator_api1.toadsquare.com';
$config['APIPassword'] = '1363927255';
$config['APISignature'] = 'ATFIN-AChe9icxF9aCXLfw52AiwwAp.Ks134-YBk5Cdn8K38c.G9lnDT';
*/

$config['DeviceID'] = $config['Sandbox'] ? '' : 'PRODUCTION_DEVICE_ID_GOES_HERE';
$config['ApplicationID'] = $config['Sandbox'] ? 'APP-80W284485P519543T' : 'APP-2E454556LR591923K';
$config['DeveloperEmailAccount'] = $config['Sandbox'] ? 'andrew@angelleye.com' : 'accounts@toadsquare.com';
$config['PayFlowUsername'] = $config['Sandbox'] ? 'tester' : 'PRODUCTION_USERNAME_GOGES_HERE';
$config['PayFlowPassword'] = $config['Sandbox'] ? 'Passw0rd~' : 'PRODUCTION_PASSWORD_GOES_HERE';
$config['PayFlowVendor'] = $config['Sandbox'] ? 'angelleye' : 'PRODUCTION_VENDOR_GOES_HERE';
$config['PayFlowPartner'] = $config['Sandbox'] ? 'PayPal' : 'PRODUCTION_PARTNER_GOES_HERE';

/* End of file paypal.php */
/* Location: ./system/application/config/paypal.php */
