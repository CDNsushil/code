<?php 
/**
 * @Author : Sushil Mishra
 * @Email  : sushilmishra2cdnsol.com
 * @Timestamp : Feb-26 06:51PM 
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
	if(file_exists(dirname(__FILE__).'/expiryAlert'.EXT))
	{
		include(dirname(__FILE__).'/expiryAlert'.EXT);
		log_message("ALL","All files include successfully");
	}
	if(isset($_POST["key"]) && $_POST["key"]==config::getInst()->getKeyValue("encryption_key"))
	{
		log_message("ALL","expiryCheck will run for --> EXTERNAL (".$_SERVER["REQUESTED_URI"].")");
		
	} else {
		
		/// -- Log Message to Log file for Type of call --
		log_message("ALL","expiryCheck will run for --> INTERNAL ()");
		$db_job = expiryCheck();
		exit();
		
	}// -- FII :: $_POST["key"] --
	

function expiryCheck(){
	$db = db_connect();
	
	$currentDate=date('Y-m-d');
	$res = pg_query($db, 'SELECT * from "TDS_UserContainer" where "entityId" > 0 AND "elementId" > 0 AND "expiryDate" < \''.$currentDate.'\' AND "isExpired" = \'f\' ');
	if($db){
		while ($row = pg_fetch_assoc($res)) {
		
			$istable=true;
			$isElements=false;
			$eventWithLaunch=false;
			
			$tableElement='';
			$primeryFieldElement='';
			$publishFieldElement='';
			$archiveFieldElement='';
			
			if(isset($row['entityId']) && isset($row['elementId']) && $row['entityId'] > 0 && $row['elementId'] >0){
				
				switch($row['entityId']){
					case 93: 
						$table='TDS_UserShowcase';
						$primeryField='showcaseId';
						$publishField='isPublished';
						$archiveField='isArchive';
						break;
					case 86: 
						$table='TDS_WorkProfile';
						$primeryField='workProfileId';
						$publishField='isPublished';
						$archiveField='isArchive';
						break;
					case 71: 
						$table='TDS_UpcomingProject';
						$primeryField='projId';
						$publishField='isPublished';
						$archiveField='projArchived';
						break;
					case 82: 
						$table='TDS_Work';
						$primeryField='workId';
						$publishField='isPublished';
						$archiveField='workArchived';
						break;
					case 49: 
						$table='TDS_Product';
						$primeryField='productId';
						$publishField='isPublished';
						$archiveField='productArchived';
						break;
					case 97: 
						$table='TDS_Blogs';
						$primeryField='blogId';
						$publishField='blogPublish';
						$archiveField='isArchive';
						
						$isElements=true;
						$tableElement='TDS_Posts';
						$primeryFieldElement='blogId';
						$publishFieldElement='isPublished';
						//$archiveFieldElement='postArchived';
						break;
					case 9: 
						$table='TDS_Events';
						$primeryField='EventId';
						$publishField='isPublished';
						$archiveField='EventArchive';
						if($row['pkgSections']=='{9:4}'){
							$eventWithLaunch=true;
						}
						break;
					case 15: 
						$table='TDS_LaunchEvent';
						$primeryField='LaunchEventId';
						$publishField='isPublished';
						$archiveField='isArchive';
						break;
						
					case 54: 
						$table='TDS_Project';
						$primeryField='projId';
						$publishField='isPublished';
						$archiveField='isArchive';
						
						$isElements=true;
						if($row['pkgSections']=='{1}'){
							$tableElement='TDS_FvElement';
						}elseif($row['pkgSections']=='{2}'){
							$tableElement='TDS_MaElement';
						}elseif($row['pkgSections']=='{3}'){
							$tableElement='TDS_WpElement';
						}elseif($row['pkgSections']=='{3:1}'){
							$tableElement='TDS_NewsElement';
						}elseif($row['pkgSections']=='{3:2}'){
							$tableElement='TDS_ReviewsElement';
						}elseif($row['pkgSections']=='{4}'){
							$tableElement='TDS_PaElement';
						}elseif($row['pkgSections']=='{10}'){
							$tableElement='TDS_EmElement';
						}
						$primeryFieldElement='projId';
						$publishFieldElement='isPublished';
						break;
						
					default:
						$istable=false;
								
				}
				
				if($istable){
					$result = pg_query($db, 'UPDATE "'.$table.'" SET "'.$publishField.'" = \'f\', "'.$archiveField.'" = \'t\', "isExpired" = \'t\'  WHERE "'.$primeryField.'" = '.$row['elementId']);	
					if($result){
						log_message("INFO",":: successfully updates, Table:".$table.",".$primeryField.":".$row['elementId'].", ".date("D M j G:i:s T Y")."");
						
						$res1=pg_query($db, 'UPDATE "TDS_search" SET "ispublished" = \'f\' ,"isdeleted"=\'t\',"datemodified" = \''.date('Y-m-d h:i:s').'\' WHERE "entityid" = '.$row['entityId'].' AND "elementid" = '.$row['elementId']);
						if($res1){
							log_message("INFO",":: successfully updates, Table:TDS_search, entityId: ".$row['entityId'].": elementid:".$row['elementId'].", ".date("D M j G:i:s T Y")."");
						}else{
							log_message("INFO",":: Eroor is Occerd to updates, Table:TDS_search, entityId: ".$row['entityId'].": elementid:".$row['elementId'].", ".date("D M j G:i:s T Y")."");
						}
						if($isElements){
							$res2=pg_query($db, 'UPDATE "'.$tableElement.'" SET "'.$publishFieldElement.'" = \'f\'  WHERE "'.$primeryFieldElement.'" = '.$row['elementId']);
							if($res2){
								log_message("INFO",":: successfully updates, Table:".$tableElement.",".$primeryFieldElement.":".$row['elementId'].", ".date("D M j G:i:s T Y")."");
							
								$res3=pg_query($db, 'UPDATE "TDS_search" SET "ispublished" = \'f\' ,"isdeleted"=\'t\',"datemodified" = \''.date('Y-m-d h:i:s').'\' WHERE "entityid" = '.$row['entityId'].' AND "projectid" = '.$row['elementId']);
								if($res3){
									log_message("INFO",":: successfully updates, Table:TDS_search, entityId: ".$row['entityId'].": projectid:".$row['elementId'].", ".date("D M j G:i:s T Y")."");
								}else{
									log_message("INFO",":: Eroor is Occerd to updates, Table:TDS_search, entityId: ".$row['entityId'].": projectid:".$row['elementId'].", ".date("D M j G:i:s T Y")."");
								}
							}else{
								log_message("INFO",":: Eroor is Occerd to updates, Table:".$tableElement.",".$primeryFieldElement.":".$row['elementId'].", ".date("D M j G:i:s T Y")."");
							}
								
						}
						
						if($eventWithLaunch){
							$launchResult = pg_query($db, 'SELECT "LaunchEventId" from "TDS_LaunchEvent" where "userContainerId" = '.$row['userContainerId'].' ');
							while ($rows = pg_fetch_assoc($launchResult)) {
								if(isset($rows['LaunchEventId']) && $rows['LaunchEventId'] >0){
									$res4=pg_query($db, 'UPDATE "TDS_LaunchEvent" SET "isPublished" = \'f\', "isArchive" = \'t\', "isExpired" = \'t\'  WHERE "LaunchEventId" = '.$rows['LaunchEventId']);
									if($res4){
										log_message("INFO",":: successfully updates, Table:TDS_LaunchEvent ,LaunchEventId:".$rows['LaunchEventId'].", ".date("D M j G:i:s T Y")."");
										$res5=pg_query($db, 'UPDATE "TDS_search" SET "ispublished" = \'f\' ,"isdeleted"=\'t\',"datemodified" = \''.date('Y-m-d h:i:s').'\' WHERE "entityid" = 15 AND "elementid" = '.$rows['LaunchEventId']);
										if($res5){
											log_message("INFO",":: successfully updates, Table:TDS_search, entityId: 15, : elementid:".$rows['LaunchEventId'].", ".date("D M j G:i:s T Y")."");
										}else{
											log_message("INFO",":: Eroor is Occerd to updates, Table:TDS_search, entityId: 15, : elementid:".$rows['LaunchEventId'].", ".date("D M j G:i:s T Y")."");
										}
									}else{
										log_message("INFO",":: Eroor is Occerd to updates, Table:TDS_LaunchEvent ,LaunchEventId:".$rows['LaunchEventId'].", ".date("D M j G:i:s T Y")."");
									}
									
								}
							}
						}
						//$resultExpiry = pg_query($db, 'UPDATE "TDS_UserContainer" SET "isExpired" = \'t\', "isSentExpiryMail" = \'t\'  WHERE "userContainerId" = '.$row['userContainerId']);	
					}else{
						log_message("INFO",":: Eroor is Occerd to updates, Table:".$table.",".$primeryField.":".$row['elementId'].", ".date("D M j G:i:s T Y")."");
					}
				}
			}
		}
			
		if(function_exists('expiryAlert')){
			expiryAlert();
		}
	}
}
?>
