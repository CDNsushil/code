<?php 
	/**
	 * @Author : Sushil Mishra
	 * @Email  : sushilmishra@cdnsol.com
	 * @Timestamp : June-3 2013 06:51PM 
	 * @Copyright : www.cdnsol.com 
	**/
	
	date_default_timezone_set('Europe/Luxembourg');
	// -- Check if file YAML file exists --
	define("BASEPATH",dirname(__FILE__));
	define("ROOTPATH",dirname(dirname(__FILE__)).'/');
	
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
		$db_job = moveDeletedItemstIntoTrash();
		exit();
		
	}// -- FII :: $_POST["key"] --
	

	function moveDeletedItemstIntoTrash(){
		$returnData=getDeletedProjects();
		$projectsField=$returnData[0];
		if($projectsField){
			moveIntoTrash($returnData);
		}
	}

	function getDeletedProjects($deleteQuery=array()){
		$db = db_connect();
		$datemodified=date("Y-m-d", strtotime("-1 month") );
		
		$sql=' SELECT "id","entityid","elementid","projectid","sectionid",(item).userid,(item).category,(item).work_type,"section","cachefile","TDS_UserAuth"."username" From "TDS_search" ';
		$sql.=' LEFT JOIN "TDS_UserAuth" ON "TDS_UserAuth"."tdsUid" = (item).userid ';
		$sql.=' where "ispublished" = \'f\' AND "isdeleted" = \'t\' AND "datemodified" < \''.$datemodified.'\' ';
		
		$res = pg_query( $db, $sql);
		$projectsField=false;
		if($res){
			while($row = pg_fetch_assoc($res)) {
				$projectsField[]=getProjectField($row);
			}
			$deleteQuery[]='DELETE FROM "TDS_search" where "ispublished" = \'f\' AND "isdeleted" = \'t\' AND "datemodified" < \''.$datemodified.'\' ';
		}
		return array($projectsField,$deleteQuery) ;
	}
	
	function getProjectField($row=array()){
		
		$isTableFound=false;
		if(is_array($row) && count($row) >0 && is_numeric($row['entityid']) && ($row['entityid']>0)){
			$sectionId=$row['sectionid'];
			$section=$row['section'];
			$publishedField='isPublished';
			
			$dirUploadMedia = ROOTPATH.'media/'.$row['username'].'/';
			$dirTrash = ROOTPATH.'trash/'.$row['username'].'/';
			
			$isTableFound=true;
			
			
			switch ($row['entityid'])
			{
				case 97:
					$tableName='TDS_Blogs';
					$sectionId='13';
					$primeryField = 'blogId';
					$projectField='blogId';
					$publishedField = 'blogPublish';
					$fileField = 'fileId';
					
					$tableNameElement='TDS_Posts';
					$primeryFieldElement = 'postId';
					$projectFieldElement='blogId';
					$fileFieldElement = 'postFileId';
					
					$tableNamePromotinal='TDS_PostGallery';
					$primeryFieldPromotinal = 'mediaId';
					$projectFieldPromotinal='blogId';
					$fileFieldPromotinal = 'fileId';
					$isProject = true;
					
					$dirUploadMedia.= 'blog/'; 
					$dirTrash.= 'blog/'; 
					
				break;
				
				case 96:
					$tableNameElement='TDS_Posts';
					$sectionId='13';
					$primeryFieldElement = 'postId';
					$projectFieldElement='blogId';
					$fileFieldElement = 'postFileId';
					$isElement = true;
					
					$dirUploadMedia.= 'blog/'; 
					$dirTrash.= 'blog/'; 
				break;
				
				case 93:
					$tableName='TDS_UserShowcase';
					$primeryField = 'showcaseId';
					$projectField='showcaseId';
					$isProject = true;
					
					$tableNameElement='TDS_UserShowcaseLang';
					$primeryFieldElement = 'showcaseLangId';
					$projectFieldElement='showcaseId';
					
					$isExrernalNews = true;
					$isExrernalReviews = true;
					
					$isIntroductoryVideo = true;
					$isInterviewVideo = true;
					
					$dirUploadMedia.= 'showcase/'; 
					$dirTrash.= 'showcase/'; 
				break;
				
				case 100:
					$tableNameElement='TDS_UserShowcaseLang';
					$primeryFieldElement = 'showcaseLangId';
					$projectFieldElement='showcaseId';
					$isElement = true;
					
					$dirUploadMedia.= 'showcase/'; 
					$dirTrash.= 'showcase/';
				break;
				
				case 86:
					$tableName='TDS_WorkProfile';
					$sectionId='14';
					$primeryField = 'workProfileId';
					$projectField='workProfileId';
					$fileField = 'fileId';
					$isProject = true;
					
					$tableNamePromotinal='TDS_workPromotionMedia';
					$primeryFieldPromotinal = 'mediaId';
					$projectFieldPromotinal='workId';
					$fileFieldPromotinal = 'fileId';
					
					$dirUploadMedia.= 'workProfile/'; 
					$dirTrash.= 'workProfile/';
				break;
				
				case 71:
					$tableName='TDS_UpcomingProject';
					$sectionId='17';
					$primeryField = 'projId';
					$projectField='projId';
					$isProject = true;
					
					$tableNamePromotinal='TDS_UpcomingProjectMedia';
					$primeryFieldPromotinal = 'mediaId';
					$projectFieldPromotinal='projId';
					$fileFieldPromotinal = 'fileId';
					
					$isExrernalNews = true;
					$isExrernalInterviews = true;
					
					$dirUploadMedia.= 'upcomingProjects/'.$row['projectid'].'/'; 
					$dirTrash.= 'upcomingProjects/'.$row['projectid'].'/';
				break;
				
				case 54:
					$tableName='TDS_Project';
					$primeryField = 'projId';
					$projectField='projId';
					$isProject = true;
					
					if($sectionId==1){
						$tableNameElement='TDS_FvElement';
						$dirUploadMedia.= 'project/filmNvideo/'.$row['projectid'].'/'; 
						$dirTrash.= 'project/filmNvideo/'.$row['projectid'].'/';
					}elseif($sectionId==2){
						$tableNameElement='TDS_MaElement';
						$dirUploadMedia.= 'project/musicNaudio/'.$row['projectid'].'/'; 
						$dirTrash.= 'project/musicNaudio/'.$row['projectid'].'/';
					}elseif($sectionId==3){
						$tableNameElement='TDS_WpElement';
						$dirUploadMedia.= 'project/writingNpublishing/'.$row['projectid'].'/'; 
						$dirTrash.= 'project/writingNpublishing/'.$row['projectid'].'/';
					}elseif($sectionId==0 || $sectionId=='3:1' || $sectionId=='3:2'){
						if($section=='news'){
							$sectionId='3:1';
							$tableNameElement='TDS_NewsElement';
							$dirUploadMedia.= 'project/news/'.$row['projectid'].'/'; 
							$dirTrash.= 'project/news/'.$row['projectid'].'/';
						}else{
							$sectionId='3:2';
							$tableNameElement='TDS_ReviewsElement';
							$dirUploadMedia.= 'project/reviews/'.$row['projectid'].'/'; 
							$dirTrash.= 'project/reviews/'.$row['projectid'].'/';
						}
						
					}elseif($sectionId==4){
						$tableNameElement='TDS_PaElement';
						$dirUploadMedia.= 'project/photographyNart/'.$row['projectid'].'/'; 
						$dirTrash.= 'project/photographyNart/'.$row['projectid'].'/';
					}elseif($sectionId==10){
						$tableNameElement='TDS_EmElement';
						$dirUploadMedia.= 'project/educationMaterial/'.$row['projectid'].'/'; 
						$dirTrash.= 'project/educationMaterial/'.$row['projectid'].'/';
					}
					
					$primeryFieldElement = 'elementId';
					$projectFieldElement='projId';
					$fileFieldElement = 'fileId';
					
					$isExrernalNews = true;
					$isExrernalReviews = true;
					$isExrernalInterviews = true;
				break;
				
				case 12:
					$tableNameElement='TDS_FvElement';
					$sectionId='1';
					$primeryFieldElement = 'elementId';
					$projectFieldElement='projId';
					$fileFieldElement = 'fileId';
					$isElement = true;
					$dirUploadMedia.= 'project/filmNvideo/'.$row['projectid'].'/'; 
					$dirTrash.= 'project/filmNvideo/'.$row['projectid'].'/';
				break;
				
				case 25:
					$tableNameElement='TDS_MaElement';
					$sectionId='2';
					$primeryFieldElement = 'elementId';
					$projectFieldElement='projId';
					$fileFieldElement = 'fileId';
					$isElement = true;
					$dirUploadMedia.= 'project/musicNaudio/'.$row['projectid'].'/'; 
					$dirTrash.= 'project/musicNaudio/'.$row['projectid'].'/';
				break;
				
				case 47:
					$tableNameElement='TDS_PaElement';
					$sectionId='4';
					$primeryFieldElement = 'elementId';
					$projectFieldElement='projId';
					$fileFieldElement = 'fileId';
					$isElement = true;
					$dirUploadMedia.= 'project/photographyNart/'.$row['projectid'].'/'; 
					$dirTrash.= 'project/photographyNart/'.$row['projectid'].'/';
				break;
				
				case 95:
					$tableNameElement='TDS_ReviewsElement';
					$sectionId='3:2';
					$primeryFieldElement = 'elementId';
					$projectFieldElement='projId';
					$fileFieldElement = 'fileId';
					$isElement = true;
					$dirUploadMedia.= 'project/reviews/'.$row['projectid'].'/'; 
					$dirTrash.= 'project/reviews/'.$row['projectid'].'/';
				break;
				
				case 94:
					$tableNameElement='TDS_NewsElement';
					$sectionId='3:1';
					$primeryFieldElement = 'elementId';
					$projectFieldElement='projId';
					$fileFieldElement = 'fileId';
					$isElement = true;
					$dirUploadMedia.= 'project/news/'.$row['projectid'].'/'; 
					$dirTrash.= 'project/news/'.$row['projectid'].'/';
				break;
				
				case 84:
					$tableNameElement='TDS_WpElement';
					$sectionId='3';
					$primeryFieldElement = 'elementId';
					$projectFieldElement='projId';
					$fileFieldElement = 'fileId';
					$isElement = true;
					$dirUploadMedia.= 'project/writingNpublishing/'.$row['projectid'].'/'; 
					$dirTrash.= 'project/writingNpublishing/'.$row['projectid'].'/';
				break;
				
				case 7:
					$tableNameElement='TDS_EmElement';
					$sectionId='10';
					$primeryFieldElement = 'elementId';
					$projectFieldElement='projId';
					$fileFieldElement = 'fileId';
					$isElement = true;
					$dirUploadMedia.= 'project/educationMaterial/'.$row['projectid'].'/'; 
					$dirTrash.= 'project/educationMaterial/'.$row['projectid'].'/';
				break;
				
				case 15:
					$tableName='TDS_LaunchEvent';
					$sectionId='9:3';
					$primeryField = 'LaunchEventId';
					$projectField='LaunchEventId';
					$fileField = 'FileId';
					$isProject = true;
					
					$tableNameElement='TDS_EventSessions';
					$primeryFieldElement = 'sessionId';
					$projectFieldElement='launchEventId';
					
					$tableNamePromotinal='TDS_EventMedia';
					$primeryFieldPromotinal = 'mediaId';
					$projectFieldPromotinal='launchEventId';
					$fileFieldPromotinal = 'fileId';
					
					$isExrernalNews = true;
					$isExrernalReviews = true;
					$isExrernalInterviews = true;
					$isEventSessions = true;
					
					$dirUploadMedia.= 'launchevents/'.$row['projectid'].'/'; 
					$dirTrash.= 'launchevents/'.$row['projectid'].'/';
				break;
				
				case 9:
					$tableName='TDS_Events';
					$sectionId='9:1';
					$primeryField = 'EventId';
					$projectField='EventId';
					$fileField = 'FileId';
					$isProject = true;
					
					$tableNameElement='TDS_EventSessions';
					$primeryFieldElement = 'sessionId';
					$projectFieldElement='eventId';
					
					$tableNamePromotinal='TDS_EventMedia';
					$primeryFieldPromotinal = 'mediaId';
					$projectFieldPromotinal='eventId';
					$fileFieldPromotinal = 'fileId';
					
					$isExrernalNews = true;
					$isExrernalReviews = true;
					$isExrernalInterviews = true;
					$isEventSessions = true;
					
					$dirUploadMedia.= 'events/'.$row['projectid'].'/'; 
					$dirTrash.= 'events/'.$row['projectid'].'/';
				break;
				
				case 49:
					$tableName='TDS_Product';
					$sectionId='12';
					$primeryField = 'productId';
					$projectField='productId';
					$isProject = true;
					
					$tableNamePromotinal='TDS_ProductPromotionMedia';
					$primeryFieldPromotinal = 'mediaId';
					$projectFieldPromotinal='prodId';
					$fileFieldPromotinal = 'fileId';
					
					$isExrernalNews = true;
					$isExrernalReviews = true;
					$dirUploadMedia.= 'product/'.$row['category'].'/'.$row['projectid'].'/'; 
					$dirTrash.= 'product/'.$row['category'].'/'.$row['projectid'].'/'; 
				break;
				
				case 82:
					$tableName='TDS_Work';
					$sectionId='11';
					$primeryField = 'workId';
					$projectField='workId';
					$isProject = true;
					
					$tableNamePromotinal='TDS_workPromotionMedia';
					$primeryFieldPromotinal = 'mediaId';
					$projectFieldPromotinal='workId';
					$fileFieldPromotinal = 'fileId';
					
					$dirUploadMedia.= 'work/'.$row['work_type'].'/'.$row['projectid'].'/'; 
					$dirTrash.= 'work/'.$row['work_type'].'/'.$row['projectid'].'/'; 
				break;
				
				default:
					$isTableFound=false;
				break;
			}
		}
		
		if($isTableFound){
			
			$returnData['searchId']=$row['id'];
			$returnData['entityId']=$row['entityid'];
			$returnData['elementId']=$row['elementid'];
			$returnData['projectId']=$row['projectid'];
			$returnData['section']=$row['section'];
			$returnData['userId']=$row['userid'];
			$returnData['trashfolder']=$row['username'];
			$returnData['cachefile']=$row['cachefile'];
			$returnData['sectionId']=isset($sectionId)?$sectionId:$row['sectionid'];
			
			$returnData['table']=isset($tableName)?$tableName:false;
			$returnData['primeryField']=isset($primeryField)?$primeryField:false;
			$returnData['publishedField']=isset($publishedField)?$publishedField:false;
			$returnData['projectField']=isset($projectField)?$projectField:false;
			$returnData['fileField']=isset($fileField)?$fileField:false;
			$returnData['isProject']=isset($isProject)?$isProject:false;
						
			$returnData['tableNameElement']=isset($tableNameElement)?$tableNameElement:false;
			$returnData['primeryFieldElement']=isset($primeryFieldElement)?$primeryFieldElement:false;
			$returnData['projectFieldElement']=isset($projectFieldElement)?$projectFieldElement:false;
			$returnData['fileFieldElement']=isset($fileFieldElement)?$fileFieldElement:false;
			$returnData['isElement']=isset($isElement)?$isElement:false;
			
			$returnData['tableNamePromotinal']=isset($tableNamePromotinal)?$tableNamePromotinal:false;
			$returnData['primeryFieldPromotinal']=isset($primeryFieldPromotinal)?$primeryFieldPromotinal:false;
			$returnData['projectFieldPromotinal']=isset($projectFieldPromotinal)?$projectFieldPromotinal:false;
			$returnData['fileFieldPromotinal']=isset($fileFieldPromotinal)?$fileFieldPromotinal:false;
			
			$returnData['isExrernalNews']=isset($isExrernalNews)?$isExrernalNews:false;
			$returnData['isExrernalReviews']=isset($isExrernalReviews)?$isExrernalReviews:false;
			$returnData['isExrernalInterviews']=isset($isExrernalInterviews)?$isExrernalInterviews:false;
			
			$returnData['isIntroductoryVideo']=isset($isIntroductoryVideo)?$isIntroductoryVideo:false;
			$returnData['isInterviewVideo']=isset($isInterviewVideo)?$isInterviewVideo:false;
			
			$returnData['isEventSessions']=isset($isEventSessions)?$isEventSessions:false;
			
			$returnData['dirUploadMedia']=isset($dirUploadMedia)?$dirUploadMedia:false;
			$returnData['dirTrash']=isset($dirTrash)?$dirTrash:false;
			
		}else{
			$returnData=false;
		}
		return $returnData;
	}
	
	function moveIntoTrash($data=array()){
		
		$projectsField=$data[0];
		if($projectsField && is_array($projectsField) && count($projectsField) > 0){
			$deleteQuery=$data[1];
			
			$trashData=false;
			$fileId=array();	
			foreach($projectsField as $k=>$projectField){
				if(isset($projectField['table']) && $projectField['table']){
					$projectReturnData=getProjectData($projectField,$deleteQuery);
					$projectData=$projectReturnData[0];
					if($projectData){
						$deleteQuery=$projectReturnData[1];
						$fileId=$projectReturnData[2];
						$trashData['projectData']=str_replace("'","&apos;",json_encode($projectData));
					}
				}
				if(isset($projectField['tableNameElement']) && $projectField['tableNameElement']){
					$elementReturnData=getElementData($projectField,$deleteQuery,$fileId);
					$elementData=$elementReturnData[0];
					if($elementData){
						$deleteQuery=$elementReturnData[1];
						$fileId=$elementReturnData[2];
						$trashData['elementData']=str_replace("'","&apos;",json_encode($elementData));
					}
				}
				if(isset($projectField['tableNamePromotinal']) && $projectField['tableNamePromotinal']){
					$promotionalReturnData=getPromotionalData($projectField,$deleteQuery,$fileId);
					$promotionalData=$promotionalReturnData[0];
					if($promotionalData){
						$deleteQuery=$promotionalReturnData[1];
						$fileId=$promotionalReturnData[2];
						$trashData['promotionalData']=str_replace("'","&apos;",json_encode($promotionalData));
					}
				}
				if(isset($projectData) && $projectData){
					if($projectField['isIntroductoryVideo'] && $projectData['introductoryFileId'] > 0){
						$projectField['introductoryFileId'] = $projectData['introductoryFileId'];
					}
					if($projectField['isInterviewVideo'] && $projectData['interviewFileId'] > 0){
						$projectField['interviewFileId'] = $projectData['interviewFileId'];
					}
					$prMaterislReturnData=getPrMaterislData($projectField,$deleteQuery,$fileId);
					$prMaterislData=$prMaterislReturnData[0];
					if($prMaterislData){
						$deleteQuery=$prMaterislReturnData[1];
						$fileId=$prMaterislReturnData[2];
						$trashData['prMaterialData']=str_replace("'","&apos;",json_encode($prMaterislData));
					}
					
					$shippingReturnData=getShippingData($projectField,$deleteQuery);
					$shippingData=$shippingReturnData[0];
					if($shippingData){
						$deleteQuery=$shippingReturnData[1];
						$trashData['shippingData']=str_replace("'","&apos;",json_encode($shippingData));
					}
				}
				
				if($trashData && is_array($trashData) && count($trashData) > 0){
					
					$trashData['entityId']  = $projectField['entityId'];
					$trashData['elementId'] = $projectField['elementId'];
					$trashData['projectId'] = $projectField['projectId'];
					$trashData['sectionId'] = $projectField['sectionId'];
					$trashData['userId'] 	= $projectField['userId'];
					$trashData['trashfolder'] 	= $projectField['trashfolder'];
					$trashData['projectData'] = isset($trashData['projectData'])?$trashData['projectData']:'';
					$trashData['elementData'] = isset($trashData['elementData'])?$trashData['elementData']:'';
					$trashData['promotionalData'] = isset($trashData['promotionalData'])?$trashData['promotionalData']:'';
					$trashData['prMaterialData'] = isset($trashData['prMaterialData'])?$trashData['prMaterialData']:'';
					$trashData['shippingData'] = isset($trashData['shippingData'])?$trashData['shippingData']:'';
					
					$trashId=insertDataIntoTrash($trashData);
					if(is_numeric($trashId) && ($trashId) > 0){
						deleteProjectData($projectField,$deleteQuery,$fileId);
					}
				}
			}
			
			
		}
	}
	
	function getProjectData($projectField=array(),$deleteQuery=array()){
		$projectData=false;
		$fileId=array();
		if($projectField && is_array($projectField) && count($projectField) > 0){
			$db = db_connect();
			$sql=' SELECT * FROM "'.$projectField['table'].'" ';
			if($projectField['fileField'] && $projectField['fileField'] !=''){
				$sql.=' LEFT JOIN "TDS_MediaFile" ON "TDS_MediaFile"."fileId" = "'.$projectField['table'].'"."'.$projectField['fileField'].'" ';
			}
			$sql.=' WHERE "'.$projectField['primeryField'].'" = '.$projectField['elementId'].' ';
			$sql.=' LIMIT 1 ';
			
			$res = pg_query( $db, $sql);
			
			if($res){
				$row = pg_fetch_assoc($res);
				$projectData=$row;
				$deleteQuery[]='DELETE FROM "'.$projectField['table'].'" WHERE "'.$projectField['primeryField'].'" = '.$projectField['elementId'].' ';
				if($projectField['fileField'] && $projectField['fileField'] !='' && is_numeric($projectData[$projectField['fileField']]) && ($projectData[$projectField['fileField']] > 0)){
					$fileId[]=$projectData[$projectField['fileField']];
				}
			}
		}
		return array($projectData,$deleteQuery,$fileId);
	}
	
	function getElementData($projectField=array(),$deleteQuery=array(),$fileId=array()){
		$elementData=false;
		if($projectField && is_array($projectField) && count($projectField) > 0){
			$db = db_connect();
			
			$sql=' SELECT * FROM "'.$projectField['tableNameElement'].'" ';
			if($projectField['fileFieldElement'] && $projectField['fileFieldElement'] !=''){
				$sql.=' LEFT JOIN "TDS_MediaFile" ON "TDS_MediaFile"."fileId" = "'.$projectField['tableNameElement'].'"."'.$projectField['fileFieldElement'].'" ';
			}
			if($projectField['isElement']){
				$sql.=' WHERE "'.$projectField['primeryFieldElement'].'" = '.$projectField['elementId'].' ';
				$elementDeleteQuery='DELETE FROM "'.$projectField['tableNameElement'].'" WHERE "'.$projectField['primeryFieldElement'].'" = '.$projectField['elementId'].' ';
			}else{
				$sql.=' WHERE "'.$projectField['projectFieldElement'].'" = '.$projectField['elementId'].' ';
				$elementDeleteQuery='DELETE FROM "'.$projectField['tableNameElement'].'" WHERE "'.$projectField['projectFieldElement'].'" = '.$projectField['elementId'].' ';
			}
			
			$res = pg_query( $db, $sql);
			
			if($res){
				$deleteQuery[]=$elementDeleteQuery;
				$sessionIds=array();
				while ($row = pg_fetch_assoc($res)) {
					if($projectField['fileFieldElement'] && $projectField['fileFieldElement'] !='' && is_numeric($row[$projectField['fileFieldElement']]) && $row[$projectField['fileFieldElement']]>0){
						$fileId[]=$row[$projectField['fileFieldElement']];
					}
					if($projectField['isEventSessions'] && is_numeric($row['sessionId']) && $row['sessionId'] >0){
						$sessionIds[]=$row['sessionId'];
						$ticketSql=' SELECT * FROM "TDS_Tickets" ';
						$ticketSql.=' LEFT JOIN "TTDS_TicketPriceSchedule" ON "TDS_TicketPriceSchedule"."TicketId" = "TDS_Tickets"."TicketId" ';
						$ticketSql.=' WHERE "SessionId" = '.$row['sessionId'].' ';
						$ticketRes = pg_query( $db, $ticketSql);
						if($ticketRes){
							
							while ($ticketRow = pg_fetch_assoc($ticketRes)) {
								$row['ticketDetails'][]=$ticketRow;
							}
						}
					}
					$elementData[]=$row;
					
					if(isset($row['imagePath']) && $row['imagePath'] != ''){
						$imagePath = trim($row['imagePath']);
						if(is_file($imagePath)){
							$path_parts = pathinfo($imagePath);
							$imageDir=$path_parts['dirname'];
							$fpLen=strlen($imageDir);
							if($fpLen > 0 && substr($imageDir,-1) != DIRECTORY_SEPARATOR){
								$imageDir=$imageDir.DIRECTORY_SEPARATOR;
							}
							$imageName=$path_parts['basename'];
							findFileNnovieInTrash($imageDir, $imageName);
						}
					}
					
				}
				if($projectField['isEventSessions'] && is_array($sessionIds) && count($sessionIds) > 0){
					$sessionIds=implode(',',$sessionIds);
					$deleteQuery[]='DELETE FROM "TDS_Tickets" WHERE "SessionId" in('.$sessionIds.') ';
					$deleteQuery[]='DELETE FROM "TDS_TicketPriceSchedule" WHERE "SessionId" in('.$sessionIds.') ';
				}
			}
		}
		return array($elementData,$deleteQuery,$fileId);
	}
	
	function getPromotionalData($projectField=array(),$deleteQuery=array(),$fileId=array()){
		$promotionalData=false;
		if($projectField && is_array($projectField) && count($projectField) > 0){
			$db = db_connect();
			
			$sql=' SELECT * FROM "'.$projectField['tableNamePromotinal'].'" ';
			if($projectField['fileFieldPromotinal'] && $projectField['fileFieldPromotinal'] !=''){
				$sql.=' LEFT JOIN "TDS_MediaFile" ON "TDS_MediaFile"."fileId" = "'.$projectField['tableNamePromotinal'].'"."'.$projectField['fileFieldPromotinal'].'" ';
			}
			$sql.=' WHERE "'.$projectField['projectFieldPromotinal'].'" = '.$projectField['elementId'].' ';
			
			$res = pg_query( $db, $sql);
			if($res){
				$deleteQuery[]='DELETE FROM "'.$projectField['tableNamePromotinal'].'" WHERE "'.$projectField['projectFieldPromotinal'].'" = '.$projectField['elementId'].' ';
				while ($row = pg_fetch_assoc($res)) {
					if($projectField['fileFieldPromotinal'] && $projectField['fileFieldPromotinal'] !='' && is_numeric($row[$projectField['fileFieldPromotinal']]) && $row[$projectField['fileFieldPromotinal']]>0){
						$fileId[]=$row[$projectField['fileFieldElement']];
					}
					$promotionalData[]=$row;
				}
			}
		}
		return array($promotionalData,$deleteQuery,$fileId);
	}
	
	function getPrMaterislData($projectField=array(),$deleteQuery=array(),$fileId=array()){
		$prMaterislData=false;
		if($projectField && is_array($projectField) && count($projectField) > 0){
			
			if($projectField['isExrernalNews']){
				$tbleDetails=array('table'=>'TDS_AddInfoNews','entityId'=>$projectField['entityId'],'elementId'=>$projectField['elementId']);
				$exrernalNews=getNewsReviewsInterviews($tbleDetails);
				if($exrernalNews){
					$prMaterislData['exrernalNews']=$exrernalNews;
					$deleteQuery[]='DELETE FROM "'.$tbleDetails['table'].'"  WHERE "entityId" = '.$tbleDetails['entityId'].' AND "elementId" = '.$tbleDetails['elementId'].' ';
				}
			}
			
			if($projectField['isExrernalReviews']){
				$tbleDetails=array('table'=>'TDS_AddInfoReviews','entityId'=>$projectField['entityId'],'elementId'=>$projectField['elementId']);
				$exrernalReviews=getNewsReviewsInterviews($tbleDetails);
				if($exrernalReviews){
					$prMaterislData['exrernalReviews']=$exrernalReviews;
					$deleteQuery[]='DELETE FROM "'.$tbleDetails['table'].'"  WHERE "entityId" = '.$tbleDetails['entityId'].' AND "elementId" = '.$tbleDetails['elementId'].' ';
				}
			}
			
			if($projectField['isExrernalInterviews']){
				$tbleDetails=array('table'=>'TDS_AddInfoInterview','entityId'=>$projectField['entityId'],'elementId'=>$projectField['elementId']);
				$exrernalInterviews=getNewsReviewsInterviews($tbleDetails);
				if($exrernalInterviews){
					$prMaterislData['exrernalInterviews']=$exrernalInterviews;
					$deleteQuery[]='DELETE FROM "'.$tbleDetails['table'].'"  WHERE "entityId" = '.$tbleDetails['entityId'].' AND "elementId" = '.$tbleDetails['elementId'].' ';
				}
			}
			
			if($projectField['isIntroductoryVideo'] && isset($projectField['introductoryFileId']) && is_numeric($projectField['introductoryFileId']) && ($projectField['introductoryFileId'] > 0)){
				$introductoryVideo=getMediaFileData($projectField['introductoryFileId']);
				if($introductoryVideo){
					$prMaterislData['introductoryVideo']=$introductoryVideo;
					$fileId[]=$projectField['introductoryFileId'];
				}
			}
			
			if($projectField['isInterviewVideo'] && isset($projectField['interviewFileId']) && is_numeric($projectField['interviewFileId']) && ($projectField['interviewFileId'] > 0)){
				$interviewVideo=getMediaFileData($projectField['interviewFileId']);
				if($interviewVideo){
					$prMaterislData['interviewVideo']=$interviewVideo;
					$fileId[]=$projectField['interviewFileId'];
				}
			}
		}
		return array($prMaterislData,$deleteQuery,$fileId);
	}
	
	function getShippingData($projectField=array(),$deleteQuery=array()){
		$shippingData = false;
		if($projectField && is_array($projectField) && count($projectField) > 0){
			$db = db_connect();	
			$sql=' SELECT * FROM "TDS_ProjectShipping" ';
			$sql.=' WHERE "entityId" = '.$projectField['entityId'].' AND "elementId" = '.$projectField['elementId'].' ';
			
			$res = pg_query( $db, $sql);
			if($res){
				while ($row = pg_fetch_assoc($res)) {
					$shippingData[]=$row;
				}
				$deleteQuery[]='DELETE FROM "TDS_ProjectShipping"  WHERE "entityId" = '.$projectField['entityId'].' AND "elementId" = '.$projectField['elementId'].' ';
			}
		}
		return array($shippingData,$deleteQuery);
	}
	
	function getNewsReviewsInterviews($tbleDetails){
		$prMaterislData = false;
		if($tbleDetails && is_array($tbleDetails) && count($tbleDetails) > 0){
			$db = db_connect();	
			$sql=' SELECT * FROM "'.$tbleDetails['table'].'" ';
			$sql.=' WHERE "entityId" = '.$tbleDetails['entityId'].' AND "elementId" = '.$tbleDetails['elementId'].' ';
			
			$res = pg_query( $db, $sql);
			if($res){
				while ($row = pg_fetch_assoc($res)) {
					$prMaterislData[]=$row;
				}
			}
		}
		return $prMaterislData;
	}
	
	function getMediaFileData($fileId=0){
		$mediaFileData = false;
		if(is_numeric($fileId) && ($fileId > 0) ){
			$db = db_connect();	
			$sql=' SELECT * FROM "TDS_MediaFile" ';
			$sql.=' WHERE "fileId" = '.$fileId.' LIMIT 1';
			
			$res = pg_query( $db, $sql);
			if($res){
				$mediaFileData = pg_fetch_assoc($res);
			}
		}
		return $mediaFileData;
	}
	
	function insertDataIntoTrash($trashData){
		$trashId=0;
		if($trashData && is_array($trashData) && count($trashData) > 0){
			$db = db_connect();
			$SQL = 'INSERT INTO "TDS_Trash" (
														"entityId",
														"elementId",
														"projectId",
														"sectionId",
														"userId",
														"trashfolder",
														"projectData",
														"elementData",
														"promotionalData",
														"prMaterialData"
													)
											 VALUES (
														'.$trashData['entityId'].',
														'.$trashData['entityId'].',
														'.$trashData['projectId'].',
														'.$trashData['sectionId'].',
														'.$trashData['userId'].',
														\''.$trashData['trashfolder'].'\',
														\''.pg_escape_string($trashData['projectData']).'\',
														\''.pg_escape_string($trashData['elementData']).'\',
														\''.pg_escape_string($trashData['promotionalData']).'\',
														\''.pg_escape_string($trashData['prMaterialData']).'\'
													) ';
			$query = pg_query($db, $SQL);
			$insert_query = 'SELECT lastval();';
			$insert_row = pg_fetch_row(pg_query($insert_query));
			$trashId= $insert_row[0];	
		}
		return $trashId;
	}
	
	function deleteProjectData($projectField=array(), $deleteQuery=array(), $fileIds=array()){
		
		if($projectField && is_array($projectField) && count($projectField) > 0){
			$db = db_connect();
			$dirMedia=$projectField['dirUploadMedia'];
			$dirTrash=$projectField['dirTrash'];
			$cacheFile=$projectField['cachefile'];
			
			if(isset($projectField['isProject']) && ($projectField['isProject'])){
				
				copyFolder($dirMedia,$dirTrash);
				removeDir($dirMedia);
				
				if(is_file($cacheFile)){
					@unlink($cacheFile);
				}
			}
			
			if($deleteQuery && is_array($deleteQuery) && count($deleteQuery) > 0){
				krsort($deleteQuery);
				foreach($deleteQuery as $query){
					$res = pg_query( $db, $query);
				}
			}
			
			if($fileIds && is_array($fileIds) && count($fileIds) > 0){
				$fileId = implode(',',$fileIds);
				
				$sql='SELECT "fileId","filePath","fileName" FROM "TDS_MediaFile" WHERE "fileId" in('.$fileId.') ';
				$res = pg_query( $db, $sql);
				
				if($res){
					while ($row = pg_fetch_assoc($res)) {
						$filePath=trim($row['filePath']);
						$fileName=trim($row['fileName']);
						if(is_dir($filePath) && $fileName !=''){
							$fpLen=strlen($filePath);
							if($fpLen > 0 && substr($filePath,-1) != DIRECTORY_SEPARATOR){
								$filePath=$filePath.DIRECTORY_SEPARATOR;
							}
							if(is_file($filePath.$fileName)){
								findFileNnovieInTrash($filePath,$fileName);
							}
						}
					}
				}
				$delFileSql='DELETE FROM "TDS_MediaFile" WHERE "fileId" in('.$fileId.') ';
				$res = pg_query( $db, $delFileSql);
			}
		}
		
	}
	
	function findFileNnovieInTrash($dir, $filename,$trash='trash'){
	   if(is_dir($dir) && $filename !=''){
			$fpLen=strlen($dir);
			if($fpLen > 0 && substr($dir,-1) != DIRECTORY_SEPARATOR){
				$dir=$dir.DIRECTORY_SEPARATOR;
			}
			$ffs = scandir($dir);
			foreach($ffs as $ff){
				if($ff != '.' && $ff != '..'){
					if(is_dir($dir.$ff)){
						findFileNnovieInTrash($dir.$ff.DIRECTORY_SEPARATOR, $filename);
					}elseif(is_file($dir.$ff)){
						$fileInfo=pathinfo($filename);
						if(strstr($ff,$fileInfo['filename'])){
							$trashDir=str_replace('media/',$trash.'/',$dir);
							$trashFile=$trashDir.$ff;
							$file=$dir.$ff;
							if(!is_dir($trashDir)){
								if (!mkdir($trashDir, 0777, true)) {
									die('Failed to create folders...');
								}else{
									
								}
							 }
							copy($file,$trashFile);
							unlink($file); 
						}
					}
				}
			}
		}
	}
	
	function findFileNDelete($dir, $filename){
	   if(is_dir($dir) && $filename !=''){
		  
			$fpLen=strlen($dir);
			if($fpLen > 0 && substr($dir,-1) != DIRECTORY_SEPARATOR){
				$dir=$dir.DIRECTORY_SEPARATOR;
			}
		   
			$ffs = scandir($dir);
			foreach($ffs as $ff){
				if($ff != '.' && $ff != '..'){
					if(is_dir($dir.$ff)){
						findFileNDelete($dir.$ff.DIRECTORY_SEPARATOR, $filename);
					}elseif(is_file($dir.$ff)){
						$fileInfo=pathinfo($filename);
						if(strstr($ff,$fileInfo['filename'])){
							unlink($dir.$ff);
						}
					}
				}
			}
		}
	}
	
	function copyFolder($src,$dst) { 
		if(is_dir($src)){
			 if(!is_dir($dst)){
				if (!mkdir($dst, 0777, true)) {
					die('Failed to create folders...');
				} 
			 }
			$dir = opendir($src); 
			while(false !== ( $file = readdir($dir)) ) { 
				if (( $file != '.' ) && ( $file != '..' )) { 
					if ( is_dir($src . '/' . $file) ) { 
						copyFolder($src . '/' . $file,$dst . '/' . $file); 
					} 
					else { 
						copy($src . '/' . $file,$dst . '/' . $file); 
					} 
				} 
			} 
			closedir($dir);
		}
	}
	
	function removeDir($dir) { 
	  if(is_dir($dir)){
		  foreach(glob($dir . '/*') as $file) { 
			if(is_dir($file)) removeDir($file); else unlink($file); 
		  } rmdir($dir);
	  }
	}
