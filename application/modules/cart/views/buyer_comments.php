<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!--
<div class="poup_bx width_361 shadow">
   <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
   <h3 class=" ">Buyer’s Comment</h3>
   <p class="font_bold red pt20 pl10">  <?php echo $buyerCommentsData['rateSeller']; ?></p>
   <div class="fl mt15">
      <p class="pl10"> Comment</p>
        <textarea class="search_box mt10 mb8 width338 bdr_bbb fl" type="text"  readonly><?php echo $buyerCommentsData['comments']; ?></textarea>
   </div>
    <button class="mt20" type="button" onclick="$(this).parent().trigger('close');">Cancel</button>
</div>      
-->


 <div class="poup_bx width_361 shadow">
            <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
            <h3 class="">Buyer's Comment</h3>
            
            <b class=" fl mt20 clearbox red pb15 lineH16 fs16"><?php echo $buyerCommentsData['rateSeller']; ?></b>
            <div class="fl mb20 ">
<?php echo $buyerCommentsData['comments']; ?>      </div>
            
          </div>
