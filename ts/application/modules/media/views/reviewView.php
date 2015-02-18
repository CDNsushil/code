<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

$reviewClass=@$reviewClass?$reviewClass:'width_auto ml5 Fleft';
$loggedUserId=isloginUser();
$isPublished = (isset($isPublished) && ($isPublished!='')) ? $isPublished :'f' ;

/* ADD FOR  PREVIEW MODE */
// For Event Section to get preview method if user is in preview mode
if (isset($isPreviewMethod) && ($isPreviewMethod!='')){
$moduleMethod =	$isPreviewMethod;
}

$moduleMethod = (isset($moduleMethod) && ($moduleMethod!='')) ? strtolower($moduleMethod) :'';
/* END PREVIEW COND */

$userId=isLoginUser();
$isProject = isReviewProject($userId);


$rateAll ='';
$beforeReviewLoggedIn=$this->lang->line('beforeReviewLoggedIn');
if($loggedUserId > 0){
	
					$reviewInformation=$this->load->view('media/reviewForm',array('elementId'=>$elementId,'entityId'=>$entityId,'isProject'=>$isProject),true);
					$function="if(checkIsUserLogin('".$beforeReviewLoggedIn."')){loadPopupData('popupBoxWp','popup_box',reviewData)}";?>
					<script>
					var reviewData=<?php echo json_encode($reviewInformation);?>;
					</script>
					
		<?php } else{			
				
				$function="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeReviewLoggedIn."')";
              }
              
              
  if(isset($isPublished) && $isPublished=='t' && $moduleMethod!='preview' )
		{				
		  $onclickFunction = $function ;	
		  $class="";
		  $mouseEvent = 'onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" ';
		  $title= "";
	
	    } else {
		         $onclickFunction ='';	
		         $class="opacity_4 formTip";
		         $mouseEvent = ' ';
				 //$title= $this->lang->line('reviewToolTipPbls');
				 $title= "";	        
		   }             
         
              
              
 if(isset($reviewFrom) && ($reviewFrom=='P&E')){ 
 
  $title = ($title!='')? $title : $this->lang->line('reviewToolTip');
  $class = ($class!='')? $class : 'formTip';
  
    ?>
	<div class="<?php echo $reviewClass;?> ptr" onclick="<?php echo $onclickFunction;?>">
	  <a  class="<?php echo $class?>" title="<?php echo $title?>">
		  <span class="p0 min_w29">
			  <div class="btn_review_icon pr0"></div>
		  </span>
	  </a>
	</div>
	
	<?php 
 }else{ ?>   
		<div class="<?php echo $reviewClass;?> ptr" onclick="<?php echo $onclickFunction;?>">
			<a <?php echo $mouseEvent ?>  class="<?php echo $class?>" title="<?php echo $title?>"><span class="mr0">
					<div class="btn_review_icon"></div> 
					<div class="Fright black_link_hover" ><?php echo $this->lang->line('review');?></div>
				</span>
			</a>
		</div>
	 <?php
 }
?>


