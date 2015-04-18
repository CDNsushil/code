<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$hrefNone='javascript:void(0);';
$DC=$projectId>0?'':'disable_btn'; 
if(isset($topBtnClass) && !empty($topBtnClass)) {
	$topClass = $topBtnClass;
} else {
	$topClass = 'pt1';
}

if($label['index']=='Index') 
	$indexClass = '';
else 
	$indexClass = 'two_line';
?>
<div class="cell frm_element_wrapper <?php echo $topClass;?>">
		<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/media/'.$indusrty.'/'.@$projectId);?>"><span class="<?php echo $indexClass;?>"><?php echo $label['index'];?></span></a></div>
		<?php 
				
		if($indusrty=='photographyNart') $descriptionTabLabel = $label['PADescriptionTabLabel'];
		else $descriptionTabLabel = $label['projectDescriptionTabLabel'];
		
		if($indusrty=='news' || $indusrty=='reviews') {
			$uploadMediaTabLabel = $label['uploadsNewsRevLabel'];
			$spanClass = '';
		}
		else {
			$uploadMediaTabLabel = $label['uploadMediaTab'];
			$spanClass = 'class="two_line"';
		}
		if( !($indusrty=='news' || $indusrty=='reviews') && empty($additionalInformation)){?>
			<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php if(isset($projectId) && $projectId > 0) echo base_url(lang().'/media/'.$indusrty.'/'.$action.'/additionalInformation/'.$projectId.'/'.$projectElementId); else echo $hrefNone;?>"><span class=""><?php echo $label['additionalInformationTab'];?></span></a></div>
			<?php 
		}
		if( empty($furtherDescription) ){?>
			<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php if(isset($projectId) && $projectId > 0) echo base_url(lang().'/media/'.$indusrty.'/'.$action.'/furtherDescription/'.$projectId.'/'.$projectElementId); else echo $hrefNone;?>"><span class=""><?php echo $label['coverPages'];?></span></a></div>
			<?php 
		}
		if( empty($uploadMedia)){ ?>
		    <div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php if(isset($projectId) && $projectId > 0) echo base_url(lang().'/media/'.$indusrty.'/'.$action.'/uploadMedia/'.$projectId.'/'.$projectElementId); else echo $hrefNone;?>"><span <?php echo $spanClass;?>><?php echo $uploadMediaTabLabel;?></span></a></div>	
			<?php
		}
		if(empty($projectDescription)){?>
			<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/media/'.$indusrty.'/'.$action.'/projectDescription');if(isset($projectId) && $projectId > 0) echo '/'.$projectId.'/'.$projectElementId;?>"><span class="two_line"><?php echo $descriptionTabLabel;?></span></a></div>
			<?php 
		}?>
		<div class="row line1 mr3"></div>
</div>
