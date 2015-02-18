<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes = array(
'name'=>'contactForm',
'id'=>'contactForm',
);

  $contactmeMessageInput=array('name'=>'body',
    'id'              =>  'contactmeMessage',
    'value'           =>  '',
    'descLimit'       =>'contactmeMessageDescLimit',
    'class'           =>'search_box width350 bdr_bbb fl required',
    'wordlength'      =>'',
    'rows'            =>'5',
    'onclick'         =>  "placeHoderHideShow(this,'Suggestion*','hide')",
    'onblur'          =>  "placeHoderHideShow(this,'Suggestion*','show')",
    'placeholder'     =>  "Suggestion*",														 
  );
                              
$showcaseData = showCaseUserDetails($userId);
$enterpriseName = $showcaseData['enterpriseName'];
if(isset($enterpriseName) && !empty($enterpriseName)) {
	$fullName = $enterpriseName;
} else {
	$fullName = LoginUserDetails('firstName').' '.LoginUserDetails('lastName');
}

$url = base_url().uri_string();
?>

<?php echo form_open(base_url(lang().'/tmail/sendTmail'),$formAttributes); ?>
<?php echo form_hidden('currentUrl', $url); ?>  
<input type="hidden" name="recipientsId" class="required" value="<?php echo $userId;?>">	
  
<div class="poup_bx width380 shadow fshel_midum">
   <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
   <h3 class="red fs21 fnt_mouse text_alighC pb10"><?php echo $this->lang->line('suggestion&Request')?></h3>
   <div class="bdrb_afafaf"></div>
   <h3 class="title_pp fs16  fr" > <?php echo $fullName;?></h3>
   <input class="search_box width350 bdr_bbb fl required" type="text"  name="subject" id="subject" placeholder="Subject*" value="Subject*" onclick="placeHoderHideShow(this,'Subject*','hide')" onblur="placeHoderHideShow(this,'Subject*','show')">
    <?php echo form_textarea($contactmeMessageInput);	?>	
   <div class="fr mt25 mb10">
      <button type="button" class="bg_ededed bdr_b1b1b1 bdr_bbb" onclick="$(this).parent().trigger('close');"><?php echo $this->lang->line('suggestionCancel');?></button>
      <button type="button" class=" bdr_bbb" id="submitButton"><?php echo $this->lang->line('suggestionSubmit');?></button>
   </div>
</div>
    <?php echo form_close(); ?>   
   
  
<script>
	$(document).ready(function(){
		
		$("#contactForm").validate({
			  submitHandler: function() {
				var fromData=$("#contactForm").serialize();
				fromData = fromData+'&ajaxHit=1';
				$('#popup_close_btn').hide();	
				$('#contactForm').html('<img  src="<?php echo  base_url(); ?>images/loading_wbg.gif">');
				$.post(baseUrl+language+'/common/saveSuggestions',fromData, function(data) {
				  if(data){
					  $('#popup_close_btn').show();
					  $('#contactForm').html('<div class="p10 mr10"><?php echo $this->lang->line('suggestionMsg');?></div>');
				  }
				});
			 }
		});
		
		$( "#submitButton" ).click(function() {
			$( "#contactForm" ).submit();
		});
	});
</script>