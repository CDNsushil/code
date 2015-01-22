<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


$userContainerId = (isset($containerDetails[0]['userContainerId']) && ($containerDetails[0]['userContainerId']>0) ) ? $containerDetails[0]['userContainerId'] : 0 ; ?>

<input name="userContainerId" id="userContainerId" value="<?php echo $userContainerId ?>" type="hidden">

<?php
echo Modules::run("upcomingprojects/addPromotionalVideo",$projId); 
if((isset($projId) && $projId>0) ){
$upcomingPromotionalImages['strip']=1;
echo $this->load->view('mediatheme/promoImgAccordView',$upcomingPromotionalImages);

} ?>
