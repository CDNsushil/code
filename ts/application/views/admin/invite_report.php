<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_invite_report');?></h2>
	</div>
	<div class="contentbox">

		<!--- FILTER START ---->
		<?php /*	
		<div class='fRight'>
				
				<div class="fLeft">
					<?php 
					// First search form start
					$attributes = array('name'=>'adver_filter_form','id'=>'adver_filter_form');
						echo form_open('admin/admin/advertisment',$attributes);	
						?>
							<select name="user_id" onChange="this.form.submit()" >
										<option value=""><?php echo $this->lang->line('admin_select_roll_type')?></option>
										<?php if(count($user_adver)>0){
												foreach($user_adver AS $user){
														if($user_selected == $user->user_id) { ?>
												<option value="<?php echo $user->user_id;?>" selected><?php echo $user->firstname." ".$user->lastname;?></option>
												<?php } else { 	?>
													<option value="<?php echo $user->user_id;?>"><?php echo $user->firstname." ".$user->lastname;?></option>
													<?php } ?>
										<?php }}?>
									</select>
				<?php 
						// Form close 
						$string = "</div>";
						echo form_close($string);
					?>	
				</div>
				<!--- FILTER END---->	
				* */ ?>

		
		
		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('admin_new_member_name');?></th>
					<th><?php echo $this->lang->line('admin_inviter_email_name');?></th>
					<th><?php echo $this->lang->line('admin_website_link');?></th>
					<th><?php echo $this->lang->line('admin_received_content');?></th>					
				</tr>
			</thead>
			
			<tbody>
				
				<?php 
				foreach($record as $invite_record)
				{
					echo "<tr>";
						echo "<td>".get_username($invite_record->user_id)."</td>";
						echo "<td>".$invite_record->inviter_email."</td>";
						echo "<td>".$invite_record->website_link."</td>";
						echo "<td>".$invite_record->website_content."</td>";
			
						
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
