<?php  
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['Sandbox'] = TRUE;

$config['APIVersion'] = '66.0';
$config['APIUsername'] = 'rajendrapatidar-facilitator_api1.cdnsol.com';
$config['APIPassword'] = '1395742856';
$config['APISignature'] = 'AvNLlGgJYGzKL6NjrBdG9BUphilAAraym.Z7CiawDcxhFp3sGItr3HrV';

$config['ApplicationID'] = 'APP-80W284485P519543T';



if($config['Sandbox'] == FALSE) {
$config['APIVersion'] = '66.0';
$config['APIUsername'] = 'rajendrapatidar-facilitator_api1.cdnsol.com';
$config['APIPassword'] = '1395742856';
$config['APISignature'] = 'AvNLlGgJYGzKL6NjrBdG9BUphilAAraym.Z7CiawDcxhFp3sGItr3HrV';

$config['ApplicationID'] = '';

}



/* End of file paypal.php */
/* Location: ./system/application/config/paypal.php */
