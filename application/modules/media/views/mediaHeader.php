<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$sectionId=($indusrtyId > 0)?$indusrtyId:$this->config->item($industryType.'SectionId');
$buttonDivClass = 'pt1';
$buttonAlign = 'Fright';

if($industryType=='educationMaterial' || $industryType=='photographyNart' ) {$buttonDivClass = 'mt12';}
?>
<div class="row">
	<div class=" cell frm_heading">
		<h1><?php echo $constant['project_heading']?></h1>
	</div>
	
	<div class="cell frm_element_wrapper <?php echo $buttonDivClass;?>">
		<div class="tds-button-big <?php echo $buttonAlign;?>">
			<a href="javascript:getUserContainers('<?php echo $sectionId;?>','/media/<?php echo $industryType;?>/newProject/projectDescription')"  onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $constant['project_newProject']?></span></a> 
			<?php
				if($isArchive=='t'){?>
					<a href="<?php echo base_url(lang().'/media/'.$industryType.'/');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $constant['index']?></span></a>
					<?php
				}else{ ?>
					<a href="<?php echo base_url(lang().'/media/'.$industryType.'/deletedItems');?>" onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)"><span class="two_line"><?php echo $constant['project_archive']?></span></a>
					<?php
				}
			?>
		</div>
		<div class="row line1 mr3"></div>
	</div>
</div><!--row-->
<div class="row seprator_5"></div>
