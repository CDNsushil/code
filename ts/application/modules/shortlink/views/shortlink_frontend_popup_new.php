<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="poup_bx width_232  shadow">
   <div class="close_btn position_absolute "  onclick="$(this).parent().trigger('close');" ></div>
   <h3 class="red fs21  text_alighC mb15 mt15 big_share big_short">Short Link</h3>
   <div class="bdrb_afafaf mb18"></div>
   <p class="mb20"> Use this short link on other sites, such as Twitter, to help people find your work. </p>
   <div class=" text_alighC">
       <input type="text" value="<?php echo $shareLink; ?>" id="gsInput" readonly name="getshortlink"  class="bdr_adadad fs11 width210 pt0 pb0 min-height28 bg_f5f5f5" onfocus="this.select();" />
      <button  type="button" id="copy-button" class="float_none copylink">Copy Short Link</button>
   </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        copyClip.init('.copylink');
    });
    
    // mouse enter
    $(".copylink").mouseenter(function(){
        $(this).addClass('orange_btn_hov');
    });
    
    // mouse leave
    $(".copylink").mouseleave(function(){
        $(this).removeClass('orange_btn_hov');
    });
</script>
