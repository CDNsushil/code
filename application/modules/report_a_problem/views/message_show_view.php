<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
    $displayMessage = (isset($showMessage))?$showMessage:"Your message <br /> has been sent";
?>
<div class="width_635 ml86 ">
   <div class="clearb  width_493 m_auto">
      <div class="fs18 mt38 thankyou_wrap">
         <div class="thankyou_img display_table width_380 m_auto"  >
            <h5 class="fs20 width_260 pb20  display_table clearb clr_fff fr">
               <span class="lineH23 text_alighL  lettsp-1 pl50">					“
                <?php echo $displayMessage; ?>
                ”</span> 
            </h5>
            <div class=" fl  mt-34"><img src="templates/new_version/images/forg.png" alt="" /></div>
         </div>
      </div>
   </div>
   <div class="fr option_btn btn_wrap display_block font_weight">
      <button class="b_F1592A next_click bdr_F1592A" type="button" onclick="selection_change();" >Back</button>
   </div>
</div>

