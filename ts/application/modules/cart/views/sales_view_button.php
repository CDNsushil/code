<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 ?>
<div class="cartbtn_pur ml10 mt6 fr"> <a onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)" href="<?php echo base_url('cart/sales_record_print').'/'.$purchaseData->itemId; ?>" target="_blank"><span>Sales Record</span></a> </div>
<div class="cartbtn_pur ml10 mt6 fr"> <a href="javascript:openLightBox('popupBoxWp','popup_box','/cart/buyerInfo','<?php echo $purchaseData->itemId; ?>');" onmouseup="mouseup_tds_button_pur(this)" onmousedown="mousedown_tds_button_pur(this)"><span>Contact Buyer</span></a> </div>
