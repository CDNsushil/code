<?php
class CI_Package {
	public function _is_valid_request(){
  	  
		//print_r(Gas::factory('aanaModel')->all());
		//$users = Gas::factory('aanaModel')->set_table("Blogs")->all();
		//echo "<pre>===>";
		//print_r($users);
		$_request=new stdclass();
		$_request->_is_request_valid=false;
		
		$_request->_for_package=new stdclass();
			$_request->_for_package->is_request_valid=true;
			$_request->_for_package->errorMsg=false;
			$_request->_for_package->successMsg=true;
			
		$_request->_for_space=new stdclass();
			$_request->_for_space->is_request_valid=true;
			$_request->_for_space->errorMsg=false;
			$_request->_for_space->successMsg=true;

		
		$_request->_is_request_valid=true;
		return $_request;
		//return false;
	}

}
?>