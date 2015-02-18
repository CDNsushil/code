<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$cancelButton = array(
  'name'       =>  'cancelButton',
  'id'         =>  'cancelButton',
  'content'    =>  $this->lang->line('cancel'),
  'class'      =>  'bg_ededed bdr_b1b1b1 mr5',
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
  'class'      =>  'b_F1592A bdr_F1592A',
  'type'       =>  'submit',
);
// set base url 
$baseUrl = base_url(lang().'/showcase/');
// set cancel url
$cancelUrl = $baseUrl.'/editshowcase';
// set cancel url
$backUrl = $baseUrl.$backPage;
?>

<div class="fr btn_wrap display_block font_weight">
	<a href="<?php echo $cancelUrl;?>">
		<?php echo form_button($cancelButton); ?>
	</a>
    <a href="<?php echo $backUrl;?>">
        <?php echo form_button($backButton); ?>
    </a>
	<?php echo form_button($nextButton); ?>
</div>
