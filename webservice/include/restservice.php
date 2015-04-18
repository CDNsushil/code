<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Author : Anoop singh
 * Email  : anoop@cdnsol.com
 * Timestamp : Aug-29 06:11PM
 * Copyright : www.cdnsol.com
 *
 */

final class restService{
	
	    /// -- Hold Service Action Request --
	    private $_action;
	    /// -- Hold Service Action Request --
	    private $_actionMethod;
	    /// -- Hold Service token --
	    private $_token;
	    /// -- Hold Service hash key --
	    private $_hash;
	    /// -- Hold Service Action Parameter Request --
	    private $_register;
	    /// -- Hold All error in Array --
	    private $_errorSet=array();
	    /// -- Hold Service Action Request --
	    private $_db;
		/// -- Hold Service Action Request --
		private $_input=array();
	    /// -- Hold Static private class members variables --
	    static private $_config=array();
	    /**
	    * @method __construct
	    * @see private constructor to protect beign inherited
	    * @access private
	    * @return void
	    */
	    public function __construct()
	    {
			//$this->_action	= config::getKeyValue('default_lib_name');
			//$this->_token	= config::getKeyValue('common_api_token');
			$this->_action	= 'server';
			$this->_token	= 'tbkVy4zzm0kOPapwHG5fG16VdMdvbosWtMKjQ0sX';
			/// -- Create Database Connection instance --
			$this->_db=env::getInst();
			/// -- Log Debug Message --
			log_message("debug","DB Object Initialized!!");

			
	    }
	    
	    /**
	    * @method Init
	    * @see public Initialization
	    * @access public
	    * @return void
	    */
	    public function init()
	    {	
	    	$this->segment=setEnv();
	    	//--IF--for check token and hash key is valid or not	    	
	    	if(!$this->check_token($_REQUEST)){
				/// -- Set Error Message --
				
	    		$this->setErrors("faultClass","Request is not valid.");
				/// -- Log Debug Message --	
				log_message("Error","Request is not valid.");		
				return array("faultClass","Request is not valid.");		
				exit();
			}/// -- END:FII  --		
			
			//--IF--for check method is exist or not
			if(isset($this->segment[0]) || $this->segment[0]!="")
			{
				$this->_actionMethod=$this->segment[0];
				unset($this->segment[0]);
								
				/// -- Log Debug Message --
				log_message("debug","Action Method Set:=>".$this->_actionMethod);
			}
			else{
				$this->setErrors("faultActionMethod","Action Method Not found");
				/// -- Log Debug Message --
				log_message("debug",json_encode($this->_errorSet));
			}///--END:FII--
		
			
			if(in_array("json",$this->segment))
			{
				$this->requestBody="json";
				$key=array_search('json', $this->segment);
				unset($this->segment[(int)$key]);
			}else if(in_array("xml",$this->segment)){
				$this->requestBody="xml";
				$key=array_search('xml', $this->segment);
				unset($this->segment[(int)$key]);
			}else{
				$this->requestBody="xml";
			}/// --END:FII in_array --
			
			if(count($this->segment)>0){
				$this->_input=$this->segment;
			}/// -- END:FII Count --
			
		}
	    
	    /**
	    * @method Init
	    * @see private Initialization
	    * @access private
	    * @return void
	    */
	    public function execute($requestBody = null)
	    {
	    		
	    	if($requestBody==""){
				$requestBody=$this->requestBody;
			}///--END: requestBody empty --
			
			if(count($this->_errorSet)>0){
	    		/// -- return Error Message --
    			return $this->getErrors($requestBody);
	    	}///--END:FII--
			
		
	    	/// -- check if class exists --
	    	if(class_exists($this->_action))
	    	{
	    		/// -- Load Class Object --
	    		$class=loadObject($this->_action);
	    		/// -- Log Debug Message --
				log_message("debug","Object of Class ".$this->_action." created successfully");
					
	    	}else{
	    		/// -- Set Error Message --
	    		$this->setErrors("faultClass","Class ".$this->_action." not Found");
	    		/// -- Log Debug Message --
				log_message("debug","Class ".$this->_action." not Found");
	    		/// -- return error message with requestbody type --
	    		return $this->getErrors($requestBody);
	    		
	    	}///--END:FII class_exists () --
	    	
	    	/// -- if $class is object of requested class --
    		if(is_a($class, $this->_action))
    		{				
    			/// -- if  method_exists in class --
    			if(method_exists($class,$this->_actionMethod))
    			{
					/// -- Log Debug Message --
					log_message("debug","Class ::".get_class($class)." Method:: ".$this->_actionMethod." Called with (".implode($this->_input).")Parameters!!");
					/// -- return response of method --
					return $this->getResponse(call_user_func_array(array($class, $this->_actionMethod), $this->_input),$requestBody);
    			} else{
    				/// -- set error message --
    				$this->setErrors("faultClassMethod","Call to Undefined Action::".$this->_action." with ActionMethod:: ".$this->_actionMethod." !!!");
    				/// -- return error message with requestbody type --
    				return $this->getErrors($requestBody);
    			}///--END:FII method_exists () --
    			
    		}else{
    			
    			/// -- Set Error Message --
	    		$this->setErrors("faultClass","Object Is not of type ".$this->_action."!!!");
	    		/// -- Log Debug Message --
				log_message("debug","Object Is not of type ".$this->_action."!!!");
	    		/// -- return error message with requestbody type --
	    		return $this->getErrors($requestBody);
	    		
    		}///--END:FII is_a () --
	    }///--END:execute --
	    
	    /**
	    * @method setError
	    * @see private setError($actionTag,$actionValue)
	    * @access private
	    * @params $actionTag as STRING
	    * @params $actionValue as STRING
	    * @return void
	    */
	    private function setErrors($actionTag,$actionValue)
	    {
	    	$this->_errorSet[$actionTag]=$actionValue;
	    }
	    
	    /**
	    * @method getErrors
	    * @see public getErrors($requestBody="")
	    * @access public
	    * @params $requestBody as OPTIONAL
	    * @return Error Message as _errorSet with requestBody
	    */
	    public function getErrors($requestBody="")
	    {
	    		if(strtolower($requestBody)=="json")
	    		{
	    			return json_encode($this->_errorSet);
	    		}
	    		else if(strtolower($requestBody)=="xml")
	    		{
						ob_clean();
						/// -- Initiate header --
						header("content-type:text/xml");
						/// -- Initiate the class --
						return xmlutils::array_to_xml($this->_errorSet);
	    		}else{
	    			return $this->_errorSet;
	    		}
	    		///--END:FII--
	    }
	    
	     /**
	    * @method getResponse
	    * @see public getResponse($object,$requestBody="")
	    * @access public
	    * @params $object as OBJECT
	    * @params $requestBody as response Type
	    * @return Response Message as requestBody
	    */
	    public function getResponse($object,$requestBody="")
	    {
	    		if(strtolower($requestBody)=="json")
	    		{
	    			return json_encode($object);
	    		}
	    		else if(strtolower($requestBody)=="xml")
	    		{
						ob_clean();
						/// -- Initiate header --
						header("content-type:text/xml");
						/// -- Initiate the class --
						return xmlutils::array_to_xml($object);
	    		}else{
	    			return $object;
	    		}///--END:FII--
	    }///--END:FII getResponse () --
	    
	/*-------------------------------------------------
	* function for check valid request
	* @method check_token
	* @see public check_token($token,$hashkey)
	* @access public		
	* -----------------------------------------------*/
	 function check_token($data){	
		 return true;
		 //-- BASIC -Param	
		$hash 		= $data['hash'];		
		$timestamp 	= $data['current_timestamp'];		
		$interval_time	= config::getKeyValue('interval_time');
		
		$current = time();		
		$checkhash = md5($this->_token.$timestamp);
		//--IF--for check token and hash key is valid or not	    	
		if (($current - $timestamp) > $interval_time || ($checkhash != $hash)) {			
			return false;
		}///--END:FII--		
		return true;
	 }
	    
}


?>
