<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="newlanding_container">
    <div class="wizard_wrap fs14 ">
      <div class="invoices_wrap width635 fs12 m_auto">
         <!--  Membership wrap start end -->
         <h3 class="red fs21 mt49 pt12 pb10 bb_aeaeae "><?php echo $this->lang->line('packmembership_membership_invoice'); ?></h3>
         <ul class=" width100_per mt38 open_semibold ">
            <?php if(!empty($purchasedList)){ 
                foreach($purchasedList as $purchaseData){
                ?>
                <li><span class="pl5 "><span class="min_width240 pt5 fl"><?php echo membershipitemtitle($purchaseData->type,$purchaseData->pkgId); ?></span><span class="  pt5"><?php echo date("d F Y",strtotime($purchaseData->createDate)) ?></span><span class="fr"> <a class="pdf_dowload mr10 fs12 pt5 pb5  pr36  red clearb " href="<?php echo base_url(lang().'/membershipcart/membershipInvoice').'/'.$purchaseData->orderId; ?>" target="_blank"><?php echo $this->lang->line('packmembership_view'); ?> </a></span></span></li>
            <?php }  } ?>
         </ul>
      </div>
    </div>
</div>
