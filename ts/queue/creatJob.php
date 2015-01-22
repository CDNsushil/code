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
	ini_set('display_errors','1');
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
		$db_job = readDb();
		exit();
		
	}// -- FII :: $_POST["key"] --
	

function readDb(){
	$db = db_connect();

	//select * from "TDS_MediaFile" WHERE "fileType" in ('2','3','video','Video','audio','AUDIO''') AND "TDS_MediaFile"."isExternal"	='f' AND "jobStsatus" = 'NEW' 
	if($db){
		$res = pg_query($db, 'select * from "TDS_MediaFile" WHERE "fileType" in (\'2\',\'3\',\'4\',\'video\',\'Video\',\'audio\',\'AUDIO\',\'text\',\'TEXT\') AND "isExternal"
		=\'f\' AND "jobStsatus" = \'NEW\' ');
		
		
		
		while ($row = pg_fetch_assoc($res)) {
		
			//if(mime_content_type($row['fileName']) ==  )
		//	echo mime_content_type('opt/lampp/htdocs/toadsquare/temp/toadsquare/dev/media/2Kj01iEk/project/Video_Sideways.wmv');//.$row['filePath'].$row['fileName']);
			//print_r($row);
			
			
			//get file information like extension,filename without extension etc
			$fileInfo = pathinfo($row['fileName']);;
			
			// define array here and set values in switch case to check (like if(empty ($params()) for any errors before create render job file. 
			$params = array(); 
			if($row['filePath'] != '' && $row['fileName'] != '' && $fileInfo['filename'] != ''){
				
				$fpLen=strlen($row['filePath']);
				if($fpLen > 0 && substr($row['filePath'],-1) != '/'){
					$row['filePath']=$row['filePath'].'/';
				}
				
				switch($row['fileType']){
					case 1:
					case 'image':
					case 'IMAGES':
						$params['JobID'] = $row['fileId'];
						$params['Type'] = $fileInfo['extension'];
						$params['Source'] =  config::getInst()->getKeyValue("root_path").$row['filePath'].$row['fileName'];
						$params['Destination'] =  config::getInst()->getKeyValue("root_path").$row['filePath'].'converted/'.$fileInfo['filename'].'.jpg';
						$params['Added'] = date('Y-m-d H:i:s');
						break;
					case 2:	
					case 'video':
					case 'VIDEO':
						$params['JobID'] = $row['fileId'];
						$params['Type'] = $fileInfo['extension'];;
						$params['Source'] =  config::getInst()->getKeyValue("root_path").$row['filePath'].$row['fileName'];
						$params['Destination'] =  config::getInst()->getKeyValue("root_path").$row['filePath'].'converted/'.$fileInfo['filename'].'.mp4';
						$params['ThumbPath'] = config::getInst()->getKeyValue("root_path").$row['filePath'];
						$params['Added'] = date('Y-m-d H:i:s');
						break;
					case 3:
					case 'audio':
					case 'AUDIO':
						$params['JobID'] = $row['fileId'];
						$params['Type'] = $fileInfo['extension'];;
						$params['Source'] =  config::getInst()->getKeyValue("root_path").$row['filePath'].$row['fileName'];
						$params['Destination'] =  config::getInst()->getKeyValue("root_path").$row['filePath'].'converted/'.$fileInfo['filename'].'.mp3';
						$params['Preview'] = config::getInst()->getKeyValue("root_path").$row['filePath'].'converted/'.$fileInfo['filename'].'_preview'.'.mp3';;
						$params['Added'] = date('Y-m-d H:i:s');
						break;
					case 4:
					case 'text':
					case 'TEXT':
						$params['JobID'] = $row['fileId'];
						$params['Type'] = $fileInfo['extension'];;
						$params['Source'] = config::getInst()->getKeyValue("root_path").$row['filePath'].$row['fileName'];
						$params['Destination'] = config::getInst()->getKeyValue("root_path").$row['filePath'].'converted/'.$fileInfo['filename'].''.'.swf';
						$params['Added'] = date('Y-m-d H:i:s');
						break;		
				}
			}else{
				$fail_message = 'Table field filePath or fileName is not set at'. date('D-m-Y H:i:s');
				$fail = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'FAILS\', "statusDetail" = \''.$fail_message.'\'WHERE "fileId" = \' '.$row['fileId'] .' \' AND "jobStsatus" = \'NEW\' ') or die();	
			}
			//var_dump($params);
			// check all fiels od render job is set or not
			
			
			//--------------create render jobs---------------//
			switch($row['fileType']){
					case 1:
					case 'image':
					case 'IMAGES':
					case 2:	
					case 'video':
					case 'VIDEO':
					case 3:
					case 'audio':
					case 'AUDIO':
						if(!empty($params)){
							if(!is_dir(config::getInst()->getKeyValue("root_path").$row['filePath'].'/converted')){
								@mkdir(config::getInst()->getKeyValue("root_path").$row['filePath'].'/converted');
							}
							// update jobStatus in databse if render job file is created successfully
							if(renderjob($params)){
								//echo '<br> UPDATE "TDS_MediaFile" SET "jobStsatus" = \'INPROGRESS\' WHERE "fileId" = \' '.$row['fileId'] .' \' AND "jobStsatus" = \'NEW\' ' ; //continue;
								
								$rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'INPROGRESS\' WHERE "fileId" = \' '.$row['fileId'] .' \' AND "jobStsatus" = \'NEW\' ') or die();	
								
							}
						}
						break;
					case 4:
					case 'text':
					case 'TEXT':
						if($fileInfo['extension']=="pdf") {
							if(!empty($params)){
								if(!is_dir(config::getInst()->getKeyValue("root_path").$row['filePath'].'/converted')){
									@mkdir(config::getInst()->getKeyValue("root_path").$row['filePath'].'/converted');
								}
								// update jobStatus in databse if render job file is created successfully
								if(renderjob($params)){
									//echo '<br> UPDATE "TDS_MediaFile" SET "jobStsatus" = \'INPROGRESS\' WHERE "fileId" = \' '.$row['fileId'] .' \' AND "jobStsatus" = \'NEW\' ' ; //continue;
									
									$rec = pg_query($db, 'UPDATE "TDS_MediaFile" SET "jobStsatus" = \'INPROGRESS\' WHERE "fileId" = \' '.$row['fileId'] .' \' AND "jobStsatus" = \'NEW\' ') or die();	
									
								}
							}
						}
						break;		
				}
		}
		
	}

}
?>
