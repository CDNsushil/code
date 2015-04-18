<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$cancelButton = array(
  'name'       =>  'cancelButton',
  'id'         =>  'cancelButton',
  'content'    =>  $this->lang->line('cancel'),
  'class'      =>  'bg_ededed bdr_b1b1b1 mr5',
  'type'       =>  'button',
);
$pauseButton = array(
  'name'       =>  'pauseButton',
  'id'         =>  'pauseButton',
  'content'    =>  $this->lang->line('pause'),
  'class'      =>  'bdr_b1b1b1 mr5',
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

$nextButton = array(
  'name'       =>  'nextButton',
  'id'         =>  'nextButton',
  'content'    =>  $this->lang->line('next'),
  'class'      =>  'b_F1592A bdr_F1592A uploadFileAction',
  'onclick'    =>  "$('#$formName').submit();"
);

$nextStepButton = array(
  'name'       =>  'nextStepButton',
  'id'         =>  'nextStepButton',
  'content'    =>  $this->lang->line('next'),
  'class'      =>  'b_F1592A bdr_F1592A ',
);

// set base url
$baseUrl = base_url(lang());
$projId = (isset($projId)) ? $projId : '';
// set cancle url
$cancleUrl = $baseUrl.'/upcomingprojects/donation/'.$projId;
?>

<div class="fr btn_wrap display_block font_weight">
    <?php if(!isset($showcaseAdd)) { ?>
        <a href="<?php echo $cancleUrl;?>">
            <?php echo form_button($cancelButton); ?>
        </a>
		<a onclick="window.history.back();">
            <?php echo form_button($backButton); ?>
        </a>
    <?php } ?>
    <?php if(!isset($isSkipstep) && !empty($skipPage)) { ?>
        <a href="<?php echo $baseUrl.$skipPage;?>">
            <?php echo form_button($skipButton); ?>
        </a>
    <?php
    }
    
    if(isset($isNextstep)) { ?>
        <a href="<?php echo $baseUrl.$nextPage;?>">
            <?php echo form_button($nextStepButton);?>
        </a>
    <?php } else { 
        echo form_button($nextButton);
    } ?>
</div>
