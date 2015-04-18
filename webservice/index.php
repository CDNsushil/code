<?php
/**
 * Author : Anoop singh
 * Email  : anoop.immortal@gmail.com
 * Timestamp : July-28 02:11PM
 * Copyright : www.cdnsol.com
 *
 */
	date_default_timezone_set("America/New_York");	
	/// -- Get Output in Buffer --
	//ob_start();
	/// -- Define base path to check it is a correct way to access --
	define('BASEPATH',dirname(__FILE__));
	/// -- Define Lib path --
	define('LIBPATH',"include");
	/// -- Define Directory seprator --
	define('DS',"/");
	/// -- Define EXT for file --
	define('EXT',".php");		
	
	/// -- All to catch exception handling --
	try{
		
		/// -- check FIle exists or now --
		if(file_exists(BASEPATH.DS.LIBPATH.DS."common.php")){
			/// -- Include File exists or now --
			include(BASEPATH.DS.LIBPATH.DS."common.php");			
			/// -- Log Debug Message --
			log_message("debug","common file included");
			/// -- Create Service Object --
			$resService=loadObject("restService");	
			/// -- Init Service Object --
			$resService->init();
			/// -- If service is of type REST set Return type (XML, JSON)--
			$result=$resService->execute('JSON');
			if($result){
				echo $result;
			}else{
				echo "no result found";
			}/// -- FII::END $result --
		}/// -- FII::END File_exists --
	}catch(Exception $e){
		/// -- Log Debug Message --
		log_message("error","ERROR::".__LINE__."<==>".$e);
		die("OOPS something goes wrong");
	}
	

?>
