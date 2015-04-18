<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php

 $URLuserId=$this->uri->segment(4);

 if(!isset($URLuserId) || $URLuserId=='') $URLuserId = isLoginUser();
?>
<div class="width_451 sub_col_middle global_shadow">
                <div class="sub_col_middle_inner global_shadow">
                  <!--box01 sub01-->
                  <div class="row note font_size13 p15 lineH16 fntclr_Upcoming upcoming_desc_shadow bdr_cccccc mb1 ">
					<em><?php echo $upcomingRecord['proShortDesc'];?></em> 
				  </div>
				  <div class="blogbottom_sheado"></div>  
                 
                  <div class="font_opensansSBold Fright pl15 pr15 mt-14">
					<?php $this->load->view('creativeinvolved/keypersonnel_frontend_view',array('elementId'=>$upcomingRecord['projId'],'entityId'=>$entityId,'heading'=>$this->lang->line('keyPersonnel'),'noButton'=>1)); ?>
				  <div class="width_40 cell">&nbsp;</div><a class="orange_color cell gray_clr_hover" href="javascript:void(0);" onclick="openLightBox('popupImages','popupImagesContainer','/upcomingfrontend/popupFurDesc','<?php echo $upcomingRecord['projId'];?>','<?php echo $URLuserId;?>','<?php echo $craveCount;?>','<?php echo $viewCount;?>','<?php echo $ratingAvg;?>');"><?php echo $this->lang->line('furtherDesc'); ?></a>
				  </div>
                  <div class="clear"></div>
                  <div class="seprator_10"></div>
               
                  <div class="summery_posted_wrapper font_opensans bdrt_f15921"> 
					  <span class="cell pl15"><?php echo $this->lang->line('releasedDate');?></span> 
					  <span class="cell width_130 pl15 font_opensansSBold orange">
						  <?php $releaseDate = date("F Y", strtotime($upcomingRecord['projReleaseDate']));echo $releaseDate; ?>
					  </span>
					  <div class="clear"></div>
				  </div>
				
                  <div class="summery_posted_wrapper font_opensans bdrt_f15921">                   
					  <span class="cell width_280  pl15 font_opensansSBold">
					  <?php 
						echo $upcomingRecord['projCity'];
						if($upcomingRecord['projCountry']>0)
						{
							if(!empty($upcomingRecord['projCity'])){
								echo ',&nbsp;&nbsp;'.getCountry($upcomingRecord['projCountry']);
							}else{
								echo getCountry($upcomingRecord['projCountry']);
							} 
						}
						//if(@$upcomingRecord['projCountry']>0) echo ',&nbsp;&nbsp;'.getCountry($upcomingRecord['projCountry']);
					  ?>
					  </span> 
					  <span class="cell width_100  pl15 font_opensansSBold">
						 <?php echo getLanguage($upcomingRecord['projLanguage']);?>
					  </span> 
					  <div class="clear"></div>
				  </div>                  
              
                  <div class="summery_posted_wrapper font_opensans bdrt_f15921">                  
                  <span class="cell width_280  pl15 font_opensansSBold">
					<?php 					
						if(isset($upcomingRecord["projUpType"]) && $upcomingRecord["projUpType"]!='')
						{
							if($upcomingRecord["projUpType"]==1) echo $this->lang->line('EducationalMaterial');
							if($upcomingRecord["projUpType"]==2) echo $this->lang->line('perOrEvent');
							if($upcomingRecord["projUpType"]==3) echo $this->lang->line('mediaProject');
						}							
					?>
				  </span>
				  <span class="cell width125px  pl15 font_opensansSBold">
				  <?php 
						$projIndustryName = getFieldValueFrmTable('IndustryName','MasterIndustry','IndustryId',$upcomingRecord['projIndustry']);
						echo $projIndustryName[0]->IndustryName;
				  ?>
				  </span> 
				  <div class="clear"></div>
				  </div>
                 
                  <div class="seprator_16 bdrt_f15921"></div>
                  <!--box01 sub06-->
                   
                  <div class="row pr0 mb10">					  
					  
					<div class="fl blog_links_wrapper pt0">
						<?php	
							//$url = base_url().uri_string();
							$currentUrl = base_url().uri_string();
																					
							$relation = array('getFrontShortLink', 'email','share','entityTitle'=> $upcomingRecord['projTitle'], 'shareType'=>$upcomingRecord['projType'], 'shareLink'=> $currentUrl,'id'=> 'Project'.$upcomingRecord['projId'],'entityId'=>$entityId,'elementid'=>$upcomingRecord['projId'],'projectType'=>$upcomingRecord['projType'],'isPublished'=>$upcomingRecord['isPublished'],'viewType'=>'showcase');
							$this->load->view('common/relation_to_share',array('relation'=>$relation));
						?>							  
				   </div>   					  
					                
					  <div class="tds-button_rate cell Fright">   
						 <?php $this->load->view('rating/ratingView',array('elementId'=>$upcomingRecord['projId'],'entityId'=>$entityId,'ratingAvg'=>$ratingAvg,'ratingClass'=>'width_auto Fleft'));?> 
					  </div>                    
                      
                    <div class="cell Fright">
                    <?php
                 
					$cacheFile = 'cache/upcoming/upcoming_'.$upcomingRecord['projId'].'_'.@$currentproductDetail->tdsUid.'.php';
					$cacheImg = @$upcomingRecord['filePath'].'/'.@$upcomingRecord['fileName'];
					
					$this->load->view('craves/craveView',array('elementId'=>$upcomingRecord['projId'],'entityId'=>$entityId,'ownerId'=>@$upcomingRecord['tdsUid'],'projectType'=>'upcoming','furteherDetails'=>'{"projectId":"'.$upcomingRecord['projId'].'","table":"Upcoming","primeryField":"projId","imageUrl":"'.$cacheImg.'","fieldSet":"productId as id, projTitle as craveTitle, proShortDesc as craveShortDescription, projTag as tagwords","cacheFilePath":"'.$cacheFile.'"}'));
				
					?>                  
                    </div>
                    <div class="clear"></div>
                  </div>
                <div class="fl font_size11 padding_left10 font_opensansSBold mb10"><?php 
							echo getMasterRating($upcomingRecord['rating']);
				?></div>
                <div class="clear"></div>
                </div>
              </div>
              <div class="seprator_6"></div>
<?php // ?>
