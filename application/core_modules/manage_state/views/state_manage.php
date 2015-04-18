<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Set header text start*/
if(isset($stateData[0]['stateId'])){
	$headText = $this->lang->line('EditStateHeader');
}else{
	$headText = $this->lang->line('addStateHeader');
}
/*Set header text end*/

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
	'name'=>'stateForm',
	'id'=>'stateForm',
);

$stateName = array(
	'name' 		=> 'stateName',
	'id' 		=> 'stateName',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('stateName',$stateData[0]['stateName']),
);

$stateCode = array(
	'name' 		=> 'stateCode',
	'id' 		=> 'stateCode',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('stateCode',$stateData[0]['stateCode']),
);

$status = array(
	'name'        => 'status',
	'id'       	  => 'status',
	'value'       => 1 ,
	'checked'     => $stateData[0]['status'] =='t'?TRUE:FALSE,
);

$countryId = 'countryId';
$countryList = getCountryList();
$countryValue = $stateData[0]['countryId'];

$lang = 'lang';
$langList = getAbbrLangList($stateData[0]['lang']);
$langValue = $stateData[0]['lang'];


echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_state/state_manage'),$formAttributes).'
<div class="page_list">
	<ul class="ul_relative"> 
		<div class="">
    
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('stateName').' </label>
			</div>
			<li>'.form_input($stateName).'</li>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('stateCode').' </label>
			</div>
			<li>'.form_input($stateCode).'</li>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('countryName').' </label>
			</div>
			<li class="pr">
				<div id="selectCountry">
					'.form_dropdown($countryId , $countryList, set_value($countryId , ( ( !empty($countryValue) ) ? "$countryValue" : 0 )),'id="countryId" class="required error single selectBox"').'
				</div>
			</li>
			<div class="seprator_10"></div>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('lang').' </label>
			</div>
			<li class="pr">
				<div id="selectLanguage">
					'.form_dropdown($lang , $langList, set_value($lang , ( ( !empty($langValue) ) ? "$langValue" : 0 )),'id="lang" class="required error single selectBox"').'
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
					<input type="hidden" name="stateId"  id="stateId" value="'.$stateData[0]['stateId'].'">
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
	var stateId = $('#stateId').val();
	$("#stateForm").validate({
		submitHandler: function() {
			var fromData=$("#stateForm").serialize();
			$.post(baseUrl+'admin/settings/manage_state/update_state',fromData, function(data) {
				if(data){
					if(stateId!=''){
						window.location.href=baseUrl+'admin/settings/manage_state/state_manage/'+stateId;
					}else{
						window.location.href=baseUrl+'admin/settings/manage_state';
					}
				}
			});
		}
	});
});

</script>
