<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Paypal extends CI_Controller 
{
	function __construct()
	{
		parent::__construct();
	
	}
	function index()
	{
		$config['Sandbox'] = TRUE;

		$config['APIVersion'] = '66.0';
		$config['APIUsername'] = 'rajendrapatidar-facilitator_api1.cdnsol.com';
		$config['APIPassword'] = '1395742856';
		$config['APISignature'] = 'AvNLlGgJYGzKL6NjrBdG9BUphilAAraym.Z7CiawDcxhFp3sGItr3HrV';

		/*
		$config['APIVersion'] = '66.0';
		$config['APIUsername'] = 'accounts-facilitator_api1.toadsquare.com';
		$config['APIPassword'] = '1363927255';
		$config['APISignature'] = 'ATFIN-AChe9icxF9aCXLfw52AiwwAp.Ks134-YBk5Cdn8K38c.G9lnDT';
		*/
		if($config['Sandbox'] == FALSE) {
		$config['APIVersion'] = '66.0';
		$config['APIUsername'] = 'accounts_api1.toadsquare.com';
		$config['APIPassword'] = 'VDX9V5CPUGAARJF8';
		$config['APISignature'] = 'AFcWxV21C7fd0v3bYYYRCpSSRl31ADJTKr7LS5OkGqfsP8A4V85v7TeB';
		return $config;
		}
	}
		
	
}



/* End of file paypal.php */
/* Location: ./system/application/config/paypal.php */
