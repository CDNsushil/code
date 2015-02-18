<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row  ml30" id="furtherDescription1">
<?php
	$formAttributes = array(
		'name'=>'customForm',
		'id'=>'customForm'
	);
$retunUrl = 'package/userpckgstouser';
echo form_open($retunUrl,$formAttributes);
?>
	<div class="row">
	<input type="text" name="sections" id="sections" />
		</div>
	<div class="row heightSpacer"></div>
	<div class="row">
		<div class="tds-button Fleft">
		 <button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Save" name="submit" type="submit" ><span><div class="Fleft">Submit</div> <div class="icon-save-btn"></div></span></button>
		</div>
	</div>
<?php
echo form_close();
?>
</div>
