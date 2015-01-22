<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $usersCount = countResult('UserAuth'); ?>
<div class="fr width150px b">Total Users: <?php echo $usersCount; ?></div>
<ul>
			<li>
				<div class="row">
					<div class="cell width200px b"><?php echo $this->lang->line('userFirstName');?></div>
					<div class="cell width200px b"><?php echo $this->lang->line('userSecondName');?></div>
					<div class="cell width300px b"><?php echo $this->lang->line('email');?></div>
					<div class="cell width100px b"><?php echo $this->lang->line('status');?></div>
					<div class="cell"><?php //echo $this->lang->line('status');?></div>
				</div>
				</li>
		<?php
			
			foreach($users as $user_i =>$user_detail){
				?>
				<li>
				<div class="row">
					<div class="cell width200px"><?php echo !empty($user_detail['firstName'])?$user_detail['firstName']:'&nbsp;';?></div>
					<div class="cell width200px"><?php echo !empty($user_detail['lastName'])?$user_detail['lastName']:'&nbsp;';?></div>
					<div class="cell width300px wordWrap"><?php echo !empty($user_detail['email'])?$user_detail['email']:'&nbsp;';?></div>
					<div class="cell width100px"><?php 
					if($user_detail['active']==1) echo '<div class="fl mr30 formTip icon_filesent ptr" onclick="update_status('. $user_detail['authuid'].',0)"> </div>';
					else echo'<div class="fl mr30 formTip icon_blockeduser ptr" onclick="update_status('. $user_detail['authuid'].',1)"> </div>';
					?></div>
					<div class="cell"><?php echo $user_detail['banned'];?></div>
				</div>
				</li>
				<?php
			}
		?>
		<li>
			<?php
			if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?>
				
					<div class="pt15 ml28 mt7 mr15">
						<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_users/index'),"divId"=>"showUserList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
				</div>
				<div class="clear"></div>
			<?php } ?>
		</li>
	</ul>	

		
