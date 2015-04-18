<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 


// set base url
$baseUrl = formBaseUrl();

?>
<div class="row content_wrap">
   <div class="m_auto Crave_cnt film_video clearb  ">
      <div class="sap_40"></div>
      <div class=" fl pl20">
         <div class="content_creave display_table  pl20 pr20 pt18  clearb">
            <div class="right_box pl34 fl  " id="searchResultDiv">
                <?php $this->load->view('form/media_renew_collection_view'); ?>
            </div>
         </div>
         <!--crave list One-->
         <div class="sap_65 clearb"></div>
      </div>
   </div>
</div>

