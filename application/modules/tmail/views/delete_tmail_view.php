<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    if(isset($data->id) && !empty($data->id)){
        $nextContId = getUserNextTmail($data->id,$curentUid,$type);
        $prevContId = getUserPrevTmail($data->id,$curentUid,$type);
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



    $formAttributes = array(
    'name'=>'viewTmailList',
    'id'=>'viewTmailList'
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
            
            $actionMenu = ($type=="Sent")?"menu2":"menu3";
            //-----load common header of tmail-----//
            $innerHeaderArray   =   array(
                'isCompose'     =>  true,
                'actionMenu'    =>  'menu3',
            );
            $this->load->view('tmail_common_inner_header',$innerHeaderArray);
        ?>
      <div class="sap_25"></div>
        <?php echo form_open(base_url(lang().'/tmail/replyTmail'),$formAttributes); 

            //echo "<pre>";
            //print_r($data);

            ?>

            <input type="hidden" id="currentRecordId" name="currentRecordId" value="<?php echo $data->status_id; ?>" />	
            <input type="hidden" id="nextRecordId" name="nextRecordId" value="<?php echo $nextRecord; ?>" />
            <input type="hidden" id="viewType"name="viewType" value="<?php echo $type; ?>" />							
            <input type="hidden" id="subject" name="subject" value="<?php echo $data->subject; ?>" />
            <input type="hidden" id="reply_msg_id" name="reply_msg_id" value="<?php echo $data->id; ?>" />
            <input type="hidden" id="receiverid" name="receiverid" value="<?php echo $data->sender_id; ?>" />
            <input type="hidden" id="body" name="body" value="<?php echo htmlspecialchars($data->body); ?>" />
            <input type="hidden" name="userName" value="<?php echo isGetUserName($data->tdsUid);?>" />
            <input type="hidden" name="threadId" value="<?php echo $data->thread_id;?>" />
            <input type="hidden" name="msgType" value="<?php echo $data->type;?>" />
             
              <div class="fl width770">
                 <div class="fl width_65  text_alignR pr20 fs13 clr_888">
                    <label class="pt18 fr clearbox">Subject</label>
                    <label class="pt15 fr clearbox">
                        <?php if($data->is_sender!='t') { ?>From
                        <?php }else { ?>
                        To
                        <?php } ?>
                    </label>
                 </div>
                 <div class="width677 position_relative bdr_b5b5b5 pb20  mb25 fr " >
                    <div class="bg_f7f7f7 fl pl25 pt8 pr25 pb15 width100_per">
                       <div class="clearbox ">
                          <div class="bb_F1592A pt5 pb7 "><b><?php echo  $data->subject;?></b> 
                            
                                <div class="fr">       
                                    <?php   
                                        if($nextContId != $prevContId ){ 
                                            if(($max_id==$data->id) || ($min_id==$data->id)) 
                                            {

                                                if($min_id==$data->id) {  ?>                
                                                <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" class="up_arows fl common_2"></a> 
                                        <?php }

                                                if($max_id==$data->id) {  ?>				
                                                <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$nextContId[0]->id.'/'.$type) ?>" class="down_arows fl common_2"></a> 
                                  
                                          <?php  }

                                            }else{

                                                if(count($prevContId) != 0 ) {?>
                                                <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" class="up_arows fl common_2"></a> 
                                          <?php  }

                                                if(count($nextContId) != 0 ) { ?>				
                                                <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$nextContId[0]->id.'/'.$type) ?>" class="down_arows fl common_2"></a> 
                                        <?php    }
                                            }
                                        }
                                    ?>
                                </div>
                           </div>
                          <div class="pt7 fs13"> <?php echo isGetUserName($data->tdsUid);?><span class="fr red"><?php echo dateFormatView($data->cdate,$fmt = 'd F Y');?></span> </div>
                       </div>
                    </div>
                    <div class="pr25 pl25 fs13 letter_spP7">
                       <div class="sap_25"></div>
                                 <iframe class="brd_none" onload="iframeLoaded()" id="ifr" src="<?php echo base_url_lang("tmail/showtmailbody/".$data->id); ?>" height="100%" width="100%" ></iframe>
                       <div class="sap_55"></div>
                       
                    </div>
                 </div>
                 <div class="width677 fr">
                    <button type="button" class="fr  print_btn">Print </button>
                    <button type="button" onclick="deletTmailPopup();" class="mr10 fr">Delete </button>
                 </div>
              </div>
              
              <?php echo form_close(); ?>
             
     
       <?php $this->load->view('right_tmail_view'); ?>
   </div>
</div>

<script>
    function iframeLoaded() {
        var iFrameID = document.getElementById('ifr');
        if(iFrameID) {
            // here you can make the height, I delete it first, then I make it again
            iFrameID.height = "";
            iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
        }   
    }
</script>
