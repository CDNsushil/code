<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$selectedPacakge   =  (!empty($packageDetails->subscriptionType))?$packageDetails->subscriptionType:'';
$packageStartDate  =  (!empty($packageDetails->startDate))?$packageDetails->startDate:'';
$packageEndDate    =  (!empty($packageDetails->endDate))?$packageDetails->endDate:'';
$packageSpace      =  (!empty($packageDetails->packageSpace))?$packageDetails->packageSpace:'';
//get diffrence of date from subscription start date
$startDateDiffrence = getSubscriptionDayDiff(1);
//get diffrence of date from subscription end date
$endDateDiffrence = getSubscriptionDayDiff(2);
//set day limits 
$degradeAfterDay = preg_replace("/[^0-9]/", '',$this->config->item('downgrade_button_after_day'));
$renewBeforeDay = preg_replace("/[^0-9]/", '',$this->config->item('renew_button_before_day'));
?>

<div class="row">
  <div class=" cell frm_heading mt3">
  <h1>Your Membership</h1>
  </div>
  <div class="frm_btn_wrapper">
  <div class="tds-button-big fr mr11">
    <a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/dashboard'); ?>"><span >Dashboard </span></a>
    <a onmouseup="mouseup_big_button(this)" onmouseout="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/dashboard/globalsettings'); ?>" ><span>Global Settings</span></a>
  </div>
  </div>
</div>
<div class="row line1 mr14"></div>
<div class="row seprator_5"></div>
   <!---
<div class="row">
  <div class="main_project_heading">
     
  <div class="btn_outer_wrapper width_auto pl5 mr14 ml5">
  <div class="fr">
    <div class="tds-button-big Fleft">
      <a  onmouseover="mouseover_big_button(this)" onmouseup="mouseup_big_button(this)" onmousedown="mousedown_big_button(this)"  href="#" class="a_dash_navactive"><span class="span_dash_navactive">Information</span></a>
      <a onmouseover="mouseover_big_button(this)" onmouseup="mouseup_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/package/buytools/'); ?>"><span>Buy Tools</span></a>
      <a href="<?php echo base_url(lang().'/package/purchases/'); ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Purchases</span></a>
  
    </div>
    </div>
   
    <div class="clear"></div>
  </div>
  </div>
</div>
 -->
<div class="clear"></div>
<div class="row seprator_2"></div>
<div class="clear"></div>
<div class="package_wrapper01 pl5">
<?php 
  //$this->load->view('package/package_presentation');
  //$this->load->view('package/package_theame',array('clr_white'=>'','hideHeading'=>1,'memberbox_left_shedow'=>''));
?>
<table style="width:400px; height:250px; font-size:16px;" border="2">
<tr >
  <td>Selected Membership</td>
  <td>
    <div class="tds-button-big Fleft clr_f1592a">
      <?php 
            if($selectedPacakge==$this->config->item('package_type_1')){
              echo $this->config->item('package_title_1');
            }elseif($selectedPacakge==$this->config->item('package_type_2')){
               echo $this->config->item('package_title_2');
            }elseif($selectedPacakge==$this->config->item('package_type_3')){
              echo $this->config->item('package_title_3');
            }
       ?>
    </div>
  </td> 
</tr>

<tr >
  <td>Upgrade</td>
  <td>
    <?php  if($selectedPacakge==$this->config->item('package_type_1')){ ?>
      <div class="tds-button-big Fleft">
        <a href="<?php echo base_url(lang().'/package/upgradepackage/2'); ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Annual</span></a>
      </div>
    <?php } ?>
     <?php  if($selectedPacakge==$this->config->item('package_type_1') || $selectedPacakge==$this->config->item('package_type_2')){ ?>
      <div class="tds-button-big Fleft">
        <a href="<?php echo base_url(lang().'/package/upgradepackage/3'); ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">3 Year</span></a>
      </div>
    <?php } ?>
  </td> 
</tr>


<tr >
  <td>Renew</td>
  <td>
        <?php
         $renewDay                 =  $this->config->item('renew_button_before_day');
         $renewDate                =  date('Y-m-d', strtotime($renewDay, strtotime($packageEndDate)));
         $renewDateStrtotime       =  strtotime($renewDate);
         $currentDateStrtotime     =  time();
          
         if($renewDateStrtotime <= $currentDateStrtotime && !empty($packageEndDate)){
       ?>
        
        <div class="tds-button-big Fleft">
          <a href="<?php echo base_url('/package/renewstageone/1'); ?>" id="<?php echo $selectedPacakge; ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" class="renewpackage" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Renew</span></a>
        </div>
      
      <?php  } ?>
    
  </td> 
</tr>

<tr >
	<td>Downgrade</td>
	<td>
		<?php  if(($selectedPacakge == $this->config->item('package_type_3') || $selectedPacakge == $this->config->item('package_type_2')) && ($startDateDiffrence <= $degradeAfterDay  || $endDateDiffrence <= $renewBeforeDay)) { ?>
		<div class="tds-button-big Fleft">
		  <a href="<?php echo base_url('/package/degradepackage/1');?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Free</span></a>
		</div>
		<?php  if($selectedPacakge == $this->config->item('package_type_3')) { ?>
			<div class="tds-button-big Fleft">
				<a href="<?php echo base_url('/package/degradepackage/2');?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">1 Year</span></a>
			</div>
		<?php } }?>
	</td> 
</tr>

<tr >
  <td>Refund</td>
  <td>
		<?php  if(($selectedPacakge == $this->config->item('package_type_3') || $selectedPacakge == $this->config->item('package_type_2')) && ($startDateDiffrence <= $degradeAfterDay)) { ?>
			<div class="tds-button-big Fleft">
				<a href="<?php echo base_url('/package/refundpackage'); ?>" onmousedown="mousedown_big_button(this)" onmouseup="mouseup_big_button(this)" onmouseover="mouseover_big_button(this)" style="background-position: 0px 0px;"><span style="background-position: right 0px;">Refund</span></a>
			</div>
    <?php } ?>
  </td> 
</tr>

</table>


<div class="clear"></div>
<div class="seprator_10"></div>
</div>
<div class="seprator_10"></div>
<div class="clear"></div>

