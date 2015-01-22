<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$addInfoSection=$this->uri->segment(7);
	//$addInfoSection='socialMedia';
	//echo $entityId;
	
	$socialMediaSection='dn';
	$toggle_icon='';
	if(!$addInfoSection || $addInfoSection=='socialMedia' || empty($addInfoSection)){
		$socialMediaSection='';
		$toggle_icon='toggle_icon';
	}
?>
<div class="row ">
	<div class="cell tab_left">
		<div class="tab_heading">
			<?php echo $this->lang->line('socialLinks'); ?>
		</div><!--tab_heading-->
	</div>
	<div class="cell tab_right">
		<div class="tab_btn_wrapper">
			<div class="tds-button-top"> 
				<!-- Post add Icon -->
				<a class="formTip  formToggleIcon"  title="<?php echo $label['add'];?>" toggleDivId="SocialMedia-Content-Box" toggleDivForm="SocialMediaForm-Content-Box" toggleDivIcon="socialMediaToggleIcon"  >
					<span><div class="projectAddIcon"></div></span>
				</a>				
			</div>
		</div>
	</div>
</div><!--row-->
<div class="clear"></div>
<div class="form_wrapper toggle frm_strip_bg <?php echo $socialMediaSection;?>" id="SocialMedia-Content-Box">
	<div class="row"><div class="tab_shadow"></div></div>
	<div class="row dn" id="SocialMediaForm-Content-Box">
		<?php echo Modules::run("additionalInfo/socialMediaForm",$entityId,$elementId,$returnUrl); ?>
	</div>
	<!--Manage copy social sites code here--> 
	<?php 
	$userId = isLoginUser()?isLoginUser():0;
	if(($entityId==86 || $entityId==93) && isset($userId)) {
		if($entityId==86) {
			$showcaseRes=getUserShowcaseId($userId);
			$workProId = $showcaseRes->showcaseId;		
			$copyTitle = $this->lang->line('copyShowcaseSites');
			$socialLinkRst = getProfileSocialMediaLinks(93,$workProId);
		} else {
			$workProfileRes = getUserWorkProfileId($userId);
			$workProId = $workProfileRes[0]->workProfileId;
			$copyTitle = $this->lang->line('copyWorkProfileSites');
			$socialLinkRst = getProfileSocialMediaLinks(86,$workProId);
		}
		if(is_array($socialLinkRst) && count($socialLinkRst)>0) {
		?>
			<div class="row fr mr5">
				<div class="tds-button-big Fleft"><a href="<?php echo site_url().'common/copyProfileSocialLinks/'.$entityId;?>" onClick="return confirm('Are you sure you want to copy social sites?')" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px; "><span class="two_line" style="background-position: 100% 0px;"><?php echo $copyTitle;?></span></a></div>
				
				<!--<a href="<?php //echo site_url().'common/copyProfileSocialLinks/'.$entityId;?>" class="dash_link_hover underline" onClick="return confirm('Are you sure you want to copy social sites?')"><?php //echo $copyTitle;?></a>-->
			</div>
			<div class="clear"></div>
		<?php } }?>
	<!--Manage copy social sites code here--> 
	
	<div class="row" id="socialMediaContent">
		<!-- Show List Of Social Media -->
		<?php  echo Modules::run("additionalInfo/listSectionSocialMedia",$entityId,$elementId,$returnUrl); ?> 
	</div>
	

</div><!-- End Div SocialMedia-Content-Box -->	
	
	<script>
function canceltoggle(toggleFlag)
{
 
  if(toggleFlag==0)
  {
	$('#SocialMediaForm-Content-Box').slideUp();
	$('#socialLink').val('');
	$('#profileSocialLinkId').val(0);
	setSeletedValueOnDropDown('#socialLinkType','');
	}
  
  if(toggleFlag ==1)
  {
	$('#socialLink').val('');
	$('#profileSocialLinkId').val(0);
	$('#SocialMediaForm-Content-Box').slideDown();
	
  }
 
 

  
}
</script>
	
	

