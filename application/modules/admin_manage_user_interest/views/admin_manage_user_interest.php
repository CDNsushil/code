<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_manage_user_interest')?></h2>
	</div>
	<form action='' method="get" >
	<table class="fright">
	<tr><td>
					<a href='javascript:void(0)' id='open_add_box' onclick='open_add_box();'>Add interest topics</a>
	</td>
	<td>
	<select name="filter_interest_type" id='interest_category'>
		<option value="">--Select Interest Type--</option>
						<?php if(!empty($all_interest_type)){?><?php foreach($all_interest_type as $interest_type):?>
						<?php if($interest_type->type!=''):?>
						<option  <?php if($interest_type_filter==$interest_type->type){?> selected="selected"<?php }?> value="<?php echo $interest_type->id;?>">
						<?php echo $interest_type->type;?>
						</option>
						<?php endif?>
						<?php endforeach?>
						<?php }else{echo "No Records";}?>		
		
	
	</select>
	<input type="hidden" name="type" value="<?php $type = $this->input->get('type');if(!empty($type)){echo $type;}?>">
	</td>
	<td class="tooltipClass fLeft">
					<input width="15px" type="image" alt="Search" src="<?php echo ADMINIMG."search.jpg";?>">
				
	</td>
	</tr>
	</table>
	</form>
	
		<table style="width:100%">
			<thead>
				
				
				<th><?php echo $this->lang->line('interest_type')?></th>
				<th><?php echo $this->lang->line('interest_text')?></th>
				<th><?php echo $this->lang->line('interest_status')?></th>
				<th><?php echo $this->lang->line('table_action')?></th>
			</thead>
			<?php if(!empty($interest_result)){?>
			<?php foreach($interest_result as $interest_result):?>
			<tr id="fadout<?php echo $interest_result->id?>">
				
				<td id='update_type<?php echo $interest_result->id?>'>
				<?php foreach($all_interest_type as $type):
					if($type->id==$interest_result->type){
						$interest_type_text = $type->type;
						echo $interest_type_text;
						}
					endforeach;?>
				</td>	
				<td id='update_text<?php echo $interest_result->id?>'>
				<?php echo $interest_result->text;?>
				</td>
				<td id='update_status<?php echo $interest_result->id?>'>
				<?php if($interest_result->status==1){echo"Enabled";}else{echo "Disabled";}?>
				</td>	
				<td>
					<a class="tooltipClass" onclick="open_update_interest('<?php echo $interest_result->id?>','<?php echo $interest_result->type;?>','<?php echo $interest_result->text?>','<?php echo $interest_result->status?>');" href="javascript:void(0)" style="">
							<div class="edit_icon"></div>
							</a>
					<a href="javascript:void(0)" title="Delete post" class="tooltipClass" onclick="interest_delete_confirm('<?php echo $interest_result->id;?>');">
				<div class="delete_icon" ></div>
				</a>
				</td>
			</tr>
			<?php endforeach?>
			<?php }else{
			echo "No Record Found.........";}?>
			
		</table>
		<div id="popup_box3">
			<div class="confirm_text" id='interest_text_heading'></div>
				<div class="update_point_box">
					<div id='interest_cat_update'>
					<div class="fleft padding label">Select interest category</div>
					<div class="fleft"><select name="filter_interest_type" id='interest_category1'>
						<option value="">--Select Interest Type--</option>
						<?php if(!empty($all_interest_type)){?><?php foreach($all_interest_type as $interest_type):?>
						<?php if($interest_type->type!=''):?>
						<option  <?php if($interest_type_filter==$interest_type->type){?> selected="selected"<?php }?> value="<?php echo $interest_type->id;?>">
						<?php echo $interest_type->type;?>
						</option>
						<?php endif?>
						<?php endforeach?>
						<?php }else{echo "No Records";}?>		
					</select>
					</div></div>
					<div class="fleft padding label">Interest Text</div>
					<div class="fleft"><textarea name="interest_text" id="interest_text"></textarea></div>
					<div class="fleft padding label">Status</div>
					<div class="fleft">Enable<input type='radio' name='interest_status' id='interest_enable' value='1'>Disable<input type='radio' name='interest_status' id='interest_disable' value='0'></div>
				</div>
				<div class="clear"></div>
				<div class="con_button">
					<button class="botton" id='interest_ok_button' onClick="insert_user_interest(); ">
						<span class="button next_bt">
							<span><?php echo $this->lang->line('ok')?></span>
						</span>
					</button>

					<button class="button" id='interest_box_close' onclick='interest_box_close();'>
						<span class="button next_bt">
							<span><?php echo $this->lang->line('cancel_button')?></span>
						</span>
					</button>
				</div>
				<div id="required"></div>
		</div>
		<div id="popup_box4">
			<h1 id='interest_notification'></h1>
		</div>
	<div id="pagination">
		<?php echo $paging ?>
	</div>
</div>

