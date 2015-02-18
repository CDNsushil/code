<div class="contentcontainer">
	<?php if($this->session->flashdata('edit_success')){?>
		<div class="status success">
				<p class="closestatus"><a href="#" title="Close">x</a></p>
				<p><img src="<?php echo ADMINIMG ?>icons/icon_success.png" alt="Success" /><?php echo $this->session->flashdata('edit_success')?></p>
		</div>
	<?php }?>
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_point_page');?></h2>

	</div>
	<div class="contentbox">
		<div class="fRight">
			<div class="fLeft">
			<a href="<?php echo BASEURL?>admin_point_page/new_point_page"><?php echo $this->lang->line('admin_page_new');?></a>
			</div>
			<div class="clear"></div>
		</div>
		<div class="clear"></div>
		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('table_serial');?></th>
					<th><?php echo $this->lang->line('admin_page_name');?></th>
					<th><?php echo $this->lang->line('admin_content');?></th>
					<th><?php echo $this->lang->line('admin_status');?></th>
					<th>Edit</th> 
					<th>Delete</th>
				</tr>
			</thead>
			
			<tbody id="state_list">
				<?php
				$i = 1;
				if($point_pages !=false){
					foreach($point_pages as $pages){?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php   echo $pages->page_name ?></td>
							<td><?php   echo $pages->content ?></td>
							<td>
								<?php if($pages->status==0){?>				
									<div id="<?php echo $pages->bubble_id; ?>">								
										<a style="margin-left:20px" onclick="update_state(<?php echo $pages->bubble_id ?>,<?php echo 1 ?>)" href="javascript:void(0)">
											<span id="<?php echo $pages->bubble_id;?>">Activate</span>
										</a>
									</div>
								<?php 
									}else{?>
									<div id="<?php echo $pages->bubble_id; ?>">
										<a style="margin-left:20px" onclick="update_state(<?php echo $pages->bubble_id ?>,<?php echo 0 ?>)" href="javascript:void(0)">
											 <span id="<?php echo $pages->bubble_id;?>">Deactivate</span>
										</a>
									</div>	
									<?php }
								?>
							</td>
							<td>
								<a  class="tooltipClass" href="<?php echo BASEURL?>admin_point_page/edit_page/<?php echo $pages->bubble_id;?>">
									<img class="tooltipClass" alt="Active" src="<?php echo ADMINIMG?>icons/icon_edit.png">
								</a>
							</td> 
							<td>
								<a onclick="javascript:if(confirm('You want to change status , continue?')){ window.location.href='<?php echo BASEURL ?>admin_point_page/page_delete/<?php echo $pages->bubble_id?>'}" class="tooltipClass" href="javascript:void(0)">
									<img class="tooltipClass" alt="Active" src="<?php echo ADMINIMG?>icons/icon_delete.png">
								</a>
							</td>
						</tr>
						
					<?php 
					 $i++; 
					 }
				 }
				 else echo "<tr><td>No Pages</td></tr>"; 
				?>
			</tbody>
		</table>
	</div>
	<div id="pagination">
		<?php echo $paging ?>
	</div>
</div>
