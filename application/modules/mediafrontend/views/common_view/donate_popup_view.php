<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$formAttributes =   array(
    'name'      =>  'donateForm',
    'id'        =>  'donateForm'
);

?>
<?php 
    $DonateInfoMsg=$this->lang->line('DonateInfoMsg');
    $DonateInfoMsg=str_replace('{currencySign}',$currencySign,$DonateInfoMsg);
    echo form_open(base_url_secure('cart/donate'),$formAttributes);
?>
<div class="poup_bx width520 shadow">
   <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');"></div>
   <h3 class=""><?php echo $this->lang->line('proj_d_heading'); ?></h3>
   <div class="search_box_wrap  mt20 ">
        <p class=" mb14">
            <?php echo $DonateInfoMsg; ?>
        </p>
      <div class="fl aution_wrap"><span class=" pt10 pr15 fl" > <?php echo $this->lang->line('proj_d_popup_amount'); ?>  <?php echo $currencySign;?> </span>
      <input type="text" name="price" class=" bdr_bbb width166 required priceOverOne" value=""></div>
      <button type="button" class="search_button " onclick="$('#donateForm').submit();" ><?php echo $this->lang->line('proj_d_popup_btn'); ?></button>
   </div>
   <ul class="fs13 donat_ul list_dic">
      <li> <?php echo $this->lang->line('proj_d_popup_msg_1'); ?> </li>
      <li> <?php echo $this->lang->line('proj_d_popup_msg_2'); ?></li>
      <li> <?php echo $this->lang->line('proj_d_popup_msg_3'); ?> </li>
      <li> <?php echo $this->lang->line('proj_d_popup_msg_4'); ?> <br>
         <a href="<?php echo base_url_lang('cart/mypurchases') ?>" class=" font_weight color_blck clearb  "> <?php echo $this->lang->line('proj_d_popup_msg_5'); ?>  </a> 
      </li>
   </ul>
</div>
<input type="hidden" name ='entityId' value="<?php echo $entityId; ?>" />
<input type="hidden" name ='elementId' value="<?php echo $elementId; ?>" /> 
<input type="hidden" name ='projId' value="<?php echo $projId; ?>" />  
<input type="hidden" name ='sectionId' value="<?php echo $sectionId; ?>" />
<input type="hidden" value="<?php echo $sellerCurrency; ?>" name="currency" />
<input type="hidden" value="4" name="purchaseType" />
<input type="hidden" value="<?php echo $ownerId; ?>" name="ownerId" />
<?php echo form_close(); ?>        
<script>
$(document).ready(function(){
    $.extend($.validator.messages, {
        required: "",
        number: ""
    });
        
	$("#donateForm").validate();
});
</script>
