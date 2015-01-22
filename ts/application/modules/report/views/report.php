<div id="report_coantainer">
		<input type="hidden" id="wall_post_id"  value="" />
		<input type="hidden" id="wall_post_type" value="" />
	<div id="report_type_coantainer" >
		<div id="report_type_id">
			<div class="report_type_class rport_header"  onclick="hide_report_type_cointainer();" ><?php echo $this->lang->line('post_report');?></div>
			<?php
			foreach($report_type as $report){ ?>
				<div class="report_type_class"  onclick="open_confirm_box('<?php echo $report->report_type_id;?>');" ><?php echo ucwords($report->report_type);?></div>
			<?php }			 
			?>			
		</div>
	</div>			
</div>
