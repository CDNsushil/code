<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* Description:
	 * The controller class "download" is meant to handle the processing of "Work Profile" section
	 * It include functionality to fetch/add/edit work address,sicaol media links,employment history,etc
	 * @package	Toadsquare
	 * @subpackage	Module
	 * @category	Controller
	 * Author Name: Sushil Mishra
	 * Date Created: 16 March 2013 */
class download extends MX_Controller {
	private $data = array();
	private $userId = null;
	function __construct(){
		$load = array(
					'model'		=> 'model_download'
				);
		parent::__construct($load);	
		$this->userId=$this->isLoginUser();
	}
	
	function index($FD=''){
		$this->file($FD='');
	}
	
	function file($FD=''){
		$FD =  ucfirst($FD);
		$FD =  decode($FD);
		$FD = explode('+',$FD);
		$isfileFound=false;
		$sellstatus=false;
		if(isset($FD[0]) && ($FD[0] >0) && isset($FD[1]) && ($FD[1] >0) && isset($FD[2]) && ($FD[2] >0) && isset($FD[3]) && ($FD[3] >0) && isset($FD[4]) && is_numeric($FD[4]) && isset($FD[5]) && (strlen($FD[5])>1) && isset($FD[6]) && (strlen($FD[6])>1) && isset($FD[7]) && isset($FD[8]) && isset($FD[9]) && is_numeric($FD[9])){
			$buyerId=(isset($FD[10]) && ($FD[10] >0))?$FD[10]:0; 
		    $dwnId=(isset($FD[11]) && ($FD[11] >0))?$FD[11]:0;
			
			$FD=array(
						'ownerId'=>$FD[0],
						'entityId'=>$FD[1],
						'elementId'=>$FD[2],
						'projectId'=>$FD[3],
						'fileId'=>$FD[4],
						'tableName'=>$FD[5],
						'primeryField'=>$FD[6],
						'elementTable'=>$FD[7],
						'elementPrimeryField'=>$FD[8],
						'isElement'=>$FD[9],
						'buyerId'=>$FD[10],
						'dwnId'=>$FD[11]
			);
			
			$fileDetails=$this->model_download->getDownloadFile($FD);
			if($fileDetails && isset($fileDetails[0]['fileId']) && $fileDetails[0]['fileId'] > 0){
				if($FD['isElement']==1 && ($fileDetails[0]['projCategory'] !=1 &&  $fileDetails[0]['projCategory'] !=6)){ //projCategory==1 =>major F&V and projCategory==6 =>major W&P
					
					$fileName=trim($fileDetails[0]['fileName']);
					$filePath=trim($fileDetails[0]['filePath']);
					$fpLen=strlen($filePath);
					if($fpLen > 0 && substr($filePath,-1) != '/'){
						$filePath=$filePath.'/';
					}
					$file=$filePath.$fileName;
					if(is_file($file)){
						$isfileFound=true;
						if($fileDetails[0]['projSellstatus']=='f' || $fileDetails[0]['isDownloadPrice']=='f'){
							
						}else{
							$sellstatus=true;
						}
					}else{
						
					}
				}else{
					$isfileFound=true;
					if($fileDetails[0]['projSellstatus']=='t' && $fileDetails[0]['isprojDownloadPrice']=='t'){
						$sellstatus=true;
					}
				}
				if($isfileFound){
					if($sellstatus){
						$authorisedUser=false;
						$buyerId=$this->userId;
						
						if($dwnId > 0){
							$whereField=array('dwnId'=>$dwnId,'userId'=>$buyerId);
							$purchaseData=$this->model_common->getDataFromTabel('SalesItemDownload', $field='*',  $whereField, '', '', 'ASC', 1 );
							
							
							
							if($purchaseData && isset($purchaseData[0])){
									$purchaseData=$purchaseData[0];
									
									$dwnMaxday = $purchaseData->dwnMaxday;
									$expiryDate= getPreviousOrFututrDate($purchaseData->dwnDate, '+'.$dwnMaxday.' day' ,$format='Y-m-d');
									$currentDate=date('Y-m-d');
									if(strtotime($currentDate) <= strtotime($expiryDate)){
										$authorisedUser=true;
									}
							}
							
						}
						if(!$authorisedUser){
							$msg=$this->lang->line('notAuthorisedToDownload');
							set_global_messages($msg, $type='error', $is_multiple=true);
							redirect('home');
							exit;
						}
					}
					$inserData=array();
					$isfileFound=false;
					if((strlen($FD['elementTable']) > 1) && (strlen($FD['elementPrimeryField']) > 1)){
						$entityId=getMasterTableRecord($FD['elementTable']);
					}else{
						$entityId=$FD['entityId'];
					}
					foreach($fileDetails as $k=>$files){
						$fileName=trim($files['fileName']);
						$copyFileName=trim($files['rawFileName']);
						$copyFileName=($copyFileName!='')?$copyFileName:$fileName;
						$copyFileName=str_replace(' ','_',$copyFileName);
						$filePath=trim($files['filePath']);
						$fpLen=strlen($filePath);
						if($fpLen > 0 && substr($filePath,-1) != '/'){
							$filePath=$filePath.'/';
						}
						$file=$filePath.$fileName;
						if(is_file($file)){
							$isfileFound=true;
							if((strlen($FD['elementTable']) > 1) && (strlen($FD['elementPrimeryField']) > 1)){
								$elementId=$files['elementId'];
							}else{
								$elementId=$FD['elementId'];
							}
							$inserData[]=array(
											'downloadByUser'=>$this->userId,
											'entityId'=>$entityId,
											'elementId'=>$elementId,
											'projectId'=>$FD['projectId'],
											'ownerId'=>$FD['ownerId'],
											'fileId'=>$files['fileId'],
											'date'=>currntDateTime()
										);
							$dwnWhere=array(
								'entityId'=>$entityId,
								'elementId'=>$elementId
							);
							$dwnRes=$this->model_common->getDataFromTabel('LogSummary', 'actId,dwnCount',  $dwnWhere, '', '', '', 1 );
							if($dwnRes){
								$dwnRes=$dwnRes[0];
								$actId=$dwnRes->actId;
								$dwnCount=($dwnRes->dwnCount+1);
								$updateData=array(
									'dwnCount'=>$dwnCount
								);
								$this->model_common->editDataFromTabel('LogSummary', $updateData, 'actId', $actId);
							}else{
								$dwnCount=1;
								$dwnData=array(
									'entityId'=>$entityId,
									'elementId'=>$elementId,
									'dwnCount'=>$dwnCount,
									'createDate'=>currntDateTime()
								);
								$this->model_common->addDataIntoTabel('LogSummary', $dwnData);
							}
						}
					}
					if(count($inserData) > 0){
						$this->model_common->insertBatch($table='LogDownload', $inserData);
						$this->downloadFile($filePath,$fileName,$copyFileName);
						return true;
					}
				} 
				if(!$isfileFound){
					$msg=$this->lang->line('fileNotFound');
					set_global_messages($msg, $type='error', $is_multiple=true);
					redirect('home');
					exit;
				}
			}
		}
	}
	function downloadFile($filePath='',$fileName='',$dwnFileName=''){ 
		$file=$filePath.$fileName;
		if(is_file($file)){
			if($dwnFileName==''){
				$dwnFileName=$fileName;
			}
			$fsize = filesize($file);
			$fileInfo=pathinfo($file);
			$extension=$fileInfo['extension'];
			$extension = strtolower($extension);
			switch($extension) { case 'jar': $mime = "application/java-archive"; break; case 'zip': $mime = "application/zip"; break; case 'jpeg': $mime = "image/jpeg"; break; case 'jpg': $mime = "image/jpg"; break; case 'jad': $mime = "text/vnd.sun.j2me.app-descriptor"; break; case "gif": $mime = "image/gif"; break; case "png": $mime = "image/png"; break; case "pdf": $mime = "application/pdf"; break; case "txt": $mime = "text/plain"; break; case "doc": $mime = "application/msword"; break; case "ppt": $mime = "application/vnd.ms-powerpoint"; break; case "wbmp": $mime = "image/vnd.wap.wbmp"; break; case "wmlc": $mime = "application/vnd.wap.wmlc"; break; case "mp4s": $mime = "application/mp4"; break; case "ogg": $mime = "application/ogg"; break; case "pls": $mime = "application/pls+xml"; break; case "asf": $mime = "application/vnd.ms-asf"; break; case "swf": $mime = "application/x-shockwave-flash"; break; case "mp4": $mime = "video/mp4"; break; case "m4a": $mime = "audio/mp4"; break; case "m4p": $mime = "audio/mp4"; break; case "mp4a": $mime = "audio/mp4"; break; case "mp3": $mime = "audio/mpeg"; break; case "m3a": $mime = "audio/mpeg"; break; case "m2a": $mime = "audio/mpeg"; break; case "mp2a": $mime = "audio/mpeg"; break; case "mp2": $mime = "audio/mpeg"; break; case "mpga": $mime = "audio/mpeg"; break; case "wav": $mime = "audio/wav"; break; case "m3u": $mime = "audio/x-mpegurl"; break; case "bmp": $mime = "image/bmp"; break; case "ico": $mime = "image/x-icon"; break; case "3gp": $mime = "video/3gpp"; break; case "3g2": $mime = "video/3gpp2"; break; case "mp4v": $mime = "video/mp4"; break; case "mpg4": $mime = "video/mp4"; break; case "m2v": $mime = "video/mpeg"; break; case "m1v": $mime = "video/mpeg"; break; case "mpe": $mime = "video/mpeg"; break; case "mpeg": $mime = "video/mpeg"; break; case "mpg": $mime = "video/mpeg"; break; case "mov": $mime = "video/quicktime"; break; case "qt": $mime = "video/quicktime"; break; case "avi": $mime = "video/x-msvideo"; break; case "midi": $mime = "audio/midi"; break; case "mid": $mime = "audio/mid"; break; case "amr": $mime = "audio/amr"; break; default: $mime = "application/octet-stream"; }
			set_time_limit(0);
			ob_clean(); 
			header("Content-Type: application/".$mime);
			header("Content-Description: file transfer");
			header('Content-Disposition: attachment; filename="' . basename($dwnFileName) . '"');
			header('Content-Length: '. $fsize);
			$open = fopen($file, "rb");
			flush();
			while(!feof($open)){
				print fread($open, (1024*1024));
				ob_flush();
				flush();
				usleep(500);
			}
			fclose($open);
			flush(); 
			exit();
		}
	}
}
