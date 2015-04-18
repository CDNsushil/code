<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

 $showText= (!empty($isReview))?"Review":"News Article";
?>

<div class="poup_bx text_alighC shadow">
    <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
    <div class="sap_10"></div>
    <h3 class="red">Add your Showcase Homepage</h3>
    <div class="sap_20"></div>
    <div class="fs16 text_alignC">  Put up your Showcase Homepage<br />
       Then you post your <?php echo $showText; ?>.  
    </div>
    <a href="<?php echo base_url_lang('showcase/showcasetype'); ?>">
        <button class="mt20 float_none green_btn" type="button ">Add your Showcase Homepage</button>
    </a>
 </div>
