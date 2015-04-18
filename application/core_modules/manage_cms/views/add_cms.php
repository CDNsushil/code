<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

<!--add script for Editor -->
<script type="text/javascript" src="<?php echo base_url().'templates/system/javascript/jquery-plugin/niceditor/nicEdit.js'?>" ></script>

<script type="text/javascript">
	bkLib.onDomLoaded(function() {
	var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','subscript','superscript','strikethrough','removeformat','hr','image','link','unlink','forecolor']});
	
	myNicEditor.panelInstance('description');
});
</script>
<!--End Editor script -->

<?php 
echo '<div class="frm_heading_wp pb10"><div class="summery_right_archive_wrapper  absolute_heading "> <h1>'.$this->lang->line('titleCreateNewTip').'</h1> </div></div>';
if($this->session->flashdata('error')){ ?> 
<div class="error">
<?php echo $this->session->flashdata('error');?>
</div>
<?php }
echo '<div class="edit_post_wp">'  .'';
echo '
'.form_open(SITE_AREA_SETTINGS.'manage_cms/submit_cms', 'class="form"').'

<div class="page_list">
	<ul class="ul_relative">
		<div class="">
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('sectionTitle').' </label>
			</div>
			<li>'.form_input($Title).'</li>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('pageKey').' </label>
			</div>
			<li>'.form_input($pageKey).'</li>
			
			<div id="oneLineDescription" class="label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('enterDescription').' </label>
			</div>
			<div class="frm_element_wrapper NIC">		
				<div class="sales_infmn">
					<div id="myNicPanel">
					</div>
					<div id="descriptionPanelDiv" class="cell frm_element_wrapper NIC minHeight300px" >
					'.form_textarea($Description).'
					</div>
				</div>
			</div>';
	
		echo '<li>
		<div class="seprator_9"></div>
		 <div class="tds-button fr">
						<input type="submit" value="Save" name="save">
						<input type="button" value="Cancel" onClick="history.go(-1);" class="canclebtn">
					</div>';
		
		echo '
        <div class="clear">&nbsp;</div>
		</li>
		</div>
	</ul>
</div>
</div>
'.form_close().'';
?>
