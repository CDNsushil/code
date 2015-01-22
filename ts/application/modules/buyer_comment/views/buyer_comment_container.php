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
				case 'filmNvideo':
				$project_Url = base_url('mediafrontend/searchresult').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId.'/filmvideo';
				break;
				case 'musicNaudio':
				$project_Url = base_url('mediafrontend/searchresult/').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId.'/musicaudio';
				break;
				case 'writingNpublishing':
				$project_Url = base_url('mediafrontend/searchresult/').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId.'/writingpublishing';
				break;
				case 'photographyNart':
				$project_Url = base_url('mediafrontend/searchresult/').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId.'/photographyart';
				break;
				case 'educationMaterial':
				$project_Url = base_url('mediafrontend/searchresult/').'/'.$buyer_comments->ownerId.'/'.$buyer_comments->elementId.'/educationmaterial';
				break;
				default:
					 $project_Url = base_url('home');
				
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
				$ratingImg=base_url().'images/rating/rating_0'.$ratingAvg.'.png';
			/****************crave and ratting code end***************/
			
			
			//print_r($buyer_comments);
		?>
		
		
			<div class="buyer_cmtboxbg pt7 pb7 mr9 ml9 pl12 pr12 position_relative minH80">	
				<div class="position_absolute shadow_wp left436">
				<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
				  <tbody>
					<tr>
					  <td height="30"><img src="<?php echo base_url('templates/frontend/'); ?>/images/seprator_buyercomenttop.png"></td>
					</tr>
					<tr>
					  <td class="seprator_buyercoment">&nbsp;</td>
					</tr>
					<tr>
					  <td height="30"><img src="<?php echo base_url('templates/frontend/'); ?>/images/seprator_buyercomentbtm.png"></td>
					</tr>
				  </tbody>
				</table>
				<div class="clear"></div>
				</div>
				<?php 
					$getUserShowcase	= showCaseUserDetails($buyer_comments->tdsUid);
					
					$creative=$getUserShowcase['creative'];
					$associatedProfessional=$getUserShowcase['associatedProfessional'];
					$enterprise=$getUserShowcase['enterprise'];
					$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg'):''));
					if(!isset($userDefaultImage) || $userDefaultImage=='') $userDefaultImage=$this->config->item('defaultMemberImg_m');
					//$profile_img = getContactUserProfileImage($value['email']);
					if($getUserShowcase['userImage']!='') {
						 $userImage=$getUserShowcase['userImage'];
					}
					//echo $userImage;
					$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
					$userImage=getImage($userImage,$userDefaultImage);
					
				?>
				
				<a href="<?php echo base_url('showcase/aboutme/'.$buyer_comments->tdsUid); ?>"  target="_blank">
				 <div class="fl width_412">
					<div class="fl height_68 width68 bg_444 pall6">
								 <img src="<?php echo $userImage; ?>" class="maxH68_maxW68 bdr_white">
						  </div>
						  
					<div class="fl ml26">
						<div class="row width_304">
							<div class="fl font_arial font_weight clr_f1592a width_206 gray_clr_hover"><?php echo $buyer_comments->custName; ?> </div>
							<div class="fr text_alignR font_arial font_weight clr_444"><?php echo $buyer_comments->rateSeller; ?> </div>
							<div class="clear"></div>
						</div>
						<div class="seprator_5"></div>
						<div class="fl width_304 clr_444 lineH15">
					   <?php echo $buyer_comments->comments; ?> 
						</div>
					</div>                       
				</div>
				</a>
				
				<a href="<?php echo $project_Url;?>" target="_blank">
				<div class="fr width295">
					<div class="seprator_5"></div>
											<div class="fl width_90 height_68 bdr_cecece bg_444 ">
												<div class="AI_table">
													<div class="AI_cell">
														<img class="maxW80_maxH60 bdr_white" src="<?php echo $buyer_comments->itemImage; ?>">
													 </div>
												 </div>
											</div>
											
											<div class="fr width186 mt3">
												<div class="fontB font_size12 clr_444 lineH14 dash_link_hover"><?php echo $buyer_comments->itemName; ?> </div>
											 
											 <div class=" seprator_35"></div>
											 <div class="row mr10">

											   <div class="cell blogS_crave_btn min_w20 font_opensans craveDiv<?php echo $projectEntityId.''.$projDetail->projId;?> <?php echo $cravedALL;?>">
													<?php echo $craveCount;?>
												   </div>
												   <div class="cell ml14 mt6 Fright"><img src="<?php echo $ratingImg;?>" /></div>
												   <div class="icon_view3_buyer_comment"> <?php echo $viewCountShow; ?></div>
										  </div>
										   
											</div>			
				</div>
				</a>
				
				 <div class="clear"></div>
			   </div>
			   
        <div class="clear"></div>
           
        <div class="seprator_6"></div>
       
       
      

       
       <?php } if( $countTotal > 10)
			{?> 
       
        <div class="clear"></div>
					
					<div class="pt5 row ml10 mr15">
						
					        <?php $this->load->view('pagination_multi',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/buyer_comment/index/'.$userId.'/yes'),"divId"=>"showInbox","formId"=>"composeForm","unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
					</div>
       <?php } } ?>
       
       <!-------------Row end here------->
