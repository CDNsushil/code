<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(isset($continentData[0]['id'])){
	$headText = $this->lang->line('EditContinentHeader');
}else{
	$headText = $this->lang->line('addContinentHeader');
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
	'name'=>'continentForm',
	'id'=>'continentForm',
);

$continentName = array(
	'name' 		=> 'continent',
	'id' 		=> 'continent',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'		=> set_value('continent',$continentData[0]['continent']),
);

$status = array(
	'name'      => 'status',
	'id'        => 'status',
	'value'     => 1 ,
	'checked'   => $continentData[0]['status'] =='t'?TRUE:FALSE,
);

$lang = 'lang';
$langList = getAbbrLangList($continentData[0]['lang']);
$langValue = $continentData[0]['lang'];

echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_continent/continent_manage'),$formAttributes).'
<div class="page_list">
	<ul class="ul_relative"> 
		<div class="">
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('continentName').' </label>
			</div>
			<li>'.form_input($continentName).'</li>
			<div class="seprator_10"></div>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('lang').' </label>
			</div>
			<li class="pr">
				<div id="selectLanguage">
					'.form_dropdown($lang , $langList, set_value($lang , ( ( !empty($langValue) ) ? "$langValue" : 'en' )),'id="lang" class="required error single selectBox"').'
				</div>
			</li>
			<div class="seprator_10"></div>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('tipStatus').' </label>
			</div>
			<li class="padding_0">
				<div class="defaultP">'.form_checkbox($status).'</div>
			</li>
			<div class="clear"></div>
			
			<li> 
				<div class="tds-button fr width300px">
					<input type="hidden" name="continentId"  id="continentId" value="'.$continentData[0]['id'].'">
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
/*Function to manage checkbox */
runTimeCheckBox()
	
/*Function to save state in db */
$(document).ready(function(){
	var continentId = $('#continentId').val();
	$("#continentForm").validate({
		submitHandler: function() {
			var fromData=$("#continentForm").serialize();
			$.post(baseUrl+'admin/settings/manage_continent/update_continent',fromData, function(data) {
				if(data){
					if(continentId!=''){
						window.location.href=baseUrl+'admin/settings/manage_continent/continent_manage/'+continentId;
					}else{
						window.location.href=baseUrl+'admin/settings/manage_continent';
					}
				}
			});
		}
	});
});

</script>
