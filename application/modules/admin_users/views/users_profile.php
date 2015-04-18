<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_users_profile');?></h2>
	</div>
	<div class="contentbox">
		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('admin_id');?></th>
					<th>User</th>
					<th><?php echo $this->lang->line('admin_cc');?></th>
					<th><?php echo $this->lang->line('admin_email');?></th>
					<th><?php echo $this->lang->line('admin_age');?></th>
					<th><?php echo $this->lang->line('admin_country');?></th>
					<th><?php echo $this->lang->line('admin_points');?></th>
					<th><?php echo $this->lang->line('admin_ip');?></th>		
					<th><?php echo $this->lang->line('admin_edit');?></th>		
					<th><?php echo $this->lang->line('admin_delete');?></th>		
					<th><?php echo $this->lang->line('admin_status');?></th>
					<th><?php echo $this->lang->line('admin_email');?></th>		
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; 
				if($users!=false){
					foreach($users as $users){?>
						<tr>

							<td><?php echo $users->user_id; ?></td>
							<td> 
					<div class="name_box_wrapper fLeft">
							<div class="user_box">
								<img src="<?php  echo getimage('user', 2,$users->user_id);?>" width="40px" height="40px" />
							</div><!--user_box-->
					
							<div class="user_name-box">
								<?php echo $users->firstname." ".$users->lastname; ?>
							</div>
					</div><!--name_box_wrapper-->

							</td>
							<td></td>
							<td><?php echo $users->email;?></td>
							<td><?php echo $dob;?></td>
							<td><?php echo $users->country_name;?></td>
							<td class="admin_section_div"><?php echo $point;?></td>
							<td>
                            <?php if(isset($users->user_ip))
                           	echo $users->user_ip;  
                           	?>
							</td>

							<td class="tooltipClass admin_section_div" title="Edit User Data">
								<a href="<?php echo BASEURL ?>admin_users/user_edit/<?php echo $users->user_id;?>">
								<img src="<?php echo ADMINIMG?>icons/icon_edit.png" alt="Edit" /></a>
							</td>


                                      <?php if($users->published==4) { ?>

							<td class="admin_section_div">
								<a title="Deleted User" href="javascript:void(0" class="tooltipClass"  title=""><img src="<?php echo ADMINIMG?>icons/icon_close.png" alt="Deactive" />
							</td>

                                             <?php  } else {?>
         
                                                       <td class="admin_section_div">
								<a title="Delete User Data" href="javascript:void(0)" class="tooltipClass" onClick="javascript:if(confirm('You are about to delete , continue?')){ window.location.href='<?php echo BASEURL ?>admin_users/delete_user/<?php echo $users->user_id;?>'}" title=""><img src="<?php echo ADMINIMG?>icons/icon_delete.png"   /></a>
							</td>    

 <?php } ?>

							<td class="admin_section_div">
							<?php if($users->published==1) { ?>								
							<a href="javascript:void(0);" onClick="confirm_activation('1','<?php echo $users->user_id?>')">
								<img src="<?php echo ADMINIMG?>icons/active-icon.jpg" alt="Active" title="<?php echo ucfirst($users->firstname).' is active';?>" class="tooltipClass" />
							</a>
							<?php } else if($users->published==2 || $users->published==3) { ?> 

							<a href="javascript:void(0);" onClick="confirm_activation('0','<?php echo $users->user_id?>')" title="<?php echo ucfirst($users->firstname).' is deactivated';?>" class="tooltipClass">
								<img src="<?php echo ADMINIMG?>icons/icon_close.png" alt="Deactive" />
							</a>

							<?php } else  { ?>
							<a href="javascript:void(0);" onClick="confirm_activation('0','<?php echo $users->user_id?>')" title="<?php echo ucfirst($users->firstname).' is deactive';?>" class="tooltipClass">
								<img src="<?php echo ADMINIMG?>icons/icon_close.png" alt="Deactive" />
							</a>
							<?php } ?>
							</td>
						<td>
<a class="edit_item tooltipClass" onclick="send_email_advert('<?php echo $users->email  ?>')" title="mail"><img src="<?php echo ADMINIMG?>icons/mail_icon.jpg"></a>

</td>
						</tr>
				<?php $i++; }
				 }
				?>
			</tbody>
		</table>
	</div>
	
</div>
