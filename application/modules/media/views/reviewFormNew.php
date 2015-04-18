<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    
    $lang=lang();
    
    //$industryId=0;	
    $languageId=0;
    $required='required';
    $entityId=(!empty($entityId)) ? $entityId : 0;
    $elementId=(!empty($elementId)) ? $elementId : 0;	
    $projectID = (!empty($projectId))?$projectId:$elementId;
    $section  = (!empty($section)) ? $section : '' ;
    $projName =  (!empty($enterPriseName)) ? $enterPriseName : '' ;
    $industryId = (!empty($industryId)) ? $industryId : '' ;

    
    $formAttributes = array(
        'name'=>'uploadmediaForm',
        'id'=>'uploadmediaForm',
        'toggleDivForm'=>'uploadElementForm'
    );
    
    $title = array(
        'name'	=> 'articleTitle',
        'id'	=> 'articleTitle',	
        'class'	=> ' width480 bdr_bbb fl required',
        'value'	=> '',
        //'minlength'	=> 2,
        'onclick'      =>  "placeHoderHideShow(this,'Title*','hide')",
        'onblur'       =>  "placeHoderHideShow(this,'Title*','show')",
        'placeholder'  =>  "Title*",
        'maxlength'	  => 50
    );
    $articleSubjectInput = array(
        'name'	=> 'articleSubject',
        'id'	=> 'articleSubject',	
        'type'	=> 'hidden',
        'value'	=> $projName,
        //'minlength'	=> 2,
        'maxlength'	=> 50
    );
    
    
    $wordCountInput = array(
        'name'	=> 'wordCount',
        'id'	=> 'wordCount',	
        'class'	=> ' width_80 mt20 bdr_bbb fl number valid',   
        'value'	=> '',
        'placeholder'=>'Word Count*',
        'onclick'      =>  "placeHoderHideShow(this,'Word Count*','hide')",
        'onblur'       =>  "placeHoderHideShow(this,'Word Count*','show')",
        'maxlength'	=> 11
    );
    
    $projectId = array(
        'name'	=> 'projectid',
        'type'	=> 'hidden',
        'id'	=> 'projectid',
        'value'	=> $projectID
    );
    $elementId = array(
        'name'	=> 'elementId',
        'id'	=> 'elementId',
        'type'	=> 'hidden',
        'value'	=> $elementId
    );
    $entityId = array(
        'name'	=> 'entityId',
        'id'	=> 'entityId',
        'type'	=> 'hidden',
        'value'	=> $entityId
    );
    
        
    $articleInput = array(
        'id'	=> 'article',
        'name'	=> 'article',
        'class'	=> 'mt20 width480 bdr_bbb fl required '.$required,
        'rows' => 3,
        'placeholder'=>'Review*',
        'cols' => 45,
        'value'=>''
    );
    
    $industryId = array(
        'id'	=> 'industryId',
        'name'	=> 'industryId',	
        'type'	=> 'hidden',
        'value'	=> $industryId
    );
    
    
    $editProjectId = array(
        'name'	=> 'editProjectId',
        'type'	=> 'hidden',
        'id'	=> 'editProjectId',
        'value'	=> ''
    );
    
    $editElementId = array(
        'name'	=> 'editElementId',
        'type'	=> 'hidden',
        'id'	=> 'editElementId',
        'value'	=> ''
    );
    
    $isEdit = array(
        'name'	=> 'isEdit',
        'type'	=> 'hidden',
        'id'	=> 'isEdit',
        'value'	=> ''
    );

//$userId=isLoginUser();
//$isProject = isReviewProject($userId);	
$isProject = (isset($isProject))?$isProject:'';
?>
<?php echo form_open_multipart($this->uri->uri_string(),$formAttributes); 	?>	
<div class="poup_bx width500 shadow">
    <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
    <div class=" text_alignR pr15 clr_666 fs16"><?php echo $section; ?></div>
    <h3 class="">Review</h3>
    <div class="sap_20"></div>
    <div class=" font_bold  fs16 mb15"><?php echo $projName; ?></div>
    <div class="clearb display_inline_block"> 
       <div class="clearb"> <?php echo form_input($title); ?></div>
      
        <div class="clearb">  <?php echo form_textarea($articleInput); ?></div>
      
        <div class="clearb"> <?php echo form_input($wordCountInput);?></div>
    </div>
    <div class="popup_msgbox_bottom open_sans mt20  fs12 clearb">
       <p>After you save your Review you need to go to your <?php echo $section; ?> Dash to edit and
          publish it.
       </p>
      
    </div>
    <button  id="saveButtonreview" type="submit" name="submit">Submit</button>
 </div>
<?php
    echo form_input($projectId);
    echo form_input($elementId);
    echo form_input($entityId);
    echo form_input($industryId);
    echo form_input($articleSubjectInput);
    echo form_input($isEdit);
    echo form_input($editProjectId);
    echo form_input($editElementId);
    
    //-------form close -------//
    echo form_close(); 
?> 
 <script>
    //selectBox();
    $(document).ready(function(){

            $("#uploadmediaForm").validate({

                messages: {
                wordCount: "Please enter a number."
                },			
                submitHandler: function() {					

                    var fromData=$("#uploadmediaForm").serialize();

                    $.post(baseUrl+language+'/media/updateReview',fromData, function(data) {
                        if(data){
                            
                            openLightBox('popupBoxWp','popup_box','/media/reviewsavedpopup',data.projId,data.elemId);							
                            
                            $('#showButton').removeClass('dn');
                            $('#showButtons').addClass('dn');
                            
                            $('#showButtonsFirst').removeClass('dn');
                            $('#showButtonsFirsts').addClass('dn');
                            

                            $('#showLink').attr('href','<?php echo base_url() ?>media/reviews/editProject/uploadMedia/'+data.projId +'/'+data.elemId);

                            
                            $('#isEdit').val('1');
                            $('#editProjectId').val(data.projId);
                            $('#editElementId').val(data.elemId);

                            $('#msg').html(data.msg);
                            
                            $("#msg").show().delay(5000).fadeOut();
                          
                            
                            
                            // $("#uploadElementForm").html('<div class="width_280 minHeight54px">'+ data +'</div>');
                        }

                    },"json" );				

                }
            });

            /*
            //Close form when click on cancel button

                $('#AjaxcancelButtonreview').click(function(){

                    $('#popup_box').trigger('close');	
                });

            $('#showLink').click(function(){

                $('#popup_box').trigger('close');

            });*/

    });


    </script>
