<div class="contentcontainer">
	<div class="headings altheading">	
		<h2><?php echo $this->lang->line('admin_advertisment');?></h2>
	</div>
	<div class="contentbox">
			<div class="fLeft">
					<table>
					<tr>
						

						<td class="admin_section_div">
							<a onclick="javascript:if(confirm('You are about to delete , continue?')){ window.location.href='<?php echo BASEURL ?>admin/admin/advertis_delete/<?php echo $ads_id?>'}" class="tooltipClass" href="javascript:void(0)" class="tooltipClass" title="Delete Advertisment "><img src="<?php echo ADMINIMG?>icons/icon_delete.png"></a>
						</td>					
						<td class="admin_section_div">
						<?php if($ads_info->published==1) { ?>
							<a onclick="javascript:if(confirm('You want to change status , continue?')){ window.location.href='<?php echo BASEURL ?>admin/admin/advertis_status/<?php echo $ads_info->bannerid?>/0'}" class="tooltipClass" title="Active Advertisment " href="javascript:void(0)">
								<img class="tooltipClass" alt="Active" src="<?php echo ADMINIMG?>icons/active-icon.jpg">
							</a>
						<?php } elseif($ads_info->published==2) { ?>
							<a onclick="javascript:if(confirm('You want to change status , continue?')){ window.location.href='<?php echo BASEURL ?>admin/admin/advertis_status/<?php echo $ads_info->bannerid?>/1'}" class="tooltipClass"  title="Deactive Advertisment " href="javascript:void(0)">
								<img class="tooltipClass" alt="Active" src="<?php echo ADMINIMG?>icons/icon_delete.png">
							</a>
							
							<?php } 
						else { ?>
							<a onclick="javascript:if(confirm('You want to change status , continue?')){ window.location.href='<?php echo BASEURL ?>admin/admin/advertis_status/<?php echo $ads_info->bannerid?>/1'}" class="tooltipClass"  title="Active Advertisment " href="javascript:void(0)">
								<img class="tooltipClass" alt="Active" src="<?php echo ADMINIMG?>icons/icon_close.png">
							</a>						
							<?php } ?>	
						</td>
						<td class="admin_section_div">
							<a class="edit_item tooltipClass" onclick="send_email_advert('<?php echo $ads_info->email  ?>')" class="tooltipClass"   title="Send mail to advertiser"><img src="<?php echo ADMINIMG?>icons/mail_icon.jpg"></a>
						</td>
					</tr>
			</table>
			<?php $ad_url = getimage('ad',1,$ads_info->user_id,$ads_info->filename);?>
			<img width='200' src='<?php echo BASEURL."resize/index/200/200/".base64_encode($ad_url); ?>'/>
		</div>
		<div class="fLeft advert_view">
			<table>
				<tr>
					<td class="texthead"><?php echo $this->lang->line('admin_advertiser');?></td>
					<td><?php echo $ads_info->username; ?></td>
				</tr>
				<tr>
					<td class="texthead"><?php echo $this->lang->line('admin_advert_title');?></td>
					<td><?php echo $ads_info->ad_title; ?></td>			
					<td class="texthead"><?php echo $this->lang->line('admin_url');?></td>
					<td><?php echo $ads_info->url; ?></td>
				</tr>
				<tr>
					<td class="texthead"><?php echo $this->lang->line('admin_updated');?></td>	
					<td><?php echo $ads_info->updated; ?></td>				
					<td class="texthead"><?php echo $this->lang->line('admin_advert_start_date');?></td>	
					<td><?php echo date("Y-m-d",strtotime($ads_info->ad_start_date)); ?></td>
				</tr>	
				
				<tr>
					<td class="texthead"><?php echo $this->lang->line('admin_advert_demographic_area');?></td>
					<td><?php echo $ads_info->ad_demographic_area; ?></td>				
					<td class="texthead"><?php echo $this->lang->line('admin_advert_keyword');?></td>
					<td><?php echo $ads_info->ad_keyword; ?></td>
				</tr>
				<tr>					
					<td class="texthead"><?php echo $this->lang->line('table_desc');?></td>
					<td><?php echo $ads_info->description; ?></td>
				</tr>
				
				<tr>					
					<td class="texthead"><?php echo $this->lang->line('admin_advert_ppc');?></td>
					<td><?php echo $ads_info->ad_ppc; ?></td>									
					<td class="texthead"><?php echo $this->lang->line('admin_advert_ppm');?></td>
					<td><?php echo $ads_info->ad_ppm; ?></td>
				</tr>
				<tr>					
					<td class="texthead"><?php echo $this->lang->line('admin_advert_amount');?></td>
					<td><?php echo $ads_info->amount; ?></td>									
					<td class="texthead"><?php echo $this->lang->line('admin_advert_pay_date');?></td>
					<td><?php echo $ads_info->pay_date; ?></td>
				</tr>
				<tr>					
					<td class="texthead"><?php echo $this->lang->line('admin_advert_pay_status');?></td>
					<td><?php echo $ads_info->payment_status; ?></td>									
					<td class="texthead"><?php echo $this->lang->line('admin_advert_payer_email');?></td>
					<td><?php echo $ads_info->payer_email; ?></td>
				</tr>			
			</table>		
		</div>
		<div class="clear"></div>
	</div>
</div>
