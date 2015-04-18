<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$toolTip = (isset($tootlTip) && ($tootlTip!='')) ? $tootlTip :'';
$craved='';
$loggedUserId=isloginUser();

$isPublished = (isset($isPublished) && ($isPublished!='')) ? $isPublished :'f' ;

/* ADD FOR  PREVIEW MODE */
// For Event Section to get preview method if user is in preview mode
if (isset($isPreviewMethod) && ($isPreviewMethod!='')){
$moduleMethod =	$isPreviewMethod;
}

$moduleMethod = (isset($moduleMethod) && ($moduleMethod!='')) ? strtolower($moduleMethod) :'';
/* END PREVIEW COND */

$beforeCraveLoggedIn=$this->lang->line('beforeCraveLoggedIn');
if($loggedUserId > 0){
    $ownerId=@$ownerId > 0?@$ownerId:(@$this->uri->segment(4)>0?$this->uri->segment(4):isLoginUser());
    
    $where=array(
                    'tdsUid'=>$loggedUserId,
                    'entityId'=>$entityId,
                    'elementId'=>$elementId
                );
    $countResult=countResult('LogCrave',$where);
    $craved=($countResult>0)?'cravedALL':'';
    ?>
    <script>
        var ceavedata<?php echo $entityId.''.$elementId?> = {"elementId":"<?php echo $elementId;?>","entityId":"<?php echo $entityId;?>","ownerId":"<?php echo $ownerId;?>","projectType":"<?php echo $projectType;?>","furteherDetails":'<?php echo $furteherDetails;?>'};
    </script>
    <?php
    $function="postCrave('', ceavedata".$entityId.''.$elementId.",'".$entityId."','".$elementId."','".$beforeCraveLoggedIn."')";
}else{
    $function="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeCraveLoggedIn."')";
}
    
    //if type is preview
    $previewMsg = '';
    if(previewModeActive()){
        $previewMsg="customAlert('You cannot crave in preview mode.')";
    }
    
    if($isPublished=='t' && previewModeActive()===false) {  ?>
          
        <li>
            <a href="javascript:void(0)"  onclick="<?php echo $function;?>" title="<?php echo $toolTip ?>" > 
             <span class="fl"><?php echo $buttonTitle; ?></span>
             <i id="craveDiv<?php echo $entityId.''.$elementId?>" class="ab_share creav_me <?php echo $craved;?>"></i></a>
        </li>

    <?php  } else {  ?>

        <li ><a href="javascript:void(0)" onclick="<?php echo $previewMsg;?>"> 
            <?php echo $buttonTitle; ?> 
        <i  id="craveDiv<?php echo $entityId.''.$elementId?>" class="ab_share creav_me <?php echo $craved;?>"></i></a></li>

    <?php } ?>

