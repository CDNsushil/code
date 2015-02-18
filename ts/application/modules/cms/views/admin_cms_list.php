<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<link href="<?php echo ADMINCSS?>styleLanguage.css" type="text/css" rel="stylesheet"/>

<div id="wrapperL">
	<h1>Cms Manager</h1>
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
		<a href="<?php echo site_url('cms/cms_list');?>"><?php echo $this->lang->line('cms_home_link');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display left side titles -->
	<div class="box language">
		<p><a href="<?php echo BASEURL?>cms/add_cms"><b><?php echo $this->lang->line('cms_create_file_link');?></b></a></p>
		<div id="contentLeft">
			<ul>
				<?php foreach($cms_list as $cms_lists){ ?>
				<li id="recordsArray_<?php echo $cms_lists['id']; ?>">
					<a href="<?php echo site_url('cms/cms_list/'.$cms_lists['id']);?>" class="get_link">
						<?php echo $cms_lists['title'];?>
					</a>
				</li>			
				<?php } ?>
			</ul>
		</div>
	</div>
	<!--End display left side titles -->
		
	<!--Display description of title -->
		<?php if(isset($description)&&!empty($description)){ ?>
		<div class="box files">
		<?php
		echo ''.anchor('cms/edit_cms/'.$titleId.'', '<img src="'.base_url().'templates/assets/images/edit_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsEditTitle').'" />').'&nbsp;&nbsp;&nbsp;';
		
		if($titleId==1 || $titleId==8){?>
			<a href="<?php echo site_url('cms/broadcast_mails/'.$titleId);?>" onClick="return confirm('Are you sure you want to broadcast this email?')"><?php echo $this->lang->line('admin_broadcast_email');?></a>
		<?php
		}	
		//echo ''.anchor('cms/delete_cms/'.$titleId.'', '<img src="'.base_url().'templates/assets/images/delete_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" />').'&nbsp;&nbsp;&nbsp;&nbsp;';						
		?>			
		<?php 
		foreach($description as $f)
		{  
			echo '<h1>'. $f['title'].'</h1><br>';
			echo changeToUrl($f['description']) ;
		}?>
	</div>
	<?php }else{ ?>
		<div class="box files">
			<?php
			if(isset($topDescription)&&!empty($topDescription)){ 
				foreach($topDescription as $f)
				{
					echo ''.anchor('cms/edit_cms/'.$f['id'].'', '<img src="'.base_url().'templates/assets/images/edit_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsEditTitle').'" />').'&nbsp;&nbsp;&nbsp;';
					
					if($f['pageKey']=='termsconditions' || $f['pageKey']=='termsnconditionfr'){
						?>
						<a href="<?php echo site_url('cms/broadcast_mails/'.$f['id']);?>" onClick="return confirm('Are you sure you want to broadcast this email?')"><?php echo $this->lang->line('admin_broadcast_email');?></a>
						<?php
					}
					//echo ''.anchor('cms/delete_cms/'.$f['id'].'', '<img src="'.base_url().'templates/assets/images/delete_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" />').'&nbsp;&nbsp;&nbsp;&nbsp;';	
									
					echo '<h1>'. $f['title'].'</h1><br>';
					echo changeToUrl($f['description']) ;
				}
			}?>
		</div>
	<?php } ?>		
	</div>

<!--End cmslist of title -->
