<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'  =>  'newTmail',
    'id'    =>  'newTmail'
);


$composebody = array(
        'id'	=> 'body',
        'name'	=> 'body',
        'class'	=> 'width556px rz required ',
        'rows' => 12,
        'cols' => 50,
        'value'=>''
    );
    
    
$receiverMail = array(
        'name'	=> 'receiverMail',
        'id'	=> 'receiverMail',	
        'class'	=> 'Bdr width_487 required',
        'readonly' => 'readonly',			
        'value'	=>  ''		
    );	

$receiverName = array(
        'name'	=> 'receiverName',
        'id'	=> 'receiverName',	
        'class'	=> 'width620 mt5 required',
        'readonly' => 'readonly',			
        'value'	=>  (isset($receiverName))?$receiverName:''	
    );
// set subject if it comes from recommendation
$recommendationSubject = (isset($recommendationSubject)) ? $recommendationSubject :'';	
// set tmail main subject
$subject = (isset($subject) && ($subject!='')) ? $subject :$recommendationSubject;	
$subject = array(
        'name'	=> 'subject',
        'id'	=> 'subject',	
        'class'	=> 'width600 mt5 required',
        'value'	=> $subject
        
    );	

// set user's id
$recipientsId =  (isset($recipientsId))?$recipientsId:'';
// set user's email
$receiverEmail =  (isset($receiverEmail))?$receiverEmail:'';


//creaved user list view
$Information=$this->load->view('tmail/craved_user_list',array('elementId'=>''),true);

?>

<script>var rData=<?php echo json_encode($Information);?></script>

<?php 
    $function="openLightBox('popupBoxWp','popup_box','/tmail/getCravedUser')";
?>
               
<div class="row content_wrap" >
    <?php 
        //-----load common header of tmail-----//
        $dataArray= array(
            'tmailHeader'=>$this->lang->line('tmail_compose'),
            'actionMenu'=>'menu1',
        );
        $this->load->view('tmail_common_header',$dataArray);
    ?>
  <div class=" m_auto pt27 sc_album width950 ml38 display_table">
     
        <?php 
      
            //-----load common header of tmail-----//
            $innerHeaderArray   =   array(
                'isCompose'     =>  false,
                'actionMenu'    =>  'menu1',
            );
            $this->load->view('tmail_common_inner_header',$innerHeaderArray);
        ?>
      <div class="sap_30"></div>
      
        <?php echo form_open(base_url(lang().'/tmail'),$formAttributes); ?>

        <input type="hidden" name="type" value="1">
        <input type="hidden" name="recipientsId" id="recipientsId" value="<?php echo $recipientsId?>">
        <input type="hidden" name="receiverMail" id="receiverMail" value="<?php echo $receiverEmail?>">
        
        <div class="fl width765">
             <div class="fl width58  text_alignR pr25 fs13 clr_888"> <label class="pt25 fr clearbox">To</label>
             <div class="sap_65"></div>
                <label class="pt56 fr clearbox">Subject </label>
             </div>
             <div class="width680 position_relative bdr_b5b5b5 height500 mb20 fl " >
                <div class="bg_f7f7f7 fl pl25 pt8 pr10 box_siz width100_per">
                   <div class="clearbox ">
                     <div class="height55"><?php echo form_input($receiverName);  ?></div> 
                      
                      <div class="sap_5"></div>
                      <span class="fl pt12"> Search members who have creaved you or anything on your Showcase </span>
                      
                      <button type="button"   class="searchbtnbg  selectuserpopup fr">Search </button> 
                   </div>
                   
                    <p class="mb10 red height32 fs12 mt5 blankMessage" >
                        &nbsp;
                    </p>
                    <p class="mb10 red height32 fs12 dn mt5 errorMessage">
                        This member has not craved you so you can't Tmail then from here. They may have allowed other members to contact them from the Showcase HOmepage. If they have sent you a Tmail you can replay.   
                    </p>
                    <p class=" height_60"><?php echo form_input($subject); ?></p>
                   
                   
                </div>
             
                    <div id="myInstance1" class="editor_2  pt5">
                       <?php echo form_textarea($composebody); ?>
                    </div>
                    
                    <div id="replErrorMsg" ></div>	
             </div>
             <button type="submit" id="saveCompose"  class=" fr send_btn">Send </button>
             <button type="button" id="cancelCompose" class="fr mr10">Cancel </button>
        </div>
        
       <?php echo form_close(); ?>	
       
        <?php $this->load->view('right_tmail_view'); ?>
   </div>
</div>
        
<script>
    
    var cravedListCount = "<?php echo $cravedListCount; ?>"; 
    
    // instance, using default configurations.
    var editor  = CKEDITOR.replace( 'body', {
            toolbar: [
        
                { name: 'forms', items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
                    'HiddenField' ] },
                '/',
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
                { name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
                '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
                { name: 'links', items : [ 'Link','Unlink' ] },
                { name: 'styles', items : [ 'Styles','Format','Font','FontSize' ] },
	
        ]
    });


    $(document).ready(function(){
            
            $("#newTmail").validate({

                //messages: {
                //wordCount: "Please enter a number."
                //},			
                submitHandler: function() {	
                    
                   var msgbody = $("#cke_1_contents iframe").contents().find("body").text();				
                    
                   if(msgbody==''){
                        $('#replErrorMsg').html('This is required field');
                        $('#myInstance1').addClass('error_div_border');
                        return false;
                    }else{
                        $('#replErrorMsg').html('');
                        $('#myInstance1').removeClass('error_div_border');
                    }		
                    
                    var body = CKEDITOR.instances['body'].getData();
                    
                    $('#body').val(body);
                    var fromData=$("#newTmail").serialize();
                    fromData = fromData+'&ajaxHit=1';
                    
                    $.post(baseUrl+language+'/tmail/sendTmail',fromData, function(data) {
                        if(data){
                            window.location = "<?php echo base_url(lang().'/tmail'); ?>";
                        }
                    });	

                }
            });
        
        
        $('#cancelCompose').click(function() {				
            window.location.href = "<?php echo base_url(lang().'/tmail')?>";			
        });	
        
    });
    
    //open select user popup
    $(".selectuserpopup").click(function(){
        
        if(cravedListCount==0 || cravedListCount=="0"){
            $('.blankMessage').hide();
            $('.errorMessage').show();
            return false;
        }else{
            $('.blankMessage').show();
            $('.errorMessage').hide(); 
        }
        
        var userId = $('#recipientsId').val();
        openLightBox('popupBoxWp','popup_box','/tmail/getCravedUser',userId)
    });
    
    
</script>

