<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_advertisment');?></h2>
	</div>
	<div class="contentbox">

		<!--- FILTER START ---->	
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

		
		
		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('admin_advertiser');?></th>
					<th><?php echo $this->lang->line('admin_banner');?></th>
					<th width="100px"><?php echo $this->lang->line('admin_banner_code');?></th>
					<th><?php echo $this->lang->line('table_desc');?></th>
					<th><?php echo $this->lang->line('admin_url');?></th>
					<th><?php echo $this->lang->line('admin_updated');?></th>		
					<th class="admin_section_div"><?php echo $this->lang->line('admin_view');?></th>		
					<th class="admin_section_div"><?php echo $this->lang->line('admin_delete');?></th>		
					<th class="admin_section_div"><?php echo $this->lang->line('admin_status');?></th>					
					<th class="admin_section_div"><?php echo $this->lang->line('admin_email');?></th>		
					
				</tr> 
			</thead>
			<tbody>
				<?php
				foreach($advertisment as $adver)
				{
					$ad_url = getimage('ad',1,$adver->user_id,$adver->filename);
					
					echo "<tr>";
						echo "<td>".$adver->username."</td>";
						echo "<td><img height='80' width='80' src='".BASEURL."resize/index/80/80/".base64_encode($ad_url)."'/></td>";
						//echo "<td>".htmlentities("<!--<img height='80' width='80' src='".BASEURL."resize/index/80/80/".base64_encode($ad_url)."'/>-->")."</td>";
						echo "<td><div>".htmlentities("<!-- -->")."</div></td>";
						echo "<td>".ucfirst($adver->description)."</td>";
						echo "<td><div style='word-wrap:break-word;width:100px;'>".$adver->url."</div></td>";
						echo "<td>".$adver->updated."</td>";
						?>
							
							<td class="admin_section_div">
								<a href="<?php echo BASEURL ?>admin/admin/advertis_view/<?php echo $adver->bannerid?>" class="tooltipClass" ><img src="<?php echo ADMINIMG?>icons/view.jpg"></a>
							</td>

							<td class="admin_section_div">
								<a onclick="javascript:if(confirm('You are about to delete , continue?')){ window.location.href='<?php echo BASEURL ?>admin/admin/advertis_delete/<?php echo $adver->bannerid?>'}" class="tooltipClass" href="javascript:void(0)"><img src="<?php echo ADMINIMG?>icons/icon_delete.png"></a>
							</td>

							
							<td class="admin_section_div">
							<?php if($adver->published==1) { ?>
								<a onclick="javascript:if(confirm('You want to change status , continue?')){ window.location.href='<?php echo BASEURL ?>admin/admin/advertis_status/<?php echo $adver->bannerid?>/0'}" class="tooltipClass" href="javascript:void(0)">
									<img class="tooltipClass" alt="Active" src="<?php echo ADMINIMG?>icons/active-icon.jpg">
								</a>
							<?php } elseif($adver->published==2) { ?>
								<a onclick="javascript:if(confirm('You want to change status , continue?')){ window.location.href='<?php echo BASEURL ?>admin/admin/advertis_status/<?php echo $adver->bannerid?>/1'}" class="tooltipClass" href="javascript:void(0)">
									<img class="tooltipClass" alt="Active" src="<?php echo ADMINIMG?>icons/icon_delete.png">
								</a>
								
								<?php } 
							else { ?>
								<a onclick="javascript:if(confirm('You want to change status , continue?')){ window.location.href='<?php echo BASEURL ?>admin/admin/advertis_status/<?php echo $adver->bannerid?>/1'}" class="tooltipClass" href="javascript:void(0)">
									<img class="tooltipClass" alt="Active" src="<?php echo ADMINIMG?>icons/icon_close.png">
								</a>
								
								<?php } ?>	
							</td>
						<td class="admin_section_div">
								<a class="edit_item tooltipClass" onclick="send_email_advert('<?php echo $adver->email  ?>')" title="mail"><img src="<?php echo ADMINIMG?>icons/mail_icon.jpg"></a>
							</td>
						<?php 
						
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
