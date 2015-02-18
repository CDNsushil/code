<div class="contentcontainer">
	<?php if($this->session->flashdata('message')){?>
		<div class="status success">
				<p class="closestatus"><a href="#" title="Close">x</a></p>
				<p><img src="<?php echo ADMINIMG ?>icons/icon_success.png" alt="Success" /><?php echo $this->session->flashdata('message')?></p>
		</div>
	<?php }?>
	<div class="headings altheading">
		<div class="advert_heading"><h2><?php echo $this->lang->line('advert_heading_page')?></h2></div>
		<div class="advert_add_link"><a title="add advertisement" href="<?php echo BASEURL ?>admin/advert/advert_add/" title=""><img src="<?php echo ADMINIMG?>icons/icon_breadcrumb.png" alt="Add" /><span class="advert_add_link_text" style="margin-left:10px; color:#fff; font-weight:bold; text-decoration:underline;">Add ad</span></a></div>
	</div>
	<div class="contentbox">
		<table width="100%">
			<thead>
				<tr>
					<th width="10%"><?php echo $this->lang->line('advert_table_serial')?></th>
					<th width="34%"><?php echo $this->lang->line('advert_table_title')?></th>
					<th width="10%"><?php echo $this->lang->line('advert_table_page')?></th>
					<th width="10%"><?php echo $this->lang->line('advert_table_position')?></th>
					<th width="12%"><?php echo $this->lang->line('advert_table_created')?></th>
					<th width="12%"><?php echo $this->lang->line('advert_table_updated')?></th>
					<th width="12%"><?php echo $this->lang->line('advert_table_action')?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php 
				$i=1; 
				if($result!=false)
				{
					foreach($result as $value)
					{
					?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $value->advert_title; ?></td>
							<td><?php echo ucfirst($value->page); ?></td>
							<td><?php echo ucfirst($value->position); ?></td>
							<td><?php echo date('d F,Y',strtotime($value->created_date)); ?></td>
							<td><?php echo date('d F,Y',strtotime($value->updated_date)); ?></td>
							<td>
								<a style="margin:0 10px" title="edit advertisement" href="<?php echo BASEURL ?>admin/advert/advert_update/<?php echo $value->advert_id;?>" title=""><img src="<?php echo ADMINIMG?>icons/icon_edit.png" alt="Edit" /></a>
								<a title="delete advertisement" href="javascript:void(0)" onClick="javascript:if(confirm('You are about to delete ad, continue?')){ window.location.href='<?php echo BASEURL ?>admin/advert/advert_delete/<?php echo $value->advert_id;?>'}" title=""><img src="<?php echo ADMINIMG?>icons/icon_delete.png" alt="Delete" /></a>
							</td>
						</tr>
					<?php 
					$i++; 
					}
				}	
				else
				{
				?>
					<tr><td colspan="5" align="center"><?php echo $this->lang->line('advert_there_is_no_ads');?></td></tr>
				<?php
				}				
				?>
			</tbody>
		</table>
	</div>
</div>
