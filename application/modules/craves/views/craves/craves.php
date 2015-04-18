<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row content_wrap" >
  <div class="m_auto Crave_cnt film_video clearb  ">
    <div class=" pl45 pr25 bg_f3f3f3 fl title_head mb12">
        <ul class="dis_nav crave_nav fs16 mt25 fr pl50 pr3 mr-1">
            <li <?php if($page=='mycraves') echo 'class="active"';?> ><a href="<?php echo base_url(lang().'/craves/index');?>">Edit My Craves</a> </li>
            <?php
            if($fans != 't'){?>
                <li <?php if($page=='cravingme') echo 'class="active"';?>> <a href="<?php echo base_url(lang().'/craves/cravingme');?>">Edit Craving Me</a></li>
                <?php
            }?>
            <li <?php if($page=='myplaylist') echo 'class="active"';?>> <a href="<?php echo base_url(lang().'/craves/myplaylist');?>">Edit My Playlist</a></li>
        </ul>
    </div>
      <div class=" fl pl20"> <?php 
        if($page != 'myplaylist'){
            $this->load->view('craves/craves/crave_header');
        }?>
         
         <div class="content_creave display_table  pl20 pr20 pt18  clearb">
           <div class="right_box pl34 fl  " id="searchResultDiv">
                <?php
                if(isset($load_view) && !empty($load_view)){
                    $this->load->view($load_view);
                }else{
                    echo '<p>No Record Found.</p>';
                }?>
           </div>
        </div><!--crave list One-->
         <div class="sap_65 clearb"></div>
         
      </div>
   </div>
</div>
<script>
	function unCrave(entityId,elementId,userId,craveId) {	
		confirmBox("Do you really want to delete this crave?", function () {	 
			var ceavedata = {"elementId":elementId,"entityId":entityId,"ownerId":userId,"craveId":craveId};   
			var url ='<?php echo base_url(lang().'/craves/postCrave')?>';
			
            $.post(baseUrl+language+'/craves/uncrave',ceavedata, function(data) {
                if(data){
                    $('#removecrave_'+craveId).remove();
                    //refreshPge();
                }
            });
            
                /*var res= AJAX(url,'',ceavedata);
                if(res) {
                $('#uncrave_'+craveId).remove();	
                $('#removecrave_'+craveId).remove();	 			 
                //refreshPge();				 
                }*/
		});
	}  	
</script>

 
