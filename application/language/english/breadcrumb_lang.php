<?php

$lang['toadSquare'] = 'Toadsquare';

$userInfo = showCaseUserDetails();
//echo '<pre />';print_r($userInfo);
if($userInfo['userFullName']){
	$userFnameLname = ($userInfo['enterprise']=='t')?$userInfo['enterpriseName']:$userInfo['userFullName'];
}else{
	$userFnameLname = $lang['toadSquare'];
}
//$lang['set_home'] = 'Home';
$lang['set_home'] = $userFnameLname;
$lang['home'] = 'Home';

/* End of file breadcrumb_lang.php */
/* Location: ./application/language/english/breadcrumb_lang.php */
