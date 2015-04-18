<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
'name'=>'replyTmail',
'id'=>'replyTmail'
);


$composebody = array(
		'id'	=> 'replymsg',
		'name'	=> 'replymsg',
		'class'	=> 'width556px rz required ',
		'rows' => 12,
		'cols' => 50,
		'value'=>''
	);
	
$replyEmailId = (isset($replyEmailId) && $replyEmailId!='') ? $replyEmailId :'';	
$receiverMail = array(
		'name'	=> 'receiverMail',
		'id'	=> 'receiverMail',	
		'type'   =>'hidden',		
		'readonly' => 'readyonline',
		'value'	=> $replyEmailId		
	);	
	
$replyUserName = (isset($replyName) && $replyName!='') ? $replyName :'';	

$subject = (isset($subject) && ($subject!='')) ? $subject :'';	
$subject = array(
		'name'	=> 'subject',
		'id'	=> 'subject',	
		'class'	=> 'width600 mt5 required',
		'value'	=> 'Re: '.$subject
		
	);	
	
	
	
?>
<div class="row content_wrap" >
    <?php 
        //-----load common header of tmail-----//
        $dataArray= array(
            'tmailHeader'=>  $this->lang->line('tmail_read'),
            'actionMenu'=> 'menu1',
        );
        $this->load->view('tmail_common_header',$dataArray);
    ?>
   <div class=" m_auto pt27 sc_album width950 ml38 display_table">
        <?php 
            
            //-----load common header of tmail-----//
            $innerHeaderArray   =   array(
                'isCompose'     =>  true,
                'actionMenu'    =>  'menu1',
            );
            $this->load->view('tmail_common_inner_header',$innerHeaderArray);
        ?>
      <div class="sap_30"></div>
      <?php echo form_open(base_url(lang().'/tmail/replyTmail'),$formAttributes); ?>
      
       <input type="hidden" name="senderId" value="<?php echo $senderId ?>" >
         <input type="hidden" name="receiverid" value="<?php echo $receiverid  ?>" > 
         <input type="hidden" name="reply_msg_id" value="<?php echo $reply_msg_id  ?>" >
         <input type="hidden" name="msgType" value="<?php echo $msgType  ?>" >
         <input type="hidden" name="threadId" value="<?php echo $threadId  ?>" >
      
      <div class="fl width765">
             <div class="fl width58  text_alignR pr25 fs13 clr_888"> <label class="pt25 fr clearbox">To</label>
                <label class="pt20 fr clearbox">Subject </label>
             </div>
             <div class="width680 position_relative bdr_b5b5b5 height435 mb20 fl " >
                <div class="bg_f7f7f7 fl pl25 pt8 pr10 pb20 width100_per">
                  
                    <div class="clearbox pb10 ">
                        <div class="bb_F1592A pt5 pb7 ">
                            <?php echo form_input($receiverMail);  ?>
                            <b><?php echo $replyrName ?></b>
                            <span class="fr red"><?php echo dateFormatView($messageData->cdate,$fmt = 'd F Y');?></span>
                        </div>
                    </div>
                   
                    <p class=" height_55"><?php echo form_input($subject); ?></p>
                  	
                   
                </div>
                
                <div id="myInstance1" class="editor_2 pt5">
                    <?php echo form_textarea($composebody); ?>
                </div>

                <div id="replErrorMsg"></div>
             </div>
             <button type="submit" id="saveCompose"  class=" fr send_btn">Send </button>
             <button type="button" id="cancelCompose" class="fr mr10">Cancel </button>
             
             <?php $data['mailThreadData'] = $mailThreadData;
			 $this->load->view('show_thread',$data); ?>
        </div>
        
        <?php echo form_close(); ?>	
        
      <?php $this->load->view('right_tmail_view'); ?>
   </div>
   
</div>

<script type="text/javascript">
    // instance, using default configurations.
    var editor  = CKEDITOR.replace( 'replymsg', {
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
    
     $("#replyTmail").validate({

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
                
                var body = CKEDITOR.instances['replymsg'].getData();
               
                $('#replymsg').val(body);
                
                var fromData=$("#replyTmail").serialize();
                fromData = fromData+'&ajaxHit=1';
                
                $.post(baseUrl+language+'/tmail/saveReplyTmail',fromData, function(data) {
                    if(data){
                        $('#replymsg').val(' ');
                        window.location.href = "<?php echo base_url(lang().'/tmail/viewTmail/'.$reply_msg_id.'/'.$viewType)?>";
                    }
                });	

            }
        });
        
    $('#cancelCompose').click(function() {			
        history.go(-1);			
    });	
    
</script>

