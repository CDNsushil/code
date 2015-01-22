<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
	<?php 
				if(!empty($reviewData)) {
				
				foreach($reviewData as $reviews) {	
					
				// prepare user profile image
				$creative=$reviews->creative;
				$associatedProfessional=$reviews->associatedProfessional;
				$enterprise=$reviews->enterprise;
				$userDefaultImage=($creative=='t')?$this->config->item('defaultCreativeImg_xxs'):(($associatedProfessional=='t')?$this->config->item('defaultAssProfImg_xxs'):(($enterprise=='t')?$this->config->item('defaultEnterpriseImg_xxs'):''));						
				$userImage="media/".$reviews->username."/profile_image/".$reviews->image;
				$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
				$userImage=getImage($userImage,$userDefaultImage);	
					
				//prepare showing data	
				$firstName = ucwords($reviews->firstName);
				$lastName = ucwords($reviews->lastName);
				$reviewsTitle = getSubString($reviews->title,30);
				$reviewsDescription = $reviews->article;
				$reviewsCreateDate = date('d F Y',strtotime($reviews->createdDate));	
				?>
			
			<div class="brd_acacac pb10">
				<div class="imgbg_container">
					<img src="<?php echo $userImage; ?>" class="imgcont global_shadow">
					<div class="name_boxp"><?php echo $firstName; ?><br><?php echo $lastName; ?> </div>
					<div class="seprator_10"></div>
					<div class="font_opensansSBold font_size13 clr_888"><?php echo $reviewsCreateDate; ?></div>
				</div>
				
				<div class="revicont_bg">
					<div class="font_opensansSBold font_size12 clr_white lineH14 bdrb_5c5c5c pt10 pb10"><?php echo $reviewsTitle; ?></div>
					<div class="font_opensans font_size12 clr_white pt7">
					<?php echo $reviewsDescription; ?>
					</div>
				</div>
	   
				<div class="clear"></div>  
				
		  </div>
		  <div class="seprator_20"></div>
		<?php	
		}  
			if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){?>
				 <div class="row">
					<div class="cell width_569  pagingWrapper">
						<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/competition/entriesmedia/'.$userId.'/'.$competitionEntryId),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design mr-139')); ?>
					</div>
						<div class="clear"></div>
				</div>
			<?php
				}
		  
		 } ?>
