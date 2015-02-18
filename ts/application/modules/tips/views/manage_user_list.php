<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div id="wrapperL">
	<h1>Users Manager</h1>
	<div class="box menu">
			<a href="#">Home</a>
	</div>
	<div class="box language">
		<div id="contentLeft">
			<ul class="ui-sortable">
			<li id="recordsArray_10">
				<a class="get_link" href="<?php echo base_url('admin/AllSalesExportToCSV');?>" >All Sales Export</a>
			</li>
			<li id="recordsArray_10">
				<a class="get_link" href="<?php echo base_url('admin/AllMembershipExportToCSV');?>" >All Membership Export</a>
			</li>
			</ul>
		</div>
	</div><!-- End box language -->
	<div class="box files">
		<ul>
			<li>
				<div class="row">
					<div class="cell width150px"><?php echo $this->lang->line('username');?></div>
					<div class="cell width300px"><?php echo $this->lang->line('email');?></div>
					<div class="cell width100px"><?php echo $this->lang->line('status');?></div>
					<div class="cell"><?php //echo $this->lang->line('status');?></div>
				</div>
				</li>
		<?php
			foreach($users as $user_i =>$user_detail){
				?>
				<li>
				<div class="row">
					<div class="cell width150px"><?php echo $user_detail['username'];?></div>
					<div class="cell width300px wordWrap"><?php echo $user_detail['email'];?></div>
					<div class="cell width100px"><?php 
					if($user_detail['active']==1) echo '<div class="fl mr30 formTip icon_filesent"> </div>';
					else echo'<div class="fl mr30 formTip icon_blockeduser"> </div>';
					?></div>
					<div class="cell"><?php echo $user_detail['banned'];?></div>
				</div>
				</li>
				<?php
			}
		?>
	</ul>	
	</div>
</div>
