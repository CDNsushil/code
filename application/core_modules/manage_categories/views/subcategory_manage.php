<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if(isset($categoryData[0]['CategoryID'])){
		$headText = $this->lang->line('EditsubCategoryHeader_'.$type);
		$buttonText = "Update";
	}else{
		$headText = $this->lang->line('addsubCategoryHeader_'.$type);
		$buttonText = "Save";
	}
?>


<?php
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
	'name'=>'categoryForm',
	'id'=>'categoryForm',
);

$categoryName = array(
	'name' 		=> 'Name',
	'id' 		=> 'Name',
	'type' 		=> 'text',
	'class' 	=> 'textbox width450px required',
	'value'	=> set_value('Name',$categoryData[0]['Name']),
);



$parentList 	=  getCategorylist($type);
$parentValue 	=  $categoryData[0]['parentID'];
$parentValueId	=  (!empty($parentValue))?$parentValue:0;


echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_categories/subcategory_manage/'.$type),$formAttributes).'
<div class="page_list">
	<ul class="ul_relative"> 
		<div class="">
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('categoryName').' </label>
			</div>
			<li class="pr">
				'.form_dropdown('parentID',$parentList,$parentValueId,'id="parentID" class="required error single selectBox"').'
				<div class="clear"></div>
			</li>
			<div class="seprator_10"></div>
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('subcategoryName').' </label>
			</div>
			<li>'.form_input($categoryName).'</li>
			<div class="seprator_5"></div>
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('SubCatDescr').' </label>
			</div>
			<li>
			        <textarea class="search_box mt10 mb8 width450px bdr_bbb fl required" maxlength="50"  id="sub_description" name="sub_description">'.set_value('sub_description',$categoryData[0]['Description']).'</textarea>
			</li>
			<li> 
				<div class="tds-button fr width300px">
					<input type="hidden" name="CategoryID"  id="CategoryID" value="'.$categoryData[0]['CategoryID'].'">
					<input type="hidden" name="type"  id="type" value="'.$type.'">
					<div class="tds-button Fleft"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Submit" name="submit" type="submit" id="SubmitButton"><span><div class="Fleft">'.$buttonText.'</div> <div class="icon-save-btn"></div></span></button></div>
					
					<div class="tds-button Fleft"><button onclick=window.location="'.site_url(SITE_AREA_SETTINGS.'manage_categories/sub_index/'.$type).'"  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="cancel dash_link_hover" type="button" id="cancelButton"><span><div class="Fleft">Cancel</div> <div class="icon-form-cancel-btn"></div></span></button></div>
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
/*Function to save genre in db */
$(document).ready(function(){
	var CategoryID = $('#CategoryID').val();
	var type = $('#type').val();
	$("#categoryForm").validate({
		submitHandler: function() {
			var fromData=$("#categoryForm").serialize();
			$.post(baseUrl+'admin/settings/manage_categories/update_subcategory/'+type,fromData, function(data) {
				if(data){
					/*
					if(CategoryID!=''){
						window.location.href=baseUrl+'admin/settings/manage_categories/subcategory_manage/'+type+'/'+CategoryID;
					}else{
						window.location.href=baseUrl+'admin/settings/manage_categories/subcategory_manage/'+type;
					}
					*/
					window.location.href=baseUrl+'admin/settings/manage_categories/sub_index/'+type;
					
				}
			});
		}
	});
	
	
});

</script>
