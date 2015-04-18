<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

//get loggedIn userId

$reviewProjectId    =  (!empty($reviewProjectId))?(string)$reviewProjectId:'0';
$reviewElementId    =  (!empty($reviewElementId))?(string)$reviewElementId:'0';
$reviewEntityId     =  (!empty($reviewEntityId))?(string)$reviewEntityId:'0';
$reviewIndustryId   =  (!empty($reviewIndustryId))?(string)$reviewIndustryId:'0';
$isPublished        =  (!empty($isPublished))?(string)$isPublished:'f';
 
$loggedUserId=isLoginUser();
$beforeReviewLoggedIn=$this->lang->line('beforeReviewLoggedIn');
    if($loggedUserId){
        
        $userReviewInfo=array
                (
                    'projectId'=>$reviewProjectId,
                    'elementId'=>$reviewElementId,
                    'entityId'=>$reviewEntityId,
                    'industryId'=>$reviewIndustryId,
                    'isPublished'=>$isPublished
                );
                
            
                
?>
    <script>
    var reviewData<?php echo $reviewProjectId.'_'.$reviewElementId;?>=<?php echo json_encode($userReviewInfo);?>;
    </script>
    <?php   
        $onclickFunction    =   "userreview(reviewData".$reviewProjectId.'_'.$reviewElementId.",1)";
        if((isset($isPublished) && $isPublished=='f') || previewModeActive()){
            $onclickFunction = '';
            //check if preview mode
            if(previewModeActive()){
                $onclickFunction="customAlert('You cannot review in preview mode.')";
            }
            
        }
    }else{
        $onclickFunction    =   "openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeReviewLoggedIn."')";
    }
?>

<?php if($reviewdesign==1){ ?>
        <button class="review button_c fs11" onclick="<?php echo $onclickFunction;?>" type="button">Review </button>
<?php }elseif($reviewdesign==2){ ?>
        <li><a href="javascript:void(0)" onclick="<?php echo $onclickFunction;?>"> <span class="fl">Review me</span> <i class="ab_share review_me"></i></a></li>
<?php }elseif($reviewdesign==3){ ?>
         <button class="review button_c fr fs11" onclick="<?php echo $onclickFunction;?>" type="button">Review me</button>
<?php } ?>

<script type="text/javascript">
    function userreview(reviewData<?php echo $reviewProjectId.'_'.$reviewElementId;?>,isReviewForm){
        
        var redirecturl      =  "/media/reviewswizard";
        var formData	 	 =  $(this).serialize();
        //post url 
        url = '/media/userreviewnews';//stage first post url 
        $.ajax({
          type: 'POST',
          url: baseUrl + language + url,
          dataType: 'json',
          data: reviewData<?php echo $reviewProjectId.'_'.$reviewElementId;?>,
          beforeSend: function() {
            loader();
          },
          success: function(data) {
                
                if(data.issuccess==true){
                    if(data.isshowcase==true){
                        redirectToPage(redirecturl);
                    }else{
                        openLightBox('popupBoxWp','popup_box','/media/showcasecreatepopup',isReviewForm);
                    }
                }else{
                    customAlert('You can not review on this.','Error');
                }
            },  
          error: function(xhr, ajaxOptions, thrownError) {
               customAlert(thrownError,'Error');
          }
        });
    }
</script>
