<?php

	function FetchMonths($year,$userId=0,$model='model_blog'){
		
		$CI =& get_instance();
		$CI->load->model($model,'',TRUE);
		return $CI->$model->showArchivesMonths($year,$userId);
	}


?>
