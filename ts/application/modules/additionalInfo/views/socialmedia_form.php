<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script>
	$(document).ready(function(){	
		$("#socialMediaForm").validate({});	
	});
</script>

<?php

$socialMediaFormAttributes = array(
	'name'=>'socialMediaForm',
	'id'=>'socialMediaForm',
	'toggleDivForm'=>'SocialMediaForm-Content-Box',
	'section'=>'#socialMedia'
	
);

$socialLinkArr = array(
	'name'	=> 'socialLink',
	'id'	=> 'socialLink',
	'value'	=> set_value('socialLink'),
	'size'	=> 30,
	'maxlength'	=> 100,
	'class' => 'BdrCommon width246px required',

);

$socialLinkTypeArr = array(
	'name'	=> 'profileSocialLinkType',
	'id'	=> 'profileSocialLinkType',
	'class'       => 'frm_Bdr required',
	'title' =>  $this->lang->line('socialLinkType'),
);

$mode  = array(
	'name'	=> 'mode',
	'value'	=> set_value('mode'),
	'id'	=> 'mode',
	'type'  => 'hidden',
	
);

?>


<div  id="uploadElementForm" style="display: block;">
<div class="upload_media_left_top row"></div><!--upload_media_left_top-->
<?php echo form_open('additionalInfo/saveAddInfosocialMedia',$socialMediaFormAttributes); ?>
<div class="upload_media_left_box">
	<input type="hidden" value="0" name="profileSocialLinkId" id="profileSocialLinkId" />
	<input type="hidden" value="f" name="socialLinkArchived" id="socialLinkArchived" />
	<input type="hidden" value="<?php echo $entityId;?>" name="entityId" id="entityId" />
	<input type="hidden" value="<?php echo $elementId;?>" name="elementId" id="elementId" />
	<input type="hidden" value="<?php echo @$returnUrl;?>" name="returnUrl" id="returnUrl" />
	
	
	<div class="row">
		<div class="label_wrapper cell">
			<label  class="select_field"><?php echo $this->lang->line('socialLinkSite'); ?></label>
		</div><!--label_wrapper-->
		<?php 
				
				$socialLinkTypeName = 'profileSocialLinkType';
				if($mode=='edit')
					$socialLinkTypeval = $profileSocialLinkType;
				else
					$socialLinkTypeval ='';
					
		?>
		<div class="cell frm_element_wrapper">			
		<?php
			
				$socialLinkType = getIconList();
				echo form_dropdown('profileSocialLinkType', $socialLinkType, set_value('profileSocialLinkType'),'id="socialLinkType" class="required"');
		?>
			</div>
		
	</div><!--from_element_wrapper-->
	<div class="seprator_5 cell"></div>
	
	<div class="row">
		<div class="label_wrapper cell">
			<label  class="select_field_multiline"><?php echo $this->lang->line('socialLinkSocial'); ?></label>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<?php echo form_input($socialLinkArr);
			 ?>
			 <div class="row wordcounter"><?php echo form_error($socialLinkArr['name']); ?></div>
		</div>
	</div><!--from_element_wrapper-->
	
	<?php echo form_hidden('save','Save');?>
		
	<div class="row ">
		<div class="label_wrapper cell bg_none"></div><!--label_wrapper-->
			<div class="cell frm_element_wrapper">
			<div class="cell Fleft">
				<div class="Req_fld cell"><?php echo $label['requiredFields'];?></div><!--Req_fld-->				
			</div>			
			<div class="fr">					
				<?php
					$button=array('save','cancelHide');
					echo Modules::run("common/loadButtons",$button); 
				?>				
			</div>
			<div class="fl pb5"><?php echo $label['afterReqMsg']?> </div>
		</div>	
	</div>
	
	
	<!--<div class="seprator_25 clear"></div>-->
</div>
<?php echo form_close(); ?> 

<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->

</div>
<div class="clear seprator_25"></div>
