<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	if(isset($dataProject[$imageField]) && !empty($dataProject[$imageField])){
		if(is_file($dataProject[$imageField])){
			$src=getImage($dataProject[$imageField]);
		}else{
			$src=isset($src)?$src:'';
		}
	}
	echo $img='<img src="'.$src.'" />';
?>
