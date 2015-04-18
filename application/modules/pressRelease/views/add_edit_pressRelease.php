<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$pressReleaseId=$id;
	$pressReleaseIdInput = array(			
		'name' 				=> 'pressReleaseId',
		'id' 				=> 'pressReleaseId',
		'type' 				=> 'hidden',
		'value' 			=> $id
		
	);

	$videoFileInput = array(			
		'name' 				=> 'videoFile',
		'id' 				=> 'videoFile',
		'type' 				=> 'hidden',
		'value' 			=> $videoFile
		
	);
		
	$titleInput = array(			
		'name' 				=> 'title',
		'id' 				=> 'title',
		'type' 				=> 'text',
		'class' 			=> 'textbox width595px required',
		'value' 			=> $title
	);

	$descriptionInput = array(			
		'name' 				=> 'description',			
		'id' 				=> 'description',	
		'cols'				=> 65,
		'rows'				=> 20,
		'class'      		=> 'formTip textarea  frm_Bdr required',
		'value' 			=> $description
	);

	$pressReleaseDateInput = array(
		'name'	=> 'pressReleaseDate',
		'id'	=> 'pressReleaseDate',
        'type' 	=> 'text',
        'class' => 'textbox  date-input',
        'value' => !empty($date)?dateFormatView($date,'d F Y'):'',
		'readonly' =>true
	);
	
	
?>

<!--add script for Editor -->

<script type="text/javascript">
	
	bkLib.onDomLoaded(function() {
	var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','subscript','superscript','strikethrough','removeformat','hr','link','unlink','forecolor']});
	myNicEditor.panelInstance('description');
});
</script>
<!--End Editor script -->
<?php 
echo '<div class="frm_heading_wp contentcontainer"><div class="summery_right_archive_wrapper  absolute_heading "> <h1>'.$actionHeading.'</h1> </div></div>';
$validation_errors=validation_errors();
if(!empty($validation_errors)){ ?> 
	<div class="error">
	<?php echo $validation_errors; ?>
	</div>
	<?php
}elseif($this->session->flashdata('msg')){ ?>
	<div class="msgAdmin">
		<?php echo $this->session->flashdata('msg');?>
	</div>
	<?php 
}
echo '<div class="edit_post_wp">'  .'';

echo '
'.form_open_multipart('pressRelease/save_pressRelease', 'class="form" id="add_edit_pressRelease" name="add_edit_pressRelease"').'

<div class="width650px fl">
	<ul class="ul_relative">
			<li id="oneLineDescription" class="cell label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('sectionTitle').' </label>
			</li>
			<li>'.form_input($titleInput).'</li>
			
			<li id="oneLineDescription" class="cell label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('releaseDate').' </label>
			</li>
			<li>'.form_input($pressReleaseDateInput).'</li>
			
			<li id="oneLineDescription" class="cell label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('enterDescription').' </label>
			</li>
			<li class=" cell frm_element_wrapper NIC">		
				<div class="sales_infmn" >
					<div id="myNicPanel">
					</div>
					<div id="descriptionPanelDiv" class="cell frm_element_wrapper NIC " >
					'.form_textarea($descriptionInput).'
					</div>
				</div>
			</li>';
	
		echo '<li> <div class="tds-button fr pr25">
						<input type="submit" value="Save" name="save">
						<input type="button" value="Cancel" onClick="window.location.href=\''.base_url('pressRelease/listing').'\'" class="canclebtn">
					</div>';
		
		echo '
			<div class="clear">&nbsp;</div>
		</li>
	</ul>
</div>';
echo form_input($pressReleaseIdInput);
echo form_input($videoFileInput);
echo form_close();

$this->load->view('supporting_matrial',array('section'=>'pressRelease'));
?>
</div>

<script>
	$(document).ready(function(){
		$("#add_edit_pressRelease").validate({ });
	});
</script>

