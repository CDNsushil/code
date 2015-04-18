<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_204'));?>
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
<div class="popup_gredient bg_white">
  <div >
	<div class="row">
		<div class="cell frm_heading orange">
			<h1><?php echo $this->lang->line('searchLabel');?></h1>
		</div>
	</div>
	<div class="row heightSpacer">&nbsp;</div>
	<div class="clear"></div>
	<div class="left_coloumn"><!--left_coloumn-->
			<?php
				$formAttributes = array(
				'name'=>'searchontoadsquare',
				'id'=>'searchontoadsquare',
				);
				
				echo form_open($this->uri->uri_string(),$formAttributes);
				//$view='searchontoadsquare_result';
				$view='search_media_result';
				if(!isset($sectionList) || !$sectionList){
					$sectionIdInput = array(
						'name'	=> 'sectionId',
						'type'	=> 'hidden',
						'id'	=> 'sectionId',
						'value'	=> $sectionId
					);
					echo form_input($sectionIdInput);
				}
				$keyword=(isset($keyword) && $keyword !='' )?$keyword:$this->lang->line('keywordSearch');
				
				if(isset($prosectionId)){
					$projectSectionId = $prosectionId;
				}else{
					$projectSectionId = 0;
				}
			?>
		  <div class="search_left_box ml9 mr10">
			<div class=" ml3 mt6">
			  <div class="search_box_wrapper width_170">
				<input type="text" name="keyWord" value="<?php echo $keyword;?>" class="new_keyword_style search_text_box " placeholder="<?php echo $this->lang->line('keywordSearch');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearch');?>','show')">
				<div>
					<input type="submit" name="searchSubmitByImage" value="" class="search_btn_glass">
					<!--<input type="image" src="<?php //echo base_url();?>images/btn_search_box.png" name="searchSubmitByImage" />-->
				</div>
			  </div>
			  <!--search_box_wrapper-->
			</div>
			<div class="clear"></div>
			
			<?php
				if(isset($sectionList) && $sectionList){
					?>
					<div class="SRleft_select_box ml1 mt6" id="sectiondiv">
					 <?php echo form_dropdown('sectionId', $sectionList, $sectionId,'id="sectionId"');?>
					</div>
					<?php
					$view='search_media_result';
				}
			?>
		  </div>
		   <input type="hidden" name="fromSection" id="fromSection" value="<?php echo isset($section)?$section:'';;?>">
		  <?php
				if(isset($sectionList) && $sectionList){ ?>
					 <div class="Fright mr6 mt6">
							<div class="tds-button-big Fleft"> <a href="javascript:void(0)" onclick="$('#searchontoadsquare').submit();" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span><?php echo $this->lang->line('searchLabel');?></span></a> </div>
					  </div>
					<?php
				}
		  ?>
		 
		  <?php echo form_close(); ?>
	</div><!--left_coloumn-->
	<!--right_column-->
	<div id="searchontoadsquareResultDiv" class="cell mt0 ml11 mr11 pt0 bdr_non bg_light_gray height475px width600px oh">
        <?php
			if($searchResult){
				echo $searchResult;
			}else{
				echo '<div class="p15">search result will come here</div>';
			}
        ?>
	 </div>
	<!--right_column-->
	<div class="clear"></div>
	</div>
	<div class="clear seprator_25"></div>
</div>

<script>
	$(document).ready(function(){	
		$("#searchontoadsquare").validate({
			  submitHandler: function() {
				$('html').animate({scrollTop:0}, 'slow');
				$('#searchontoadsquareResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
				var fromData=$("#searchontoadsquare").serialize();
				fromData = fromData+'&viewPage=<?php echo $view;?>'+'&prosectionId=<?php echo $projectSectionId;?>';
				$.post(baseUrl+language+'/search/searchresult',fromData, function(data) {
				  if(data){
					 $('#searchontoadsquareResultDiv').html(data);
				  }
				});
			 }
		});
	});
	runTimeCheckBox();
	selectBox();
</script>
