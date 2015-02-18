<div class="contentcontainer">
	<div class="headings altheading">
		<h2>Admin Activities<?php //echo $this->lang->line('admin_invite_report');?></h2>
	</div>
	<div class="contentbox">

		<table width="100%">
			<thead>
				<tr>
					<th>Admin Type<?php //echo $this->lang->line('admin_new_member_name');?></th>
					<th>Date<?php //echo $this->lang->line('admin_inviter_email_name');?></th>
					<th>Summary<?php //echo $this->lang->line('admin_website_link');?></th>
				</tr>
			</thead>
			
			<tbody>
				
				<?php 
				foreach($activity as $activity_record)
				{
					echo "<tr>";

						echo "<td>".$activity_record->admin_type."</td>";
						echo "<td>".$activity_record->create_date."</td>";
						echo "<td>".$activity_record->module_name." <b>".$activity_record->module_summary."</b> ".$activity_record->module_action."</td>";
						echo "</tr>";
				}
				?>
				</tbody>
		</table>
		
	</div>
	<div id="pagination">
		<?php echo $paging; ?>
	</div>
</div>
