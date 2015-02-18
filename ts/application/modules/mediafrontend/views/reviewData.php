<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

 if(isset($result) && !empty($result)) { ?>
	
	<!--<div id="showReviews">-->
	<?php
	
	$formAttributes = array(
		'name'=>'reviewList',
		'id'=>'reviewList',
		'toggleDivForm'=>'uploadElementForm'
	);	
	
	echo form_open('',$formAttributes);	

	$resultCount = count($result);	
	
	?>			
	<input type="text" name="count" id="count" class="dn" value="0">
	<input type="text" name="currentPage" id="currentPage" class="dn" value="1">			  
	<input type="text" name="records" id="records"class="dn" value="<?php echo $resultCount ?>">
	<input type="text" name="entityId" id="entityId" class="dn" value="<?php echo $entityId ?>">
	<input type="text" name="projectElementId" id="projectElementId" class="dn" value="<?php echo $projectElementId ?>" >			  
	<input type="text" name="craveCount" id="craveCount" class="dn" value="<?php echo $craveCount ?>" >
	<input type="text" name="viewCount" id="viewCount" class="dn" value="<?php echo $viewCount ?>" >
	<input type="text" name="industryId" class="dn"  value="<?php echo $industryId ?>" >

			<div class="sub_col_middle global_shadow_light mt18">			
				<?php $space='row  mt5';?>     
						<!--loop01-->
					<?php foreach ($result as $proj) {  
                     //  echo "<pre>";
                     // print_r($result);;die;
                      
                      if($industryId==10){
						  
						  $link = "/educationMaterial/piece";
					   }elseif($industryId==2){
							$link = "/musicNaudio/piece";  
							  
					   }elseif($industryId==3){
						   $link =  "/writingNpublishing/piece";
						   
					   }elseif($industryId==4){
                           $link = "/photographyNart/piece";
                      
				       }elseif($industryId==9){
                           $link =  "/performancesnevents/piece";
                      
				       }elseif($industryId==12){
                          $link = "/productNshowcase/piece";				       
				       
				       }else {
					      $link = "/filmNvideo/piece";	   
										   
					   }
                        
                      $reviewsUrl = base_url(lang().'/mediafrontend/searchresult/'.$proj->userId.'/'.$proj->projId.'/'.$proj->elementId.'/reviews'.$link);
								 // $userData= showCaseUserDetails($proj->userId);
								 
								 //echo $proj->imagePath;
								 $getUserShowcase	= showCaseUserDetails($proj->userId);
								
								 $craveCount = (!empty($proj->craveCount))? $proj->craveCount : 0;
								 $viewCount = (!empty($proj->viewCount))? $proj->viewCount : 0;
								 
								  $path = 'media/'.$proj->username.'/profile_image/'; 
								  $img=(!empty($proj->imagePath)) ? $proj->imagePath :  $path.$proj->profileImageName;  
								  $thumbImage = addThumbFolder($img,'_s');
								  $imagetype = $this->config->item('defaultReviewsImg_s');
								  $elementImage=getImage($thumbImage,$imagetype);
								  ?>               
							<a target="_blank" href="<?php echo $reviewsUrl ?>">	 
								  <div class="row all_list_item">
									<div class="seprator_5"></div>
									<div class="<?php echo  $space ?>">
									  <div class="cell width_114">
										<div class="blog_profile_img">
											  <div class="AI_table">
													<div class="AI_cell C555"><img class="review_thumb" src="<?php echo $elementImage; ?>"></div>
											  </div>
										</div><!--blog_profile_img -->
												<div class="blog_profile_name"><?php echo $getUserShowcase['userFullName'] ?></div>
												<div class="blog_profile_date"><?php echo  dateFormatView($proj->createdDate,'d F Y') ?></div>
									   </div>
									  
									  <div class="cell width_310 padding_left16">
											<div class="blog_profile_title dash_link_hover"><?php echo $proj->title ?></div>
											<div class="blog_profile_txt"><?php echo   nl2br(getSubString($proj->article,300)); ?> </div>
									  </div>
									  
									  <div class="clear seprator_13"></div>
									  <div class="blog_status_bar padding_left10 padding_right10"> <span class="blogS_crave_btn Fleft width_40"><?php echo $craveCount ?></span> <span class="blogS_view_btn Fleft"><?php echo $viewCount ?></span>  </div>
									</div>
								</div>
							</a>	
							   <?php  $space='row  mt25';?>
					   <?php } ?>
				
				<!--pagination area-->
			   
			</div> <!-- global_shadow_light-->
	
<?php echo form_close();?> 

<div class="clear"></div>
<div class="clear seprator_5"></div>
	<!-- PAGINATION -->  
	 <div class="row">
			<?php

			$url =base_url()."en/mediafrontend/getReviewList/".$entityId."/".$projectElementId."/".$craveCount."/".$viewCount."/";

		//$count =$countReview;
		if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
			 <div class="row">
				<div class="cell width_480  pagingWrapper">
					<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>$url,"divId"=>"showReviews","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
				</div>
				<div class="clear"></div>
			</div>
		<?php
		}?>  
			<div id="totalRecords" class="dn"><?php // echo $count ; ?></div>

	</div>
 <!-- PAGINATION END --> 
    

<!--</div>-->
<?php } ?>
