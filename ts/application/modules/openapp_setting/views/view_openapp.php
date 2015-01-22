<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_manage_openapp_heading')?></h2>
	</div>
	<div id="main">
	
		<div>
				<div class="fLeft">
					<?php $all_app = $app_data['all_apps']->result();
						  $total_approve_apps = $app_data['total_approved'];
						  $total_pending_apps = $app_data['total_pending']; 
					?>
					<div><?php echo $this->lang->line('total_approved_apps')?> : <?php echo $total_approve_apps;?></div>
					<div><?php echo $this->lang->line('total_pending_apps')?> : <?php echo $total_pending_apps;?></div>
				</div>
				<form action="" method="get">
				<div class="fRight">
					<div class="fLeft">	
						<select name="category" >
							<option value="">By app category</option>
							<?php foreach($app_categories as $categories):?>
								<?php if($categories->id!=''):?>
								<option  <?php if($category==$categories->id){?> selected="selected"<?php }?> value="<?php echo $categories->id;?>">
								<?php echo $categories->category_name;?>
								</option>
								<?php endif?>
							<?php endforeach?>
				    	</select>
				    </div>
				    <div class="fLeft">						
						<input class="tooltipClass" title="Search" width="18px" type="image" alt="Search" src="<?php echo ADMINIMG."search.jpg";?>">				
					</div>
					</form>
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
		</div>
	
	<div><?php echo $this->session->flashdata('message');?></div>
	<table width="100%">
			<thead>
				<th width="40px"><?php echo $this->lang->line('s_no')?></th>
				<th width="120px"><?php echo $this->lang->line('app_title')?></th>
				<th><?php echo $this->lang->line('app_added_by_user')?></th>
				<th><?php echo $this->lang->line('app_description')?></th>
				<th><?php echo $this->lang->line('app_category')?></th>
				<th><?php echo $this->lang->line('app_preview')?></th>
				<th><?php echo $this->lang->line('app_approved')?></th>
				</thead>
	<?php if($this->input->get('per_page')){$i=(($this->input->get('per_page')-1)*10)+1;}
			else{$i=1;}
			foreach($all_app as $app):?>
		<tbody id="state_list">
			<tr>
				<td><?php echo $i++;?></td>
				<td><?php echo $app->title;?></td>
				<td><?php echo "<a href='".BASEURL."admin_users/user_profile/".$app->user_id."'>".ucfirst($app->firstname)." ".$app->lastname."</a>";?></td>
				<td><?php echo substr($app->description,0,50);?>.....</td>
				<td><?php echo $app->category_name;?></td>
				<td><a href="<?php echo BASEURL?>opensocial/admin_preview_openapp/<?php echo $app->user_id;?>/<?php echo $app->app_id;?>/<?php echo $app->id;?>">Preview</a></td>
				<td>
					<?php if($app->approved=='Y') { ?>								
							<a  href="javascript:void(0);" onClick="openapp_confirm('<?php echo $app->app_id?>','N')">
							<div class='status_a'></div></a>
							<?php } else{ ?>
							<a  href="javascript:void(0);" onClick="openapp_confirm('<?php echo $app->app_id?>','Y')" class="tooltipClass">
							<div class='status_d'></div>
							</a>
							<?php } ?>
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
