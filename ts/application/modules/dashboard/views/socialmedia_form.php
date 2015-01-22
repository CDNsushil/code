<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
	'class' => 'BdrCommon width246px mt5 mb5 required',

);

$socialLinkTypeArr = array(
	'name'	=> 'profileSocialLinkType',
	'id'	=> 'profileSocialLinkType',
	'class' => 'frm_Bdr required',
	'title' =>  $this->lang->line('socialLinkType'),
);

$mode  = array(
	'name'	=> 'mode',
	'value'	=> set_value('mode'),
	'id'	=> 'mode',
	'type'  => 'hidden',
	
);
?>

<?php echo form_open('additionalInfo/saveAddInfosocialMedia',$socialMediaFormAttributes); ?>
<ul class="mt25 billing_form form2 clearb fl">
	<li class=" width_258  mr200 select select_1">
		<input type="hidden" value="0" name="profileSocialLinkId" id="profileSocialLinkId" />
		<input type="hidden" value="f" name="socialLinkArchived" id="socialLinkArchived" />
		<?php 	
		$socialLinkTypeName = 'profileSocialLinkType';
		if($mode=='edit')
			$socialLinkTypeval = $profileSocialLinkType;
		else
			$socialLinkTypeval ='';	
	
		$socialLinkType = getIconList();
		echo form_dropdown('profileSocialLinkType', $socialLinkType, set_value('profileSocialLinkType'),'id="profileSocialLinkType" class="required"');
		?>
	 </li>
	<li>
		<input class="font_wN required" type="text" name="socialLink" id="socialLink" value= "" placeholder="Your Social Media Page URL eg. www.facebook.com/pages/Toadsquare/121921117888970*"  onclick="placeHoderHideShow(this,'Your Social Media Page URL eg. www.facebook.com/pages/Toadsquare/121921117888970*','hide')" onblur="placeHoderHideShow(this,'Your Social Media Page URL eg. www.facebook.com/pages/Toadsquare/121921117888970*','show')" />
                                
		<?php //echo form_input($socialLinkArr);?>
	</li>
	<li class="fr mt10 mb10">
		<span>
			<input class="red fr p10 bdr_a0a0a0 fshel_bold width_auto socialMediaSubmit" type="button" value="Cancel" id="cancleMedia"/>
		</span>
		<span>
			<input class="red fr p10 bdr_a0a0a0 fshel_bold width_auto socialMediaSubmit" type="submit" value="Add" id="addMedia"/>	
		</span>
	</li>
</ul>
<?php echo form_close(); ?> 

<script>
$(document).ready(function() {
	$("#socialMediaForm").validate({
		submitHandler: function() {
			var fromData=$("#socialMediaForm").serialize();
			$.post(baseUrl+language+'/dashboard/addSocialMedia',fromData, function(data) {
				if(data){
					window.location.href = window.location.href;
				}
			});
		}
	});
	
   /**
	* Clear fields on cancle form
	*/
	$('#cancleMedia').click(function() {
		$('#profileSocialLinkId').val(0);
		$('#socialLink').val('');
		$('#profileSocialLinkType').val('');
		setSeletedValueOnDropDown('profileSocialLinkType','');
	});
});
</script>
