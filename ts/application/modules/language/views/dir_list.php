<script type="text/javascript">
$(document).ready(function(){
	$('.button_del').click(function(){
		var answer = confirm('<?php echo $this->lang->line('language_confirm_lang_delete');?>');
		return answer; // answer is a boolean
	});
	$('#new_lang_form').hide();
	$("#new_lang").click(function() { ///add click action for button
		$('#new_lang_form').toggle();
	});
});
</script>
<link href="<?php echo ADMINCSS?>styleLanguage.css" type="text/css" rel="stylesheet"/>
<div id="wrapperL">
	<h1>Translation Manager</h1>
	<div class="box menu"><a href="<?php echo site_url('admin/settings/manage_language');?>"><?php echo $this->lang->line('language_home_link');?></a>&nbsp;</div>
	<?php if($this->session->flashdata('error')){ ?>
		<div class="error">
			<?php echo $this->session->flashdata('error');?>
		</div>
	<?php }elseif($this->session->flashdata('msg')){ ?>
		<div class="msg">
			<?php echo $this->session->flashdata('msg');?>
		</div>
	<?php } ?>
	<?php $this->load->view('language/dir_list_view'); ?>
	<div class="box files"><br /><p>Please Click on the language name to select files </p>
	<br />
	<h1>How it works</h1><br />
	<p><ul class="t_help">
		
		<li>The list of languages are created by folder structure in /language/.</li>
<li>The list of files are created by content in language directory. Only .php files are considered and backup files are excluded.</li>
<li>When you choose some file for the first time (keys are not in database) you will be asked if you want to add them.</li>

<li>If there are some differences between keys in file and keys in database we have two options.</li>
<li> 1. Some keys exists in file and not in database - you will be asked if you want to add them. Until than, that keys will not be available in form. Warning! If you save your file before adding those keys, the translation and key will be erased from the file.</li>
<li>2. Some keys exists in database and not in the file - you will see <span style='color:red;'>(NEW!)</span> next to key name. You will see that most likely when new key was added to the file in other language.</li>

<li>If you delete key from file it is also deleted from other languages and database.</li>

<li>All translations are escaped by addslashes php function.</li>

<li>I assume that if you want a line break in your translation, you need to add &lt;br/&gt; tag.</li>
</ul>
</p>
	<br /><br /></div>
</div>

