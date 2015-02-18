<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<style>
#BrowserHiddenPromo  {
    height: 30px;
    opacity: 0;
    position: relative;
    text-align: right;
    width: 260px;
    z-index: 2;
}
</style>
<script>
$(document).ready(function(){	
	$("#promotionlaImageForm").validate({});	
});
</script>
<?php
$EventIdToShow =  $data['EventId'];
$promotionlaImageFormAttributes = array(
	'name'=>'promotionalImageForm',
	'id'=>'promotionalImageForm'
);


$title = array(
	'name'	=> 'title',
	'id'	=> 'title',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  'Add title here',
	'value'	=> set_value('newsTitle'),
	'placeholder'	=> 'Add title here',
	'minlength'	=> 2,
	'maxlength'	=> 50,
	'size'	=> 50,
	'style' => 'width:438px;'
);

$description = array(
	'name'	=> 'description',
	'id'	=> 'description',
	'class'	=> 'BdrCommonTextarea heightAuto rz formTip required error',
	'title'=>  $label['add'].' '.$label['description'].' here'.$label['50_100_words'],
	'value'	=> set_value('description'),
	'placeholder'	=>  $label['add'].' '.$label['description'].' here'.$label['50_100_words'],
	'minlength'	=> 50,
	'rows'	=> 5,
	'wordlength'=>"50,100",
	'style' => 'width:438px;',
	'onkeyup'=>"checkWordLen(this,100,'descriptionLimit')"
);


$promotionalImage = array(
	'name'	=> 'promotionalImage',
	'id'	=> 'promotionalImage',
	'value'	=> set_value('promotionalImage'),
	'rows'      => 2,
    'cols'      => 45,
	'style'      => 'width:392px;',
	'class'       => 'BdrCommonTextarea heightAuto rz formTip required error',
	'title'       =>  $label['promotionalImage'],
);
$userfile =	array(
	'name'        => 'userfile',
	'id'          => 'workVideo',
);
$showProfileImage ='';
?>

<div class="frm_wp" style="width:721px;">	
<?php echo form_open_multipart('event/eventFurtherDesc',$promotionlaImageFormAttributes); ?>
<?php
if(isset($EventIdToShow) && $EventIdToShow>0)
 echo form_hidden('EventId',$EventIdToShow); 
 //echo form_hidden('LaunchEventId',0); 
echo form_hidden('fileType',1); 
$allowed_image_size='2048 ';
$image_size_unit='MB';
$eventMediaPathTrue = 'xyz';
?>
	
<input type="hidden" value="0" name="promotionalImageId" id="promotionalImageId" />
<input type="hidden" value="" name="formtype" />

<div class="row rowHeight40">
		<div class="cell orng_lbl" style="vertical-align:top;"><?php echo $label['promoImage'];  ?></div>
		<div class="cell">
			
				<div class="row" >
					<div class="cell dblBorder" style="vertical-align:middle; height:100px; width:100px; padding:5px;">
						<img style="max-width:100px; min-height:100px; max-height:100px; margin:auto;" id="currentPromotionalImage"  src="<?php echo getImage($eventMediaPathTrue);?>" />
					</div>
					<div class="cell" style="padding-left:10px;">&nbsp;</div>
					<div class="cell dblBorder" style="background-color:#E9E9E9; min-height:100px; width:311px; padding:5px;">
					
					<div class="row" >
					<div class="cell" ><?php echo $label['uploadImage']; ?><span class="clear_seprator"></span></div>
					</div>
					<div class="row">
					<div class="cell" align="center">
						<div id="FileUpload">
                                <input type="file" size="24" name="userfile" id="BrowserHiddenPromo" onchange="getElementById('PromoFileField').value = getElementById('BrowserHiddenPromo').value;" onmousedown="mousedown_tds_button(getElementById('browse_btn'));" onmouseup="mouseup_tds_button(getElementById('browse_btn'));"/>
                                
                                <div id="BrowserVisible">
                                	 <input type="text" id="PromoFileField" style="width:170px;" class="formTip Bdr4" title="<?php echo $label['uploadImage']; ?>"/>
                                	 <div class="tds-button" style="position:absolute; right:0; top:0;">
                                        <a id="browse_btn"><span>Browse</span></a>
                                    </div>
                                </div>
                            </div>
						</div>
					</div><!-- End row -->
					<div class="row">
						<div class="cell" align="left" style="padding-top:25px;"><?php echo $label['allowed_image_size'].' '.$allowed_image_size.$image_size_unit; ?></div>
					</div><!-- End row -->
					</div>
				
				</div>
			
		</div><!-- End of cell for browse button and related text-box-->
    </div><!-- End row rowHeight40 -->

<div class="row heightSpacer"> &nbsp;</div>	
<div class="row">
	<div class="cell orng_lbl"><?php echo $label['title'];?></div>
	<div class="cell" >
		<?php echo form_input($title); ?>
		<div class="red"><?php echo form_error($title['name']); ?></div>
	</div>
	<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
</div>
		  

<div class="row heightSpacer"> &nbsp;</div>		  
<div class="row">
<div class="cell orng_lbl"><?php echo $label['add'].' '.$label['description'];?></div>
<div class="cell" >
<?php echo form_textarea($description); ?>
<div class="red"><?php echo form_error($description['name']); ?></div>
<div class="remainingLimit fl" id="descriptionLimit">0</div> <div class="fl">Total Words </div>
</div>
<div class="cell "><span class="cell"><img src="images/icon_I_small2.jpg" /></span></div>
</div>

<!-- Below Show Save And Cancel Button -->
<div class="row">
<div class="cell">
	  <div class="Btn_wp">
	  <div class="btn_wp" style="padding-left:145px;">
		<div class="button_left">
		  <div class="button_right">
			<div class="button_text save"  onclick="submitForm('promoImage');">
				<?php echo form_submit('submit', 'Save', ' class="border0 backgroundNone white bold"'); ?>
			</div>
		  </div>
		</div>
	  </div>
	</div>
</div><!-- End class="cell" -->
<div class="cell">
	 <div class="Btn_wp">
	  <div class="btn_wp" style="padding-left:10px; width: 90px;">
		<div class="button_left">
		  <div class="button_right">
			<div class="button_text" style=" padding-left:10px; font-weight:bold;" onclick="commonCancel('PROMOTIONALIMAGEForm-Content-Box','PROMOTIONALIMAGE-No-Records');">
				<?php echo $label['cancel']; ?>
			</div>
		  </div>
		</div>
	  </div>
	</div>
	
</div><!-- End class="cell" -->
</div><!-- End class="row" -->
<div class="row heightSpacer"> &nbsp;</div>	
</div><!-- End Div frm_wp -->	  
<div class="row heightSpacer"> &nbsp;</div>	
</form>
