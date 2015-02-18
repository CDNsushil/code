<div class="seprator_12"></div>  <?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row width_451 sub_col_middle global_shadow_light">
	<div class="EM_greyDbox bdr_Bnon">
         
          <div class="row pl16 pr16">             
              <div class="cell pt12 pb7 text_alignC bdrb_e6ac9a width410px">
                <h1 class="heading04"><?php echo $project['projName'];?></h1>               
              </div>
              <div class="clear"></div>
            </div>
          
          <div class="seprator_13"></div>  
          
          <div class="row mr10 ml10">
          	<div class="cell EM_main_thumb width_206">
				<div class="AI_table"><div class="AI_cell"><img class="max_w206_h174" src="<?php echo $project['projectImage'];?>" ></div></div></div>
            <div class="cell width_206 ml15"> 
                	
				<div class="gradient_morawithper shedowdfor_lightbox pb10 bdr_white">
					<div class="font_opensansSBold">
					  <div class="summery_posted_wrapper bdr_non">
						  <span class="cell pl16"><?php echo $this->lang->line('Published');?></span>
						  <span class="cell pl16 orange"><?php $releaseDate = date("F Y", strtotime($project['projReleaseDate']));echo $releaseDate; ?></span>
						  <div class="clear"></div>
					 </div>
						
					  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">
						  <span class="cell pl16"><?php echo $producedInCountry = $project['countryName'];?></span>
						  <div class="clear"></div>	 
					  </div>
					  
					  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">
						  <span class="cell  pl16"><?php echo $language = $project['Language_local'];?></span>
						  <div class="clear"></div>	 
					  </div>
					 
					  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
						<span class="cell pl16"><?php echo $project['IndustryName']; //echo $this->lang->line('Type');?></span>							
						<div class="clear"></div>	 
					  </div>
					  
					  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
						<span class="cell pl16"><?php echo $project['Genre']; //echo $this->lang->line('Type');?></span>							
						<div class="clear"></div>	 
					  </div>
					  
					  <?php if(!empty($project['projGenreFree'])){ ?>
					  <div class="summery_posted_wrapper bdrt_f15921 heightAuto">	
						<span class="cell pl16"><?php echo $project['projGenreFree'];?></span>		
						<div class="clear"></div>	 
					  </div>
					 <?php  } ?>  
						<div class="summery_posted_wrapper height_42 bdrt_f15921">
						<div class="cell pl15 pt5 lineH27 height_auto">
							<div class="icon_crave4_blog craveDiv<?php echo $entityId.''.$project['projectId']?> <?php echo $project['cravedALL'];?>"><?php echo $constant['project_craved'].'&nbsp;&nbsp;';?><span class="inline"><?php echo $project['craveCount'];?></span></div>
							<div class=" cell padding_left16 pt10 rateDiv<?php echo $entityId.''.$project['projectId']?>">			 
							   <img  src="<?php echo base_url($project['ratingImg']);?>" />
							</div>	
							
						</div>
						<div class="pl15  lineH27">
							<div class="icon_view3_blog"><?php echo $constant['project_views'].'&nbsp;'.$project['viewCount'];?></div>						
						</div>	
						<div class="clear"></div>
						</div>
					<div class="row pl20 pr5">
						<div class="fr fileinfo_len_size"><span><?php echo (@$element['fileLength'])?@$element['fileLength'].'&nbsp':'';echo $project['dirSize'].'&nbsp;'.$this->lang->line('mb');?></span></div>
					</div>
			   </div><!-- End font_opensansSBold -->
			 <div class="clear"></div>				
			</div><!-- End EM_view_crave_box -->
            </div><!-- cell width_206 ml15 -->
            <div class="clear"></div>
          </div>
          <div class="seprator_40"></div>
          </div>
     <div class="shadow_below_title"></div>
	<?php
		if(strlen(trim(@$project['projShortDesc']))>2){ ?>
				<div class="row note pt13 padding_replace fntclr_EM"> <em><?php echo nl2br($project['projShortDesc']);?></em> </div>
				<div class="seprator_10"></div>
			<?php		
		}
	
		if(strlen(trim(@$project['projDescription']))>2){ ?>
				<div class="row "><?php echo changeToUrl(nl2br($project['projDescription']));?></div>
			<?php		
		}
	 ?>
	
	<div class="seprator_34"></div>
	
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
		if(!($industryType=='news' || $industryType=='reviews')){ ?>			
			<div class="tds-button01 cell Fright">				
			   <?php $this->load->view('media/reviewView',array('elementId'=>$project['projectId'],'entityId'=>$entityId,'projName'=>$project['projName'],'section' =>'Educational Material','industryId' =>'10','isPublished'=>$project['isPublished']));	?>				
			</div>		
		<?php		
		}
	  ?>
	  <div class="clear"></div>
	</div>
	<!--box01 sub05-->
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
<div class="row width470px ma mt18" id="advert468_60"><?php 
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
  <!--article loop area-->
  <?php echo Modules::run("mediafrontend/getReviewList",$entityId,$project['projectId'],$project['craveCount'],$project['viewCount']); ?> 
  
