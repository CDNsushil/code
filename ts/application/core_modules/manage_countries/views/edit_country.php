<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<?php echo '<div class="frm_heading_wp pb10"><div class="summery_right_archive_wrapper  absolute_heading "> <h1>'.$this->lang->line('EditCountryHeader').'</h1> </div></div>
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
echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_countries/edit_country'),$formAttributes).'
<div class="page_list">
	<ul class="ul_relative"> 
		<div class="">
    
		<div id="oneLineDescription" class="cell label_wrapper_topic">
			<label class="select_field_topic"> '.$this->lang->line('countryName').' </label>
		</div>
		<li>'.form_input($countryName).'</li>
	
		<div id="oneLineDescription" class="cell label_wrapper_topic">
			<label class="select_field_topic"> '.$this->lang->line('countryLocalName').' </label>
		</div>
		<li>'.form_input($countryLocalName).'</li>';
		
	echo '<li> <div class="tds-button fr width300px">
					<input type="hidden" name="countryId"  id="countryId" value="'.$countryId.'">
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
/*Function to update country in db */
$(document).ready(function(){
	var countryId = $('#countryId').val();
	$("#countryForm").validate({
		submitHandler: function() {
			var fromData=$("#countryForm").serialize();
			$.post(baseUrl+'admin/settings/manage_countries/update_country',fromData, function(data) {
				if(data){
					window.location.href=baseUrl+'admin/settings/manage_countries/edit_country/'+countryId;
				}
			});
		}
	});
});

</script>
