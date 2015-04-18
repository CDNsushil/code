<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


$formAttributes = array(
    'name'=>'viewTmailList',
    'id'=>'viewTmailList'
);	

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
          <div class="sap_25"></div>
          
    <?php echo form_open(base_url(lang().'/tmail/replyTmail'),$formAttributes); ?>

        <input type="hidden" id="currentRecordId" name="currentRecordId" value="<?php echo $data->status_id; ?>" />
        <input type="hidden" id="nextRecordId" name="nextRecordId" value="<?php echo $nextRecord; ?>" />
        <input type="hidden" id="viewType"name="viewType" value="<?php echo $type; ?>" />
        <input type="hidden" id="subject" name="subject" value="<?php echo $data->subject; ?>" />
        <input type="hidden" id="reply_msg_id" name="reply_msg_id" value="<?php echo $data->id; ?>" />
        <input type="hidden" id="receiverid" name="receiverid" value="<?php echo $data->sender_id; ?>" />
        <input type="hidden" id="body" name="body" value='<?php echo htmlspecialchars($data->body); ?>' />
        <input type="hidden" name="userName" value="<?php echo isGetUserName($data->tdsUid); ?>"/>
        <input type="hidden" name="threadId" value="<?php echo $data->thread_id;?>" />
        <input type="hidden" name="msgType" value="<?php echo $data->type;?>" />
        
                <?php
                //print_r($data);

                if($data->type==5) { ?>

                        <div class="row">
                            <div class="">
                                <div class="clr_666 font_opensans"><?php //echo $this->lang->line('showOnKeyPersonelShowcase');?></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <?php
                        $subjectLebel= $this->lang->line('request');
                        $where=array('msgid'=>$data->id,'senderid'=>$data->sender_id,'receiverid'=>isloginUser());
                        $showResult=showProjectDetails($where);
                        
                        if($showResult){
                            $projName=$showResult->title;
                            $projId=$showResult->elementid;
                            $projUser=$showResult->userid;
                            $section=$showResult->section;
                            $projectType=$showResult->projectType;
                            if($projectType=='filmNvideo')$projLink=base_url(lang().'/mediafrontend/mediashowcases/'.$projUser.'/'.$projId);
                            elseif($projectType=='musicNaudio')$projLink=base_url(lang().'/mediafrontend/aboutalbum/'.$projUser.'/'.$projId);
                            elseif($projectType=='photographyNart')$projLink=base_url(lang().'/mediafrontend/photoartdetails/'.$projUser.'/'.$projId);
                            elseif($projectType=='writingNpublishing')$projLink=base_url(lang().'/mediafrontend/writingdetails/'.$projUser.'/'.$projId);
                            elseif($projectType=='educationMaterial')$projLink=base_url(lang().'/mediafrontend/educationelement/'.$projUser.'/'.$projId);
                            elseif($projectType=='upcoming')$projLink="javascript:void(0)";
                            else $projLink='#';
                        }else{
                            $projName='';
                            $projLink='#';
                        }

                }else{  
                       $subjectLebel= $this->lang->line('subject');
                } ?>
          <div class="fl width770">
             <div class="fl width_65  text_alignR pr20 fs13 clr_888">
                <label class="pt18 fr clearbox">Subject</label>
                <label class="pt15 fr clearbox">From </label>
             </div>
             <div class="width677 position_relative bdr_b5b5b5 pb20  mb25 fr " >
                <div class="bg_f7f7f7 fl pl25 pt8 pr25 pb15 width100_per">
                   <div class="clearbox ">
                       <div class="bb_F1592A pt5 pb7 "><b><?php echo $subjectLebel;?></b> 
                            
                            <div class="fr">   
                            <?php   
                            if($nextContId != $prevContId ){ 
                                if(($max_id==$data->id) || ($min_id==$data->id)) 
                                {

                                    if($min_id==$data->id && isset($prevContId[0]->id )) {  ?>                
                                        <a href="<?php echo base_url(lang().'/tmail/viewTmail/'.$prevContId[0]->id.'/'.$type) ?>" class="up_arows fl common_2"></a> 
                            <?php }

                                    if($max_id==$data->id && isset($nextContId[0]->id )) {  ?>				
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
                      <div class="pt7 fs13"> <?php
											echo isGetUserName($data->tdsUid);
											
											?>
                                            <span class="fr red"><?php echo dateFormatView($data->cdate,$fmt = 'd F Y');?></span> </div>
                   </div>
                </div>
                <div class="pr25 pl25 fs13 letter_spP7">
                   <div class="sap_25"></div>
                   
                        
                        <iframe class="brd_none" onload="iframeLoaded()" id="ifr" src="<?php echo base_url_lang("tmail/showtmailbody/".$data->id); ?>" height="100%" width="100%" ></iframe>
                        <?php
                        if($data->type==5) { 
                                    ?>
                                    <p class="fr red">
                                        <a  target="_blank" href="<?php echo $projLink;?>">
                                           <button class="fr red "> <?php echo $projName;?> </button>
                                        </a>
                                   </p>
                        <?php } ?>
                    <div class="sap_55"></div>
                   
                           <?php
                                $labelWorkProfile ='';
                                // echo $data->type;

                                if ( ($data->type == 5) && ($type=='Inbox') ) {
                                    $isParrent=countResult('tmail_messages',array('parent_message_id'=>$data->id));
                                    if(!($isParrent > 0)){
                                    ?>
                                        <p class="fr red"> <button type="button" onclick="acceptShowProjectRequest();" class="fr red send_profile"><?php echo $this->lang->line('accept');?> </button></p>
                                    <?php
                                    }else{ 
                                        $labelWorkProfile = $this->lang->line('acceptedRequestAlready');
                                    ?>
                                            <p class="fr red"><?php //echo $this->lang->line('acceptedRequestAlready');?></p>
                                    <?php
                                        }
                                }                                         
                                            
                                if( ($data->type==5) && ($type=='Inbox')){ ?>								
                                            
                                    <p class="fr red"><?php echo $labelWorkProfile ?></p>

                                <?php } else if ( ($data->type == 2) && ($type=='Inbox')    ) {
                                $threadId=$data->thread_id; 
                                $senderId=isLoginUser(); 
                                $getMainMsgId=countResultFirstInsert('tmail_messages',array('thread_id'=>$threadId,'parent_message_id' => 0));
                                $isParrent=countResult('tmail_messages',array('parent_message_id'=>$getMainMsgId->id));
                                ?>

                         

                                <?php

                                if($isParrent > 0)
                                {
                                $getAttMainMsgId=countResultFirstInsert('tmail_messages',array('parent_message_id' => $getMainMsgId->id));
                                $isAttachPro=countResult('tmail_attachment',array('msg_id'=>$getAttMainMsgId->id));

                                if($getAttMainMsgId->sender_id==$senderId)
                                {?>

                                
                                 <p class="fr red"><?php echo $this->lang->line('profileAlreadySnt') ?></p>

                                <?php
                                }else
                                {   
                                $isWorkprofile = getAttacmentWorkProfile($getAttMainMsgId->id); 

                                if (isset($isWorkprofile) && ($isWorkprofile!="") && ($type=='Inbox')) {	?>
   
                                <div class="fr">
                                  <p class=""> <a  target="_blank" href="<?php echo base_url().'workprofilefrontend/showProfile/'.$isWorkprofile ?>"> View Work Profile</a></p>
                                  <p class=" red"> <?php echo $this->lang->line('Thislinkwillworkfor15days') ?></p>
                                </div>
                                

                                <?php } }

                                }else
                                {?>

                                
                                        <p class="fr red">  <button type="button" onclick= "replayTmail()" class="fr red send_profile">Send Work Profile </button></p>
                                
                                <?php }	?>

                              			
                        <?php 	} ?>
             
                   
                </div>
             </div>
             <div class="width677 fr">
                 <a href="<?php echo base_url_lang('showcase/aboutme/'.$data->sender_id); ?>" target="_blank" class="fl mt20 ml36 clr_0072bc"> View Showcase > </a>
                <button type="button"     class="fr  print_btn">Print </button>
                <button type="button"  onclick="deletTmailPopup();" class="mr10 fr">Delete </button>
                <?php	if($type!='Trash')	{ ?>
                    <button type="submit" class="fr  mr10 replay_btn">Replay </button>
                <?php } ?>
                
             </div>
             
             <?php
					  $this->load->view('show_thread',array('mailThreadData'=>$mailThreadData, 'current_view_id'=>$data->id)); ?>
                      
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
          
