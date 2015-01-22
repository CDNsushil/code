	<script type="text/javascript">
	$(document).ready(function(){
		$('#create_file_form').hide();
		$("#new_file").click(function() { ///add click action for button
			$('#create_file_form').toggle();
		});
		$('#new_lang_form').hide();
		$("#new_lang").click(function() { ///add click action for button
			$('#new_lang_form').toggle();
		});
		$('.button_del').click(function(){
			var answer = confirm('<?php echo $this->lang->line('language_confirm_lang_delete');?>');
			return answer; // answer is a boolean
		});
	});

   </script>
<link href="<?php echo ADMINCSS?>styleLanguage.css" type="text/css" rel="stylesheet"/>
	<div id="wrapperL">
		<h1>Translation Manager</h1>
		<?php if($this->session->flashdata('error')){ ?>
			<div class="error">
				<?php echo $this->session->flashdata('error');?>
			</div>
		<?php }elseif($this->session->flashdata('msg')){ ?>
			<div class="msg">
				<?php echo $this->session->flashdata('msg');?>
			</div>
		<?php } ?>
		<div class="box menu">
			<a href="<?php echo site_url('/admin/settings/manage_language');?>"><?php echo $this->lang->line('language_home_link');?></a>&nbsp;|&nbsp;<a href="#" id="new_file"><?php echo $this->lang->line('language_create_file_link');?></a>
			<div class="right">Lang: <strong><?php echo $sel_dir;?></strong></div>
			<div class="clear"></div>
			<div id="create_file_form">
				<?php echo form_open(site_url('admin/settings/manage_language/create_file'));?>
					<p><?php echo $this->lang->line('language_create_file_info');?></p><br/>
					<input type="text" name="filename" value=""/>
					<input type="hidden" name="language" value="<?php echo $sel_dir;?>" />
					<input type="submit" name="create" value="<?php echo $this->lang->line('language_create_label');?>" />
				</form>
			</div>
		</div>
		<?php if(isset($dir)&&!empty($dir)){
			$this->load->view('language/dir_list_view');
		 } ?>
		<?php if(isset($files)&&!empty($files)){ ?>
		<div class="box files">
			<ul>
			<?php foreach($files as $f){ ?>
			<?php $langRemaining=array();?>	
				<li><a href="<?php echo site_url('admin/settings/manage_language/lang_file/'.$sel_dir.'/'.$f);?>"><?php echo $f;?></a>
				<?php echo form_open(site_url('/language/delete_language_file'));?>
					<input type="hidden" name="language" value="<?php echo $sel_dir;?>" />
					<input type="hidden" name="filename" value="<?php echo $f;?>" />
				<!--<input type="submit" name="delete" value="<?php echo $this->lang->line('language_delete_file');?>" class="button_del" />-->
				</form><p class="clear"></p>
				<?php foreach($dir as $d){
						if(!file_exists(APPPATH."language/{$d['dir']}/$f")){ 
							$langRemaining[]=$d['dir'];
						}
					}
					if(isset($langRemaining) && count($langRemaining)>0){
				?>
					<div id="notFoundFiles" class="notFoundFiles">Files not found for:
						<div id="NF"><?php echo implode(" | ",$langRemaining);?></div>
					</div>
				<?php } ?>
				</li>
			<?php } ?>
			</ul>
		</div>
		<?php }else{ ?>
			<div class="box files"><?php echo $this->lang->line('language_no_files');?></div>
		<?php } ?>
	</div>

