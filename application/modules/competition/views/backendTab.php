<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$hrefNone='javascript:void(0);';
$DC=(is_numeric($competitionId) && ($competitionId>0))?'':'disable_btn'; ?>

<div class="row">
		<div class="cell frm_heading">
			<h1>
			<?php 
				echo $heading;
			?>
			</h1>
		</div>
		<div class="cell frm_element_wrapper pt1">
				<?php 
				if($currentMathod != 'competitionlist'){?>
					<div class="tds-button-big Fright"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/competition/competitionlist/');?>"><span class="two_line"><?php echo $this->lang->line('competitionIndex');?></span></a></div>
					<?php
				} 
				if($currentMathod != 'postCompetitionEmails' && $currentMathod != 'competitionShortList'){?>
					<div class="tds-button-big Fright disable_btn"><a  href="<?php echo $hrefNone;?>"><span class="two_line"><?php echo $this->lang->line('postCompetitionEmails');?></span></a></div>	
					<?php
				}
				
				if($currentMathod != 'prizes' && $currentMathod != 'competitionShortList'){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/competition/prizes/language1');if(isset($competitionId) && $competitionId > 0) echo '/'.$competitionId.'/';?>"><span><?php echo $this->lang->line('prizes');?></span></a></div>	
					<?php
				}
				if($currentMathod != 'competitionMedia' && $currentMathod != 'competitionShortList'){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/competition/competitionMedia/language1');if(isset($competitionId) && $competitionId > 0) echo '/'.$competitionId.'/';?>"><span class="two_line"><?php echo $this->lang->line('requiredMediaTab');?></span></a></div>	
					<?php
				}
				if($currentMathod != 'criteria' && $currentMathod != 'competitionShortList'){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/competition/criteria/language1');if(isset($competitionId) && $competitionId > 0) echo '/'.$competitionId.'/';?>"><span><?php echo $this->lang->line('criteria');?></span></a></div>	
					<?php
				}
				
				if($currentMathod != 'description' && $currentMathod != 'competitionShortList'){?>
					<div class="tds-button-big Fright <?php echo $DC;?>"><a onmousedown="mousedown_big_button(this)" onmouseout="mouseout_big_button(this)" onmouseup="mouseup_big_button(this)" href="<?php echo base_url(lang().'/competition/description/language1');if(isset($competitionId) && $competitionId > 0) echo '/'.$competitionId.'/';?>"><span><?php echo $this->lang->line('description');?></span></a></div>
					<?php 
				}?>
				<div class="row line1 mr3"></div>
		</div>
</div>
<?php if(isset($isMultilingual) && ($isMultilingual==true)){
	
	$languageLink1=isset($languageLink1)?$languageLink1:'#';
	$languageLink2=isset($languageLink2)?$languageLink2:'#';
	$activeLang1=isset($activeLang1)?$activeLang1:'';
	$activeLang2=isset($activeLang2)?$activeLang2:'';
	$language1=isset($language1)?$language1:$this->lang->line('language1');
	$language2=isset($language2)?$language2:$this->lang->line('language2');
	 ?>
	<div class="row fr pr15 pt10 pb10">
		<div class="cell"><a href="<?php echo $languageLink1; ?>" class="fm_os dash_link_hover <?php echo $activeLang1;?>"><?php echo $language1;?></a></div>
		<div class="cell pl10 pr10 f14 fm_os grey ">|</div>
		<div class="cell"><a href="<?php echo $languageLink2; ?>" class="fm_os <?php echo $activeLang2;?>"><?php echo $language2;?></a></div>
	</div>
	<?php
}
