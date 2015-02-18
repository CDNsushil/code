<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$industryArray = getIndustryClass($competition_array[0]->industryId);
$border10pxClass = $industryArray['10pxborderClass'];
$sortButton = $industryArray['sortButton'];
$sendData['industryArray']=$industryArray;
 ?>
<td valign="top">
	<div class="cell right_coloumn bg_2c2c2c bg-non margin_0 <?php echo $border10pxClass; ?> width778 pb10">
		<div class="row font_helvetica_L ml18 pt25 pr10">
			<div class="bdr_Bwhite fl height_27">
				<span class="fl clr_white font_size30 text_alignC font_HelReg"> <?php
					// group title	
					echo getSubString($competitionGroupDetail->title,50);  ?> </span>
				<div class="fl ml39 mt-13">
					<img alt="associted" src="<?php echo base_url('templates/frontend/images/associated.png'); ?>">
				</div>
			</div>
			<div class="fr bg_2c2c2c font_size17 font_helveticaLight text_alignR height_23 mr1 bdr_4c4c4c pl10 pr10 backtocomp_shedow">
				<a href="<?php echo base_url('competition/showcase/'.$this->uri->segment('4').'/'.$this->uri->segment('5')); ?>" class="clr_white lineH22" ><?php echo $this->lang->line('backtoCompetition'); ?></a>
			</div>
			<div class="clear">
			</div>
		</div>
		<div class="seprator_10"></div>
		<div class="row">
			<div class="bdr6_676767 bg_444 ml15 mr12 mt10 position_relative pt7 pb7 pl12 pr12 font_opensansSBold">
				<div class="font_size13 clr_white lineH20">
					 <?php 
						// group description
						echo getSubString($competitionGroupDetail->onelineDescription,200); 
					 ?>
				</div>
				<div class="font_size13 clr_b8b8b8 fr">
					<?php echo $this->lang->line('headingUserCompetitionMsg'); ?>
				</div>
				<div class="clear">
				</div>
			</div>
			<div class="clear">
			</div>
		</div>
		<div class="seprator_5">
		</div>
			<div id="showCompetition">
				<?php $this->load->view('associatedcompetitionframe',$sendData); ?>
			</div>
		<div class="seprator_10"></div>	
	</div>

</td>
<script>
function mousedown_tds_button_jludark(obj){
	obj.style.backgroundPosition ='0px -43px';
	obj.firstChild.style.backgroundPosition ='right -43px';
}
function mouseup_tds_button_jludark(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}
</script>
