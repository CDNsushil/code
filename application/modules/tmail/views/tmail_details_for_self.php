<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
'name'=>'viewTmailList',
'id'=>'viewTmailList'
);	

if(isset($mailThreadData[0]['id']) && !empty($mailThreadData[0]['id'])){
	$nextContId = getUserNextTmail($mailThreadData[0]['id'],$curentUid,$type);
	$prevContId = getUserPrevTmail($mailThreadData[0]['id'],$curentUid,$type);
}

$max_id;
$min_id;

if( isset($nextContId[0]->id) && ($nextContId[0]->id!='') ){
	$nextRecord = $nextContId[0]->id;
}
elseif( isset($prevContId[0]->id) && ($prevContId[0]->id!='') ){
	$nextRecord = $prevContId[0]->id;	
}else {
	$nextRecord = 0;	
}
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
            
            $actionMenu = ($type=="Inbox")?"menu1":"menu3";
            //-----load common header of tmail-----//
            $innerHeaderArray   =   array(
                'isCompose'     =>  true,
                'actionMenu'    =>  $actionMenu,
            );
            $this->load->view('tmail_common_inner_header',$innerHeaderArray);
        ?>
        <?php
            //print_r($mailThreadData);
            echo form_open(base_url(lang().'/tmail/replyTmail'),$formAttributes); ?>

            <input type="hidden" id="currentRecordId" name="currentRecordId" value="<?php echo $mailThreadData[0]['pr_id']; ?>" />
            <input type="hidden" id="nextRecordId" name="nextRecordId" value="<?php echo $nextRecord; ?>" />
            <input type="hidden" id="viewType"name="viewType" value="<?php echo $type; ?>" />
            <input type="hidden" id="subject" name="subject" value="<?php //echo $data->subject; ?>" />
            <input type="hidden" id="reply_msg_id" name="reply_msg_id" value="<?php echo $mailThreadData[0]['pr_id']; ?>" />
            <input type="hidden" id="receiverid" name="receiverid" value="<?php //echo $data->sender_id; ?>" />
            <input type="hidden" id="body" name="body" value='<?php //echo htmlspecialchars($data->body); ?>' />
            <input type="hidden" name="userName" value="<?php //echo $data->firstName.' '.$data->lastName ;?>" />
            <input type="hidden" name="threadId" value="<?php //echo $data->thread_id;?>" />
            <input type="hidden" name="msgType" value="<?php //echo $data->type;?>" />

      <div class="sap_25"></div>
      <div class="fl width765">
         <div class="fl width_65  text_alignR pr20 fs13 clr_888">
            <label class="pt20 fr clearbox">Subject</label>
            <label class="pt15 fr clearbox">From </label>
         </div>
         <div class="width677 position_relative bdr_b5b5b5  mb25 fl " >
            <div class="bg_f7f7f7 fl pl25 pt8 pr25 pb10 width100_per">
               <div class="clearbox ">
                  <div class="bb_F1592A pt10 pb5 "><b><?php echo $mailThreadData[0]['subject']; ?>	</b> 
                  
                    <div class="fr">   
                        
                       
                        <?php   
                            if($nextContId != $prevContId ){ 
                                if(($max_id==$mailThreadData[0]['id']) || ($min_id==$mailThreadData[0]['id'])) 
                                {
                                    if($min_id==$mailThreadData[0]['id'] && isset($prevContId[0]->id )) {  ?>                
                                    <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" class="up_arows fl common_2"></a> 
                            <?php }

                                    if($max_id==$mailThreadData[0]['id'] && isset($nextContId[0]->id )) {  ?>				
                                    <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$nextContId[0]->id.'/'.$type) ?>" class="down_arows fl common_2"></a> 
                              <?php  }

                                }else{

                                    if(count($prevContId) != 0 && isset($prevContId[0]->id )) {?>
                                        <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" class="up_arows fl common_2"></a> 
                              <?php  }

                                    if(count($nextContId) != 0 && isset($nextContId[0]->id) ) { ?>				
                                       <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$nextContId[0]->id.'/'.$type) ?>" class="down_arows fl common_2"></a> 
                            <?php    }
                                }
                            }
                        ?>
                        
                    </div>
                  </div>
                  <div class="pt7 fs13"> <?php echo 'Toadsquare';?> <span class="fr red"><?php echo dateFormatView($mailThreadData[0]['cdate'],$fmt = 'd F Y');?></span> </div>
               </div>
            </div>
            <div class="pr25 pl25">
               
                    
                         <iframe class="brd_none" onload="iframeLoaded()" id="ifr" src="<?php echo base_url_lang("tmail/showtmailbody/".$mailThreadData[0]['id']); ?>" height="100%" width="100%" ></iframe>
               
                    <?php
                        //Set attachment of tmail start here
                         if(!empty($attachmentData->fileId) && !empty($attachmentData->filePath) && !empty($attachmentData->fileName) && file_exists(ROOTPATH.$attachmentData->filePath.$attachmentData->fileName)) {?>
                                    
                            <p class="fr red mb25">    
                                <a  href="<?php echo base_url().$attachmentData->filePath.$attachmentData->fileName;?>" original-title="Download" download="<?php echo $attachmentData->rawFileName;?>">
                                  <button class="fr red send_profile" type="button">Send Work Profile </button>
                                </a>
                             </p>   
                             
                        <?php }
                        //Set attachment of tmail end here
                        ?>
                            
                       

            </div>
            
         </div>
         <span class="sap_10"> </span>
         <button class="fr  print_btn" type="button">Print </button>
         <button class="mr10 fr" type="button" onclick="deletTmailPopupSelf()">Delete </button>
      </div>
        
        <?php echo form_close(); ?>
            
        <?php $this->load->view('right_tmail_view'); ?>
      
   </div>
</div>

<script type="text/javascript">
    function deletTmailPopupSelf(){
        
        confirmBox("Are you sure you wish to delete?", function () {
            var val = parseInt($('#currentRecordId').val());			
            var nextRecord =parseInt($('#nextRecordId').val());
            var type = ($('#viewType').val());		

            $.ajax
            ({     
                type: "POST",
                url: "<?php echo base_url() ?>tmail/trashTmailPopupMessage/"+val+'/'+type+'/'+nextRecord,
                success: function(msg)
                {
                    window.location.href= "<?php echo base_url_lang('tmail/inbox') ?>";
                }
            });	
        });
   }

    function iframeLoaded() {
        var iFrameID = document.getElementById('ifr');
        if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
        }   
    }
</script>
