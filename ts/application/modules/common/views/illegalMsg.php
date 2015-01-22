<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$currentModuleClass = $this->router->class;
if($currentModuleClass == 'dashboard') {
	$dashClasses = 'width410px ml10';
}else{
	$dashClasses = '';
}
echo '<div class="row deletedItemBox '.$dashClasses.'">'.$this->lang->line('illegalMsg').'</div><div class="clear seprator_10"></div>';
