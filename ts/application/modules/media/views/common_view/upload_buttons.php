<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$cancelButton = array(
  'name'       =>  'cancelButton',
  'id'         =>  'cancelButton',
  'content'    =>  $this->lang->line('cancel'),
  'class'      =>  'bg_ededed bdr_b1b1b1 mr5',
  'type'       =>  'button',
);

$skipButton = array(
  'name'       =>  'skipButton',
  'id'         =>  'skipButton',
  'content'    =>  $this->lang->line('skip'),
  'class'      =>  'back back_click4 bdr_b1b1b1 mr5',
  'type'       =>  'button',
);

$backButton = array(
  'name'       =>  'backButton',
  'id'         =>  'backButton',
  'content'    =>  $this->lang->line('back'),
  'class'      =>  'back back_click4 bdr_b1b1b1 mr5',
  'type'       =>  'button',
);

$backAjaxButton = array(
  'name'       =>  'backAjaxButton',
  'id'         =>  'backAjaxButton',
  'content'    =>  $this->lang->line('back'),
  'class'      =>  'back back_click4 bdr_b1b1b1 mr5 dn',
  'type'       =>  'button',
);

$nextBtndn = '';
if(isset($isNextstep)) {
    $nextBtndn = 'dn';
}
$nextButton = array(
  'name'       =>  'nextButton',
  'id'         =>  'nextButton',
  'content'    =>  $this->lang->line('next'),
  'class'      =>  'b_F1592A bdr_F1592A uploadFileAction '.$nextBtndn,
  'onclick'    =>  "$('#$formName').submit();"
);

$nextAjaxBtndn = 'dn';
if(isset($isNextstep)) {
    $nextAjaxBtndn = '';
}
$nextAjaxButton = array(
  'name'       =>  'nextAjaxButton',
  'id'         =>  'nextAjaxButton',
  'content'    =>  $this->lang->line('next'),
  'class'      =>  'b_F1592A bdr_F1592A '.$nextAjaxBtndn,
);

// set cancel url
$baseUrl = formBaseUrl();
// set cancle url
$cancleUrl = '#';

if(isset($projectId) && !empty($projectId)) {
    $cancleUrl = $baseUrl.'/editproject/'.$projectId;
} elseif(isset($elementId) && !empty($elementId)) {
    $cancleUrl = $baseUrl.'/editproject/'.$elementId;
}

?>

<div class="fr btn_wrap display_block font_weight">
    <a href="<?php echo $cancleUrl;?>">
        <?php echo form_button($cancelButton); ?>
    </a>
    <?php if(!empty($backPage)) { ?>
    <a href="<?php echo $baseUrl.$backPage;?>">
        <?php echo form_button($backButton); ?>
    </a>
    <?php }
    if(!isset($isSkipstep) && !empty($skipPage)) { ?>
        <a href="<?php echo $baseUrl.$skipPage;?>">
            <?php echo form_button($skipButton); ?>
        </a>
    <?php
    }
    echo form_button($backAjaxButton);
    echo form_button($nextButton);
    echo form_button($nextAjaxButton);
    ?>
</div>
