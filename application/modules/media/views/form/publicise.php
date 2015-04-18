<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$lang=lang();
$PubliciseForm = array(
	'name'=>'PubliciseForm',
	'id'=>'PubliciseForm'
);

$MW_PubliciseHeading  =str_replace('{{var category}}',$category,$this->lang->line('MW_PubliciseHeading'));
$MW_PubliciseMsg  =str_replace('{{var catType}}',$this->lang->line('catType'.$projCategory),$this->lang->line('MW_PubliciseMsg'));
 

$isPublished = (isset($isPublished) && ($isPublished=='t'))?'t':'f';
if($isPublished == 't'){
    $yesChecked='checked';
    $noChecked=''; 
}else{
    $yesChecked='';
    $noChecked='checked';
}

$projId = isset($projId)?$projId:0;
$projIdInput = array(
	'name'	=> 'projId',
	'type'	=> 'hidden',
	'id'	=> 'projId',
	'value'	=>$projId
);
echo form_open(base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'saveProjectStatus'.DIRECTORY_SEPARATOR),$PubliciseForm); 
    echo form_input($projIdInput);
    ?>
<div class="c_1">
  <h3 class=" fs21 red  "><?php echo $MW_PubliciseHeading;?></h3>
  <h4 class="fl width_472  mt20 lineH24"><?php echo $MW_PubliciseMsg;?></h4>
  <div class="butn ml0 mr0 b_f7f7f7 fs17 mt30 fr bdr_b4b4b4 lineh16">
     <div class="table_cell pad_2"> <span class="defaultP fs14 pr0">
        <label class="publish_yes_"> 
        <input type="radio" value="t" name="isPublished" <?php echo $yesChecked;?>><?php echo $this->lang->line('Yes');?></label>
        <label class="publish_no">
        <input type="radio" value="f" name="isPublished" <?php echo $noChecked;?>><?php echo $this->lang->line('No');?></label>
        </span>
     </div>
  </div>
  <div class="sap_25"></div>
  <ul class="clearb org_list">
     <li class="icon_2 liststyle_none "><?php echo $this->lang->line('doThisLter');?></li>
  </ul>
  <div class=" fs14 fr btn_wrap display_block mt5 font_weight">
    <a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'previewpublish'.DIRECTORY_SEPARATOR.$projId) ;?>">
        <button type="button" class="back back_click4 bdr_b1b1b1 mr5" role="button" aria-disabled="false"><?php echo $this->lang->line('back');?></button>
    </a>   
    <button class="b_F1592A bdr_F1592A" type="submit" role="button" aria-disabled="false"><?php echo $this->lang->line('finish');?></button>
  </div>
</div>
