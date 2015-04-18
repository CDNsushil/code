<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$cancelButton = array(
  'name'       =>  'cancelButton',
  'id'         =>  'cancelButton',
  'content'    =>  $this->lang->line('packstage2_cancel'),
  'class'      =>  'bg_ededed bdr_b1b1b1 mr5',
  'type'       =>  'button',
);

$backButtonClass  =  (!empty($backClass))?$backClass:'';
$backButton = array(
  'name'       =>  'backButton',
  'id'         =>  'backButton',
  'content'    =>  $this->lang->line('packstage2_back'),
  'class'      =>  'back bdr_b1b1b1 mr5 '.$backButtonClass,
  'type'       =>  'button',
);

/* set join buttons title  */
$joinBtn = $this->lang->line('packstage2_join');
$isUpgrade = $this->session->userdata('isUpgradePackage'); //get upgrade session value if exist
if(!empty($isUpgrade)) {
	$joinBtn = $this->lang->line('packstage2_upgrade');
}
$joinButton = array(
  'name'       =>  'joinButton',
  'id'         =>  'joinButton',
  'content'    =>  $joinBtn,
  'class'      =>  'b_F1592A bdr_F1592A',
  'type'       =>  'submit',
);

/* set submit buttons title  */
$sbtBtn = $this->lang->line('packstage2_renew');
$isDegrade = $this->session->userdata('isDegradePackage'); //get degrade session value if exist
if(!empty($isDegrade)) {
	$sbtBtn = $this->lang->line('packstage2_degrade');
}

$renewButton = array(
  'name'       =>  'renewButton',
  'id'         =>  'renewButton',
  'content'    =>   $sbtBtn,
  'class'      =>  'b_F1592A bdr_F1592A',
  'type'       =>  'submit',
);

$refundButton = array(
  'name'       =>  'refundButton',
  'id'         =>  'refundButton',
  'content'    =>  $this->lang->line('packstage2_refund'),
  'class'      =>  'b_F1592A bdr_F1592A',
  'type'       =>  'submit',
);

$payNowButton = array(
  'name'       =>  'payNowButton',
  'id'         =>  'payNowButton',
  'content'    =>  $this->lang->line('packstage2_paynow'),
  'class'      =>  'b_F1592A bdr_F1592A paynowbutton',
  'type'       =>  'submit',
);

$nextButtonClass  =  (!empty($nextClass))?$nextClass:'';
$nextButton = array(
  'name'       =>  'nextButton',
  'id'         =>  'nextButton',
  'content'    =>  $this->lang->line('packstage2_next'),
  'class'      =>  'b_F1592A bdr_F1592A '.$nextButtonClass,
  'type'       =>  'submit',
);
?>

<div class="fr btn_wrap display_block font_weight">
    
    <a href="<?php echo (!empty($cancelUrl))?$cancelUrl:'javascript:void(0)'; ?>" class="cancelaction">
        <?php echo form_button($cancelButton); ?>
    </a>
  
    <a href="<?php echo (!empty($backUrl))?$backUrl:'javascript:void(0)'; ?>">
        <?php echo form_button($backButton); ?>
    </a>

    <?php 
    if(!empty($isJoinButton) ){ 
      echo form_button($joinButton);  // join button
    }elseif(!empty($isRenewButton) ){
      echo form_button($renewButton);  // renew button
    }elseif(!empty($isRefundButton) ){
      echo form_button($refundButton); // refund button
    }elseif(!empty($isPayNowButton) ){
      echo form_button($payNowButton); // pay now button
    }else{
       echo form_button($nextButton); 
    }   
    ?>
</div>
