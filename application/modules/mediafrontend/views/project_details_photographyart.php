<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    //add preview word if preview mode is active
    $previewWord =  (previewModeActive())?"/preview":"";

?>
<div class="row width_451 sub_col_middle global_shadow_light">
	<div class="row">
		<div class="audio_player_shadow">
		  <div class="img_grey_bg">
			  <div class="seprator_30"></div>
			  <div class="PA_top_big_img bdr_grey10 ptr" onclick="loadPopupData('popupBoxWp','popup_box',popup_images);">
				  <div class="AI_table">
						<div class="AI_cell"><img class="max_w361_h240 bdr_cecece"  src="<?php echo $project['projectImage']; ?>" ></div>
				  </div>
			  </div>
			  <div class="PA_top_big_img_title text_alignC"> <?php echo string_decode($project['projName']);?></div>
		  </div>
		</div>
	</div>
<div class="seprator_10"></div>
<div class="">
  <div class="cell pl12 pr10 width_267">
	<div class="industry_type_wrapper font_opensansSBold ">
	   <div class="summery_posted_wrapper bdrt_f15921">
			  <span class="cell pl16"><?php echo $this->lang->line('Published');?></span>		
				  <span class="cell width_90 pl15 orange"><?php $releaseDate = date("F Y", strtotime($project['projReleaseDate']));echo $releaseDate; ?></span>
				  <div class="clear"></div>
			  </div>
			  <div class="summery_posted_wrapper bdrt_f15921 ">
				  <span class="cell width125px pl16"><?php echo $project['countryName'];?></span>
				  <span class="cell pl16"><?php echo $language = $project['Language_local'];?></span>
				  <div class="clear"></div>
			  </div>
			  <!--summery_posted_date_wrapper--->
			  <div class="summery_posted_wrapper bdrt_f15921">	
			    <span class="cell width125px pl16"><?php echo $project['projectTypeName'];?></span>			 
				<?php if(!empty($project['genre'])){ ?>
						<span class="cell pl16"><?php echo $project['genre'];?></span> 
				<?php } ?>
				<div class="clear"></div>
			  </div>
			  <?php if(!empty($project['projGenreFree'])){ ?>
			  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
			    <span class="cell pl16"><?php echo $project['projGenreFree'];//echo getSubString($project['projGenreFree'],30);?></span>
				<div class="clear"></div>
			   </div>			 
			  <?php  echo '<div class="bdrt_f15921"></div>'; } ?>
	</div>
	<!--industry_type_description-->
  </div>
  <div class="cell bdr_non">
		<div class="cell pl10 pt10 lineH27">
			<div class="icon_crave4_blog craveDiv<?php echo $entityId.''.$project['projectId']; echo $project['cravedALL'];?>"><?php echo $constant['project_craved'].'&nbsp;&nbsp;';?><span class="inline"><?php echo $project['craveCount'];?></span></div>
			
		       <div class=" cell padding_left16 pt10 rateDiv<?php echo $entityId.''.$project['projectId']?>">			 
				  <img  src="<?php echo base_url($project['ratingImg']);?>" />
			   </div>
		</div>
		
		<div class="clear"></div>
		<div class=" width_90 pl10 lineH27">
		  <div class="icon_view3_blog"><?php echo $constant['project_views'].'&nbsp;'.$project['viewCount'];?></div>
		</div>
	  </div>	  
	   <div class="cell pb20">
				<div class="pl16  font_opensansSBold clr_f1592a font_size11"><?php  if(isset($element['fileLength']) && $element['fileLength']!='00:00:00') echo $element['fileLength'];?><span class="display_inline  pl15"><?php echo $project['dirSize'].'&nbsp;'.$this->lang->line('mb');?></span></div>
		</div>
	  <div class="clear"></div>
	</div>

<?php
	if(strlen(trim(@$project['projShortDesc']))>2){ ?>
			<div class="row note pt20 fntclr_PA"> <em><?php echo html_entity_decode(nl2br($project['projShortDesc']));?></em> </div>
			<div class="seprator_10"></div>
		<?php		
	}
 ?>
 
 <?php
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
		  ?>
		 
			<?php $this->load->view('craves/craveView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'ownerId'=>$project['tdsUid'],'projectType'=>$industryType,'isPublished'=>$project['isPublished'],'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));?>
		  <?php
			if(!($industryType=='news' || $industryType=='reviews')){?>
			
				<div class="tds-button01 cell Fright">
			
		               <?php $this->load->view('media/reviewView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'projName'=>$project['projName'],'section' =>'Photography & Art','industryId' =>'4','isPublished'=>$project['isPublished']));	?>
			
                </div>				
                   
			<?php		
			}
		  ?>
		  <div class="clear"></div>
		</div>
		<?php
			if($project['methodName']=='searchresult'){
				$project['projectListingCount']=0;
			}
			$btn=$project['projectListingCount']<=1?'btn':'';
		?>
		<div class="row pagination02 font_opensans <?php echo $btn?>">
			<?php 
			if($project['projectListingCount'] > 0){
				if(@$project['previousProjectId']>0){?>
					<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$project['methodName'].'/'.$userId.'/'.$project['previousProjectId'].'/'.$project['previousProjectType'].$previewWord);?>" class="cell pre_arrow"><?php echo $constant['previousLink'];?></a> 
					<?php
				}
				if(@$project['nextProjectId']>0){ ?> 
					<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$project['methodName'].'/'.$userId.'/'.$project['nextProjectId'].'/'.$project['nextProjectType'].$previewWord);?>" class="cell Fright next_arrow"><?php echo $constant['nextLink'];?></a>
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
	       <div class="fr font_size11 padding_left10 font_opensansSBold pt5"><?php echo $project['projRating'];?></div>		  		 
			  
					<?php if(!empty($project['productionHouse'])) { ?>
					     <div class="row fr">
							<div class="cell font_size11 pl16"><?php echo $constant['gallery'];?>
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
<?php echo Modules::run("mediafrontend/getReviewList",$entityId,$project['projectId'],$project['craveCount'],$project['viewCount']); ?>
