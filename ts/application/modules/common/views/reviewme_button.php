<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$loggedUserId=isloginUser();
$isPublished = (isset($isPublished) && ($isPublished!='')) ? $isPublished :'f' ;

if (isset($isPreviewMethod) && ($isPreviewMethod!='')){
$moduleMethod =	$isPreviewMethod;
}

$moduleMethod = (isset($moduleMethod) && ($moduleMethod!='')) ? strtolower($moduleMethod) :'';

$userId=isLoginUser();
$isProject = isReviewProject($userId);


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
?>
<button class="review button_c fr fs11" type="button" onclick="<?php echo $onclickFunction;?>"> Review me </button>


