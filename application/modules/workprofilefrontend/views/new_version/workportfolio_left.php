<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$accessUserProfile = (isset($accessUserProfile) && ($accessUserProfile!='')) ? $accessUserProfile :''; 

$profileFName = (isset($workDetail->profileFName)) ? $workDetail->profileFName : ''; // set first name
$profileLName = (isset($workDetail->profileLName)) ? $workDetail->profileLName : ''; // set last name

$mediaDetail = getMediaDetail($workDetail->fileId);
if(is_array($mediaDetail) && !empty($mediaDetail)) {
	$profileImgPath = $mediaDetail[0]->filePath;
	$profileImgName = $mediaDetail[0]->fileName;
} else {
	$profileImgPath = '';
	$profileImgName = '';
}

$workProfileThumbImage = addThumbFolder($profileImgPath.$profileImgName,'_l','crop_thumb');														
$workProfileSrc = '<img src="'.getImage($workProfileThumbImage,$this->config->item('defaultWorkWanted_s')).'" />';												   
?>
<div class="left_portfolio fl">
	<div class="sap_25"></div>
	<div class="profile_pic table_cell "> <?php echo $workProfileSrc;?> </div>
	<div class="sap_25 bb_c2c2"></div>
	<div class="sap_30"></div>
	<div class="text_alignR open_sans fs13">
		<?php if(isset($workDetail->profileAdd) && (trim($workDetail->profileAdd)!='')) {
			echo '<p>'.$workDetail->profileAdd.'</p>';
		}
		if(isset($workDetail->profileStreet) && (trim($workDetail->profileStreet)!='')) {
			 echo '<p>'.$workDetail->profileStreet.'<p/>'; 
		} 
		if(isset($workDetail->profileCity) && (trim($workDetail->profileCity)!='')) {
			echo '<p>'.$workDetail->profileCity.'<p/>';
		}
		if(isset($workDetail->profileState) && (trim($workDetail->profileState)!='')) {
			 echo '<p>'.$workDetail->profileState.'<p/>'; 
		}
		if(isset($workDetail->profileZip) && (trim($workDetail->profileZip)!='')) {
			 echo '<p>'.$workDetail->profileZip.'<p/>';
		}
		if(isset($workDetail->profileCountry) && ($workDetail->profileCountry!='')) {
			 echo '<p>'.getCountry($workDetail->profileCountry).'</p>';
		 }?>
		<div class="sap_45"></div>
		<?php if(isset($workDetail->websiteUrl) && ($workDetail->websiteUrl!='')) {
			echo '<p>'.$workDetail->websiteUrl.'</p>'; 
		}
		if(isset($workDetail->profileEmail) && ($workDetail->profileEmail!='')) {
			echo '<p>'.$workDetail->profileEmail.'</p>'; 
		}
		if(isset($workDetail->profilePhone) && ($workDetail->profilePhone!='')) {
			 echo '<p><span  class="green pr10">T:</span>+'.$workDetail->profilePhone.'</p>';
		} 
		if(isset($workDetail->profileMobile) && ($workDetail->profileMobile!='')) {
			 echo '<p><span  class="green pr10">M:</span>+'.$workDetail->profileMobile.'</p>';
		} 
		?>
	</div>
	<div class="sap_55"></div>
	<a class="Profile_btn open_sans" href="<?php echo base_url()?>workprofilefrontend/index/<?php echo $accessUserProfile ?>">
		Profile
	</a>
</div>	
