<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="showRecommend">      
<?php if(isset($recomends) && !empty($recomends) ) {  
                         // echo "<pre>";print_r($recomends) ; die;
                            ?> 
                          
                          <div id="count" class="dn">0</div>
                          <div id="records" class="dn"><?php echo count($recomends) ?></div>
                          
						  <div class="width_506 pl25">
							<div class="heading_box font-SansLight"><div class="bdr_B616161 pl20 pr10 height_19"><?php echo $this->lang->line('recommedMembers');?></div></div>
							<div id="recommendationSlider" class="slider pt7 recomend_btn_place"> 
							 <a href="#" class="buttons left_293 prev mr2 disable"></a>
							
							<div class="pr"><div align="center" class ="width_506 pl25 ma load-image" id="load"></div></div>
							  <div class="viewport CSEprisebottom_scroll_container">
								<ul class="overview">									
								<?php  
								foreach ($recomends as $recomend) {  
									$showcaseUrl = '/showcase/index/'.$recomend->tdsUid;
									//echo '<pre />';	print_r($recomend);
									//$path = 'media/'.$recomend->username.'/profile_image/';
                                    //$img=(!empty($recomend->imagePath)) ? $recomend->imagePath :  $path.$recomend->profileImageName;  
                                    $getUserShowcase = showCaseUserDetails($recomend->tdsUid);
			
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
										$userImage=addThumbFolder($userImage,$suffix='_m',$thumbFolder ='thumb',$userDefaultImage);  	
										$userImage=getImage($userImage,$userDefaultImage);
                                ?>                                    
									  <li class="pb10 ptr" onclick="gotourl('<?php echo $showcaseUrl;?>')">
										<div class="CSEprise_mem_thumb mt20" >
										  <div class="AI_table">
											<div class="AI_cell"><img src="<?php echo $userImage; ?>"></div>
										  </div>
										</div>
										<div class="cell ml30 width_362 clr_cfcfcf">
										  <div class="CSEprise_memT bdr_Borange font_opensans">
											  <?php if(isset($recomend->firstName)) echo $recomend->firstName .' '.$recomend->lastName; ?>
										  </div>
										  
										  <div class=" font_opensans font_size13 Fright mt_minus3 ">
											  <?php echo dateFormatView($recomend->created_date,'F Y') ?>
										  </div>
										  <div class="clear"></div>
										  
										  <div class=" font_opensans font_size13 pt5"><span class="font_times f22 inline pl20">"</span>
													<?php if(isset($recomend->recommendations)) echo $recomend->recommendations; ?>
													       <span class="font_times f22 inline lineH16">"</span>										    
										  </div>
										</div>
									  </li>
									  
								  
								<?php } ?> 
								 
								 
								</ul>
							  </div>
							   <a href="#" class="buttons left_293 next mr2"></a></div>
						  </div>
                  <?php }  ?>
		</div>
<script type="text/javascript">
	$(document).ready(function(){
		if($('#recommendationSlider'))	
		$('#recommendationSlider').tinycarousel({ axis: 'y', display: 3, start:1});	
		
		if($('#AMslider'))	
		$('#AMslider').tinycarousel();	
	});
</script>  
