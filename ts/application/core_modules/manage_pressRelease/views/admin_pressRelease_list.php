<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<link href="<?php echo ADMINCSS?>styleLanguage.css" type="text/css" rel="stylesheet"/>

<div id="wrapperL">
	<h1>Press Release</h1>
	<?php if($this->session->flashdata('error')){ ?>
	<div class="error">
		<?php echo $this->session->flashdata('error');?>
	</div>
	<?php }elseif($this->session->flashdata('msg')){ ?>
	<div class="msg">
		<?php echo $this->session->flashdata('msg');?>
	</div>
	<?php } ?>
		
	<!--Top menu home link -->
	<div class="box menu">
		<a href="<?php echo site_url('admin/settings/manage_pressRelease');?>"><?php echo $this->lang->line('cms_home_link');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display left side titles -->
	<div class="box language">
		<p><a href="<?php echo BASEURL?>admin/settings/manage_pressRelease/add_edit_pressRelease"><b><?php echo $this->lang->line('create_New');?></b></a></p>
		<div id="contentLeft">
			<ul>
				<?php $sk=0;
				if($press_list)foreach($press_list as $k=>$press_lists){ 
					$color='';
					if($pressReleaseId > 0 && ($pressReleaseId)==$press_lists['id']){
						$sk=$k;
						$color='dark_blue';
					}elseif($pressReleaseId == 0 && $k==0){
						$color='dark_blue';
					}
					?>
					<li id="recordsArray_<?php echo $press_lists['id']; ?>">
						<a href="<?php echo site_url('admin/settings/manage_pressRelease/index/'.$press_lists['id']);?>" class="get_link <?php echo $color;?>  pb15">
							<?php echo $press_lists['title'];?>
						</a>
					</li>			
					<?php
				} ?>
			</ul>
		</div>
	</div>
	<!--End display left side titles -->
		
	<!--Display description of title -->
	<div class="box files">
		<?php
			if(isset($press_list[$sk])){
					$f=$press_list[$sk];
					echo '<div class="fr">';
					echo ''.anchor('admin/settings/manage_pressRelease/add_edit_pressRelease/'.$f['id'].'', '<img src="'.base_url().'templates/assets/images/edit_icon.png" height="15px" width="15px" title="'.$this->lang->line('edit').'" />').'&nbsp;&nbsp;&nbsp;';
					echo ''.anchor('admin/settings/manage_pressRelease/delete_pressRelease/'.$f['id'].'', '<img src="'.base_url().'templates/assets/images/delete_icon.png" height="15px" width="15px" title="'.$this->lang->line('delete').'" onClick="return confirm(\'Are you sure you want to delete?\')" />').'&nbsp;&nbsp;&nbsp;&nbsp;';	
					echo '</div>';	
								
					echo '<h1>'. $f['title'].'</h1><br>';
					echo '<h4> Release Date: '. dateFormatView($f['date'],$fmt = 'd F Y').'</h4><br>';
					echo $f['description'] ;
			}else{
					echo $this->lang->line('noRecord');
			}?>
	</div>
	
</div>

<!--End cmslist of title -->
