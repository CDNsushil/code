<td valign="top" class="craveBg" >

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require(APPPATH.'modules/craves/views/cravedata.php');
?>
<div class="crave_page_top mt6">
	<?php $this->load->view('crave_navigation_frontend'); ?>
	<div class="Fright mr9">
		<div class="search_box_wrapper">
		  <?php
			$formAttributes = array(
				'name'=>'craveSearchForm',
				'id'=>'craveSearchForm',
			);
			echo form_open($this->uri->uri_string(),$formAttributes);
				?>
				<input name="craveSearch" id="craveSearch" type="text" class="search_text_box" value="<?php if(empty($craveSearch)){ echo $this->lang->line('searchCraves');} else echo $craveSearch;?>" placeholder="<?php echo $this->lang->line('searchCraves');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('searchCraves');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('searchCraves');?>','show')">
				<div class="height28"> 
				<input type="submit" name="searchCrave" value="" class="search_btn_glass">
				<!--<input type="image" src="<?php //echo base_url();?>images/btn_search_box.png" name="searchCrave" value="searchCrave" >-->
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
   <div class="Fright mr10">
	    <?php 
			$cravelistUrl=base_url('craves/'.$currentMathod.'/'.$userId);
			if(is_array($craveTypeDropDwon) && count($craveTypeDropDwon) > 0){
				unset($craveTypeDropDwon['work']);
				ksort($craveTypeDropDwon);
				echo form_dropdown('projType', $craveTypeDropDwon, $craveSection,'id="projType" class="main_SELECT width220px dn" onchange="goTolink(this,\''.$cravelistUrl.'\')"');
			}
	   ?>
	</div>
	<div class="clear"></div>
</div>


<div class="p8 bg_white mt10 ml10 mr10">
	<?php
	 $craveDataCount=count($craveData);
	
	 if($craveData && is_array($craveData) && $craveDataCount > 0){
		echo "<div id='elementFrontendListingAjaxDiv' class='row'>";
			$this->load->view('craves_frontend_list',array('craveData'=>$craveData));
		echo "</div>";
		
	}else{//$this->load->view('common/no_search_found_full'); ?>
		
			<div class="bg_SRCreative width_742 p8 nocravbg_orangeS mb5">
				<div class="nocravebg width_auto"> 
					<div class="nocravebg_inner minH147">
					   <div class="font_opensansSBold font_size30 clr_f1592a bdrB_878688 width385px mt52 ml222 lineH22"><?php echo $this->lang->line('noCraveFound') ?></div>
					</div>

				<div class="nocravebg_btm minH60 ml0 mr0">
				</div>
				</div>
			</div>		
		
	<?php }?>

	
	 <div class="clear"></div>
</div>
 <div class="clear"></div>

	<?php //$this->load->view('common/adv_728_90'); ?>
	<div id="advert728_90">
		<?php 
		if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) {
			//Manage right side advert
			$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'5'));
			if(!empty($bannerRhsData)) {
				$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'5','sectionId'=>$advertSectionId)); 
			} else { 
				$this->load->view('common/adv_728_90');
			} 
		} else {
			$this->load->view('common/adv_728_90');
		}?> 	
	</div>
 </div>
<div class="clear"></div>
 <div class="seprator_10"></div>
</td>
