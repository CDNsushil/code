<div class="contentcontainer">
	<?php if($this->session->flashdata('edit_success')){?>
		<div class="status success">
				<p class="closestatus"><a href="#" title="Close">x</a></p>
				<p><img src="<?php echo ADMINIMG ?>icons/icon_success.png" alt="Success" /><?php echo $this->session->flashdata('edit_success')?></p>
		</div>
	<?php }?>
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('heading_page')?></h2>
	</div>
	<div class="contentbox">
		<table width="100%">
			<thead>
				<tr>
					<th><?php echo $this->lang->line('table_serial')?></th>
					<th><?php echo $this->lang->line('table_pages')?></th>
					<th><?php echo $this->lang->line('table_created')?></th>
					<th><?php echo $this->lang->line('table_updated')?></th>
					<th><?php echo $this->lang->line('table_action')?></th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=1; 
				foreach($pages as $page){?>
					<tr>
						<td><?php echo $i;?></td>
						<td><?php echo $page->page_name ?></td>
						<td><?php echo date('d-m-Y',strtotime($page->created_date)) ?></td>
						<td><?php echo date('d-m-Y',strtotime($page->updated_date)) ?></td>
						<td>
							<a style="margin-left:20px" title="edit page" href="<?php echo BASEURL ?>admin/admin/edit_page/<?php echo $page->page_id?>" title=""><img src="<?php echo ADMINIMG?>icons/icon_edit.png" alt="Edit" /></a>
						</td>
					</tr>
				<?php $i++; } ?>
			</tbody>
		</table>
	</div>
</div>
