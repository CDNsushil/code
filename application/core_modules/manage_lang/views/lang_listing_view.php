<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul>
	<li>
		<div class="row">
			<div class="cell width200px b"><?php echo $this->lang->line('langName');?></div>
			<div class="cell width200px b"><?php echo $this->lang->line('langLocal');?></div>
			<div class="cell width200px b"><?php echo $this->lang->line('langAbbr');?>
			<div class="cell"><?php //echo $this->lang->line('admin_status');?></div></div>
		</div>
	</li>
	<?php
	if(isset($languageList) && !empty($languageList)){
		foreach($languageList as $languageList){ ?>
			<li>
				<div class="row">
					<div class="cell width200px"><?php echo !empty($languageList['Language'])?$languageList['Language']:'&nbsp;';?></div>
					<div class="cell width200px"><?php echo !empty($languageList['Language_local'])?$languageList['Language_local']:'&nbsp;';?></div>
					<div class="cell width200px"><?php echo !empty($languageList['lang_abbr'])?$languageList['lang_abbr']:'&nbsp;';?></div>
					<div class="cell">
						<a href="<?php echo base_url().SITE_AREA_SETTINGS.'manage_lang/language_manage/'.$languageList['langId'];?>" class="formTip" title="<?php echo $this->lang->line('admin_edit');?>">
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
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_lang/index'),"divId"=>"showLangList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
			</div>
			<div class="clear"></div>
			<?php 
		} ?>
	</li>
</ul>	
