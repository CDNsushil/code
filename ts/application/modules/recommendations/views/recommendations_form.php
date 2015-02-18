<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$formName='recommendationForm';
	$formAttributes = array(
		'name'=>$formName,
		'id'=>$formName
	);
    
    $recommendationsInput = array(
        'id'	=> 'recommendations',
        'name'	=> 'recommendations',
        'class'	=> 'mt20 width480 bdr_bbb fl required ',
        'rows' => 3,
        'placeholder'=>'Recommendations*',
        'onclick'      =>  "placeHoderHideShow(this,'Recommendations*','hide')",
        'onblur'       =>  "placeHoderHideShow(this,'Recommendations*','show')",
        'wordlength'=>'3,50',
		'onkeyup'=>"checkWordLen(this,50,'recommendationsLimit')",
        'cols' => 45,
        'value'=>''
    );
	
	$to_useridInput = array(
		'name'	=> 'to_userid',
		'id'	=> 'to_userid',
		'value'	=> $to_userid,
		'type'	=> 'hidden'
	);
	$is_show_in_showcaseInput = array(
		'name'	=> 'is_show_in_showcase',
		'id'	=> 'is_show_in_showcase',
		'value'	=> (isset($is_show_in_showcase) && ($is_show_in_showcase == 't'))?'t':'f',
		'type'	=> 'hidden'
	);
	$is_show_in_cvInput = array(
		'name'	=> 'is_show_in_cv',
		'id'	=> 'is_show_in_cv',
		'value'	=> (isset($is_show_in_cv) && ($is_show_in_cv == 't'))?'t':'f',
		'type'	=> 'hidden'
	);
	$is_show_in_workrequestclassifiedInput = array(
		'name'	=> 'is_show_in_workrequestclassified',
		'id'	=> 'is_show_in_workrequestclassified',
		'value'	=> (isset($is_show_in_workrequestclassified) && ($is_show_in_workrequestclassified == 't'))?'t':'f',
		'type'	=> 'hidden'
	);
    
    $creative_name = (isset($name))?$name:'';
    if(empty($creative_name)){
        $userInfo =showCaseUserDetails($to_userid);
        if($userInfo['enterprise']=='t'){
            $creative_name= $userInfo['enterpriseName'];
        }else{
            $creative_name= $userInfo['userFullName'];
        }
    }
?>

		<?php echo form_open(base_url(lang().'/recommendations/postrecommendations'),$formAttributes);
			echo form_input($to_useridInput); 
			echo form_input($is_show_in_showcaseInput); 
			echo form_input($is_show_in_cvInput); 
			echo form_input($is_show_in_workrequestclassifiedInput); 
			?>
            <div class="poup_bx width500 shadow">
                <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
                    <div id="recommendationsFormDiv" class="row">
                        <div class=" text_alignR pr15 clr_666 fs16"><?php echo $creative_name; ?></div>
                        <h3 class="red fs21  text_alighC pb10"><?php echo $this->lang->line('recommend'); ?></h3>
                        <div class="bdrb_afafaf"></div>
                        <div class="sap_20"></div>
                        
                        <div class="clearb display_inline_block"> 
                            <div class="clearb">  <?php echo form_textarea($recommendationsInput); ?>
                                <span class="red pl10 fs13 fshel_midum">3 - 50 words</span>
                                <span class="red pr10 fr fs13 fshel_midum">
                                    <span id="recommendationsLimit">0</span>
                                    <span>words</span>
                                </span>
                            </div>
                        </div>
                        
                        <button  id="saveButtonreview" type="submit" name="submit"><?php echo $this->lang->line('suggestionSubmit');?></button>
                 </div>
             </div>
 
        <?php echo form_close(); ?>       
        
<script>
	$(document).ready(function(){	
		$("#recommendationForm").validate({
			  submitHandler: function() {
				$('#searchResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading.gif" />');
				var fromData=$("#recommendationForm").serialize();
				$.post(baseUrl+language+'/recommendations/postrecommendations',fromData, function(data) {
				  if(data){
					 $('#recommendationsFormDiv').html("<div class='p15'>"+data+"</div>");
				  }
				});
			 }
		});
	});
	
$('.parent').hover(function(){
$(this).find('.orange_clr_imp').toggleClass('gray_color')
});
</script>
