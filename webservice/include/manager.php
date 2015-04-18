<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class manager
{

	public function getManager(){
		if($_SERVER["REQUEST_METHOD"]=="POST")
			{
				$this->_name="Manager POST";
				$this->_age="121";
				$this->_address="140 industry house";
				return	$this;
			}
			else if($_SERVER["REQUEST_METHOD"]=="GET")
			{
				$this->_name="manager GET";
				$this->_age="12";
				$this->_address="120 industry house";
				return	$this;
			}
			else if($_SERVER["REQUEST_METHOD"]=="PUT")
			{
				$this->_name="manager GET";
				$this->_age="12";
				$this->_address="120 industry house";
				return	$this;
			}
			else{
				return array("ERROR"=>"Send Data via GET/POST");
			}
	}
}

?>