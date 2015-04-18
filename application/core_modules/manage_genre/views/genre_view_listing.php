<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul>
	<li>
		<div class="row">
			<div class="cell width250px b"><?php echo $this->lang->line('genreName');?></div>
			<div class="cell width200px b"><?php echo $this->lang->line('industry');?></div>
			<div class="cell width150px b"><?php echo $this->lang->line('projectType');?></div>
			<div class="cell width150px b"><?php echo $this->lang->line('admin_status');?>
			<div class="cell"><?php //echo $this->lang->line('admin_status');?></div>
		</div>
	</li>

<?php
	if(isset($genreList) && !empty($genreList)){
		foreach($genreList as $genreList){ 
			if(isset($genreList['industryId'])){
				$industry = getIndustry($genreList['industryId']);
			}else{
				$industry = '&nbsp;';
			}
			?>
			<li>
				<div class="row">
					<div class="cell width250px"><?php echo !empty($genreList['Genre'])?$genreList['Genre']:'&nbsp;';?></div>
					<div class="cell width200px wordWrap"><?php echo $industry;?></div>
					<div class="cell width150px"><?php echo !empty($genreList['projectTypeName'])?$genreList['projectTypeName']:'&nbsp;';?></div>
					<div class="cell width150px"><?php 
						if($genreList['status']=='t') echo '<div class="fl mr30 formTip icon_filesent ptr" onclick="update_status('. $genreList['GenreId'].',0)"> </div>';
						else echo'<div class="fl mr30 formTip icon_blockeduser ptr" onclick="update_status('. $genreList['GenreId'].',1)"> </div>';
					?></div>
					<div class="cell">
						<a href="<?php echo base_url().SITE_AREA_SETTINGS.'manage_genre/genre_manage/'.$genreList['GenreId'];?>" class="formTip" title="<?php echo $this->lang->line('admin_edit');?>">
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
			<div class="pagingWrapper">
					<div class="clearfix"></div>
					<div class="pt15 ml28 mt7 mr15">
						<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_genre/index'),"divId"=>"showGenreList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
					</div></div>
			<div class="clear"></div>
			<?php 
		} ?>
	</li>
</ul>

