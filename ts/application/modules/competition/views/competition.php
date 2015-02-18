<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

$industryArray = getIndustryClass($competitionDetail->industryId);
$border8pxClass = $industryArray['8pxborderClass'];

$sendData['industryArray']=$industryArray;
?>
<td valign="top">
	<div class="cell right_coloumn margin_0 bdr10_fff width778 bg_444 bg-non pb10">
		<div class="row font_helvetica_L pl72 pt25 pr10">
			<div class="clr_white font_size30 fl">
				<?php echo $this->lang->line('competitionDetailsHeading'); ?>
			</div>
			<?php if($competitionDetail->competitionGroupId > 0) { ?>
				<a href="<?php echo base_url('competition/associatedcompetition/'.$userId.'/'.$competitionId.'/'.$competitionDetail->competitionGroupId); ?>" class="associated_class font_opensansSBold">
				<div class="fr ml10 mt-8 mr7">
					<img src="<?php echo base_url('templates/frontend/images/associated.png'); ?>" alt="associted">
				</div>
				<span class="fr font_size16 text_alignC lineH16 font_HelReg mt-8"> <?php echo $this->lang->line('competitionDetailsAssociated'); ?> </span>
				</a>
			<?php } ?>
			<div class="row">
			</div>
		</div>
		<!-- /row -->
		<div class="row pall20">
			<!-- main div  -->
			<div class="<?php echo $border8pxClass; ?> bg_white pt12 min_h595 pb15 global_shadow">
			
				<!------competition detail view start---->	
					<?php echo $this->load->view('competitionDetailView',$sendData); ?>
				<!------competition detail view end---->	
				
				<!------winner list view start------>
					<?php echo $this->load->view('competitionDetailsWinnerList'); ?>
				<!------winner list view start-------->	
				
			</div>
			<!-- main div  -->
			
			<div class="seprator_15"> </div>
			
				<!------ competition detail sample entry button view start---->	
					<?php echo $this->load->view('competitionDetailsSampleEntryButtonView',$sendData); ?>
				<!------competition detail sample entry button end---->
		</div>
		<!-- /row -->
	</div>
</td>

<script>

	$(document).ready(function(){
			$('#slider1').tinycarousel({ display: 3 });	
		});	
		
	function mousedown_tds_button_jludark(obj){
		obj.style.backgroundPosition ='0px -43px';
		obj.firstChild.style.backgroundPosition ='right -43px';
	}
	function mouseup_tds_button_jludark(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.firstChild.style.backgroundPosition ='right 0px';
	}


	function mousedown_tds_compenter1(obj){
		obj.style.backgroundPosition ='0px -81px';
		obj.firstChild.style.backgroundPosition ='right -81px';
	}
	function mouseup_tds_compenter1(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.firstChild.style.backgroundPosition ='right 0px';
	}
</script>
