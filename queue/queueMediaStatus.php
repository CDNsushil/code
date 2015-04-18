<?php 
/**
 * @Author : Mayank Kanungo /opt/lampp/bin/php -f /opt/lampp/htdocs/toadsquare/temp/toadsquare/dev/queue/queueMedia.php > /opt/lampp/htdocs/toadsquare/temp/toadsquare/dev/queue/logs/queueMedia.log
 * @Email  : mayankkanugo83@gmail.com
 * @Timestamp : Nov-02 01:23PM
 * @Copyright : www.cdnsol.com
**/
	date_default_timezone_set('Europe/Luxembourg');
	// -- Check if file YAML file exists --
	define("BASEPATH",dirname(__FILE__));
	// -- File Extension --
	define("EXT",".php");
	ini_set('display_errors',1);
	
	// -- Check if file Common file exists --
	if(file_exists(dirname(__FILE__).'/inc/common'.EXT))
	{
		include(dirname(__FILE__).'/inc/common'.EXT);
		log_message("ALL","All files include successfully");
	}
	// create databse object
	$db = db_connect();
	
	if(isset($_POST["key"]) && $_POST["key"]==config::getInst()->getKeyValue("encryption_key"))
	{
	
		log_message("ALL","QueueMediaStatus will run for --> EXTERNAL (".$_SERVER["REQUESTED_URI"].")");
		
	} else {
		
		/// -- Log Message to Log file for Type of call --
		log_message("ALL","QueueMediaStatus will run for --> INTERNAL ()");
		
		$destinaiton = array();
		$preview = array();
		/// -- Traverse Directory And find if there is any new .renderjob file availabe in it --
		$ite=new RecursiveIteratorIterator(new RecursiveDirectoryIterator(config::getInst()->getKeyValue("media_queue_trash"),RecursiveIteratorIterator::SELF_FIRST));
		foreach ( $ite as $filename=>$cur) 
		{
			$jobId = updateStatus($ite);
			$job = explode(',',$jobId);
			if(isset($job[0]) && $job[0] > 0) array_push($destinaiton , $job[0]);
			if(isset($job[1])) array_push($preview , $job[1]);
		}// END FOR $ite as $filename=>$cur --
		if(!empty($destinaiton) || !empty($preview)){
			//update status in databse if files are converted successfully and create destination file or not
			// need to be done upadte status for Thumbnail and previews
			if(is_array($destinaiton) && count($destinaiton) > 0 ){
				$res = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'DONE\' WHERE "TDS_MediaFile"."fileId" in('.implode(' , ',$destinaiton).')');	
			}
			//send_req($destinaiton , $preview);
		}
		exit();
		
	}// -- FII :: $_POST["key"] --

function updateStatus($ite){
	
	$result=isset($result)?$result:'';
	$Preview=isset($Preview)?$Preview:'';
	$Destination=isset($Destination)?$Destination:'';
	
	/// -- Check for file name and JobId so, that both needs to be same --
	$fileName=explode(config::getInst()->getKeyValue("done"),$ite->getFilename());
	/// -- Patter for .renderjob file --
	$pattern='/^.+'.config::getInst()->getKeyValue("done").'$/i';
	preg_match($pattern, $ite->getFilename(), $matches);
	
	if(count($matches)>0)
	{
		/// -- Load YAML config file from given file and read as array --
		$array = Spyc::YAMLLoad(config::getInst()->getKeyValue("media_queue_trash").$ite->getFilename());

		if(array_key_exists("Type",$array) && array_key_exists("JobID",$array))
		{
			if($fileName[0]==$array["JobID"])
			{
				/// -- Check for file Type If it is availabe in our COnfig Array for status udpate --
				/*if(in_array(strtolower($array["type"]),config::getInst()->getKeyValue("media_queue_trash")))
				{
					/// -- Check if file is converted and existes at given destination path or not --
					if(file_exists($array["Source"]))
					{*/
						/// -- Check if Able to Aquire reLock on file --
						if(reLock($ite,$array))
						{
								/// -- Call Toadsquare fucntion to udpate sattus in databse  --
								if(file_exists($array["Destination"]))
								{  
									$Destination = $array["JobID"];
									// CODE TO CREATE ARRAY FOR STATUS UPDETE
									if(isset($array["Preview"]) && $array["Preview"]){
											if(file_exists($array["Preview"]))
											{
												$Preview = $array["JobID"];
											}else{
												
												/*
												 * 
												 * Comment by lokendra 25-jun-2013 
												///TODO: CODE TO MOVE .relockjob FILE TO QUEUE AND TRY TO CUT SAMPLE  CLIP AGAIN
												//echo 'TODO: CODE TO MOVE .relockjob FILE TO QUEUE AND TRY TO CUT SAMPLE  CLIP AGAIN';
												if (!copy(config::getInst()->getKeyValue("media_queue_trash").$array["JobID"].config::getInst()->getKeyValue("relockjob"), config::getInst()->getKeyValue("media_queue_inqueue").$array["JobID"].config::getInst()->getKeyValue("renderjob"))) {
													log_message("INFO",":: ".$array["JobID"].config::getInst()->getKeyValue("relockjob")." Failed to Copy from Inqueue to Trash  At ".date("D M j G:i:s T Y")."\n");
												}
												else{
													
													$relockjob=config::getInst()->getKeyValue("media_queue_trash").$array["JobID"].config::getInst()->getKeyValue("relockjob");
													if(is_file($relockjob)){
														unlink($relockjob);
													}
												 
												  log_message("INFO",":: ".$array["JobID"].config::getInst()->getKeyValue("lockjob")." Moved from Inqueue to Trash  At ".date("D M j G:i:s T Y")."\n");
												}/// -- FI::copy() --
													*/
													
												log_message("INFO",":: ".$array["JobID"].config::getInst()->getKeyValue("lockjob")." Moved from Inqueue to Trash  At ".date("D M j G:i:s T Y")."\n");
												
													
											}
											//echo  "JobID".$array["JobID"];die;
									}
									
									log_message("INFO",":: Status added successfully in databse array for:-".$array["Destination"]." At ".date("D M j G:i:s T Y")."\n".$result);
									
									$jobFile=config::getInst()->getKeyValue("media_queue_trash").$array["JobID"].config::getInst()->getKeyValue("relockjob");
									if(is_file($jobFile)){
										unlink($jobFile);
									}
									log_message("INFO",":: ".config::getInst()->getKeyValue("media_queue_trash").$array["JobID"].config::getInst()->getKeyValue("relockjob")." deted  ".date("D M j G:i:s T Y")."\n".$result);
								
								}else{
								
									log_message("INFO",":: ERROR Occer while converting ".$array["Source"]." At ".date("D M j G:i:s T Y")."\n".$result."\n");
									
									/*
									 * 
									 * ///TODO: CODE TO MOVE .relockjob FILE TO QUEUE AND TRY TO CONEVERT AGAIN
									if (!copy(config::getInst()->getKeyValue("media_queue_trash").$array["JobID"].config::getInst()->getKeyValue("relockjob"), config::getInst()->getKeyValue("media_queue_inqueue").$array["JobID"].config::getInst()->getKeyValue("renderjob"))) {
										log_message("INFO",":: ".$array["JobID"].config::getInst()->getKeyValue("relockjob")." Failed to Copy from Trash to Inqueue  At ".date("D M j G:i:s T Y")."\n");
									}
									else{
										$relockjob=config::getInst()->getKeyValue("media_queue_trash").$array["JobID"].config::getInst()->getKeyValue("relockjob");
										if(is_file($relockjob)){
											unlink($relockjob);
										}
									  log_message("INFO",":: ".$array["JobID"].config::getInst()->getKeyValue("relockjob")." Moved from Trash to Inqueue  At ".date("D M j G:i:s T Y")."\n");
									
									
									}/// -- FI::copy() --
									*/
									
								}/// -- FII :: file_exists($array["Destination"]) --
						}/// -- FII: lock() --	
					/*}else{
						log_message("INFO",":: -- Source file '".$array["Source"]."' Dosent exists -- ".date("D M j G:i:s T Y")."\n");
					}/// -- FII :: file_exists($array["Source"]) --
				}else{
					//TODO: Nothing to do	
					log_message("INFO",":: ERROR File Type not found. Requested file ext is EXT:".$array["Type"]." Not found in Config file ".date("D M j G:i:s T Y"));
					
				}/// -- FII :: in_array($array["Type"],config::getInst()->getKeyValue("media_format_queue")) --*/
			}else{
				log_message("INFO",":: ERROR Occer Field Miss Match 'JobId', Filename:".$fileName[0].", JobId:".$array["JobID"].", ".date("D M j G:i:s T Y")." !!!!");
				
			}/// -- FII :: $fileName[0]==$array["JobID"] --
		}else{
			log_message("INFO",":: ERROR Occer while reading renderjob file for Field Missin Type and JobId At ".$ite->getFilename()." ". date("D M j G:i:s T Y")." !!!!");
		}/// -- FII :: array_key_exists("Type",$array) && array_key_exists("JobID",$array) --
	
	return $Destination.','.$Preview;
	}/// -- FII :: count($matches)>0 --
	
	
		
}/// -- END::process() --	

	
function reLock($ite,$array){
	/// -- Create LOCK on file --
	if(!rename(config::getInst()->getKeyValue("media_queue_trash").$ite->getFilename(),config::getInst()->getKeyValue("media_queue_trash").$array["JobID"].config::getInst()->getKeyValue("relockjob"))) 
	{
		log_message("INFO",":: ".$array["JobID"]." Not Able to aquire ReLock At ".date("D M j G:i:s T Y"));
		return false;
	}
	log_message("INFO",":: ".$array["JobID"]." enter in status queue with ".$array["Destination"]." At ".date("D M j G:i:s T Y"));
	return true;
}/// -- END::lock() --	
/*
function send_req($destinaiton = array() , $preview =  array()){
	$url = config::getInst()->getKeyValue("curl_url");
	$ch      = curl_init( $url );
	curl_setopt($ch, CURLOPT_POST ,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS    ,$status);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION  ,1);
	curl_setopt($ch, CURLOPT_HEADER      ,0);  // DO NOT RETURN HTTP HEADERS
	curl_setopt($ch, CURLOPT_RETURNTRANSFER  ,1);  // RETURN THE CONTENTS OF THE CALL
	$content = curl_exec( $ch );
	$err     = curl_errno( $ch );
	$errmsg  = curl_error( $ch );
	$header  = curl_getinfo( $ch );
	curl_close( $ch );

	log_message("INFO"," UPDATE DATBASE STATUS :: Content::".$content);	
	return $content;	
}*/
	?>
