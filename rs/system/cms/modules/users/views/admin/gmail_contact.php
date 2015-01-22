<?php defined('BASEPATH') or exit('No direct script access allowed'); //this form show all gmail contacts ?>

<?php echo form_open(base_url().'admin/users/gtact', 'class="crud" autocomplete="off" id="gmail_contact"') ?>
<section class="title">
	<h4>
		Gmail Contacts
	
		<div class="gmail_contact">
			<span class="chosen_sprite"></span>
			<?php echo form_input('search_word','','placeholder="Enter Affiliate Name" class="affi_contact" id="search_word"')?>
			<input type="submit" name="contact_btn"  value="Search" class="contact_btn">
			<?php echo anchor('admin/users/gmailContact','Reset', 'rel="" class="cancel"') ?>		
			<?php echo anchor('admin/users/exportGmailContactCSV/','Export CSV', 'rel="" class="cancel "') ?>
		</div>
									
	</h4>
</section>

<section class="item">
	<div class="content">
		<?php if(isset($gmailContacts) && !empty($gmailContacts)): ?>
			<table class="table-list" cellspacing="0">
				<thead>
					<tr>
						<th width=""><?php echo lang('global:email');?> </th>
						<th width=""><?php echo 'Reference (Affiliate)'?></th>
						<th width="">Contact Date</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="3">
							<div class="inner"><?php $this->load->view('admin/partials/pagination');  ?></div>
						</td>
					</tr>
				</tfoot>
				<tbody class="bodyContent">
					
				<?php foreach ($gmailContacts as $gmail):?>
					<tr>
						
						<td ><?php echo $gmail->contact_email; ?></td>
						<td ><?php echo ucwords($gmail->first_name.' '.$gmail->last_name); ?></td>
						<td ><?php echo date('d M Y',strtotime($gmail->created_at)); ?></td>
					
					</tr>
				<?php endforeach;?>
				</tbody>
				
			</table>
		
		<?php else: ?>
			<section class="title">
				<p><?php echo lang('membership:no_membership');?></p>
			</section>
		<?php endif;?>
		<span class="pagination">
		   <?php if(!empty($links)){ echo $links; } ?>
		 </span>  
	</div>

</section>
<?php echo form_close();?>
<script>
$(document).ready(function(){
	$("#gmail_contact").submit(function(event) {
		var fromData=$("#gmail_contact").serialize();
		var url = BASE_URL+'admin/users/searchAffiliateContact';
		
		$.post(url,fromData, function(data) {
		  if(data){
				 $('tbody.bodyContent').html('');
				$('tbody.bodyContent').html(data.msg);
			}
		},"json");

	return false;	
	
  });
});
</script>  
