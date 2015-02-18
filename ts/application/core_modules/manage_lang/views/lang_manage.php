<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(isset($languagetData[0]['langId'])){
	$headText = $this->lang->line('EditLangHeader');
}else{
	$headText = $this->lang->line('addLangHeader');
}
echo '<div class="frm_heading_wp pb10"><div class="summery_right_archive_wrapper  absolute_heading "> <h1>'.$headText.'</h1> </div></div>
<div class="seprator_25"></div>
';
if($this->session->flashdata('error')){ ?> 
<div class="error">
<?php echo $this->session->flashdata('error');?>
</div>
<?php }
echo '<div class="edit_post_wp">'  .'';

$formAttributes = array(
	'name'=>'langForm',
	'id'=>'langForm',
);

$languageName = array(
	'name' 		=> 'Language',
	'id' 		=> 'Language',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('Language',$languagetData[0]['Language']),
);

$languageLocal = array(
	'name' 		=> 'Language_local',
	'id' 		=> 'Language_local',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('Language_local',$languagetData[0]['Language_local']),
);

$langAbbr = array(
	'name' 		=> 'lang_abbr',
	'id' 		=> 'lang_abbr',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('lang_abbr',$languagetData[0]['lang_abbr']),
);

echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_lang/lang_manage'),$formAttributes).'
<div class="page_list">
	<ul class="ul_relative"> 
		<div class="">
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('langName').' </label>
			</div>
			<li>'.form_input($languageName).'</li>
			<div class="seprator_10"></div>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('langLocal').' </label>
			</div>
			<li>'.form_input($languageLocal).'</li>
			<div class="seprator_10"></div>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('langAbbr').' </label>
			</div>
			<li>'.form_input($langAbbr).'</li>
			<div class="seprator_10"></div>
			
			<li> 
				<div class="tds-button fr width300px">
					<input type="hidden" name="langId"  id="langId" value="'.$languagetData[0]['langId'].'">
					<input type="submit" value="Save" name="save">
					<input type="button" value="Cancel" onClick="history.go(-1);" class="canclebtn">
				</div>
				<div class="clear">&nbsp;</div>    
			</li>
		</div>
	</ul>
</div>
</div>
'.form_close().'';
?>

<script type="text/javascript">
/*Function to save state in db */
$(document).ready(function(){
	var langId = $('#langId').val();
	$("#langForm").validate({
		submitHandler: function() {
			var fromData=$("#langForm").serialize();
			$.post(baseUrl+'admin/settings/manage_continent/update_continent',fromData, function(data) {
				if(data){
					if(langId!=''){
						window.location.href=baseUrl+'admin/settings/manage_lang/lang_manage/'+langId;
					}else{
						window.location.href=baseUrl+'admin/settings/manage_lang';
					}
				}
			});
		}
	});
});

</script>
