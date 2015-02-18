<script type="text/javascript">
$('document').ready(function(){
	$("#app_url").attr("disabled", "disabled"); 
	$("#app_select").change(function(){
		var singleValues = $(this).find(":selected").text();
		$("#app_select").parent().find('#app_selected_text').html(singleValues);
		if(singleValues != '--Select Category--'){
				$("#app_url").removeAttr("disabled"); 
				$('.classic').hide();
			}
		else{
				$("#app_url").attr("disabled", "disabled");
				$('.classic').show();
			}
	});	
	});	
	
function watermark(inputId,text){
  var inputBox = document.getElementById(inputId);
    if (inputBox.value.length > 0){
      if (inputBox.value == text)
        inputBox.value = '';
    }
    else
      inputBox.value = text;
}
</script>

<script type='text/javascript'>
$(function () {
$("#app_url").tooltip({

		// place tooltip on the right edge
		position: "center left",

		// a little tweaking of the position
		offset: [-2, -10],

		// use the built-in fadeIn/fadeOut effect
		//effect: "fade",

		// custom opacity setting
		opacity: 0.7

	});
});
</script>
<div id="columnMidpanel">
<div class="ChangingPoints">
<b>Your Applications:</b>
		<?php //echo $this->load->view('userIntro');?>
		<a class="fRight" href="<?php echo base_url(); ?>opensocial">Back to My Apps</a> <br />
		<br />
		
	
<span class="success_message" id="success"><?php echo $this->session->flashdata('success_app');?></span>
<span class="error_message" id="error"><?php echo $this->session->flashdata('error_app');?></span>
<div>
 The OAuth consumer key and secret are automatically generated and
    unique for your profile. Normally these would be created for for a registered developer account where you register your site and/or purpose but are listed here for developer conveniance.<br><br>
    They can be used to develop an REST + (3 legged) OAuth client, if your not developing
    an Auth consuming mobile application or website, feel free to ignore these values <br><br>
    If your developing a gadget that uses the REST and/or RPC interface, you should be using the <a href="http://sites.google.com/site/oauthgoog/2leggedoauth/2opensocialrestapi" style="color: rgb(51, 102, 204);">2-legged oauth</a>
    tokens which you can find in the 'edit applications' overview of your profile.<br>
</div>   
<br/><br/>   
<table style="width:100%">
	<tr>
		<td>Oauth consumer key</td>
    	<td><?php echo ($res_key[0]->consumer_key);?></td>
	</tr>
	<tr>
		<td>Consumer secret</td>
        <td><?php echo ($res_key[0]->consumer_secret);?></td>   
    </tr>
</table>	 
        	 
</div>
</div>
<?php
//$this->template('/common/footer.php');
?>
