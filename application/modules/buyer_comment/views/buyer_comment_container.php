<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-----------------Row start here-------------->
		
		<?php 
		if($get_buyer_comments['get_num_rows'] > 0)
		{	 
			
		foreach($get_buyer_comments['get_result'] as $buyer_comments)
		{	
			
			/****************here get project url by type start****************/
			switch($buyer_comments->get_type)
			{	
				case 'Film & Video':
				$project_Url = base_url_lang('mediafrontend/mediashowcases').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId;
				break;
				case 'Music & Audio':
				$project_Url = base_url_lang('mediafrontend/aboutalbum').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId;
				break;
				case 'Writing & Publishing':
				$project_Url = base_url_lang('mediafrontend/writingdetails').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId;
				break;
				case 'Photography & Art':
				$project_Url = base_url_lang('mediafrontend/photoartdetails').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId;
				break;
				case 'Education Material':
				$project_Url = base_url_lang('mediafrontend/educationdetails').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId;
				break;
				default:
					 $project_Url = base_url_lang('home');
				
			}
			
			/****************here get project url by type end****************/
			
			/*************crave and ratting code start****************/
			
			$entityId  = $buyer_comments->entityId;
			$elementId  = $buyer_comments->elementId;
				$craveCount=0;
				$ratingAvg=0;
					$LogSummarywhere=array(
						'entityId'=>$entityId,
						'elementId'=>$elementId
					);
					$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
					
					if($resLogSummary)
					{
						$resLogSummary = $resLogSummary[0];											
						$craveCount = $resLogSummary->craveCount;
						$ratingAvg = $resLogSummary->ratingAvg;
						$viewCountShow = $resLogSummary->viewCount;
					}else
					{										
						$craveCount=0;
						$ratingAvg=0;
						$viewCountShow=0;
					}
				
				$loggedUserId=isloginUser();
				if($loggedUserId > 0){
					$where=array(
						'tdsUid'=>$loggedUserId,
						'entityId'=>$entityId,
						'elementId'=>$elementId
					);
					$countPAResult=countResult('LogCrave',$where);
					$cravedALL=($countPAResult>0)?'cravedALL':'';
				}else{
					$cravedALL='';
				}
			
				$ratingAvg=roundRatingValue($ratingAvg);
				
				$ratingImg = ratingImagePath($ratingAvg);
				
				//$ratingImg=base_url_lang().'images/rating/rating_0'.$ratingAvg.'.png';
			/****************crave and ratting code end***************/
			
			
			//print_r($buyer_comments);
		?>
		
		
				<?php 
					$getUserShowcase	= showCaseUserDetails($buyer_comments->tdsUid);
					
					$creative=$getUserShowcase['creative'];
					$associatedProfessional=$getUserShowcase['associatedProfessional'];
					$enterprise=$getUserShowcase['enterprise'];
					
					
					
					//$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
					
					if(!empty($getUserShowcase['creative']) || !empty($getUserShowcase['associatedProfessional']) || !empty($getUserShowcase['enterprise'])){ 
					$userDefaultImage=($getUserShowcase['enterprise']=='t')?$this->config->item('defaultEnterpriseImg_xs'):($getUserShowcase['associatedProfessional']=='t'?$this->config->item('defaultAssProfImg_xs'):$this->config->item('defaultCreativeImg_xs'));
					}else{
					$userDefaultImage=$this->config->item('defaultMemberImg_xs');
					}
 					
 					
 					
					if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_xs');
					//$profile_img = getContactUserProfileImage($value['email']);
					if($getUserShowcase['userImage']!='') {
						 $userImage=$getUserShowcase['userImage'];
					}
					//echo $userImage;
					$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='crop_thumb');  	
					$userImage=getImage($userImage,$userDefaultImage);
					
				?>
				
         
        <div class="user_div clearbox">
			<a href="<?php echo base_url_lang('showcase/aboutme/'.$buyer_comments->tdsUid); ?>"  target="_blank">
                     <div class="fl p10"> <div class="profile_comment width100  pr20 pl3 fl">
            <p class="green clearbox pl5"> <?php echo $buyer_comments->custName; ?> </p>
          </div> 
          
            <?php if($getUserShowcase['enterprise']=='t'){ ?>
                                <div class="fl interpise text_alignC"> <img class="entermaxhw" src="<?php echo $userImage; ?>" alt="" /> </div>
                            <?php }else{ ?>
                                <div class="comnet_img fl"> <img src="<?php echo $userImage; ?>" alt="" /> </div>
                            <?php } ?>
          
          <!--
           <div class="comnet_img fl"> <img src="<?php //echo $userImage; ?>" alt="" /> </div>
                      -->
          
          <div class="width305 pl15 bdrL_2666 min_H110 ml30 fl lineH20"> 
           <b class=" fl clearbox red pb10 lineH16 fs16"><?php echo $buyer_comments->rateSeller; ?></b>
         <?php echo $buyer_comments->comments; ?></div>
          </div>
           </a>
              <a href="<?php echo $project_Url;?>" target="_blank">
           <div class="fr mt10 bg_f3f3f3 mr10 width300">  <div class=" fr  min_H110 width300"> 
                          <div class="display_table bg_dfdfdf fl   width110X110 ">
                <div class="table_cell"> <img src="<?php echo $buyer_comments->itemImage; ?>" class="max110X110" /> </div>
              </div> <div class="fl width162 pt10 pl8 pr8 pb10"><b class="fs12 min_h48 pb10 fl lineH14 "><?php echo $buyer_comments->itemName; ?></b> 
                          <div class="head_list fr mt15 ">
                <div class="icon_view3_blog icon_so"><?php echo $viewCountShow; ?></div>
                <div class="icon_crave4_blog icon_so <?php echo $cravedALL; ?>"><?php echo $craveCount;?></div>
                <div class="rating fl pt6"> <img src="<?php echo $ratingImg;?>" alt=""> </div>
           
              </div> </div>
                        </div> </div>
                 </a>        
          </div>


<!--
                 <div class="user_div clearbox mb64">
                     <a href="<?php echo base_url_lang('showcase/aboutme/'.$buyer_comments->tdsUid); ?>"  target="_blank">
                        <div class="fl">
                            <div class="profile_comment width_120  pr20 pl3 fl">
                               <p class="green clearbox pl5"> <?php echo $buyer_comments->custName; ?> </p>
                            </div>
                            
                            <?php if($getUserShowcase['enterprise']=='t'){ ?>
                                <div class="fl width106x106 text_alignC"> <img class="entermaxhw" src="<?php echo $userImage; ?>" alt="" /> </div>
                            <?php }else{ ?>
                                <div class="comnet_img fl"> <img src="<?php echo $userImage; ?>" alt="" /> </div>
                            <?php } ?>
                            <div class="width305 pl15 bdrL_2666 min_H110 ml30 fl lineH21"> 
                               <b class=" fl clearbox red pb10 lineH16 fs16"><?php echo $buyer_comments->rateSeller; ?></b>
                                <?php echo $buyer_comments->comments; ?>
                            </div>
                        </div>
                     </a>
                      <a href="<?php echo $project_Url;?>" target="_blank">
                         <div class="fr width300">
                            <div class="border_cacaca fr  min_H110 width288">
                               <div class="display_table bg_dfdfdf fl   width110X110 ">
                                  <div class="table_cell"> <img src="<?php echo $buyer_comments->itemImage; ?>" class="max110X110" /> </div>
                               </div>
                               <div class="fl width162 pt10 pl8 pr8 pb10">
                                  <b class="fs12 min_h48 pb10 fl lineH14 "><?php echo $buyer_comments->itemName; ?></b> 
                                  <div class="head_list fr mt15 ">
                                     <div class="icon_view3_blog icon_so"><?php echo $viewCountShow; ?></div>
                                     <div class="icon_crave4_blog icon_so <?php echo $cravedALL; ?>"><?php echo $craveCount;?></div>
                                     <div class="rating fl pt6"> <img src="<?php echo $ratingImg;?>" alt=""> </div>
                                  </div>
                               </div>
                            </div>
                         </div>
                     </a>
                  </div>
-->
       <div class="clear"></div>
       <?php 
       
       }  
    ?>
    
       <?php
		$url =current_url();
    if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
         <div class="row">
                <?php $this->load->view('pagination_new',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$url,"divId"=>"showbuyercomments","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
            <div class="clear"></div>
        </div>
    <?php } ?> 
    
       <?php 
        } 
        ?>
       
       <!-------------Row end here------->
