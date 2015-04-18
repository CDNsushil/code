<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
$lang           =   lang(); // get current selected language
$mediaFileForm  =   array(
    'name'      =>  'mediaFileForm',
    'id'        =>  'mediaFileForm'
);
// set base url
$baseUrl = formBaseUrl();
// set delete content and add space url for add space popup
$deleteContentUrl = $baseUrl.'/editproject/'.$projectId;
$addSpaceUrl = $baseUrl.'/membershipcart/'.$projectId;
$addSpaceNote = $this->lang->line('addSpaceMembershipNote');
if($subscriptionType == 1) {
	$deleteContentUrl = base_url(lang().'/showcase/editshowcase');
	$addSpaceUrl = base_url(lang().'/showcase/membershipcart');
	$addSpaceNote = $this->lang->line('addSpaceMediaNote');
}

if($containerInfo['remainingSize'] > 0) { ?>

	<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
		<div class="TabbedPanelsContent width635 m_auto clearb TabbedPanelsContentVisible">
			<?php echo form_open($this->uri->uri_string(),$mediaFileForm); ?>
				<div class="c_1 clearb">
					<?php 
					//load file upload form
					$this->load->view("form/upload_file_form");
					?>
			   </div>
			<?php  echo form_close(); ?>
			<!-- Form buttons -->
			<?php 
			if($projData->projSellstatus == 't' && $projData->hasDownloadableFileOnly != 0 && $projRes->sellPriceType != 3 && $indusrtyName != 'educationMaterial') {
				// get session value of edit media mode
				$isEditMedia = $this->session->userdata('isEditMedia');
				if(!empty($isEditMedia)) {
					// set back page url
					$backPageUrl = '/editproject/'.$projectId;
				} else {
					// set back page url
					$backPageUrl = '/sellersetting/'.$projectId;
				}
				// set back page
				$data['backPage'] = $backPageUrl;
			} elseif(($projData->hasDownloadableFileOnly == 0 && $projData->elementType == 0) || $indusrtyName == 'educationMaterial') {
				// set back page
				$data['backPage'] = '/uploadform/'.$projectId.'/'.$elementId;
			}
			// set next form name
			//$data['formName'] = 'mediaFileForm/'.$projectId.'/'.$elementId;
			$data['formName'] = 'mediaFileForm';
			if($fileId > 1) {
				//set skip page
				$skipPage = '/setdisplayimage/'.$projectId.'/'.$elementId;
				if($indusrtyName == 'photographyNart') {
					$skipPage = '/uploadtitle/'.$projectId.'/'.$elementId;
				}
				$data['skipPage'] = $skipPage;
			} else {
				$data['isSkipstep'] = 1;
			}
			
			$this->load->view('common_view/upload_buttons',$data);
			?>
		</div>
	</div>
	<script type="text/javascript">
		$(document).ready(function() {
			$("#mediaFileForm").validate({
				submitHandler: function() {
					var fromData=$("#mediaFileForm").serialize();
					var fileVal = $('#fileName1').val();
					var embeddVal = $('#embbededURL1').val();
					if(fileVal == '' && embeddVal == '') {
						customAlert('Please upload file.');
						return false;
					}
				}
			});
		});
	</script>
		
<?php } else { ?>
   <!-- Display Add space popup if container space is finished-->
	<script type="text/javascript">
	$( window ).load(function() {
		var addspaceNote = '<?php echo $addSpaceNote;?>';
		var subscriptionType = '<?php echo $subscriptionType;?>';
		
		var msgHtml = '<div class="poup_bx width410 shadow fshel_midum">';
		msgHtml += '<div class="close_btn position_absolute "  onclick="$(this).parent().trigger(\'close\');"></div>';
		msgHtml += '<h3 class="">You need more storage space </h3>';
		msgHtml += '';
		msgHtml += '<P class="text_alighL mt20 fs14 lineH19" >You do not have enough Storage Space to upload this. You either need to delete something from this section of your Showcase or buy more space. </P>';
		msgHtml += ' <ul class=" display_table clearb defaultP fl mb10 mt10">';
		msgHtml += '<li><label class="mb10"><input  type="radio" name="addSpaceOption" value="1" checked > '+addspaceNote+' </label></li>';
		msgHtml += '<li><label><input  type="radio" name="addSpaceOption" value="2"  > Delete Content from this Section</label></li></ul>';
		if(subscriptionType > 1) {
			msgHtml += '<p class="or_text ml10">OR </p>';
			msgHtml += '<p class="mb10 ml15">Go to your Toadsquare menu and delete content.<br/> You can delete content in a section by selecting edit.</p>';
		}
		msgHtml += '<div class="fr mt40 mb10">';
		msgHtml += '<button type="button" class="bdr_bbb nextStep">Next</button>';
		msgHtml += '</div>';
		msgHtml += '</div>';
		
		$("#popup_box").show();
		$("#popup_box").html(msgHtml);
		$('#popupBoxWp').lightbox_me({
		  centered: true, 
		  closeEsc:false,
		  closeClick:false,
		  onLoad: function() {radioCheckboxRender();}	
		});
		
		$('.nextStep').click(function () {
			var addSpaceOption = $('input:radio[name=addSpaceOption]:checked').val();
			
			if(addSpaceOption == 2) {
				var nextStageUrl = '<?php echo $deleteContentUrl;?>';
			} else {
				var nextStageUrl = '<?php echo $addSpaceUrl;?>';
			}
			window.location.href = nextStageUrl;
			
		});
	});
	</script>
	<?php
}?>	


