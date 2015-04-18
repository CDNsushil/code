<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<script type="text/javascript" src="<?php echo base_url().'templates/system/javascript/drag/jquery-1.3.2.min.js'?>" ></script>
<script type="text/javascript" src="<?php echo base_url().'templates/system/javascript/drag/jquery-ui-1.7.1.custom.min.js'?>" ></script>
<script type="text/javascript">
						   
	$(function() {
		BASEPATH = "<?php echo BASEURL.lang()?>";
		$("#contentLeft ul").sortable({ opacity: 0.6, cursor: 'move', update: function() {
			var order = $(this).sortable("serialize");
				$.post(BASEPATH+"/tips/update_tip_order", order, function(theResponse){
				}); 												
			}								  
		});
		
		$(".get_link").click(function(event) {
			var href = $(this).attr('href');
			document.location.href=href;
			//event.preventDefault();
		});
	});
	
</script>

<div id="wrapperL">
	<h1>Tips Manager</h1>
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
		<a href="<?php echo site_url('tips');?>"><?php echo $this->lang->line('tips_home_link');?></a>
	</div>
	<!-- End top menu home link -->
		
	<!--Display left side titles -->
	<div class="box language">
		<p><a href="<?php echo BASEURL?>tips/add_tip"><b><?php echo $this->lang->line('tips_create_file_link');?></b></a></p>
		<div id="contentLeft">
			<ul>
				<?php foreach($tips as $d){ ?>
				<li id="recordsArray_<?php echo $d['id']; ?>">
					<a href="<?php echo site_url('tips/tips_list/'.$d['id']);?>" class="get_link">
						<?php //echo $d['subtitle'].$d['title'];?>
						<?php echo $d['title'];?>
					</a>
					<img id="move_tip_img"  src="<?php echo base_url() ?>templates/assets/images/Move.png" height="15px" width="15px"  />
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
		echo ''.anchor('tips/edit_tip/'.$titleId.'', '<img src="'.base_url().'templates/assets/images/edit_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsEditTitle').'" />').'';
			
		echo ''.anchor('tips/delete_tip/'.$titleId.'', '<img src="'.base_url().'templates/assets/images/delete_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" />').'&nbsp;&nbsp;&nbsp;&nbsp;';						
		?>			
		<?php 
		foreach($description as $f)
		{  
			echo '<h1>'. $f['title'].'</h1><br>';
			echo '<h3>'. $f['subtitle'].'</h3><br>';
			echo $f['description'] ;
		}?>
	</div>
	<?php }else{ ?>
		<div class="box files">
			<?php
			if(isset($topDescription)&&!empty($topDescription)){ 
			foreach($topDescription as $f)
			{
			echo ''.anchor('tips/edit_tip/'.$f['id'].'', '<img src="'.base_url().'templates/assets/images/edit_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsEditTitle').'" />').'';
			
			echo ''.anchor('tips/delete_tip/'.$f['id'].'', '<img src="'.base_url().'templates/assets/images/delete_icon.png" height="15px" width="15px" title="'.$this->lang->line('discussionsDeleteTitle').'" onClick="return confirm(\'Are you sure you want to delete?\')" />').'&nbsp;&nbsp;&nbsp;&nbsp;';	
								
			 
			echo '<h1>'. $f['title'].'</h1><br>';
			echo '<h3>'. $f['subtitle'].'</h3><br>';
			echo $f['description'] ;
			}}?>
		</div>
	<?php } ?>
</div>
<!--End tiplist of title -->

