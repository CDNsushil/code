<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul>
	<li>
		<div class="row">
			<div class="cell width200px b"><?php echo $this->lang->line('continentName');?></div>
			<div class="cell width200px b"><?php echo $this->lang->line('lang');?></div>
			<div class="cell width200px b"><?php echo $this->lang->line('admin_status');?>
			<div class="cell"><?php //echo $this->lang->line('admin_status');?></div></div>
		</div>
	</li>
	<?php
	if(isset($continentList) && !empty($continentList)){
		foreach($continentList as $continentList){ ?>
			<li>
				<div class="row">
					<div class="cell width200px"><?php echo !empty($continentList['continent'])?$continentList['continent']:'&nbsp;';?></div>
					<div class="cell width200px"><?php echo !empty($continentList['lang'])?$continentList['lang']:'&nbsp;';?></div>
					<div class="cell width200px"><?php 
						if($continentList['status']=='t') echo '<div class="fl mr30 formTip icon_filesent ptr" onclick="update_status('. $continentList['id'].',0)"> </div>';
						else echo'<div class="fl mr30 formTip icon_blockeduser ptr" onclick="update_status('. $continentList['id'].',1)"> </div>';
					?></div>
					<div class="cell">
						<a href="<?php echo base_url().SITE_AREA_SETTINGS.'manage_continent/continent_manage/'.$continentList['id'];?>" class="formTip" title="<?php echo $this->lang->line('admin_edit');?>">
							<img src="<?php echo base_url().'templates/assets/images/edit_icon.png';?>" height="15px" width="15px" />
						</a>
				</div>
			</li>
			
			<li class="dn">
				<div class="row">
					<div class="cell width200px"><input type="text" name="continent" id="continent" value="<?php echo $continentList['continent'];?>"></div>
					<div class="cell width200px"><input type="text" name="lang" id="lang" value="<?php echo $continentList['lang'];?>"></div>
					<div class="cell width200px"><input type="text" name="status" id="status" value="<?php echo $continentList['status'];?>"></div>
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
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_continent/index'),"divId"=>"showContinentList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
			</div>
			<div class="clear"></div>
			<?php 
		} ?>
	</li>
</ul>	
