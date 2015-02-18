<!-- Alternative Content Box Start -->
 <div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('advert_add_heading');?></h2>
	</div>
	<div class="contentbox">
	
	<?php if(validation_errors()){?>
		<div class="error_msg">
			<?php echo validation_errors(); ?>
		</div>
	<?php }?>
	
		<?php echo form_open('admin/advert/advert_update/','id="advert_form"')?>
		<table>
			<tr>
				<td><?php echo $this->lang->line('advert_title');?></td>
				<td>
					<?php 
						$data = array(
							'name'  =>'advert_title',
							'value' => '',
							'id'	=>'advert_title',
							'class'	=>'inputbox',
							'type'	=>'text',
							'value'=> $result[0]->advert_title
						);
						echo form_input($data);
					?>
					<span class="validation_msg" id="validation_page_title"><?php echo $this->lang->line('add_title_validation');?></span>
				</td>
			</tr>
			
			<tr>
				<td><?php echo $this->lang->line('advert_code');?></td>
				<td>
					<?php 
						$data = array(
							'name' =>'advert_code',
							'id' =>'advert_code',
							'class'	=>'inputbox',
							'value' =>'',
							'type' =>'textarea',
							'value'=> $result[0]->advert_code
						);
						echo form_textarea($data);
					?>
					<span class="validation_msg" id="validation_page_title"><?php echo $this->lang->line('add_code_validation');?></span>
				<td>
			</tr>
			
			<tr>
				<td><?php echo $this->lang->line('advert_pages');?></td>
				<td>
				<?php 	
					$advert_pages_data = array(); $selected = '';
					if($advert_pages_query->num_rows() > 0):
						$advert_pages_data[''] = $this->lang->line('advert_page_option');
						foreach($advert_pages_query->result() as $row):
							if($row->advert_page_id==$result[0]->advert_page_id): 
								$selected = $result[0]->advert_page_id; 
							endif;
							$advert_pages_data[$row->advert_page_id] = $row->advert_page;
						endforeach;
					endif;
					?>
					<?php 		
						$element_attributes = 'id="advert_page" class="required"';
						echo form_dropdown('advert_page', $advert_pages_data, $selected, $element_attributes);
					?>	
				<td>
			</tr>
			
			<tr>
				<td><?php echo $this->lang->line('advert_positions');?></td>
				<td>
				<?php 	
					$advert_positions_data = array(); $selected='';
					if($advert_positions_query->num_rows() > 0):
						$advert_positions_data[''] = $this->lang->line('advert_position_option');
						foreach($advert_positions_query->result() as $row):
							if($row->advert_position_id==$result[0]->advert_position_id): 
								$selected = $result[0]->advert_position_id; 
							endif;
							$advert_positions_data[$row->advert_position_id] = $row->advert_position;
						endforeach;
					endif;
					?>
					<?php 		
						$element_attributes = 'id="advert_positions" class="required"';
						echo form_dropdown('advert_positions', $advert_positions_data, $selected, $element_attributes);
					?>	
				<td>
			</tr>			
			
			<tr>
				<td>&nbsp;</td>
				<td>
				<?php
					$data = array(
						'name'  =>'submit',
						'value' =>$this->lang->line('advert_submit'),
						'id'	=>'submit',
						'type'	=>'submit',
						'class' =>'btn'
					);
					echo form_input($data);
				?>
				<?php
					$data = array(
						'name'  =>'cancel',
						'value' =>$this->lang->line('advert_cancel'),
						'id'	=>'cancel',
						'type'	=>'button',
						'class' =>'btn',
						'onClick' => 'back()'
					);
					
					echo form_input($data);
				?>
				</td>
			</tr>
		</table>
				<?php
					$data = array(
						'name'  =>'advert_id',
						'value' => $result[0]->advert_id,
						'id'	=>'advert_id',
						'type'	=>'hidden',
					);
					echo form_input($data);
				?>		
		<?php echo form_close();?>
	</div>
</div>
<!-- Alternative Content Box End -->  
<script language="javascript">
function back()
{
	window.location.href="<?php echo BASEURL;?>admin/advert";
}
</script>