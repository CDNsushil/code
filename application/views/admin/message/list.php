<div class="contentcontainer">
	<div class="headings altheading">
		<div class="fLeft">
			<h2><?php echo $this->lang->line('admin_message'); ?></h2>
		</div>
		<?php if($userId > 0){?>
			<div class="fRight">
				<a class="linkText" href="<?php echo base_url()."admin_message/messages";?>">
					<h3><?php echo $this->lang->line('admin_all_message'); ?></h3>
				</a>
			</div>
		<?php } ?>
		<div class="clear"></div>
	</div>
	<div class="contentbox">
		<div class="fRight">
			<form name="customform" action="" method="post" > 
				<div class="fLeft">
						<input defaultvalue="Enter Member Name" type="text" name="searchTxt"  onfocus="if(this.value==this.defaultValue){ this.value=''; }" onblur="if(this.value==''){ this.value = this.defaultValue; }"  value="<?php echo ($searchTxt==''?'Enter Member Name':$searchTxt);?>" />
				</div>
				<div title="Search member by name" class="tooltipClass fLeft">
					<input type="image" src="<?php echo ADMINIMG."search.jpg";?>"  alt="Search" width="15px" />
				</div>
				<div class="clear"></div>
			</form>
		</div>
		<div class="clear"></div>
		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('admin_srno'); ?></th>					
					<th><?php echo ($userId>0?$this->lang->line('admin_message_to'):$this->lang->line('admin_member_name')); ?></th>
					<?php if($userId>0){?>
						<th><?php echo $this->lang->line('admin_message_from'); ?></th>
					<?php } ?>
					<th><img src="<?php echo ADMINIMG.'fav.png';?>" height="20px" /></th>
					<th width="230px"><?php echo $this->lang->line('admin_message_message'); ?></th>
					<th width="90px"><?php echo $this->lang->line('admin_message_date'); ?></th>					
				</tr>
			</thead>			
			<tbody>				
				<?php 
				if(count($messages)>0){
					foreach($messages as $key=>$msg){?>
						<tr>
							<td><?php echo $key+1;?></td>							
							<td>
								<a href="<?php echo base_url();?>admin_users/user_profile/<?php echo $msg->to; ?>">
									<?php echo ucfirst($msg->to_firstname." ".$msg->to_lastname); ?>
								</a>
							</td>
							<?php if($userId>0){?>
								<td>
									<a href="<?php echo base_url();?>admin/admin/user_profile/<?php echo $msg->from; ?>">
										<?php echo ucfirst($msg->from_firstname." ".$msg->from_lastname); ?>
									</a>
								</td>	
							<?php } ?>
							<td><a href="<?php echo base_url().($userId > 0?"admin_message/messageDetail/".$msg->id:"admin_message/messages/1/".$msg->to);?>"  class="tooltipClass"  title="View <?php echo ($userId>0?$msg->from_firstname." ".$msg->from_lastname:$msg->to_firstname." ".$msg->to_lastname); ?> message"  ><img src="<?php echo ADMINIMG.'fav.png';?>" height="20px" /></a></td>
							<td><?php echo substr($msg->message,0,100); ?></td>
							<td><?php echo date('d F, Y',strtotime($msg->created)) ?></td>
						</tr>
				<?php }
				 }
				?>
			</tbody>
		</table>
		
		<div><?php echo $pagging; ?></div>
	</div>
</div>



