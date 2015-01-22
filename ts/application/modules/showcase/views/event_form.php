<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="frm_wp">
<div class="row" style="width:60%;">
<div class="cell"><?php  echo anchor('javascript://void(0);', $label['search'],array('class'=>'formTip','title'=> $label['search'],'onclick'=>'javascript:openLightBox(\'listBoxWp\',\'listFormContainer\',\'/showcase/showEventsList\')')); ?></div>
</div>
<!-- Below Show Save And Cancel Button -->
<div class="row">
<div class="cell">
	  <div class="Btn_wp">
	  <div class="btn_wp" style="padding-left:145px;">
		<div class="button_left">
		  <div class="button_right">
			<div class="button_text save"  onclick="submitNewsForm();">
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
			<div class="button_text" style=" padding-left:10px; font-weight:bold;" onclick="commonCancel('EVENTSForm-Content-Box','EVENTS-No-Records');">
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
<?php
//
?>
<script language="javascript" type="text/javascript">
function submitForm()
{ 
	document.eventsForm.formtype.value= 'Events';
	document.eventsForm.submit();  
}
</script>