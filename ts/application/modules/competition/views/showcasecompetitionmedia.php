<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$competitionTitle = $competitionData->title;
$competitiononelineDescription = $competitionData->onelineDescription;
$competitionDescription = $competitionData->description;
$competitionCreateDate = date('d F Y',strtotime($competitionData->createdDate));



$currentDate = strtotime(date("Y-m-d"));
$createdDate = strtotime($competitionData->createdDate);
$submissionStartDate = strtotime($competitionData->submissionStartDate);
$submissionEndDate = strtotime($competitionData->submissionEndDate);
$votingStartDate = strtotime($competitionData->votingStartDate);
$votingEndDate = strtotime($competitionData->votingEndDate);
$roundTypeLable = $this->lang->line('userCompetitionRound1');// set current round type
$onGoingRound='1';// set current going round
if($competitionData->competitionRoundType==2){
	
	if($votingEndDate <= $currentDate){
		$submissionStartDate = strtotime($competitionData->submissionStartDateRound2);
		$submissionEndDate = strtotime($competitionData->submissionEndDateRound2);
		$votingStartDate = strtotime($competitionData->votingStartDateRound2);
		$votingEndDate = strtotime($competitionData->votingEndDateRound2);
		$roundTypeLable = $this->lang->line('userCompetitionRound2');// set current round type
		$onGoingRound='2';// set current going round
	}
}

	//--------get competition language-------//
	$competitionLanguageFirst =  getLanguage($competitionData->languageId);
	if($competitionData->languageid2 > 0){
	  $competitionLanguageSecond =getLanguage($competitionData->languageid2);
	} 	


//get language 2 data if exist 	
	$languageSecondData  = getDataFromTabel('CompetitionLang', $field='title,onelineDescription,criteria',  $whereField=array('competitionId'=>$competitionId), '', '', 'ASC', $limit=1, $offset=0, $resultInArray=false);
	// check selected lanauge 
	if($language=="language2" && $competitionData->isMultilingual=="t" && !empty($languageSecondData)){
		$language2Data      = $languageSecondData[0];
		$competitionTitle   = $language2Data->title;
		$competitiononelineDescription = $language2Data->onelineDescription;
		$competitionDescription = $language2Data->description;
	}

?>

<td valign="top">
	<div class="cell right_coloumn margin_0 <?php echo $industryData['10pxborderClass_1']; ?> width778 bg_444 bg-non pb10">
		<div class="row font_helvetica_L pl72 pt25 pr80">
			<div class="font_museoSlab font_size28 clr_f1592a lineH28 bdrB_6e6e6e word-spacing2 letter_spac2">
				<?php echo getSubString($competitionTitle,50); ?> <span class="fr clr_white display_inline font_size12 font_opensansSBold pt5"><?php echo $competitionCreateDate; ?></span>
			</div>
			<div class="clear">
			</div>
		</div>
		<!-- /row -->
		<!---first supporting material show div-->
			<div class="row">
				<div class="seprator_40">
				</div>
				<center>
				 
				<?php 
					// loader media player view
					$this->load->view('mediaPlayView');
				?>
				
				</center>
				<div class="seprator_40">
				</div>
			</div>
	
		<!---first supporting material show div-->
		
		<!---supporting material slider show div-->
		<?php if(!empty($competitionMediaData)) { ?>
			<div class="row">
				<div class="scentry_slidercontainer global_shadow">
				
				<div id="slider1" class="slider">
					<div id="slider-code" class="height_137">
						<a class="buttons prev ml4 mt54 disable" href="#">left</a>
						<div class="viewport width_478 ml68 height_139">
							<ul class="overview overview_scentry" style="width: 978px; left: 0px; ">
							
								<?php 
								$rowCount=0;
								$firstMediaUrl='';
								$firstMediaType='';
								foreach($competitionMediaData as $competitionMedia) { 
									$mediaUrl='';
									if($competitionMedia->isExternal !="t"){
									$mediaImage='';
									switch($competitionMedia->fileType){
										case 1:
											//"image";
											$mediaImage = $competitionMedia->filePath.$competitionMedia->fileName;
											$mediaUrl   = $competitionMedia->filePath.$competitionMedia->fileName;
											
											// get medium image
											$defMediaImage=$this->config->item('defaultMediaImg_b');
											$mediaUrl = addThumbFolder($mediaUrl,$suffix='_b',$thumbFolder ='thumb',$defCoverImageShow);	
											$mediaUrl = getImage($mediaUrl,$defMediaImage);
										break;
										case 2:
											// "video";
											$mediaImage = getVideoThumbFolder(@$competitionMedia->filePath.$competitionMedia->fileName);
											$mediaUrl   = base_url('player/getPlayerIframe/'.$competitionMedia->fileId.'_full');
										break;
										case 3:
											// "audio";
											$mediaImage = $this->config->item('defaultAudioIcon');
											$mediaUrl   = base_url('player/getPlayerIframe/'.$competitionMedia->fileId.'_full');
										break;
										case 4:
											// "text";
											$fullFileName = $competitionMedia->filePath.$competitionMedia->fileName;
											
											if($fullFileName && !empty($fullFileName)){
												$fileInfo=pathinfo($fullFileName);
												$getExtension= strtolower($fileInfo['extension']);
												// show icon if ext. is pdf
												if($getExtension=="pdf"){
													$mediaImage=$this->config->item('defaultPdfIcon');
												}else{
													$mediaImage=$this->config->item('defaultDocxIcon');
												}
											}
										break;
										default :
											// "no type define";
											$defMediaImage=$this->config->item('defaultMediaImg_s');
										break;
									}
									$defMediaImage=$this->config->item('defaultMediaImg_s');
									$coverMediaImage = addThumbFolder($mediaImage,$suffix='_xxs',$thumbFolder ='thumb',$defCoverImageShow);	
									$coverMediaImage = getImage($coverMediaImage,$defMediaImage);
								}else{
									//set default image
									$mediaImage='';
									$defMediaImage=$this->config->item('defaultMediaImg_s');
									$coverMediaImage = addThumbFolder($mediaImage,$suffix='_xxs',$thumbFolder ='thumb',$defCoverImageShow);	
									$coverMediaImage = getImage($coverMediaImage,$defMediaImage);
									
									
									// check externa file for audio and video
									$getMediaUrlData = getMediaUrl($competitionMedia->filePath);
										
										if($getMediaUrlData['isUrl'])
										{
											//url is valid 
											$headerDetails = @get_headers($competitionMedia->filePath,1);
											if(isset($headerDetails['X-Frame-Options']))
											{
												// This code will show error 
												$src = base_url().'en/player/videoError/';

											}else
											{
												// This code will play url 
												$src = $competitionMedia->filePath;
											}
										}else
										{	
											$getSrc = $getMediaUrlData['getsource'];
											if($getMediaUrlData['embedtype'] == 'iframe')
											{
												 // This code will play embeded ifram code
												 $src = $getSrc;
											}else
											{
												// This code will play other type of embed code
												$src = base_url().'en/player/commonPlayerIframe/'.$competitionMedia->fileId.'_full/';
											} 
										}  
									
									$mediaUrl = $src;
								}	
								
								// set functino action only audio and video file
									$actionFunction = '';
									if($competitionMedia->fileType=="1" || $competitionMedia->fileType=="2" || $competitionMedia->fileType=="3"){
										$actionFunction = "playMedia('".$mediaUrl."','".$competitionMedia->fileType."')";
										if($rowCount==0){
											$firstMediaUrl=$mediaUrl ;
											$firstMediaType=$competitionMedia->fileType;
										}
										$rowCount++;
									}
								?>
								<li>
									<a href="javascript:void(0)" onclick="<?php echo $actionFunction; ?>" >
										<div class="imgcontainer global_shadow">
											<div class="height_68 pt5">
												<center><img width="54" height="57" src="<?php echo $coverMediaImage; ?>" alt="pdflogo"></center>
											</div>
											<div class="clr_white font_opensansSBold font_size12 text_alignC">
												<?php echo getSubString($competitionMedia->rawFileName,10); ?>
											</div>
										</div>
									</a>	
								</li>
								<?php  } ?>	
								
							</ul>
						</div>
						<a class="buttons next ml68 mt54" href="#">right</a>
					</div>
				</div>
		
			</div>
			</div>
		<?php } ?>
		<!---supporting material slider show div-->
		<!-- /row -->
		<div class="row">
			<div class="seprator_24">
			</div>
			<div class="global_shadow <?php echo $industryData['industryBG']; ?> pt15 pb32 pl30 pr30 ml20 mr20">
				
				<?php if($competitionData->isMultilingual=="t" && !empty($languageSecondData)){ ?>
					<div class="<?php echo $industryData['langTabCls']; ?>">
						<a href="<?php echo base_url('competition/sampleentry/'.$userId.'/'.$competitionId.'/language1');?>" class="<?php echo ($language=='language1')?'active':''; ?>"><?php
							 //showl language first
							 if($competitionData->languageId > 0){
									echo $competitionLanguageFirst;
								}else{
									echo $this->lang->line('competitionLanguage1'); 
								}
							 ?>
						 </a> |
						 <a href="<?php echo base_url('competition/sampleentry/'.$userId.'/'.$competitionId.'/language2');?>" class="<?php echo ($language=='language2')?'active':''; ?>">
							
						<?php
							//showl language second	
							if($competitionData->languageid2 > 0){
								echo $competitionLanguageSecond;
							}else{
								echo $this->lang->line('competitionLanguage2');
							}
						?>
						 
						 </a>
					</div>	
				<?php } ?>
				
				<!---
				<div class="font_helvetica_L font_size16 ml28 mr28 lineH18  <?php //echo $industryData['industryFntClr']; ?>">
					<?php //echo getSubString($competitiononelineDescription,'100'); ?>
				</div> --->
				
				<?php if(!empty($competitiononelineDescription)) { ?>
					<div class="seprator_15"></div>
					<div class="position_relative">
						<div class="comp_shedow_img">
						</div>
						
						<div class="bg_white clr_444 pl15 pr15 pt25 pb34 font_opensansSBold font_size14 shedow_prnews">
							<?php echo getSubString($competitiononelineDescription,'250'); ?>
						</div>
						
						<div class="comp_shedow_img shedow_pos">
						</div>
					</div>
				<?php } ?>
				
				<?php if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate ) { ?>
				<div class="fr mt25">
						<div class="<?php echo  $industryData['mediumButton']; ?> cell mt15 ml4">
							<a href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionId.'/'.$onGoingRound); ?>" onmouseup="mouseup_tds_compenter(this)" onmousedown="mousedown_tds_compenter(this)"><span class="widht_106"><?php echo $this->lang->line('compeEntriesShortlistButton'); ?></span></a>
						</div>
						
						<div class="<?php echo  $industryData['mediumButton']; ?> cell mt15 ml4">
							<a  href="<?php echo base_url('competition/showcaseentries/'.$userId.'/'.$competitionId.'/'.$onGoingRound); ?>"  onmouseup="mouseup_tds_compenter(this)" onmousedown="mousedown_tds_compenter(this)"><span class=" widht_106"><?php echo $this->lang->line('compeEntriesVoteButton'); ?></span></a>
						</div>
				</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
			
			<!-------media share div start----->
				<div class="bdr8_666 bg_white pt12 pb6 bg_444 global_shadow ml20 mr20 mt20">
				<div class="fl pl8">
					<?php	

						// competition details for share and crave
						$entityId=getMasterTableRecord('Competition');
						$projectId = $competitionId;
						$userId = $userId;
						$industryType = 'competition';
						$loggedUserId=isloginUser();
						
						/*For Manage view counts */
						if((isset($projectId)) && (!empty($projectId)) && (isset($entityId)) && (isset($projectId)) && (isset($industryType)) && (!empty($industryType))){
							/*Get section Id*/
							$sectionId = $this->config->item($industryType.'SectionId');
							manageViewCount($entityId,$projectId,$userId,$projectId,$sectionId);
						}	
						
						
						//--------share button code--------//
						$currentUrl = base_url().uri_string();
						$relation = array('getShortLink', 'email','share','entityTitle'=> $competitionTitle, 'shareType'=>'competition details', 'shareLink'=> $currentUrl,'id'=> 'Project'.$project['projectid'],'entityId'=>$entityId,'elementid'=>$projectId,'projectType'=>$industryType,'isPublished'=>'t','viewType'=>'showcase');
						$this->load->view('common/relation_to_share',array('relation'=>$relation));
					?>
				</div>
				<div class="cell lineH27 pt5 ml20">
					<div class="icon_crave4_blog clr_white font_size14  <?php echo ($competitionData->craveId > 0)?'cravedALL':''; ?>">
						<?php echo $competitionData->craveCount; ?>
					</div>
				</div>
				<div class="cell lineH27 pt5 ml10">
					<div class="icon_view3_blog clr_white font_size14">
						<?php echo $competitionData->viewCount; ?>
					</div>
				</div>
				<div class="clear">
				</div>
			</div>
			<!-------media share div start----->
			
			<div class="seprator_20">
			</div>
		</div>
	</div>
</td>

<script type="text/javascript">
		
	$(document).ready(function(){
			$('#slider1').tinycarousel({ display: 3 });
		
	});
		
	function mousedown_tds_compenter(obj){
	obj.style.backgroundPosition ='0px -60px';
	obj.firstChild.style.backgroundPosition ='right -60px';
	}
	function mouseup_tds_compenter(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.firstChild.style.backgroundPosition ='right 0px';
	}

	// load first media automatically
	playMedia('<?php echo $firstMediaUrl; ?>','<?php echo $firstMediaType; ?>');

</script>

