<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul>
	<li>
		<div class="row">
			<div class="cell width250px b"><?php echo $this->lang->line('stateName');?></div>
			<div class="cell width200px b"><?php echo $this->lang->line('countryName');?></div>
			<div class="cell width100px b"><?php echo $this->lang->line('stateCode');?></div>
			<div class="cell width100px b"><?php echo $this->lang->line('lang');?></div>
			<div class="cell width100px b"><?php echo $this->lang->line('admin_status');?>
			<div class="cell"><?php //echo $this->lang->line('admin_status');?></div></div>
		</div>
	</li>
	<?php
	if(isset($stateList) && !empty($stateList)){
		foreach($stateList as $stateList){ ?>
			<li>
				<div class="row">
					<div class="cell width250px"><?php echo !empty($stateList['stateName'])?$stateList['stateName']:'&nbsp;';?></div>
					<div class="cell width200px wordWrap"><?php echo !empty($stateList['countryName'])?$stateList['countryName']:'&nbsp;';?></div>
					<div class="cell width100px"><?php echo !empty($stateList['stateCode'])?$stateList['stateCode']:'&nbsp;';?></div>
					<div class="cell width100px"><?php echo !empty($stateList['lang'])?$stateList['lang']:'&nbsp;';?></div>
					<div class="cell width100px"><?php 
						if($stateList['status']=='t') echo '<div class="fl mr30 formTip icon_filesent ptr" onclick="update_status('. $stateList['stateId'].',0)"> </div>';
						else echo'<div class="fl mr30 formTip icon_blockeduser ptr" onclick="update_status('. $stateList['stateId'].',1)"> </div>';
					?></div>
					<div class="cell">
						<a href="<?php echo base_url().SITE_AREA_SETTINGS.'manage_state/state_manage/'.$stateList['stateId'];?>" class="formTip" title="<?php echo $this->lang->line('admin_edit');?>">
							<img src="<?php echo base_url().'templates/assets/images/edit_icon.png';?>" height="15px" width="15px" />
						</a>
					</div>
				</div>
			</li>
		<?php
		}
	}
	?>
	<li>
		<?php
		if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?>
			<div class="pt15 ml28 mt7 mr15">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_state/index'),"divId"=>"showStateList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
			</div>
			<div class="clear"></div>
			<?php 
		} ?>
	</li>
</ul>	
