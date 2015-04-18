<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	$hrefNone='javascript:void(0);';
	$pageOpacity='opacity_4';
	if(!isset($campaignId) || empty($campaignId)) {
		$campaignId = '';
	}
	
	$methodName = $this->router->fetch_method();
 ?>
<div class="row">
	<div class=" cell frm_heading">
		<h1><?php echo $headerTitle; ?></h1>
	</div>
	<div class="cell frm_element_wrapper pt1">
		<div class="tds-button-big Fright">
			<?php if($methodName=="index"){ ?>
				<a class="<?php echo ($currentPage=='index')?$pageOpacity:''; ?>" href="<?php echo site_url(lang()).'/advertising/description';?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="one_line"><?php echo $this->lang->line('NewAdvert'); ?></span></a>
			<?php }else {
				if(!empty($campaignId)) { ?>
				<a class="<?php echo ($currentPage=='description')?$pageOpacity:''; ?>" href="<?php echo site_url(lang()).'/advertising/description/'.$campaignId;?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="one_line"><?php echo $this->lang->line('Description'); ?></span></a>
				<a class="<?php echo ($currentPage=='adverts')?$pageOpacity:''; ?>" href="<?php echo site_url(lang()).'/advertising/adverts/'.$campaignId;?>"  onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="one_line"><?php echo $this->lang->line('Adverts'); ?></span></a>
				<a class="<?php echo ($currentPage=='stats')?$pageOpacity:''; ?>"  href="<?php echo $hrefNone;?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="one_line"><?php echo $this->lang->line('Stats'); ?></span></a>
				<?php } ?>
				<a class="<?php echo ($currentPage=='index')?$pageOpacity:''; ?>" href="<?php echo site_url(lang()).'/advertising';?>"  onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="one_line"><?php echo $this->lang->line('Index'); ?></span></a>
			<?php  }  ?>
		</div>
		<div class="row line1 mr3"></div>
	</div>
</div><!--row-->
<div class="row seprator_5"></div>
