<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('manage_email_template'); ?> </h2>
	</div>
	
	<div class="contentbox">
			<?php echo $this->session->flashdata('error_message'); ?>

		<table width="100%">
			<thead>
				<th><?php echo $this->lang->line('manage_email_language_id'); ?></th>
				<th><?php echo $this->lang->line('manage_email_templates_key'); ?></th>
				<th><?php echo $this->lang->line('manage_email_templates_subject'); ?></th>
				<th><?php echo $this->lang->line('manage_email_templates_body'); ?></th>
				<th><?php echo $this->lang->line('manage_email_templates_from_name'); ?></th>
				<th><?php echo $this->lang->line('manage_email_templates_from_email'); ?></th>
			</thead><tbody>	
				<?php foreach($result as $key=>$val){ //echo "<pre>";print_r($result[$key]->key);

					?>
				<tr>
					<td><?php echo $result[$key]->language_id; ?></td>
					<td><a href="<?php echo BASEURL?>admin_manage_email_templates/update_email_template/<?php echo $result[$key]->key; ?>"><?php echo $result[$key]->key; ?></a></td>
					<td><?php echo $result[$key]->subject; ?></td>
					<td><?php echo $result[$key]->body; ?></td>
					<td><?php echo $result[$key]->from_name; ?></td>
					<td><?php echo $result[$key]->from_email; ?></td>
				</tr><?php }?>
						

				
			</tbody>	
			
			
		</table>
	
	</div>
	
	</form>
<div id="pagination">
		<?php //echo $paging; ?>
	</div>
</div>
