<div class="report">	
	<?php 
		echo form_open('report/submit');?>
		<div class="report_combo">
		
		<?php
		$options[''] = ucwords('Select Type'); 
		foreach($report_type as $report){
			$options[$report->report_type_id] = ucwords($report->report_type);
		}
		$js = 'id="report_type_id'.$post_id.'" onchange="open_confirm_box('.$post_id.','.$post_type.');"';
		echo form_dropdown('report_type_id', $options,'',$js);?>
		</div>
		<?php $post_type_id_data = array(
			'name'	=>'post_type_id',
			'id'	=>'post_type_id',
			'value'	=>$post_type,
			'type'	=>'hidden',
		);
		echo form_input($post_type_id_data);
	
		$report_for_id_data = array(
			'name'	=>'report_for_id',
			'id'	=>'report_for_id',
			'value'	=>$post_id,
			'type'	=>'hidden'
		);
		echo form_input($report_for_id_data);?>

		<?php echo form_close();?>

</div>