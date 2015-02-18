<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*Set header text start*/
if(isset($countryData[0]['countryId'])){
	$headText = $this->lang->line('EditCountryHeader');
}else{
	$headText = $this->lang->line('addCountryHeader');
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
	'name'=>'countryForm',
	'id'=>'countryForm',
);
$countryName = array(
	'name' 		=> 'countryName',
	'id' 		=> 'countryName',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('countryName',$countryData[0]['countryName']),
);
$countryLocalName = array(
	'name' 		=> 'countryLocalName',
	'id' 		=> 'countryLocalName',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'		=> set_value('countryLocalName',$countryData[0]['countryLocalName']),
);
$countryCode = array(
	'name' 		=> 'countryCode',
	'id' 		=> 'countryCode',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('countryCode',$countryData[0]['countryCode']),
);
$status = array(
	'name'      => 'status',
	'id'        => 'status',
	'value'     => 1 ,
	'checked'   => $countryData[0]['status'] ==1?TRUE:FALSE
);

$continent = 'continentId';
$continentList = getContinentList();
$continentValue = $countryData[0]['continentId'];

echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_countries/add_country'),$formAttributes).'
<div class="page_list">
	<ul class="ul_relative"> 
		<div class="">
    
		<div id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic"> '.$this->lang->line('countryName').' </label>
		</div>
		<li>'.form_input($countryName).'</li>
	
		<div id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic"> '.$this->lang->line('countryLocalName').' </label>
		</div>
		<li>'.form_input($countryLocalName).'</li>
		
		<div id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic"> '.$this->lang->line('countryCode').' </label>
		</div>
		<li>'.form_input($countryCode).'</li>
		
		<div id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic"> '.$this->lang->line('continent').' </label>
		</div>
		<li class="pr"><div id="selectCountry">'.form_dropdown($continent , $continentList, set_value($continent , ( ( !empty($continentValue) ) ? "$continentValue" : 0 )),'id="continentId" class="required error single selectBox"').'</div></li>
		<div class="seprator_20"></div>
		<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('tipStatus').' </label>
			</div>
			<li class="padding_0">
				<div class="defaultP">'.form_checkbox($status).'</div>
			</li>
			<div class="clear"></div>
			';
		
	echo '<li> <div class="tds-button fr width300px">
					<input type="hidden" name="countryId"  id="countryId" value="'.$countryData[0]['countryId'].'">
					<input type="submit" value="Save" name="save">
					<input type="button" value="Cancel" onClick="history.go(-1);" class="canclebtn">
				</div>';
	
	echo '
        <div class="clear">&nbsp;</div>    
	</li>
</div>

</ul>
</div></div>
'.form_close().'';
?>
<script type="text/javascript">
runTimeCheckBox()

/*Function to save country in db */
$(document).ready(function(){
	var countryId = $('#countryId').val();
	$("#countryForm").validate({
		submitHandler: function() {
			var fromData=$("#countryForm").serialize();
			$.post(baseUrl+'admin/settings/manage_countries/update_country',fromData, function(data) {
				if(data){
					if(countryId!=''){
						window.location.href=baseUrl+'admin/settings/manage_countries/manage_country/'+countryId;
					}else{
						window.location.href=baseUrl+'admin/settings/manage_countries';
					}
				}
			});
		}
	});
});
</script>
