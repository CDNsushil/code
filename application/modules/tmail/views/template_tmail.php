<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');?>

 <div class="row content_wrap" >
     
     <?php 
        //-----load common header of tmail-----//
        $dataArray= array(
            'tmailHeader'=> $tmailHeader,
            'actionMenu'=> 'menu1',
        );
        $this->load->view('tmail_common_header',$dataArray);
    ?>
   
   <div class=" m_auto pt27 sc_album width950 ml38 display_table">
      
       <?php 
      
            //-----load common header of tmail-----//
            $innerHeaderArray   =   array(
                'isCompose'     =>  true,
                'actionMenu'    =>  $actionMenu,
            );
            $this->load->view('tmail_common_inner_header',$innerHeaderArray);
        ?>
      
      <div class="fl width765" id="showtmaillisting">
            <?php echo $this->load->view('template_tmail_inner_view'); ?>
      </div>
      
       <?php $this->load->view('right_tmail_view',array('className'=>'mt30')); ?>
   </div>
</div>
            
