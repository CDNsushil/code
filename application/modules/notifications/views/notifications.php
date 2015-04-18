<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
//print_r($section_craved_list);
$selectSection = end($this->uri->segment_array());
$selectSection =  (!isset($selectSection) || ($selectSection=='index'))?'all':$selectSection;

?>
<div class="row content_wrap" >
   <?php 
        //-----load common header of tmail-----//
        $dataArray= array(
            'tmailHeader'=>'Notifications',
            'actionMenu'=>'menu2',
        );
        $this->load->view('tmail/tmail_common_header',$dataArray);
    ?>
   <div class=" m_auto pt27 sc_album width950 ml38 display_table">
      <div class="clearbox"> <span class="unread_msg fl bdr_L_ddd  ml25"> <b class="red"><?php echo $unreadNotificationCount; ?></b> Unread Notifications</span> </div>
      <div class="fl mt10 width765">
        
         <div class="fl width_190 mt25 text_alignR"  >
            <ul class="listpb15 lineH16 pr10">
                <?php 
                    $listNotificationData['selectSection']=$selectSection;
                    echo $this->load->view('list_notification_type',$listNotificationData); 
                ?>
            </ul>
         </div>
         <div class="fr width560 " id="showNotification">
            <?php 
                $listNotification['selectSection'] = $selectSection;
                $listNotification['section_craved_list'] = $section_craved_list;
                echo $this->load->view('list_notification',$listNotification);  
            ?>
         </div>
       
         
      </div>
      
      <?php $this->load->view('tmail/right_tmail_view',array('className'=>'mt30')); ?>
   </div>
</div>
    
