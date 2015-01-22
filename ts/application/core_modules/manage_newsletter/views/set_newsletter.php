<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!--add script for Editor -->
<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['html','save','bold','italic','underline','left','center','right','justify','ol','ul','fontSize','fontFamily','fontFormat','indent','outdent','subscript','superscript','strikethrough','removeformat','hr','image','link','unlink','forecolor','xhtml']});
		
		myNicEditor.panelInstance('mBody');
	});
	$(function () {
		$('#newsletterDate').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
	});
</script>
<!--End Editor script -->

<?php
/* Set header text */
echo '<div class="frm_heading_wp pb10"><div class="summery_right_archive_wrapper  absolute_heading "> <h1>'.$form_heading.'</h1> </div></div>
<div class="seprator_25"></div>
';
if($this->session->flashdata('error')){ ?> 
<div class="error">
<?php echo $this->session->flashdata('error');?>
</div>
<?php }
echo '<div class="edit_post_wp fl">'  .'';

$formAttributes = array(
	'name'=>'setNewsletterForm',
	'id'=>'setNewsletterForm',
);
$toUser = array(
	'name' 		=> 'toUser',
	'id' 		=> 'toUser',
	'type' 		=> 'text',
	'class' 	=> 'textbox width600px required',
	'value'	    => '',
	'readonly'	=> true
);
$title = array(
	'name' 		=> 'title',
	'id' 		=> 'title',
	'type' 		=> 'text',
	'class' 	=> 'textbox width600px required',
	'value'		=> (isset($newsletter->title) && !empty($newsletter->title))?$newsletter->title:'',
	
);
$mBody = array(
	'name' 		=> 'mBody',
	'id' 		=> 'mBody',
	'size'		=> 30,
	'cols'		=> 70,
	'rows'		=> 22,
	'class'     => 'formTip textarea width669px  frm_Bdr required',
	'value'     =>  (isset($newsletter->content) && !empty($newsletter->content))?$newsletter->content:'',
	
);
// set newsletter date formate 
if($newsletter->newsletterDate!='')
	$newsletterDate = date('F Y',strtotime($newsletter->newsletterDate));
else
	$newsletterDate = '';
	
$newsletterDateInput = array(
	'name'	=> 'newsletterDate',
	'id'	=> 'newsletterDate',
	'type' 	=> 'text',
	'class' => 'textbox date-input required',
	'value' =>  $newsletterDate,
	'readonly' =>true
);

$newsletterId = array(
	'name' 		=> 'newsletterId',
	'id' 		=> 'newsletterId',
	'type' 		=> 'hidden',
	'value'		=> (isset($newsletter->id) && !empty($newsletter->id))?$newsletter->id:'',
	
);

echo ''.form_open(base_url(SITE_AREA_SETTINGS.'manage_newsletter/save_newsletter'),$formAttributes).'
<div id="mailSuccessMsg" class="f16 ml34 orange_color fm_os tac"></div>
<div class="page_list width_530px">
	<ul class="ul_relative">
		<div id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic b"> '.$this->lang->line('newsletter_title').' </label>
		</div>
		<li>'.form_input($title).'</li>
		
		<li id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic b"> '.$this->lang->line('newsletter_date').' </label>
		</li>
		<li>'.form_input($newsletterDateInput).'</li>
		
		<div id="oneLineDescription" class="label_wrapper_topic">
			<label class="select_field_topic b"> '.$this->lang->line('newsletter_content').' </label>
		</div>
		<li>
			<div class=" cell frm_element_wrapper NIC width635px">		
				<div class="sales_infmn" style="padding:0px;">
					<div id="myNicPanel" style="width: 630px;">
					</div>
					<div id="mBodyPanelDiv" class="cell frm_element_wrapper NIC minHeight300px" >
					'.form_textarea($mBody).'
					</div>
				</div>
			</div>
			<div id="replErrorMsg"></div>
		</li>
		
		<div class="clear"></div>
		 <div class="seprator_30"></div>  
		 <div>'.form_input($newsletterId).'</div>
		';
		
	echo '<li> <div class="tds-button width300px mr-280 fr">
					<div class="tds-button Fleft"><button class="dash_link_hover" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" value="Send" name="submit" type="submit" id="SubmitButton"><span><div class="Fleft">Save</div> <div class="icon-save-btn"></div></span></button></div>
						
					<div class="tds-button Fleft"><button onClick="history.go(-1);" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" class="cancel dash_link_hover" type="button" id="cancelButton"><span><div class="Fleft">Cancel</div> <div class="icon-form-cancel-btn"></div></span></button></div>
				</div>';
	
	echo '
        <div class="clear"></div>  
	</li>
</div>

</ul>
</div>
'.form_close().'';
?>

<!--<div class="row fr width330px bg_dropshedow pb10 bg_white mr50"><?php //$this->load->view('add_user',array('users'=>$users));?></div>-->
<script type="text/javascript">
	/*Function to send mail to users */
	$(document).ready(function(){
		$("#setNewsletterForm").validate({
			submitHandler: function(form) {
				body = $('.nicEdit-main').html().replace(/^\s+|\s+$/g,"");
				if(body.replace('<br>','')==''){
					$('#replErrorMsg').html('This is required field');
					$('#mBodyPanelDiv').addClass('error_div_border');
					return false;
				}else{
					$('#replErrorMsg').html('');
					$('#mBodyPanelDiv').removeClass('error_div_border');
					//$("#composeMailForm").submit();
					form.submit();
				}
			}
		});
	});

</script>

