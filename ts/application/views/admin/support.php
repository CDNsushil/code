<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('support')?></h2>
	</div>
	<div id="main">
	<form action="" method="get">
		<div>
				<div class="fLeft">
					<div><?php echo $this->lang->line('total_question')?> : <?php echo $total_question;?></div>
					<div><?php echo $this->lang->line('total_ans')?> : <?php echo $total_ans;?></div>
				</div>
				<div class="fRight">
					<div class="fLeft">	
						<select name="user" >
							<option value="">By Username</option>
							<?php foreach($all_users as $all_users1):?>
								<?php if($all_users1->username!=''):?>
								<option  <?php if($user_filter_name==$all_users1->user_id){?> selected="selected"<?php }?> value="<?php echo $all_users1->user_id;?>">
								<?php echo $all_users1->firstname;?>&nbsp;<?php echo $all_users1->lastname;?>
								</option>
								<?php endif?>
							<?php endforeach?>
				    	</select>
				    </div>
				    <div class="fLeft">			
						<select name="filter_q_a">
							<option value="">By Status</option>
							<option value="1" <?php echo ($q_a_status=='1'?'Selected':''); ?>>Answered</option>
							<option value="2" <?php echo ($q_a_status=='2'?'Selected':''); ?>>Pending</option>
						</select>
					</div>
					<div class="fLeft">						
						<input class="tooltipClass" title="Search" width="18px" type="image" alt="Search" src="<?php echo ADMINIMG."search.jpg";?>">				
					</div>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
		</div>
	</form>
	<div><?php echo $this->session->flashdata('message');?></div>
	<table width="100%">
			<thead>
				<th width="40px"><?php echo $this->lang->line('s_no')?></th>
				<th width="120px"><?php echo $this->lang->line('user_name')?></th>
				<th><?php echo $this->lang->line('question')?></th>
				<th><?php echo $this->lang->line('date')?></th>
				<th><?php echo $this->lang->line('answer')?></th>
				<th><?php echo $this->lang->line('date')?></th>
				<th align="center"><?php echo $this->lang->line('table_action')?></th>
			</thead>
	<?php if($this->input->get('per_page')){$i=(($this->input->get('per_page')-1)*10)+1;}
			else{$i=1;}
			foreach($support_data as $support_data):?>
		<tbody id="state_list">
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo "<a href='".BASEURL."admin_users/user_profile/".$support_data->user_id."'>".ucfirst($support_data->firstname)." ".$support_data->lastname."</a>";?></td>
				<td><?php echo $support_data->question;?></td>
				<td><?php echo  date("d F,Y h:i:s",strtotime($support_data->q_date));?></td>
				<td id="ans<?php echo $support_data->question_id;?>">
				<?php echo substr($support_data->answer,0,50);?>
				</td>
				<td id="date<?php echo $support_data->question_id;?>"><?php if(!empty($support_data->a_date)){echo  date("d F,Y h:i:s",strtotime($support_data->a_date));}?></td>
				<td>
				<?php if(empty($support_data->answer)):?><a id="answer_box<?php echo $support_data->question_id;?>" href="javascript:void(0)" onclick="open_answer_box('<?php echo $support_data->question_id;?>')" title="Answer for <?php echo ucfirst($support_data->firstname).' '.$support_data->lastname;?>" class="tooltipClass">
				<div class="clear"></div>
				<div class="reply_icon"></div>
				</a>
				<?php endif?>
				<?php $uri=$this->uri->segment(4);if($uri==''){$uri=1;}?>
				<a id="edit_box<?php echo $support_data->question_id;?>" 
				<?php if(empty($support_data->answer)){?>style="display:none;"<?php }?>
				 href="<?php echo BASEURL?>admin/admin/edit_support_ans/<?php echo $support_data->question_id;?>/<?php echo $uri;?>" onclick="" title="Update <?php echo ucfirst($support_data->firstname).' '.$support_data->lastname;?> Answer" class="tooltipClass">
					<div class="clear"></div>
					<div class="edit_icon"></div>
				</a>
				</td>
			</tr>
		</tbody>	
	<?php endforeach?>
	</table>
	</div>
	<div id="pagination">
		<?php echo $paging ?>
	</div>
</div>
