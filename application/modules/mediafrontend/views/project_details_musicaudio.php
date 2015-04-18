<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";
    
?>
<!--box01-->
<?php $lastline = '';?>
<div class="row width_451 sub_col_middle global_shadow_light">
	<div class="row">
		  <div class="cell pl10 pt5 pr10 pb15">
				<h1 class="heading04"><?php echo $project['projName'];?></h1>
		  </div>
		  <div class="clear"></div>
	</div>
	<div class="SMA_top_greyGradient_box">
		<div class=" Fleft SMA_thumb global_shadow ml10 mt10 mb10">
			<div class="AI_table">
				<div class="AI_cell">
					<img class="max_w147_h147"  src="<?php echo $project['projectImage']; ?>" >
				</div>
			</div>
		</div>
		<div class="cell pl12 pr10 width_267">
			<div class="industry_type_wrapper font_opensansSBold pt25">
			  <div class="summery_posted_wrapper bdrt_f15921">
				  <span class="cell pl16"><?php echo $this->lang->line('released');?></span>	
				  <span class="cell width_90 pl15 orange"><?php $releaseDate = date("F Y", strtotime($project['projReleaseDate']));echo $releaseDate; ?></span>
				  <div class="clear"></div>
			  </div>
			  <div class="summery_posted_wrapper bdrt_f15921 ">
				  <span class="cell width_90 pl16"><?php echo $producedInCountry = getSubString($project['countryName'],20);?></span>
				  <span class="cell  pl16"><?php echo $language = getSubString($project['Language_local'],20);?></span>
				  <div class="clear"></div>
			  </div>
			  <!--summery_posted_date_wrapper--->
			  <div class="summery_posted_wrapper bdrt_f15921">	
			    <span class="cell width_90 pl16"><?php echo $project['projectTypeName']; //echo $this->lang->line('Type');?></span>			 
				<?php if(!empty($project['genre'])){?>
						<span class="cell pl16"><?php echo getSubString($project['genre'],20);?></span> 
				<?php } ?>
				<div class="clear"></div>
			  </div>
			  <?php if(!empty($project['projGenreFree'])){ ?>
			  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
			    <span class="cell pl16"><?php echo $project['projGenreFree'];?></span>		
			    <div class="clear"></div>	 
			  </div>
			 <?php  } ?>
			  			 
			     
			  <div class="summery_posted_wrapper height_42 bdrt_f15921">
				<div class="cell width_90 pl16 pt15 lineH27">
				  <div class="icon_view3_blog"><?php echo $constant['project_views'].'&nbsp;'.$project['viewCount'];?></div>
				</div>
				<div class="cell pl16 pt15 lineH27">
					<div class="icon_crave4_blog craveDiv<?php echo $entityId.''.$project['projectId']?> <?php echo $project['cravedALL'];?>"><?php echo $constant['project_craved'].'&nbsp;&nbsp;';?><span class="inline"><?php echo $project['craveCount'];?></span></div>
				     <div class=" cell padding_left16 pt10 rateDiv<?php echo $entityId.''.$project['projectId']?>">			 
				           <img  src="<?php echo base_url($project['ratingImg']);?>" />
			         </div>			   
				</div>				
				<div class="clear"></div>
			  </div>
			  <div class="cell pb20">
						<!--<span class="cell width_90 pl16">03:55:00</span>-->
				<div class="pl16  font_opensansSBold clr_f1592a font_size11"><?php  if(isset($element['fileLength']) && $element['fileLength']!='00:00:00') echo $element['fileLength'];?><span class="display_inline  pl15"><?php echo $project['dirSize'].'&nbsp;'.$this->lang->line('mb');?></span></div>
			  </div>
			</div>
			<!--industry_type_description-->
		  </div>
		  <div class="clear"></div>
		</div>
		
		<?php
			if(strlen(trim(@$project['projShortDesc']))>2){ ?>
					<div class="row note pt20 clr_Dblue"> <em><?php echo nl2br($project['projShortDesc']);?></em> </div>
					<div class="seprator_10"></div>
				<?php		
			}
		 
			if(strlen(trim(@$project['projDescription']))>2){ ?>
					<div class="row "><?php echo changeToUrl(nl2br($project['projDescription']));?></div>
				<?php		
			}
		 ?>				
		<div class="seprator_20"></div>
		<div class="row font_opensans mb16">
			
			<div class="tds-button_rate cell Fright"> 
			   <?php $this->load->view('rating/ratingView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'ratingAvg'=>$project['ratingAvg'],'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$project['isPublished']));?>
			</div>
			
		  <?php
				if(!($industryType=='news' || $industryType=='reviews')){
					$headingKeyPersonnel=$this->lang->line('mediaProductionTeam');
					$this->load->view('creativeinvolved/keypersonnel_frontend_view',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'heading'=>$headingKeyPersonnel));
				}
			
				$this->load->view('craves/craveView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'ownerId'=>$project['tdsUid'],'projectType'=>$industryType,'isPublished'=>$project['isPublished'],'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));
		 
				if(!($industryType=='news' || $industryType=='reviews')){
		  ?>
				<div class="tds-button01 cell Fright">			
		           <?php $this->load->view('media/reviewView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'projName'=>$project['projName'],'section' =>'Music & Audio','industryId' =>'2','isPublished'=>$project['isPublished']));	?>			
                </div>			
				
		<?php } ?>
		  <div class="clear"></div>
		</div>
		<?php
			if($project['methodName']=='searchresult'){
				$project['projectListingCount']=0;
			}
			$btn = $project['projectListingCount']<=1?'btn':'';
		?>
		<div class="row pagination02 font_opensans <?php echo $btn?>">
			<?php 
			if($project['projectListingCount'] > 0){
				
				if(@$project['previousProjectId']>0){ ?>
					<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$project['methodName'].'/'.$userId.'/'.$project['previousProjectId'].'/'.$project['previousProjectType'].$previewWord);?>" class="cell pre_arrow dash_link_hover"><?php echo $constant['previousLink'];?></a> 
					<?php
				}
				if(@$project['nextProjectId']>0){ ?> 
					<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$project['methodName'].'/'.$userId.'/'.$project['nextProjectId'].'/'.$project['nextProjectType'].$previewWord);?>" class="cell Fright next_arrow dash_link_hover"><?php echo $constant['nextLink'];?></a>
					<?php
				}
			}
			?>
		  <div class="clear"></div>
		</div>
		<div class="row font_opensans mt15">
			 <div class="fl blog_links_wrapper pt0">
				<?php	
					//$url = base_url().uri_string();
					$currentUrl = base_url().uri_string();
					$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $project['projName'], 'shareType'=>$constant['project_heading'], 'shareLink'=> $currentUrl,'id'=> 'Project'.$project['projectid'],'entityId'=>$entityId,'elementid'=>$project['projectid'],'projectType'=>$project['projectType'],'isPublished'=>$project['isPublished'],'viewType'=>'showcase');
					$this->load->view('common/relation_to_share',array('relation'=>$relation));
				?>							  
			  </div> 		
			  	<div class="clear"></div>  
			  	<div class="seprator_12"></div>
				<div class="fr font_size11 lh45 padding_left10 font_opensansSBold"><?php echo $project['projRating'];?></div>		  		 
			  
				<?php if(!empty($project['productionHouse'])) { ?>
					 <div class="row fr">
						 <div class="cell font_size11 pl16"><?php echo $constant['productioNcompany'];?>
						<div class="cell padding_left10 font_size11  font_opensansSBold Fright">
							<?php echo $project['productionHouse'];?>
						</div>
						</div>
					</div>
					 
				<?php } ?>		 		  
		  
		  <div class="clear"></div>
		</div>
	</div>
<div class="row width470px ma mt20" id="advert468_60"><?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//Manage left side content bottom advert
		$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
		
		if(!empty($bannerRhsData)) {
			$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId));
		} else {
			$this->load->view('common/adv_content_bot'); 
		}
	} else {
		$this->load->view('common/adv_content_bot'); 
	}?>
</div>
</div>
	<div class="clear"></div>  
   <div class="seprator_2"></div>
<?php echo Modules::run("mediafrontend/getReviewList",$entityId,$project['projectId'],$project['craveCount'],$project['viewCount']);
// call player for playing audio clip
echo Modules::run("player/commonAudioPlayer");
 ?>
