<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$ratingClass=@$ratingClass?$ratingClass:'width_auto pt15 ml5 mt10 Fleft';
$loggedUserId=isloginUser();
$rateAll ='';
$beforeRatingLoggedIn=$this->lang->line('beforeRatingLoggedIn');

/* ADD FOR  PREVIEW MODE */
// For Event Section to get preview method if user is in preview mode
if (isset($isPreviewMethod) && ($isPreviewMethod!='')){
$moduleMethod =	$isPreviewMethod;
}

$moduleMethod = (isset($moduleMethod) && ($moduleMethod!='')) ? strtolower($moduleMethod) :'';

/* END PREVIEW COND */

$isPublished = (isset($isPublished) && ($isPublished!='')) ? $isPublished :'f' ;

if($loggedUserId > 0){
	//createDate
	$where=array(
					'tdsUid'=>$loggedUserId,
					'entityId'=>$entityId,
					'elementId'=>$elementId
				);
				
				
	$countResult=countResult('LogRating',$where);
	if($countResult > 0){
		$rateAll='rateALL';
		$alreadyRate=$this->lang->line('alreadyRate');
		$function="if(checkIsUserLogin('".$beforeRatingLoggedIn."')){customAlert('".$alreadyRate."')}";
	}else{
		$rateAll='';
		$ratingInformation=$this->load->view('rating/ratingForm',array('elementId'=>$elementId,'entityId'=>$entityId),true);
		?>
		<script>var ratingData<?php echo $entityId.$elementId;?>=<?php echo json_encode($ratingInformation);?>;</script>
		<?php
		$function="if(checkIsUserLogin('".$beforeRatingLoggedIn."')){loadPopupData('popupBoxWp','popup_box',ratingData".$entityId.$elementId.")}";
	}
}else{
	
	$function="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeRatingLoggedIn."')";
}

if($isPublished=='t' && $moduleMethod!='preview') {  ?>
    
    <button onclick="<?php echo $function;?>" class="rating_1  ptr button_c fs11 <?php echo $rateAll ?>"
     id="rateDiv<?php echo $entityId.''.$elementId?>"  type="button"><?php echo $this->lang->line('rate'); ?></button>

<?php  } else { ?>
    
    <button class="rating_1 button_c fs11 <?php echo $rateAll ?>" id="rateDiv<?php echo $entityId.''.$elementId?>"  type="button"><?php echo $this->lang->line('rate'); ?></button>
    
<?php        } ?> 
