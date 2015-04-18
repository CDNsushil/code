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
$showNextBtn = '';
$showNextStateBtn = 'dn';
if(!empty($isDomestic)) {
    $showNextBtn = 'dn';
    $showNextStateBtn = '';
}
$nextButton = array(
  'name'       =>  'nextButton',
  'id'         =>  'nextButton',
  'content'    =>  $this->lang->line('next'),
  'class'      =>  'b_F1592A bdr_F1592A '.$showNextBtn,
  'type'       =>  'submit'
);

$nextShippingStateButton = array(
  'name'       =>  'nextStateButton',
  'id'         =>  'nextStateButton',
  'content'    =>  $this->lang->line('next'),
  'class'      =>  'b_F1592A bdr_F1592A '.$showNextStateBtn,
  'type'       =>  'button',
);

$nextUrlButton = array(
  'name'       =>  'nextButton',
  'id'         =>  'nextButton',
  'content'    =>  $this->lang->line('next'),
  'class'      =>  'b_F1592A bdr_F1592A ',
  'type'       =>  'submit'
);
// set cancel url
$baseUrl = formBaseUrl();
// set skip url
//$skipUrl = $baseUrl.'/sellerconsumptiontax/'.$projectId;
if(!empty($elementId)) {
    // set skip url
    $skipUrl = $baseUrl.'/uploadimageinfo/'.$projectId.DIRECTORY_SEPARATOR.$elementId;
}
// set back url
$backUrl = $baseUrl.DIRECTORY_SEPARATOR.$backPage.DIRECTORY_SEPARATOR.$projectId.DIRECTORY_SEPARATOR.$elementId;
if(isset($spId) && !empty($spId)) {
    // set back url if shipping zone id exists
    $backUrl = $backUrl.DIRECTORY_SEPARATOR.$spId;
}
?>

<div class="fr btn_wrap display_block font_weight">
    <!--<a href="<?php //echo $baseUrl;?>">
        <?php //echo form_button($cancelButton); ?>
    </a>-->
    <?php /*if(isset($skipUrl)) { ?>
		<a href="<?php echo $skipUrl;?>">
			<?php echo form_button($skipButton); ?>
		</a>
    <?php }*/ ?>
	<a onclick="window.history.back();">
    <!--<a href="<?php //echo $backUrl;?>">-->
        <?php echo form_button($backButton); ?>
    </a>
    <?php 
    if(isset($nextUrl) && !empty($nextUrl)) {
        echo '<a href="'.$nextUrl.'">';
        echo form_button($nextUrlButton);
        echo '</a>';
    } else {
        echo form_button($nextShippingStateButton);
        echo form_button($nextButton); 
    }
    ?>
</div>
