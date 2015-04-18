<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="bg_Lgrey mr2">
	<div class="seprator_14"></div>
	<div class="wp_title_new_box global_shadow">
	  <div class="row">
		<div class="seprator_13"></div>
		<h1 class="heading04 text_alignC ml14 mr14"><?php echo $project['projName'];?></h1>
		<div class="seprator_13"></div>
		<div class="Fleft ml30 wp_topimg_thumb w107_h160"><div class="AI_table"><div class="AI_cell"><img border="0" class="max_w107_h160" src="<?php echo $project['projectImage'];?>"></div></div> </div>
		<!--liquid_box_wrapper-->
		<div class="cell summery_post2_description">
		  <div class="industry_type_wrapper font_opensansSBold pt0">
			  <div class="summery_posted_wrapper bdrt_f15921">
				   <?php 
				    $dateFormat = 'F Y';
						
				    if(!($industryType=='news' || $industryType=='reviews'|| $industryType=='writingNpublishing')){ ?>
				    <span class="cell pl16"><?php echo $this->lang->line('released');?></span>	
				    <?php } else {?>
				     <span class="cell pl16"><?php echo $this->lang->line('Published');?></span>	
				    <?php } ?>
					<span class="cell pl16 orange"><?php echo $releaseDate=get_timestamp($dateFormat,$project['projReleaseDate']);?></span>
					<div class="clear"></div>
			  </div>
			   <div class="summery_posted_wrapper bdrt_f15921">
				  <span class="cell width220px pl16"><?php echo $project['countryName'];?></span>
				  <div class="clear"></div>
			  </div>
			
			   <div class="summery_posted_wrapper bdrt_f15921">
				  <span class="cell width220px pl16"><?php echo $project['Language_local'];?></span>				
				  <div class="clear"></div>
			  </div>
			  <?php if(!($industryType=='news' || $industryType=='reviews')){ ?>
			  <div class="summery_posted_wrapper bdrt_f15921"> 
					<span class="cell width125px pl16"><?php echo $project['projectTypeName']; //echo $this->lang->line('Type');?></span>
					<?php 
						if(!empty($project['genre'])){?>
							<span class="cell  pl16"><?php echo $project['genre'];?></span> 
					<?php } ?>
					<div class="clear"></div>
			 </div>
			  <?php } ?>
			 <?php if(!empty($project['projGenreFree'])){ ?>
			  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
			    <span class="cell pl16"><?php echo $project['projGenreFree'];?></span>	
			    <div class="clear"></div>		 
			  </div>
			 <?php } ?>
			<div class="summery_posted_wrapper pt10 bdrt_f15921">
			  <div class="cell width_90 padding_left16 lineH27">
				<div class="icon_view3_blog"><?php echo $constant['project_views'].'&nbsp;'.$project['viewCount'];?></div>
			  </div>
			  <div class="cell padding_left16 lineH27">
				<div class="icon_crave4_blog crave craveDiv<?php echo $entityId.''.$project['projectId']?> <?php echo $project['cravedALL'];?>"><?php echo $constant['project_craved'].'&nbsp;&nbsp;';?><span class="inline"><?php echo $project['craveCount'];?></span></div>
				
				<div class=" cell padding_left16 pt10 rateDiv<?php echo $entityId.''.$project['projectId']?>">			 
				     <img  src="<?php echo base_url($project['ratingImg']);?>" />
			   </div>				
			  </div>			  
			  <div class="clear"></div>
			</div>
			<?php
			if(!($industryType=='news' || $industryType=='reviews')){
			?>
			<div class="summery_posted_wrapper bdr_non">
				<!--<span class="cell width_90 padding_left16">Words 34,457</span>-->
				<div class="fr">
					<?php if(@$element['wordCount'] > 0){ ?> 
					<span class="cell pl16 font_opensansSBold clr_f1592a font_size11"><?php echo $element['wordCount'].'&nbsp;'.$this->lang->line('words');?></span>
					<?php } ?>
					<div class="pl16  font_opensansSBold clr_f1592a font_size11"><span class="display_inline  pl15"><?php echo $project['dirSize'].'&nbsp;'.$this->lang->line('mb');?></span></div>
				</div>
				<div class="clear"></div>
			</div>
			<?php		
			}
			?>
		  </div><!--industry_type_description-->
		</div><!--summery_post_description-->
		<div class="clear"></div>
		<div class="seprator_24"></div>
	  </div>
	
	</div>	
	<div class="blogbottom_sheado"></div>  
	<!--
	<div class="mr5 mt5">
	  <div class="tds-button01 Fright"> <a onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)"><span>Download</span></a> </div>
	  <div class="tds-button01 Fright"> <a onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)"><span class="mr0">Read</span></a> </div>
	  <div class="clear"></div>
	</div>
	-->
	<div class="seprator_14"></div>
	  
  </div>
 
<div class="row sub_col_middle global_shadow_light FV_shade_above_title">
	<?php
		if(strlen(trim(@$project['projShortDesc']))>2){ ?>
				<div class="row note pt15 fntclr_WP"> <em><?php echo nl2br($project['projShortDesc']);?></em> </div>
				<div class="seprator_10"></div>
			<?php		
		}
	 
		if(strlen(trim(@$project['projDescription']))>2){ ?>
				<div class="row "><?php echo changeToUrl(nl2br($project['projDescription']));?></div>
			<?php		
		}
	 ?>
	
	<!--box01 sub03-->
	<div class="seprator_34"></div>
	<!--box01 sub04-->
	<div class="row font_opensans mb16">		
		<div class="tds-button_rate cell Fright"> 
		  <?php $this->load->view('rating/ratingView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'ratingAvg'=>$project['ratingAvg'],'ratingClass'=>'width_auto ml5 Fleft','isPublished'=>$project['isPublished']));?>
	    </div>		
	   <?php
	 
		if(!($industryType=='news' || $industryType=='reviews')) {
			$headingKeyPersonnel=$this->lang->line('mediaProductionTeam');
			$this->load->view('creativeinvolved/keypersonnel_frontend_view',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'heading'=>$headingKeyPersonnel));
		}
		
		$this->load->view('craves/craveView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'ownerId'=>$project['tdsUid'],'projectType'=>$industryType,'isPublished'=>$project['isPublished'],'furteherDetails'=>'{"projectId":"'.$projectId.'","table":"Project","primeryField":"projId","fieldSet":"projId as id,projBaseImgPath as craveImage, projName as craveTitle, projShortDesc as craveShortDescription, tagwords as tagwords","cacheFilePath":"'.$cacheFile.'"}'));
	
		if(!($industryType=='news' || $industryType=='reviews')){ ?>		
			<div class="tds-button01 cell Fright">				
			   <?php $this->load->view('media/reviewView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'projName'=>$project['projName'],'section' =>'Writing & Publishing','industryId' =>'3','isPublished'=>$project['isPublished']));	?>				
			</div>                   			
		<?php }  ?>
	  <div class="clear"></div>
	</div>
	<!--box01 sub05-->
	<?php
		if($project['methodName']=='searchresult') {
			$project['projectListingCount'] = 0;
		}
		$btn = $project['projectListingCount']<=1?'btn':'';
	?>
	<div class="row pagination02 font_opensans <?php echo $btn?>">
		<?php 
		if($project['projectListingCount'] > 0){
			if(@$project['previousProjectId']>0){?>
				<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$project['methodName'].'/'.$userId.'/'.$project['previousProjectId'].'/'.$project['previousProjectType']);?>" class="cell pre_arrow dash_link_hover"><?php echo $constant['previousLink'];?></a> 
				<?php
			}
			if(@$project['nextProjectId']>0){ ?> 
				<a href="<?php echo base_url(lang().$urlUsername.'/mediafrontend/'.$project['methodName'].'/'.$userId.'/'.$project['nextProjectId'].'/'.$project['nextProjectType']);?>" class="cell Fright next_arrow dash_link_hover"><?php echo $constant['nextLink'];?></a>
				<?php
			}
		}
		?>
	  <div class="clear"></div>
	</div>
	<!--box01 sub06-->
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
		  <div class="fr font_size11 padding_left10 font_opensansSBold"><?php echo $project['projRating'];?></div>
					<?php if(!empty($project['productionHouse'])) { ?>
					     <div class="row fr">
							<div class="cell font_size11 pl16"><?php echo $constant['publisher'];?>
								<div class="cell padding_left10 font_size11  font_opensansSBold Fright">
									<?php echo $project['productionHouse'];?>
								</div>
							</div>
						</div>
					<?php } ?>	
		  <div class="clear"></div>	
		</div>
</div>
   <div class="row width470px ma mt20"> <?php $this->load->view('common/adv_content_bot'); ?></div>
   <div class="clear"></div>
  <!--article loop area-->
  <?php echo Modules::run("mediafrontend/getReviewList",$entityId,$project['projectId'],$project['craveCount'],$project['viewCount']); ?>
