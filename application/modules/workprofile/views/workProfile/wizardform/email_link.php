<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'shareEmailForm',
    'id'=>'shareEmailForm',
);

// set base url
$baseUrl = base_url(lang().'/workprofile/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<h3><?php echo $this->lang->line('emailLinkHeader');?></h3>
		<div class="sap_20"></div>
		<p> The link is unique and valid for <?php echo $this->config->item('wp_shortlink_valid_till');?> days.  </p>
		<div class="sap_15"></div>
		<p>Allow the email recipient to see your: </p>
		<div class="sap_15"></div> 
		<?php //echo form_open($baseUrl.'/emaillink/',$formAttributes); ?>      
			<div class="defaultP"> 
				<span class="font_bold">
					<input type="checkbox" name="isSeeProfile" id="isSeeProfile" value="1"/>  Profile	
				</span>
				<span class="pl30 pr30"> and / or </span>	
				<span class="font_bold">
					<input type="checkbox" name="isSeePortfolio" id="isSeePortfolio" value="2" /> 	Portfolio
				</span> 
			</div>
			<div class="sap_35"></div>
			<div class="width520 email_wrap radius5 bc2c2c2 p20" >		
				<input class="width428 box_siz bc2c2c2 p10 maxHauto required" id="emailAddress" name="emailAddress" type="text" name="Title" placeholder="Email Address" value="" onclick="placeHoderHideShow(this,'Email Address','hide')" onblur="placeHoderHideShow(this,'Email Address','show')"> <i class="msg_box fr "></i>
				<p id="emailError" class="red fs12"></p>
				<div class="sap_20"></div>
				<textarea class="bc2c2c2 width428 box_siz p10 height_89" id="emailContent" type="text" >Please click on the link to see my Work Profile & Portfolio  </textarea>
				<button class="fr mt49" onClick="getShortLinkWp();">Email</button>
			</div> 
		<?php// echo form_close();?>		
	</div>
	<!-- Form buttons -->
	<?php 
	// set back page
	$data['backHistory'] = '1';
	// set next form 
	$data['isNextstep'] = '1';
	$data['nextPage'] = '/workprofile/addbutton';
	
	$this->load->view('workProfile/wizardform/common_buttons',$data);
	?>
</div>

<script type="text/javascript">
    
	function getShortLinkWp () {
		// check profile display types
		var isSeeProfile = $("#isSeeProfile").attr("checked") ? 1 : 0;
		var isSeePortfolio = $("#isSeePortfolio").attr("checked") ? 2 : 0;
		// get user email value
		var recipientEmail = $('#emailAddress').val();
		// get email content
		var emailContent = $('#emailContent').val();
		// set short type path
		var shortUrlType = 0;
		if (isSeeProfile > 0 && isSeePortfolio > 0) {
			shortUrlType = 1;
		} else if (isSeeProfile == 0 && isSeePortfolio > 0) {
			shortUrlType = 2;
		} else if (isSeeProfile > 0 && isSeePortfolio == 0) {
			shortUrlType = 3;
		}
		
		if( shortUrlType == 0 ) {
			alert('Please select Profile and / or  Portfolio option');
			return false;
		}
		
		// check recipient email address
		var emailFilter = /^[\w\-\.\+]+\@[a-zA-Z0-9\.\-]+\.[a-zA-z0-9]{2,4}$/;
		if (emailFilter.test(recipientEmail)) {
			$('#emailAddress').removeClass('error');
			$('#emailError').text('');
		} else {
			$('#emailAddress').addClass('error');
			var errorText = 'Invalid Email Address';
			if(recipientEmail == '') {
				errorText = ('This is a required field.');
			}
			$('#emailError').text(errorText);
			return false;
		}
		
		var url = baseUrl+language+'/workprofilefrontend/viewprofile/'+shortUrlType;
		var fromData = 'url='+url+'&recipientEmail='+recipientEmail+'&emailContent='+emailContent+'&shortUrlType='+shortUrlType;
		//loader();
		$.post("<?php echo base_url(lang().'/shortlink/workProfileShareLink') ?>",fromData, function(data) {
			if(data){
				refreshPge();
			}
		}, "json");		
	}	
    
</script>
