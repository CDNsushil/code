<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['Sandbox'] = TRUE;

if(ENVIRONMENT=='testing'){ //STAGING
	$config['Sandbox'] = TRUE;
	$config['APIVersion'] = '66.0';
	$config['APIUsername'] = 'accounts-facilitator_api1.toadsquare.com';
	$config['APIPassword'] = '1363927255';
	$config['APISignature'] = 'ATFIN-AChe9icxF9aCXLfw52AiwwAp.Ks134-YBk5Cdn8K38c.G9lnDT';
}elseif(ENVIRONMENT=='production'){ //LIVE
		$config['Sandbox'] = False;
		$config['APIVersion'] = '66.0';
		$config['APIUsername'] = 'accounts_api1.toadsquare.com';
		$config['APIPassword'] = 'VDX9V5CPUGAARJF8';
		$config['APISignature'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31ADJTKr7LS5OkGqfsP8A4V85v7TeB';
}else{
		$config['Sandbox'] = TRUE; //DEVLOPEMENT & LOCAL
		$config['APIVersion'] = '66.0';
		/*$config['APIUsername'] = 'accounts-facilitator_api1.toadsquare.com';
		$config['APIPassword'] = '1363927255';
		$config['APISignature'] = 'ATFIN-AChe9icxF9aCXLfw52AiwwAp.Ks134-YBk5Cdn8K38c.G9lnDT';
  
    $config['APIUsername'] = 'amitwali-facilitator_api1.gmail.com';
    $config['APIPassword'] = '6N44JYJVN33VSPD6';
    $config['APISignature'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AZPlam2ax4EtbntzGG5ZOza.wuM2';
      */
    
    $config['APIUsername'] = 'per_eur_api1.business.com';
    $config['APIPassword'] = '5HVKKE9EWGR3SYHN';
    $config['APISignature'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31Ahd9lei3A.fh..36vOAS8pEvhk-y';   
    

}



$config['DeviceID'] = $config['Sandbox'] ? '' : 'PRODUCTION_DEVICE_ID_GOES_HERE';
$config['ApplicationID'] = $config['Sandbox'] ? 'APP-80W284485P519543T' : 'APP-2E454556LR591923K';
$config['DeveloperEmailAccount'] = $config['Sandbox'] ? 'accounts@toadsquare.com' : 'PRODUCTION_DEV_EMAIL_GOES_HERE';
$config['PayFlowUsername'] = $config['Sandbox'] ? 'tester' : 'PRODUCTION_USERNAME_GOGES_HERE';
$config['PayFlowPassword'] = $config['Sandbox'] ? 'Passw0rd~' : 'PRODUCTION_PASSWORD_GOES_HERE';
$config['PayFlowVendor'] = $config['Sandbox'] ? 'Toadsquare' : 'PRODUCTION_VENDOR_GOES_HERE';
$config['PayFlowPartner'] = $config['Sandbox'] ? 'PayPal' : 'PRODUCTION_PARTNER_GOES_HERE';

/* End of file paypal.php */
/* Location: ./system/application/config/paypal.php */