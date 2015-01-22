<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row" >
<div class=" pl45 pr25  bg_f1f1f1 fl title_head ">
<h1 class="pt10 mb0  fl"><?php echo $title;?></h1>
<ul class="dis_nav fs16 mt25 fr pr15">
<li class="<?php echo ($pageKey == 'termsconditions')?'active':''; ?>"> <a href="<?php echo base_url(lang().'/cms/termsncondition/english');?>">English</a> </li>
<li class="<?php echo ($pageKey == 'termsnconditionfr')?'active':''; ?>"> <a href="<?php echo base_url(lang().'/cms/termsncondition/french');?>">Français</a> </li>
<li class="<?php echo ($pageKey == 'termsnconditiongr')?'active':''; ?>"> <a href="<?php echo base_url(lang().'/cms/termsncondition/german');?>">Deutcsh</a> </li>
</ul>
<div class="fr mr25 mt25"> <a href="<?php echo base_url('images/Terms and Conditions_18.04.2013.pdf');?>" class="pr30 pt10 pb10 pdf_dowload">Download Terms &amp; Conditions</a> </div>
</div>
<div class="clearb display_table width970 pl20 pt23 pr10 m_auto">
<div class="width780 pr10 text_alighL table_cell pb10 terms_wrap">
<?php //echo changeToUrl($description); ?>
<?php echo $description; ?>
</div>
<div class="terms_advert verti_top pt13  table_cell bg_f7f7f7">
<?php $this->load->view('common/adv_rhs'); ?>
</div>
</div>
</div>

