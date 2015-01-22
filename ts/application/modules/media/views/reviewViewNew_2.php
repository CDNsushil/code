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
    
                    $reviewInformation=$this->load->view('media/reviewFormNew',array('elementId'=>$elementId,'entityId'=>$entityId,'isProject'=>$isProject),true);
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
    } else {
         $onclickFunction ='';	
    }             
              
 if(isset($reviewFrom) && ($reviewFrom=='P&E')){ 
 
  $title = ($title!='')? $title : $this->lang->line('reviewToolTip');
  $class = ($class!='')? $class : 'formTip';
  
    ?>
     
     <li><a href="javascript:void(0)" onclick="<?php echo $onclickFunction;?>"> Review me <i class="ab_share review_me"></i></a></li>
     
    <?php 
 }else{ ?>   
         <li><a href="javascript:void(0)" onclick="<?php echo $onclickFunction;?>"> Review me <i class="ab_share review_me"></i></a></li>
     <?php
 }
?>


