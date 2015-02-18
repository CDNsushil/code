<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// show title, onelinedescription and description by language
if($language!='language2'){
	$compEntriesTitle = getSubString($competitionEntriesData->title,30);
	$compEntriesonelineDescription = $competitionEntriesData->onelineDescription;
	$compEntriesDescription = $competitionEntriesData->description;
}else{
	$compEntriesTitle = getSubString($competitionEntriesData->titlelang2,30);
	$compEntriesonelineDescription = $competitionEntriesData->onelinedescriptionlang2;
	$compEntriesDescription = $competitionEntriesData->descriptionlang2;
}

$compEntriesCreateDate = date('d F Y',strtotime($competitionEntriesData->createdDate));

$voteCount  = ($competitionEntriesData->voteCount!='')  ? $competitionEntriesData->voteCount  : 0;
$shortlistCount  = ($competitionEntriesData->shortlistCount!='')  ? $competitionEntriesData->shortlistCount  : 0;


// show css by industry type
$industryData = getIndustryClass($competitionEntriesData->industryId);
$mediumButton = $industryData['mediumButton'];

// set main media file in array
$CESupportingMaterial[4]['title'] = 'Main File';
$CESupportingMaterial[4]['fileId'] = $competitionEntriesData->fileId;
$CESupportingMaterial[4]['filePath'] = $competitionEntriesData->filePath;
$CESupportingMaterial[4]['fileName'] = $competitionEntriesData->fileName;
$CESupportingMaterial[4]['fileLength'] = $competitionEntriesData->fileLength;
$CESupportingMaterial[4]['fileType'] = $competitionEntriesData->fileType;
$CESupportingMaterial[4]['isExternal'] = $competitionEntriesData->isExternal;
$CESupportingMaterial[4]['fileSize'] = $competitionEntriesData->fileSize;
$CESupportingMaterial[4]['rawFileName'] = $competitionEntriesData->rawFileName;
$CESupportingMaterial[4]['fileHeight'] = $competitionEntriesData->fileHeight;
$CESupportingMaterial[4]['fileWidth'] = $competitionEntriesData->fileWidth;
$CESupportingMaterial[4]['fileUnit'] = $competitionEntriesData->fileUnit;

// reset array key order
$CESupportingMaterial = array_values($CESupportingMaterial);
//reverse array
$CESupportingMaterial = array_reverse($CESupportingMaterial,true);

//--------get competition language-------//
$competitionLanguageFirst =  getLanguage($competitionEntriesData->languageId);
if($competitionEntriesData->languageid2 > 0){
  $competitionLanguageSecond =getLanguage($competitionEntriesData->languageid2);
} 	


// competition data 
$currentDate = strtotime(date("Y-m-d"));
$createdDate = strtotime($competitionEntriesData->createdDate);
$submissionStartDate = strtotime($competitionEntriesData->submissionStartDate);
$submissionEndDate = strtotime($competitionEntriesData->submissionEndDate);
$votingStartDate = strtotime($competitionEntriesData->votingStartDate);
$votingEndDate = strtotime($competitionEntriesData->votingEndDate);
$roundType = $competitionEntriesData->competitionRoundType;
$roundTypeLable = $this->lang->line('userCompetitionRound1');// set current round type
$onGoingRound='1';// set current going round
if($roundType==2){
	
	if($votingEndDate <= $currentDate){
		$submissionStartDate = strtotime($competitionEntriesData->submissionStartDateRound2);
		$submissionEndDate = strtotime($competitionEntriesData->submissionEndDateRound2);
		$votingStartDate = strtotime($competitionEntriesData->votingStartDateRound2);
		$votingEndDate = strtotime($competitionEntriesData->votingEndDateRound2);
		$roundTypeLable = $this->lang->line('userCompetitionRound2');// set current round type
		$onGoingRound='2';// set current going round
	}
}

?>

<td valign="top">
	<div class="cell right_coloumn margin_0 <?php echo $industryData['10pxborderClass_1']; ?> width778 bg_444 bg-non pb10">
		<div class="row font_helvetica_L pl72 pt25 pr80">
			<div class="font_museoSlab font_size28 clr_f1592a lineH28 bdrB_6e6e6e word-spacing2 letter_spac2">
				<?php echo $compEntriesTitle; ?> <span class="fr clr_white display_inline font_size12 font_opensansSBold pt5"><?php echo $compEntriesCreateDate; ?></span>
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
		<?php if(!empty($CESupportingMaterial)) { ?>
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
								foreach($CESupportingMaterial as $CEMediaData) { 
									$mediaUrl='';
									if($CEMediaData['isExternal'] !="t"){
									$mediaImage='';
									switch($CEMediaData['fileType']){
										case 1:
											//"image";
											$mediaImage=$CEMediaData['filePath'].$CEMediaData['fileName'];
											$mediaUrl=$CEMediaData['filePath'].$CEMediaData['fileName'];
											// get medium image
											$defMediaImage=$this->config->item('defaultMediaImg_b');
											$mediaUrl = addThumbFolder($mediaUrl,$suffix='_b',$thumbFolder ='thumb',$defCoverImageShow);	
											$mediaUrl = getImage($mediaUrl,$defMediaImage);
										break;
										case 2:
											// "video";
											$mediaImage = getVideoThumbFolder(@$CEMediaData['filePath'].$CEMediaData['fileName']);
											$mediaUrl = base_url('player/getPlayerIframe/'.$CEMediaData['fileId'].'_full');
										break;
										case 3:
											// "audio";
											$mediaImage=$this->config->item('defaultAudioIcon');
											$mediaUrl = base_url('player/getPlayerIframe/'.$CEMediaData['fileId'].'_full');
										break;
										case 4:
											// "text";
											$fullFileName = $CEMediaData['filePath'].$CEMediaData['fileName'];
											
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
									$getMediaUrlData = getMediaUrl($CEMediaData['filePath']);
										
										if($getMediaUrlData['isUrl'])
										{
											//url is valid 
											$headerDetails = @get_headers($CEMediaData['filePath'],1);
											if(isset($headerDetails['X-Frame-Options']))
											{
												// This code will show error 
												$src = base_url().'en/player/videoError/';

											}else
											{
												// This code will play url 
												$src = $CEMediaData['filePath'];
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
												$src = base_url().'en/player/commonPlayerIframe/'.$CEMediaData['fileId'].'_full/';
											} 
										}  
									
									$mediaUrl = $src;
								}
								
								
								// set functino action only audio and video file
								$actionFunction = '';
								if($CEMediaData['fileType']=="1" || $CEMediaData['fileType']=="2" || $CEMediaData['fileType']=="3"){
									$actionFunction = "playMedia('".$mediaUrl."','".$CEMediaData['fileType']."')";
									if($rowCount==0){
										$firstMediaUrl=$mediaUrl ;
										$firstMediaType=$CEMediaData['fileType'];
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
												<?php echo getSubString($CEMediaData['rawFileName'],10); ?>
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
			<div class="global_shadow  <?php echo $industryData['industryBG']; ?> pt_34 pb32 pl30 pr30 ml20 mr20">
				
				<?php if($competitionEntriesData->isMultilingual=="t" && $competitionEntriesData->languageid2 > 0){ ?>
					<div class="<?php echo $industryData['langTabCls']; ?>">
						<a href="<?php echo base_url('competition/entriesmedia/'.$userId.'/'.$competitionEntryId.'/language1');?>" class="<?php echo ($language=='language1')?'active':''; ?>"><?php
							 //showl language first
							 if($competitionEntriesData->languageId > 0){
									echo $competitionLanguageFirst;
								}else{
									echo $this->lang->line('competitionLanguage1'); 
								}
							 ?>
						 </a> |
						 <a href="<?php echo base_url('competition/entriesmedia/'.$userId.'/'.$competitionEntryId.'/language2');?>" class="<?php echo ($language=='language2')?'active':''; ?>">
							
						<?php
							//showl language second	
							if($competitionEntriesData->languageid2 > 0){
								echo $competitionLanguageSecond;
							}else{
								echo $this->lang->line('competitionLanguage2');
							}
						?>
						 
						 </a>
					</div>	
				<?php } ?>
				
				<div class="font_helvetica_L font_size16 <?php echo $industryData['industryFntClr']; ?> ml28 mr28 lineH18">
					<?php echo getSubString($compEntriesonelineDescription,'100'); ?>
				</div>
				
				<?php if(!empty($compEntriesDescription)) { ?>
					<div class="seprator_15"></div>
					<div class="position_relative">
						<div class="comp_shedow_img">
						</div>
						
						<div class="bg_white clr_444 pl15 pr15 pt25 pb34 font_opensansSBold font_size14 shedow_prnews">
							<?php echo getSubString($compEntriesDescription,'250'); ?>
						</div>
						
						<div class="comp_shedow_img shedow_pos">
						</div>
					</div>
				<?php } ?>
				
				<div class="fr mt25">
					
					
					<?php 
					if($votingStartDate <= $currentDate &&  $votingEndDate >= $currentDate ) {
						$buttonArray['buttonType']='shortlist'; // button show type
						$buttonArray['buttonSection']='entriesDetails'; // button section
						$buttonArray['buttonDivClass']=$mediumButton.' cell mt15 ml4'; // button classes
						$buttonArray['competitionId']=$competitionEntriesData->competitionId;
						$buttonArray['competitionEntryId']=$competitionEntriesData->competitionEntryId;
					
						// load shortlist button
						$this->load->view('competitionButton',$buttonArray);
						
						// load vote button
						$buttonArray['buttonType']='vote'; // set for vote button
						$this->load->view('competitionButton',$buttonArray); 
					}	
					?>
					
				</div>
				<div class="clear"></div>
			</div>
			
			<!-------media share div start----->
				<div class="bdr8_666 bg_white pt12 pb6 bg_444 global_shadow ml20 mr20 mt20">
				<div class="fl pl8">
					<?php	

						// competition details for share and crave
						
						$title=$competitionEntriesData->title;
						$entityId=getMasterTableRecord('CompetitionEntry');
						$projectId = $competitionEntriesData->competitionId;
						$elementId = $competitionEntryId;
						$userId = $userId;
						$industryType = 'competition';
						$loggedUserId=isloginUser();
						
						/*For Manage view counts */
						if((isset($projectId)) && (!empty($projectId)) && (isset($entityId)) && (isset($projectId)) && (isset($industryType)) && (!empty($industryType))){
							/*Get section Id*/
							$sectionId = $this->config->item($industryType.'SectionId');
							manageViewCount($entityId,$elementId,$userId,$projectId,$sectionId);
						}	
						
						$this->load->view('media/reviewView',array('elementId'=>$elementId,'projectId'=>$projectId,'entityId'=>$entityId,'projName'=>$title,'section' =>$industryType,'industryId' =>'16','reviewClass'=>'tds-button01 cell','isPublished'=>'t'));		
						
						//--------share button code--------//
						$currentUrl = base_url().uri_string();
						$relation = array('getShortLink', 'email','share','entityTitle'=> $competitionTitle, 'shareType'=>'competition details', 'shareLink'=> $currentUrl,'id'=> 'Project'.$project['projectid'],'entityId'=>$entityId,'elementid'=>$projectId,'projectType'=>$industryType,'isPublished'=>'t','viewType'=>'showcase');
						$this->load->view('common/relation_to_share',array('relation'=>$relation));
						
						//--------crave button  code------//
						//$this->load->view('craves/craveView',array('craveClass'=>'tds-button_crave cell','elementId'=>$projectId,'entityId'=>$entityId,'ownerId'=>$userId,'projectType'=>$industryType,'isPublished'=>'t'));
				?>
				</div>
				<div class="cell lineH27 pt5 ml10">
					<div class="icon_compvote clr_white font_size14">
						<?php echo $competitionEntriesData->voteCount; ?>
					</div>
				</div>
				<div class="cell lineH27 pt5 ml10">
					<div class="icon_view3_blog clr_white font_size14">
						<?php echo $competitionEntriesData->viewCount; ?>
					</div>
				</div>
				
				<div class="font_opensans font_size14 clr_white width_116 bdr_8e8e8e text_alignR fl pr8 ml10 lineH22 mt3 C555"><?php echo $this->lang->line('compeEntriesShortListed'); ?> <span  class="di" id="sortlist<?php echo $competitionEntriesData->competitionEntryId; ?>"><?php echo $shortlistCount; ?></span>	</div>
				<div class="font_opensans font_size14 clr_white width70px bdr_8e8e8e text_alignR fl pr8 ml10 lineH22 mt3 C555"><?php echo $this->lang->line('userCompetitionVotes'); ?> <span class="di" id="vote<?php echo $competitionEntriesData->competitionEntryId; ?>"> <?php echo $voteCount; ?></span>	</div>
				
				<div class="clear">
				</div>
			</div>
			<!-------media share div start----->
			<div class="seprator_13"></div>
			<div class="reviewpiecebg">
			<?php
			if(is_array($reviewData) && count($reviewData) > 0){
				echo "<div id='elementListingAjaxDiv' class='row'>";
				 $this->load->view('reviewList',array('reviewData'=>$reviewData));
				echo "</div>";
			}	?>
		  
	<div class="blog_status_bar padding_left10 padding_right10"> <span class="blogS_crave_btn Fleft width_40"><?php echo $competitionEntriesData->craveCount; ?></span> <span class="blogS_view_btn Fleft"><?php echo $competitionEntriesData->viewCount; ?></span> <span class=" Fright">1 / 72</span> </div>
	 </div>
			
			<div class="seprator_20"></div>
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
	
	// competition vote insert
	function voteInsert(val1,val2,val3) {
	
		fromData = {
					userId:val1,
					competitionId:val2,
					competitionEntryId:val3
				}
				$.post(baseUrl+language+'/competition/competitionvoteinsert',fromData, function(data) {
					if(data){
						customAlert(data.msg);
						if(data.countShow==1){
							$('#vote'+val3).html(data.voteCount);
						}
					} 	
				},"json");
	}
	
	
	// comeptition sort list
	function sorlistNunshortlist(val1,val2,val3) {
	
				fromData = {
					userId:val1,
					competitionId:val2,
					competitionEntryId:val3
				}
				$.post(baseUrl+language+'/competition/shorlistNunshortlistInsert',fromData, function(data) {
					if(data){
						customAlert(data.msg);
						if(data.countShow==1){
							$('#sortlist'+val3).html(data.shortlistCount);
						}
					} 	
				},"json");
	}


</script>

