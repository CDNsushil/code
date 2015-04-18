<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$pressReleaseIdInput = array(			
		'name' 				=> 'pressReleaseId',
		'id' 				=> 'pressReleaseId',
		'type' 				=> 'hidden',
		'value' 			=> $id
		
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
	$newsDateInput = array(
		'name'	=> 'newsDate',
		'id'	=> 'newsDate',
        'type' 	=> 'text',
        'class' => 'textbox  date-input',
        'value' => !empty($date)?dateFormatView($date,'d F Y'):'',
		'readonly' =>true
	);
	
	$sourceInput = array(			
		'name' 				=> 'source',			
		'id' 				=> 'source',			
		'class'      		=> 'textbox frm_Bdr',
		'value' 			=> $source
	);
	
	$url = array(			
		'name' 				=> 'url',
		'id' 				=> 'url',
		'type' 				=> 'text',
		'class' 			=> 'textbox width450px url',
		'value' 			=>  $url
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
'.form_open_multipart('news/save_news', 'class="form" id="add_edit_news" name="add_edit_news" ').'

<div class="width650px fl">
	<ul class="ul_relative">
			<li id="oneLineDescription" class="cell label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('sectionTitle').' </label>
			</li>
			<li>'.form_input($titleInput).'</li>
			
			<li id="oneLineDescription" class="cell label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('releaseDate').' </label>
			</li>
			<li>'.form_input($newsDateInput).'</li>
			
			<li id="oneLineDescription" class="cell label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('source').' </label>
			</li>
			<li>'.form_input($sourceInput).'</li>
			
			<li id="oneLineDescription" class="cell label_wrapper_topic">
				<label class="select_field_topic"> '.$this->lang->line('url').' </label>
			</li>
			<li>'.form_input($url).'</li>			
			
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
						<input type="button" value="Cancel" onClick="window.location.href=\''.base_url('news/listing').'\'" class="canclebtn">
					</div>';
		
		echo '
			<div class="clear">&nbsp;</div>
		</li>
	</ul>
</div>';
echo form_input($pressReleaseIdInput);
echo form_close();
$this->load->view('news_video');
$this->load->view('pressRelease/supporting_matrial',array('section'=>'news')); ?>
</div>


<script>
	$(document).ready(function(){
		$("#add_edit_news").validate({ });
	});
</script>
