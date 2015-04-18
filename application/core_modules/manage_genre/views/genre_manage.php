<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(isset($genreData[0]['GenreId'])){
	$headText = $this->lang->line('EditGenreHeader');
}else{
	$headText = $this->lang->line('addGenreHeader');
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
	'name'=>'genreForm',
	'id'=>'genreForm',
);

$genreName = array(
	'name' 		=> 'Genre',
	'id' 		=> 'Genre',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('stateName',$genreData[0]['Genre']),
);

$industryId = 'industryId';
$industryList = getIndustryList();
$industryValue = $genreData[0]['industryId'];

$lang = 'lang';
$langList = getAbbrLangList($genreData[0]['lang']);
$langValue = $genreData[0]['lang'];

echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_genre/genre_manage'),$formAttributes).'
<div class="page_list">
	<ul class="ul_relative"> 
		<div class="">
    
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('genreName').' </label>
			</div>
			<li>'.form_input($genreName).'</li>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('industry').' </label>
			</div>
			<li class="pr">
				'.form_dropdown($industryId , $industryList, set_value($industryId , ( ( !empty($industryValue) ) ? "$industryValue" : 0 )),'id="industryId" class="required error single selectBox" onchange="getStyleProject(\'projectStyle\',\'projGenre\',this.value,\'select project\');"').'
				<div class="clear"></div>
			</li>
			<div class="seprator_10"></div>
			<div id="projectStyle">
			</div>
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
			<div class="clear"></div>
			
			<li> 
				<div class="tds-button fr width300px">
					<input type="hidden" name="GenreId"  id="GenreId" value="'.$genreData[0]['GenreId'].'">
					<div class="tds-button Fleft"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Submit" name="submit" type="submit" id="SubmitButton"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div></span></button></div>
					
					<div class="tds-button Fleft"><button onClick="history.go(-1);" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="cancel dash_link_hover" type="button" id="cancelButton"><span><div class="Fleft">Cancel</div> <div class="icon-form-cancel-btn"></div></span></button></div>
				</div>
				<div class="clear">&nbsp;</div>    
			</li>
		</div>
	</ul>
</div>
</div>';
?> 

<?
''.form_close().'';
?>

<script type="text/javascript">
runTimeCheckBox();

/*Function to save genre in db */
$(document).ready(function(){
	var GenreId = $('#GenreId').val();
	$("#genreForm").validate({
		submitHandler: function() {
			var fromData=$("#genreForm").serialize();
			$.post(baseUrl+'admin/settings/manage_genre/update_genre',fromData, function(data) {
				if(data){
					if(GenreId!=''){
						window.location.href=baseUrl+'admin/settings/manage_genre/genre_manage/'+GenreId;
					}else{
						window.location.href=baseUrl+'admin/settings/manage_genre';
					}
				}
			});
		}
	});
});

/* Function load category and type list at a time of edit genre*/
<?php if(isset($genreData[0]['GenreId']) && !empty($genreData[0]['GenreId'])){ ?>
$(document).ready(function () {
	var val1 = <?php echo $genreData[0]['industryId'];?>;
	var catId = <?php echo getTypeCatData($genreData[0]['typeId']);?>;
	var typeId = <?php echo $genreData[0]['typeId'];?>;
	getStyleProject('projectStyle','projGenre',val1,'select project',catId,typeId);
});
<?php }?>
</script>
