<?php 
/**
 * @Author : Anoop singh
 * @Email  : anoop.immortal@gmail.com
 * @Timestamp : July-31 06:11PM
 * @Copyright : www.cdnsol.com
**/

	date_default_timezone_set('Europe/Luxembourg');
	// -- Check if file YAML file exists --
	define("BASEPATH",dirname(__FILE__));
	// -- File Extension --
	define("EXT",".php");
	
	
	// -- Check if file Common file exists --
	if(file_exists(dirname(__FILE__).'/inc/common'.EXT))
	{
		include(dirname(__FILE__).'/inc/common'.EXT);
		log_message("ALL","All files include successfully");
	}	
	
	if(isset($_POST["key"]) && $_POST["key"]==config::getInst()->getKeyValue("encryption_key"))
	{
		log_message("ALL","QueueMedia will run for --> EXTERNAL (".$_SERVER["REQUESTED_URI"].")");
		
	} else {
		
		/// -- Log Message to Log file for Type of call --
		log_message("ALL","QueueMedia will run for --> INTERNAL ()");
		
		/// -- Traverse Directory And find if there is any new .renderjob file availabe in it --
		$ite=new RecursiveIteratorIterator(new RecursiveDirectoryIterator(config::getInst()->getKeyValue("media_queue_inqueue"),RecursiveIteratorIterator::SELF_FIRST));
		foreach ( $ite as $filename=>$cur) 
		{
			processQueue($ite);
		}// END FOR $ite as $filename=>$cur --
		exit();
		
	}// -- FII :: $_POST["key"] --
	
	
function processQueue($ite){
	/// -- Check for file name and JobId so, that both needs to be same --
	$fileName=explode(config::getInst()->getKeyValue("renderjob"),$ite->getFilename());

	/// -- Patter for .renderjob file --
	$pattern='/^.+'.config::getInst()->getKeyValue("renderjob").'$/i';
	preg_match($pattern, $ite->getFilename(), $matches);
	$fail_message ='';
	if(count($matches)>0)
	{
		/// -- Load YAML config file from given file and read as array --
		$array = Spyc::YAMLLoad(config::getInst()->getKeyValue("media_queue_inqueue").$ite->getFilename());
		
		if(array_key_exists("Type",$array) && array_key_exists("JobID",$array))
		{
			if($fileName[0]==$array["JobID"])
			{
				/// -- Check for file Type If it is availabe in our COnfig Array for conversion --
				if(in_array(strtolower($array["Type"]),config::getInst()->getKeyValue("media_format_queue")))
				{
					/// -- Check if converted file is accessable to given path or not --
					if(file_exists($array["Source"]))
					{
						/// -- Check if Able to Aquire Lock on file --
						if(lock($ite,$array))
						{
								/// -- Check type of converted file and execute dedicated command --
								
								$mediaType= strtolower($array["Type"]);
								
								switch($mediaType){
									/// -- Convert pdf to swf file --
									case 'pdf':
											pdfToSwf($array);
									break;
									/// -- Convert audio to MP3 file --
									case 'm4a':
									case 'mp2':
									case 'mp3':
									case 'aac':
									case 'wma':
									case 'wav':
											in_array($array["Type"], config::getInst()->getKeyValue("audio_format_queue"));
											audioToMp3($array);
									break;
									
									/// -- Convert video files assume that by default all the file extension is video file extenssion
									case '3gp':
									case 'avi':
									case 'wmv':
									case 'mp4':
									case 'f4v':
									case 'flv':
									case 'mov':
									case 'mpg':
									case 'divx':
									case 'm2v':
									case 'm4v':
									case 'vob':
									
											mediaToMp4($array);
									break;
									
									default:
											'No Type Found.';
									break;
									
								}/// -- switch case end --
								
								if(!isset($result)){$result= '';}
								
								if(file_exists($array["Destination"]))
								{
								
									if(isset($array["Preview"]) && $array["Preview"]){
										Mp3Clip($array);
									}

									log_message("INFO",":: ".$array["Source"]." Converted successfully to ".$array["Destination"]." At ".date("D M j G:i:s T Y")."\n".$result);

									///TODO: Move .renderjob file to trash folder
									if (!copy(config::getInst()->getKeyValue("media_queue_inqueue").$array["JobID"].config::getInst()->getKeyValue("lockjob"), config::getInst()->getKeyValue("media_queue_trash").$array["JobID"].config::getInst()->getKeyValue("done"))) {
										log_message("INFO",":: ".$array["JobID"].config::getInst()->getKeyValue("lockjob")." Failed to Copy from Inqueue to Trash  At ".date("D M j G:i:s T Y")."\n");
									}
									else{
									  unlink(config::getInst()->getKeyValue("media_queue_inqueue").$array["JobID"].config::getInst()->getKeyValue("lockjob"));
									  log_message("INFO",":: ".$array["JobID"].config::getInst()->getKeyValue("lockjob")." Moved from Inqueue to Trash  At ".date("D M j G:i:s T Y")."\n");
									}/// -- FI::copy() --	
									
								}else{
									log_message("INFO",":: ERROR Occer while converting ".$array["Source"]." At ".date("D M j G:i:s T Y")."\n".$result."\n");
									
								}/// -- FII :: file_exists($array["Destination"]) --
						}/// -- FII: lock() --	
					}else{
						$fail_message = "-- Source file : ".$array["Source"]." Dosent exists -- ";
						log_message("INFO",":: -- Source file '".$array["Source"]."' Dosent exists -- ".date("D M j G:i:s T Y")."\n");
					}/// -- FII :: file_exists($array["Source"]) --
				}else{
					//TODO: Nothing to do	
					//$fail_message = "File Type not found. Requested file ext is EXT:".$array["Type"]." Not found in Config file ";
					//log_message("INFO",":: ERROR File Type not found. Requested file ext is EXT:".$array["Type"]." Not found in Config file ".date("D M j G:i:s T Y"));
					
				}/// -- FII :: in_array($array["Type"],config::getInst()->getKeyValue("media_format_queue")) --
			}else{
				$fail_message = "Field Miss Match JobId , Filename:".$fileName[0].", JobId:".$array["JobID"]."";
				log_message("INFO",":: ERROR Occer Field Miss Match 'JobId', Filename:".$fileName[0].", JobId:".$array["JobID"].", ".date("D M j G:i:s T Y")." !!!!");
				
			}/// -- FII :: $fileName[0]==$array["JobID"] --
		}else{
			$fail_message = "ERROR Occer while reading renderjob file for Field Missin Type and JobId At ".$ite->getFilename()." ";
			log_message("INFO",":: ERROR Occer while reading renderjob file for Field Missin Type and JobId At ".$ite->getFilename()." ". date("D M j G:i:s T Y")." !!!!");
		}/// -- FII :: array_key_exists("Type",$array) && array_key_exists("JobID",$array) --
		
		if($fail_message !=''){
			// UDPATE FAIL MESSAGE IN DATABSE 
				if(in_array(strtolower($array["Type"]),config::getInst()->getKeyValue("media_format_queue")))
				{
					$db = db_connect();
					if($db){
						$rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'FAILS\', "statusDetail" = \''.$fail_message.'\' WHERE  "fileId" ='.$array["JobID"]);
					}	
				}
		}
	}/// -- FII :: count($matches)>0 --
			
		
}/// -- END::process() --	
	
function lock($ite,$array){
	/// -- Create LOCK on file --
	if(!rename(config::getInst()->getKeyValue("media_queue_inqueue").$ite->getFilename(),config::getInst()->getKeyValue("media_queue_inqueue").$array["JobID"].config::getInst()->getKeyValue("lockjob"))) 
	{
		log_message("INFO",":: ".$array["JobID"]." Not Able to aquire Lock At ".date("D M j G:i:s T Y"));
		return false;
	}
	log_message("INFO",":: ".$array["JobID"]." enter in queue with ".$array["Source"]." At ".date("D M j G:i:s T Y"));
	return true;
}/// -- END::lock() --	

function unLock($ite,$array){
	/// -- Create LOCK on file --
	if(!rename(config::getInst()->getKeyValue("media_queue_inqueue").$array["JobID"].config::getInst()->getKeyValue("lockjob"),config::getInst()->getKeyValue("media_queue_inqueue").$ite->getFilename())) 
	{
		log_message("INFO",":: ".$array["JobID"]." Not Able to Leave Lock At ".date("D M j G:i:s T Y"));
		return false;
	}
	log_message("INFO",":: ".$array["JobID"]." Not Able to Leave Lock At ".date("D M j G:i:s T Y"));
	return true;
}/// -- END::unLock() --	

function mediaToMp4($array){
	ob_start();
	
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	/*if($SERVERADDR=='94.242.251.14' || $SERVERADDR=='94.242.254.30')
		{
			passthru ("/usr/local/bin/ffmpeg -y -i '".$array["Source"]."' -crf 25.0 -vcodec libx264 -acodec libfaac -ar 48000 -coder 1 -flags +loop -cmp +chroma -partitions +parti4x4+partp8x8+partb8x8 -me_method hex -subq 6 -me_range 16 -g 250 -keyint_min 25 -sc_threshold 40 -i_qfactor 0.71 -b_strategy 1 -qcomp 0.6 -qmin 0 -qmax 69 -qdiff 4 -bf 3 -refs 8 -direct-pred 3 -trellis 2 -wpredp 2 -rc-lookahead 60 -threads 0 '".$array["Destination"]."'",$result);
		}else
		{
			passthru ("/usr/local/bin/ffmpeg -y -i '".$array["Source"]."' -crf 25.0 -vcodec libx264 -acodec libfaac -ar 48000 -coder 1 -flags +loop -cmp +chroma -partitions +parti4x4+partp8x8+partb8x8 -me_method hex -subq 6 -me_range 16 -g 250 -keyint_min 25 -sc_threshold 40 -i_qfactor 0.71 -b_strategy 1 -qcomp 0.6 -qmin 0 -qmax 69 -qdiff 4 -bf 3 -refs 8 -direct-pred 3 -trellis 2 -wpredp 2 -rc-lookahead 60 -threads 0 '".$array["Destination"]."'",$result);
		}*/
	passthru ("/usr/local/bin/ffmpeg -y -i '".$array["Source"]."' -movflags faststart -crf 25.0 -vcodec libx264 -acodec libfaac -ar 48000 -coder 1 -flags +loop -cmp chroma -partitions +parti4x4+partp8x8+partb8x8 -me_method hex -subq 6 -me_range 16 -g 250 -keyint_min 25 -sc_threshold 40 -i_qfactor 0.71 -b_strategy 1 -qcomp 0.6 -qmin 0 -qmax 69 -qdiff 4 -bf 3 -refs 8 -direct-pred 3 -trellis 2 -wpredp 2 -rc-lookahead 60 -threads 0 '".$array["Destination"]."'",$result);
	$content_grabbed=ob_get_contents();
	ob_end_clean();
    log_message("INFO",":: ".$content_grabbed);	
    
    //update then file length of video file
    if(file_exists($array["Source"])){
        
        $command= "/usr/local/bin/ffmpeg -y -i '".$array["Source"]."'";
        exec($command." 2>&1", $output);
        
        //$filePath = dirname(dirname(__FILE__)).'/queue/logs/test.txt';
        //file_put_contents($filePath, print_r($output, true));
        
        $duration   =  (!empty($output[17]) && strpos($output[17],'Duration')!== false)?$output[17]:'';
        $duration   =  fileLength($duration);
        
        $db = db_connect(); 
        if($db){
            $rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "fileLength" = \''.$duration.'\' WHERE  "fileId" ='.$array["JobID"]);	
        }
    }
	
	//log message in databse if there is any error in converstion and destination file is not present 
	if(!file_exists($array["Destination"])){
		$db = db_connect();
		if($db){
			$rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'FAILS\', "statusDetail" = \' Error  at '.date("D M j G:i:s T Y").' :- '.$content_grabbed.'\' WHERE  "fileId" ='.$array["JobID"]);	
		}
	}else
	{
		// create videos thumbs different-different size
		createVideoThumb($array);
	}
	
	
}/// -- END::mediaToMp4() --	

//-------create thumb capture for video-------//

function createVideoThumb($array){
	ob_start();
	
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	//--------set image dimension--------//
	$size_75_75 = '75x75';
	$size_100_100 = '100x100';
	$size_160_160 = '160x160';
	$size_240_240 = '240x240';
	$size_480_480 = '480x480';
	$size_600_600 = '600x600';
	
	//----------source image info-------//
	$imageInfo = pathinfo($array["Source"]);

	//---------set output image names----------//
	$D_75_75 =  $array["ThumbPath"].'thumb/'.$imageInfo['filename'].'_xxs.jpg';
	$D_100_100 =  $array["ThumbPath"].'thumb/'.$imageInfo['filename'].'_xs.jpg';
	$D_160_160 =  $array["ThumbPath"].'thumb/'.$imageInfo['filename'].'_s.jpg';
	$D_240_240 =  $array["ThumbPath"].'thumb/'.$imageInfo['filename'].'_m.jpg';
	$D_480_480 =  $array["ThumbPath"].'thumb/'.$imageInfo['filename'].'_b.jpg';
	$D_600_600 =  $array["ThumbPath"].'thumb/'.$imageInfo['filename'].'_l.jpg';
	
	//----------set time for capturing image----------//
		//$captureTime='00:00:08'; old code
	
		passthru("ffmpeg -i \"". $array["Source"]. "\" 2>&1");
		$duration = ob_get_contents();
		ob_end_clean();

		preg_match('/Duration: (.*?),/', $duration, $matches);
		$captureTime = "00:00:02";
		
		if($matches){
			if(isset($matches[1])){
				$duration = $matches[1];
				$duration_array = split(':', $duration);
				if(isset($duration_array[2])) {
					if($duration_array[2] > 6){
						$captureTime = "00:00:05";
					}else{
						$captureTime = $duration;
					}
				}
			}
		}
	
	
	//--------create thumb directory start--------//
	$imgThumbPath = $array["ThumbPath"].'thumb/';
	$cmdimgFolderPath = 'chmod -R 0777 '.$array["ThumbPath"];
	exec($cmdimgFolderPath);
	if (!is_dir($imgThumbPath)) {
		if (!mkdir($imgThumbPath, 0777, true)) 
		{
			die('Failed to create folders...');
		}
	}
	
	$cmdImgThumbPath = 'chmod -R 0777 '.$imgThumbPath;
	exec($cmdImgThumbPath);
	//--------create thumb directory end--------//
	
	passthru ("/usr/local/bin/ffmpeg -i '".$array["Source"]."' -an -s '".$size_75_75."' -ss '".$captureTime."' -r 1 -y '".$D_75_75."' -s '".$size_100_100."' -ss '".$captureTime."' -r 1 -y '".$D_100_100."' -s '".$size_160_160."' -ss '".$captureTime."' -r 1 -y '".$D_160_160."' -s '".$size_240_240."' -ss '".$captureTime."' -r 1 -y '".$D_240_240."' -s '".$size_480_480."' -ss '".$captureTime."' -r 1 -y '".$D_480_480."' -s '".$size_600_600."' -ss '".$captureTime."' -r 1 -y '".$D_600_600."'",$result);
	$content_grabbed=ob_get_contents();
	ob_end_clean();
	
}/// -- END::createVideoThumb() --

function pdfToSwf($array){
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	if($SERVERADDR=='94.242.251.14' || $SERVERADDR=='94.242.254.30')
		{
			define('swf2pdf_LIBRARY', '/usr/local/bin/pdf2swf ');
		}else
		{
			define('swf2pdf_LIBRARY', '/usr/local/bin/pdf2swf ');
		}
	ob_start();
		$exec_string = swf2pdf_LIBRARY . $array["Source"].'  -o '.$array["Destination"];
		passthru($exec_string);
		$content_grabbed=ob_get_contents();
	ob_end_clean();
	log_message("INFO",":: pdfToSwf:: ".$content_grabbed);
	//log message in databse if there is any error in converstion and destination file is not present 
	if(!file_exists($array["Destination"])){
		$db = db_connect();
		if($db){
			$content_grabbed = str_replace("'", "", $content_grabbed);
			$rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'FAILS\', "statusDetail" = \'Error  at '.date("D M j G:i:s T Y").' :- '.$content_grabbed.'\' WHERE  "fileId" ='.$array["JobID"]);	
		}
	}
}/// -- END::pdfToSwf() --	

function audioToMp3($array){
	
	ob_start();
	
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	/*if($SERVERADDR=='94.242.251.14' || $SERVERADDR=='94.242.254.30')
		{
			passthru ("/usr/local/bin/ffmpeg -y -i '".$array["Source"]."' -acodec libmp3lame -b:a 160k -ac 2 -ar 44100 '".$array["Destination"]."'",$result);
		}else
		{
			passthru ("/usr/local/bin/ffmpeg -y -i '".$array["Source"]."' -acodec libmp3lame -b:a 160k -ac 2 -ar 44100 '".$array["Destination"]."'",$result);
		}*/
	//---------code comment by lokendra on date 2-July-2013-------------//
	//passthru ("/usr/local/bin/ffmpeg -y -i '".$array["Source"]."' -acodec libmp3lame -b:a 160k -ac 2 -ar 44100 '".$array["Destination"]."'",$result);
	passthru ("/usr/local/bin/ffmpeg -y -i '".$array["Source"]."' -vcodec mjpeg -qscale 1 '".$array["Destination"]."'",$result);
	$content_grabbed=ob_get_contents();
    ob_end_clean();
	log_message("INFO",":: ".$content_grabbed);	
    
    //update then file length of audio file
    if(file_exists($array["Source"])){
        
        $command= "/usr/local/bin/ffmpeg -y -i '".$array["Source"]."'";
        exec($command." 2>&1", $output);
        
        $duration   =  (!empty($output[24]) && strpos($output[24],'Duration')!== false)?$output[24]:'';
        $duration   =  fileLength($duration);
        
        $db = db_connect(); 
        if($db){
            $rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "fileLength" = \''.$duration.'\' WHERE  "fileId" ='.$array["JobID"]);	
        }
    }
    
    
    //log message in databse if there is any error in converstion and destination file is not present 
	if(!file_exists($array["Destination"])){
		$db = db_connect();
		if($db){
			$content_grabbed = str_replace("'", "", $content_grabbed);
			$rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'FAILS\', "statusDetail" = \'Error  at '.date("D M j G:i:s T Y").' :- '.$content_grabbed.'\' WHERE  "fileId" ='.$array["JobID"]);	
		}
	}	
}/// -- END::audioToMp3() --	

function Mp3Clip($array){
	ob_start(); 
	$SERVERNAME=exec("hostname -f");
	$SERVERADDR=exec("hostname -i");
	
	/*if($SERVERADDR=='94.242.251.14' || $SERVERADDR=='94.242.254.30')
		{
			passthru ("/usr/local/bin/ffmpeg -t ".config::getInst()->getKeyValue("sample_clip_duration")." -y -i  '".$array["Destination"]."' -acodec libmp3lame -b:a 160k -ac 2 -ar 44100 '".$array["Preview"]."'",$result);
		}else
		{
			passthru ("/usr/local/bin/ffmpeg -t ".config::getInst()->getKeyValue("sample_clip_duration")." -y -i  '".$array["Destination"]."' -acodec libmp3lame -b:a 160k -ac 2 -ar 44100 '".$array["Preview"]."'",$result);
		}*/
	//---------code comment by lokendra on date 2-July-2013-------------//
	//passthru ("/usr/local/bin/ffmpeg -t ".config::getInst()->getKeyValue("sample_clip_duration")." -y -i  '".$array["Destination"]."' -acodec libmp3lame -b:a 160k -ac 2 -ar 44100 '".$array["Preview"]."'",$result);
	passthru ("/usr/local/bin/ffmpeg -t ".config::getInst()->getKeyValue("sample_clip_duration")." -y -i  '".$array["Destination"]."' -vcodec mjpeg -qscale 1 '".$array["Preview"]."'",$result);
	$content_grabbed=ob_get_contents();
	ob_end_clean();
	log_message("INFO",":: ".$content_grabbed);
//log message in databse if there is any error in converstion and destination file is not present 
	if(!file_exists($array["Preview"])){
		$db = db_connect();
		if($db){
			$content_grabbed = str_replace("'", "", $content_grabbed);
			$rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'FAILS\', "statusDetail" = \' media Clip is not converted properly due to resion:- '.date("D M j G:i:s T Y").' '.$content_grabbed.'\' WHERE  "fileId" ='.$array["JobID"]);	
		}
	}
}/// -- END::Mp3Clip() --

//-----------------------------------------------------------
/*
 *  @description: This method is use to get audio/video file duration
 *  @auther: lokendra meena
 *  @return: string
 */ 

    function fileLength($duration=""){
         $time = "00:00:00";
        if(!empty($duration)){  
       
        $percent = 100;
        
        preg_match('/Duration: (.*?),/', $duration, $matches);
        
            if(!empty( $matches[1])){
                $duration = $matches[1];
                $duration_array = split(':', $duration);
                if(!empty($duration_array)){
                    $duration = $duration_array[0] * 3600 + $duration_array[1] * 60 + $duration_array[2];
                    $time = $duration * $percent / 100;
                    $time = intval($time/3600) . ":" . intval(($time-(intval($time/3600)*3600))/60) . ":" . intval(($time-(intval($time/60)*60)));
                }
            }   
        }
        
        return $time;
    }


/* Backup Purpose Commands
/// -- Command to convert video and store it on desires location --
//$result=shell_exec("ffmpeg -y -i '".$array["Source"]."' -crf 25.0 -vcodec libx264 -acodec libfaac -ar 48000 -coder 1 -flags +loop -cmp +chroma -partitions +parti4x4+partp8x8+partb8x8 -me_method hex -subq 6 -me_range 16 -g 250 -keyint_min 25 -sc_threshold 40 -i_qfactor 0.71 -b_strategy 1 -qcomp 0.6 -qmin 0 -qmax 69 -qdiff 4 -bf 3 -refs 8 -direct-pred 3 -trellis 2 -wpredp 2 -rc-lookahead 60 -threads 0 '".$array["Destination"]."'");
*/	
/* End of file queueMedia.php */
/* Location: ./queueMedia.php */
?>
