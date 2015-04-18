<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
	
	$craveCount=0;
	$ratingAvg=0;
		$LogSummarywhere=array(
			'entityId'=>$entityId,
			'elementId'=>$elementId
		);
		$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg',  $LogSummarywhere, '', $orderBy='', '', 1 );
		if($resLogSummary)
		{
			$resLogSummary = $resLogSummary[0];											
			$craveCount = $resLogSummary->craveCount;
			$ratingAvg = $resLogSummary->ratingAvg;
		}else
		{										
			$craveCount=0;
			$ratingAvg=0;
		}
	$loggedUserId=isloginUser();
	if($loggedUserId > 0){
		$where=array(
			'tdsUid'=>$loggedUserId,
			'entityId'=>$entityId,
			'elementId'=>$elementId
		);
		$countPAResult=countResult('LogCrave',$where);
		$cravedALL=($countPAResult>0)?'cravedALL':'';
	}else{
		$cravedALL='';
	}
	
	$ratingAvg=roundRatingValue($ratingAvg);
	$ratingImg=base_url().'images/rating/rating_0'.$ratingAvg.'.png';
	
	if($getPurchaseComment['get_num_rows'] > 0)
	{
		$comments = $getPurchaseComment['get_result']->comments;
		$postUrl = 'purchase_comment_update';
		$heading="Edit";
		$rateSeller=$getPurchaseComment['get_result']->rateSeller;
		
	}else
	{
		$comments = '';
		$postUrl = 'purchase_comment_insert';
		$heading="Add";
		$rateSeller=' ';
	}	
?>
 
<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
 <div class="">
	 <?php
	echo form_open('cart/purchase/', 'class="form" id="purchase_comment" name="purchase_comment"'); 
	?>
		<div id="show_comment" class="dash_boxgradient minH260 width730px">
				<div class="seprator_22"></div>
				<div class="row font_museoSlab font_size20 clr_888 pl25">
				<?php
				 if($heading=="Add") { ?>
					
				<?php echo $heading; ?> <?php echo $this->lang->line('purchase_comment_heading_1'); ?> <?php echo ucwords(getUserName($ownerId));?>'<?php echo $this->lang->line('purchase_comment_heading_2'); ?>
				<?php } ?>
				
				<?php if($heading=="Edit") { ?>
				
				<?php echo $this->lang->line('purchase_comment_heading_3'); ?>
				
				<?php } ?>
				
				</div>
				<div class="seprator_22"></div>
				<div class="row">
					<div class="bdr_cecece ml_25 mr24 min_h50 box_shedow position_relative">
					
						<div class="purchase_highlight position_absolute top_10 left330"> </div>
						
						<div class="fl width_333">
						<div class="seprator_8"></div>
						 <div class=" fr join_frm_element_wrapper pl25 left119 width_270 mb8">
							 
							 <?php
							 $options = array(
							  ' '  => 'Rate Seller',
							  'Very Satisfied'    => 'Very Satisfied',
							  'Satisfied'   => 'Satisfied',
							  'Not Satisfied' => 'Not Satisfied',
							);
							 $js = 'id="rate_seller" class="selectBox" style="width: 150px;"';
							 
							 echo form_dropdown('rate_seller',$options,$rateSeller,$js) ?>
						  </div>
						<div class="clear"></div>
						 <div class="textarea_purchase_comment float_none ml13 width_290 borderNone">
							 
							 <textarea  wordlength='0,50' onkeyup="checkWordLen(this,50,'contactmeMessageLimit')" class="textarea_small height_45px required valid" id="user_comment" name="user_comment" original-title="Tag Words" onblur="placeHoderHideShow(this,'Comment','show')"   onclick="placeHoderHideShow(this,'Comment','hide')" value="Comment" placeholder="Comment"><?php echo $comments; ?></textarea></div>
						</div>
						<!--<span class="inline" id="contactmeMessageLimit">333</span>--->
						<div class="fr width_315">
						<div class="seprator_20"></div>
						<div class="fl width_90 height_68 bdr_cecece">
							<div class="AI_table">
								<div class="AI_cell">
									<img class="maxW80_maxH60" src="<?php echo $geMediaImage; ?>">
								 </div>
							 </div>
						</div>
						
						<div class="fr width_196 mr14 mt3">
							<div class="fontB font_size12 bdrb_c5c4c4 lineH10"><?php echo $projName; ?></div>
							<div class="font_size12 lineH10 tar mt2">&nbsp;<?php //echo ucwords(getUserName($ownerId));?></div>
						 
						 <div class="seprator_10"></div>
						 <div class="row ml9 mr10">
						
						
						<div class="row ml9 mr10">
							   <div class="cell blogS_crave_btn ml-15 min_w20 font_opensans craveDiv<?php echo $projectEntityId.''.$projDetail->projId;?> <?php echo $cravedALL;?>">
							   	<?php echo $this->lang->line('item_craves'); ?>  <?php echo $craveCount;?>
							   </div>
							   <div class="cell ml14 mt6 Fright"><img src="<?php echo $ratingImg;?>" /></div>
                               
                          </div>
                          
					  
					  
					  </div>
						</div>
						
					</div>
					
						 <div class="clear"></div>
						<div class="fl width_325">
							<div class="tag_word_orange fl clr_888 ml16 mt5 orange_clr_imp"><?php echo $this->lang->line('comment_lengh'); ?></div>
							
							<span class="five_words mt5 fr"> 
								<!--<span>Total </span>-->
								<span class="inline" id="contactmeMessageLimit">0</span>
								<span class="inline">  <?php echo $this->lang->line('comment_lengh_word'); ?></span>
							 </span>
							 <div class="clear"></div>
						</div>
						 <div class="clear"></div>
						<div class="seprator_10"></div>
					</div>
					
					
					
				</div>
				
				<div class="row">
						
					 
					   <div class="tds-button Fright mr20 mt14"> <button  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0"><?php echo $this->lang->line('submit'); ?></span></button></div>
   <div class="clear"></div>
   </div>
					  
			</div>
			
		
		<div id="show_success_msg" class="customAlert dn">
			
		</div>
		
		<input type="hidden" name="ownerId" value="<?php echo $ownerId; ?>" />
		<input type="hidden" name="ordId" value="<?php echo $ordId; ?>" />
		<input type="hidden" name="itemId" value="<?php echo $itemId; ?>" />
		
		<?php if($getPurchaseComment['get_num_rows']>0) 
		{?>
			<input type="hidden" name="commentId" value="<?php echo $getPurchaseComment['get_result']->id; ?>" />
		<?php } ?>
		
	</div>
	<?php echo form_close(); ?>
</div>

	


<script>
	$(document).ready(function(){	
		selectBox();
			 $("#purchase_comment").validate({
				 
				 submitHandler: function() {
					var fromData=$("#purchase_comment").serialize();
					fromData = fromData+'&ajaxHit=1';
					$.post(baseUrl+language+'/cart/<?php echo $postUrl; ?>',fromData, function(data) {
					  if(data){
							$('#show_comment').hide();
							$('#show_success_msg').show();
							$('#show_success_msg').html(data);
					  }
					});
				 }
				 
				  });
	});
</script>
