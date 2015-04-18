<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript" charset="utf-8">
	function update_status_categroy(type,catId,status)
	{
			var fromData = '';
			$.post(baseUrl+'admin/settings/manage_categories/update_status_categroy/'+catId+'/'+status,fromData, function(data) {
				if(data){
						window.location.href=baseUrl+'admin/settings/manage_categories/sub_index/'+type;
				}
			});
	}
</script>
<ul>
	<li>
		<div class="row">
			<div class="cell width350px b"><?php echo $this->lang->line('subcategoryName');?></div>
			<div class="cell width200px b"><?php echo $this->lang->line('CatName');?></div>
			<div class="cell width100px b"><?php echo $this->lang->line('StatusName');?></div>
			<div class="cell b"><?php echo $this->lang->line('admin_action');?></div>
		</div>
	</li>

<?php
	if(isset($categoriesList) && !empty($categoriesList)){
		foreach($categoriesList as $categoriesList){ 
			
			?>
			<li>
				<div class="row">
					<div class="cell width350px"><?php echo !empty($categoriesList['Name'])?$categoriesList['Name']:'&nbsp;';?></div>
					<div class="cell width200px"><?php echo !empty($categoriesList['parentID'])?getCategoryname($categoriesList['parentID']):'&nbsp;';?></div>
					
					<div class="cell width100px b">
					<?php
					if($categoriesList['Active']==1) 
					{
						echo '<div class="fl mr30 formTip icon_filesent ptr" onclick="update_status_categroy(\''.$type.'\','. $categoriesList['CategoryID'].',0)"> </div>';
					
					}else
					{
						 echo'<div class="fl mr30 formTip icon_blockeduser ptr" onclick="update_status_categroy(\''.$type.'\','. $categoriesList['CategoryID'].',1)"> </div>';
					}
					?>
					</div>
					<div class="cell ">
						<a class="mr5" href="<?php echo base_url().SITE_AREA_SETTINGS.'manage_categories/subcategory_manage/'.$type.'/'.$categoriesList['CategoryID'];?>" class="formTip" title="<?php echo $this->lang->line('admin_edit');?>">
							<img src="<?php echo base_url().'templates/assets/images/edit_icon.png'; ?>" height="15px" width="15px" />
						</a>
						<a href="<?php echo base_url().SITE_AREA_SETTINGS.'manage_categories/delete_subcategory/'.$type.'/'.$categoriesList['CategoryID'];?>">
							<img src="<?php echo base_url().'templates/assets/images/delete_icon.png'; ?>" height="15px" width="15px" title="Delete" onclick="return confirm('Are you sure you want to delete?')"></a>&nbsp;&nbsp;&nbsp;&nbsp;
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
						<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_categories/index/'.$type),"divId"=>"showGenreList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
					</div></div>
			<div class="clear"></div>
			<?php 
		} ?>
	</li>
</ul>



