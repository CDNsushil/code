<div class="Right_side_panel">
<?php
$compName = array(
	'name'	=> $label['compName'],
	'id'	=> 'compName',
	'value'	=> set_value('compName',$compName),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['compName'],
);
$empStartDate = array(
	'name'	=> $label['empStartDate'],
	'id'	=> 'empStartDate',
	'value'	=> set_value('empStartDate',$empStartDate),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['empStartDate'],
);
$empEndDate = array(
	'name'	=> $label['empEndDate'],
	'id'	=> 'empEndDate',
	'value'	=> set_value('empEndDate',$empEndDate),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['compName'],
);
$compAdd = array(
	'name'	=> $label['compAdd'],
	'id'	=> 'compAdd',
	'value'	=> set_value('compAdd',$compAdd),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['compAdd'],
);
$compDesc = array(
	'name'	=> $label['compDesc'],
	'id'	=> 'compDesc',
	'value'	=> set_value('compDesc',$compDesc),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['compDesc'],
);
$empAchivments = array(
	'name'	=> $label['empAchivments'],
	'id'	=> 'empAchivments',
	'value'	=> set_value('empAchivments',$empAchivments),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['empAchivments'],
);
$empDesignation = array(
	'name'	=> $label['empDesignation'],
	'id'	=> 'empDesignation',
	'value'	=> set_value('empDesignation',$empDesignation),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['empDesignation'],
);


echo '<div style="background-color:#FFFFFF;border:solid 1px #000;padding:10px;width:600px;
	float:left;
	height:auto;" >';

echo form_open('employmentHistory/Save');
echo form_hidden('workProfileId',$WorkProfileId); 
echo form_hidden('empHistoryId',$EmpHistoryId);  
echo form_hidden('action',$Action);
?>

<div class="orng"><?php echo form_label($compName['name'], $compName['id']); ?></div>
<?php echo form_input($compName); ?>
<?php echo form_error($compName['name']); ?>
<?php echo isset($errors[$compName['name']])?$errors[$compName['name']]:''; ?>
<span class="clear_seprator "></span>

<div class="orng"><?php echo form_label($empStartDate['name'], $empStartDate['id']); ?></div>
<?php echo form_input($empStartDate); ?>
<?php echo form_error($empStartDate['name']); ?>
<?php echo isset($errors[$empStartDate['name']])?$errors[$empStartDate['name']]:''; ?>
<span class="clear_seprator "></span>

<div class="orng"><?php echo form_label($empEndDate['name'], $empEndDate['id']); ?></div>
<?php echo form_input($empEndDate); ?>
<?php echo form_error($empEndDate['name']); ?>
<?php echo isset($errors[$empEndDate['name']])?$errors[$empEndDate['name']]:''; ?>
<span class="clear_seprator "></span>

<div class="orng"><?php echo form_label($compAdd['name'], $compAdd['id']); ?></div>
<?php echo form_input($compAdd); ?>
<?php echo form_error($compAdd['name']); ?>
<?php echo isset($errors[$compAdd['name']])?$errors[$compAdd['name']]:''; ?>
<span class="clear_seprator "></span>

<div class="orng"><?php echo form_label($compDesc['name'], $compDesc['id']); ?></div>
<?php echo form_textarea($compDesc); ?>
<?php echo form_error($compDesc['name']); ?>
<?php echo isset($errors[$compDesc['name']])?$errors[$compDesc['name']]:''; ?>
<span class="clear_seprator "></span>

<div class="orng"><?php echo form_label($empAchivments['name'], $empAchivments['id']); ?></div>
<?php echo form_textarea($empAchivments); ?>
<?php echo form_error($empAchivments['name']); ?>
<?php echo isset($errors[$empAchivments['name']])?$errors[$empAchivments['name']]:''; ?>
<span class="clear_seprator "></span>

<div class="orng"><?php echo form_label($empDesignation['name'], $empDesignation['id']); ?></div>
<?php echo form_input($empDesignation); ?>
<?php echo form_error($empDesignation['name']); ?>
<?php echo isset($errors[$empDesignation['name']])?$errors[$empDesignation['name']]:''; ?>
<span class="clear_seprator "></span>
<?php echo form_submit('save', 'Save'); ?>
</form>
</div>
