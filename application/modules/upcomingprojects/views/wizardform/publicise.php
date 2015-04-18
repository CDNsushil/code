<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$lang=lang();
$PubliciseForm = array(
	'name'=>'PubliciseForm',
	'id'=>'PubliciseForm'
);
// set base url
$baseUrl = base_url(lang().'/upcomingprojects');
$isPublished = (isset($upcomingRes['isPublished']) && ($upcomingRes['isPublished']=='t'))?'t':'f';
if($isPublished == 't') {
    $yesChecked='checked';
    $noChecked=''; 
} else {
    $yesChecked='';
    $noChecked='checked';
}

$projId = isset($projId)?$projId:0;
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=> $projId
);
echo form_open($baseUrl.'/setprojectstatus/',$PubliciseForm); 
    echo form_input($projIdInput);?>
<div class="content display_table TabbedPanelsContent width635 m_auto">    
	<div class="c_1">
		<h3 class=" fs21 red  fnt_mouse bb_aeaeae"><?php echo $this->lang->line('publiciseYourShowcase');?></h3>
		<h4 class="fl width_472  mt20 lineH24"><?php echo $this->lang->line('publiciseYourShowcaseNote');?></h4>
		<div class="butn ml0 mr0 b_f7f7f7 fs17 mt30 fr bdr_b4b4b4 lineh16">
			<div class="table_cell pad_2">
				 <span class="defaultP fs14 pr0">
					<label class="publish_yes_"> 
						<input type="radio" value="t" name="isPublished" <?php echo $yesChecked;?>><?php echo $this->lang->line('Yes');?>
					</label>
					<label class="publish_no">
						<input type="radio" value="f" name="isPublished" <?php echo $noChecked;?>><?php echo $this->lang->line('No');?>
					</label>
				</span>
			</div>
		</div>
		<div class="sap_25"></div>
		<ul class="clearb org_list">
			<li class="icon_2 liststyle_none "><?php echo $this->lang->line('doThisLter');?></li>
		</ul>
		<div class=" fs14 fr btn_wrap display_block mt5 font_weight">
			<a onclick="window.history.back();">
				<button type="button" class="back back_click4 bdr_b1b1b1 mr5"><span class="ui-button-text"><?php echo $this->lang->line('back');?></span></button>
			</a>   
			<button class="b_F1592A bdr_F1592A" type="submit"><span class="ui-button-text"><?php echo $this->lang->line('finish');?></span></button>
		</div>
	</div>
</div>
<?php echo form_close();?>
