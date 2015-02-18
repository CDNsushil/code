<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="label_wrapper cell bg-non"><!--<div class="lable_heading"><h1><?php echo $label['REVIEWS'];?></h1></div>--></div>
<div class="small_frm_wp" >
	<div class="seprator_13 row"></div>
	<?php
	$dn='';
	$countAddInfo=count($reviews);
	if(count($reviews)>0){
		$dn='dn';?>
		<div id="reviewDataHeading" class="row">
			<div class="cell title_small_frm padding_left_20">
				<span class="orange_color"><?php echo $label['title'];?></span>
			</div>

			<div class="cell writer_name_small_frm">
				<span class="orange_color"><?php echo $label['authorName'];?></span>
			</div>

			<div class="cell date_small_frm">
				<span class="orange_color"><?php echo $label['datePublish'];?></span>
			</div>
			<?php
				/*<div class="cell date_small_frm">
					Action
			</div>*/?>
			<div class="clear"></div>
			<div class=" mr10"></div>
		</div>
		
		<div id="reviewData">
			<?php
			foreach($reviews as $k=>$item){
				if($item->reviewPublishDate==NULL) $date = date("d F Y", strtotime($item->reviewCreatedDate));
				else $date = date("d F Y", strtotime($item->reviewPublishDate));	
				
				$publishDate = date("Y-m-d", strtotime($item->reviewPublishDate));
				$title = htmlentities(addslashes($item->reviewTitle),ENT_QUOTES);
				$writer = htmlentities(addslashes($item->reviewWriter),ENT_QUOTES);
				$embedvalue = urlencode($item->reviewEmbed);
				$description = htmlentities(addslashes($item->reviewDescription),ENT_QUOTES);
				$ExternalUrl = $item->reviewExternalUrl;
				$id=$item->reviewId;
				$languageId=$item->reviewLanguage;
				$urlType=$item->reviewUrlType;
				?>		
				<div class="row extract_content_bg_PR" id="rowReview<?php echo $id;?>">
					<!--<div class="cell padding_left_20">
						<div class="defaultP padding_top4">
							<input class="checkBoxReview" type="checkbox" name="reviewId" value="<?php echo $id;?>" />  
						</div>
					</div>-->
					
					<div class="cell title_small_frm padding_left_20">
						<?php echo stripslashes($title);?>
					</div>


					<div class="cell writer_name_small_frm">
						<?php echo stripslashes($writer);?>
					</div>

					<div class="cell date_small_frm width125px">
						<?php echo $date;?>
					</div>
					<?php if($userId ==$ownerId ){?>
					<div class="cell pro_btns mt5"> 
						<div class="small_btn">
							
							<?php
								$delArr = array(
													'title'=>$label['delete'],
													'class'=>"formTip deleteAdditionalInfoRow",
													'id'=>$id,
													'section'=>'#review',
													'tbl'=>'AddInfoReviews',
													'field'=>'reviewId',
													'checkbox'=>'checkBoxReview',
													'rowData'=>'#rowReview'
												);
								echo anchor('javascript://void(0);', '<div class="cat_smll_plus_icon"></div>',$delArr);	
							?>
						</div>
						<div class="small_btn">
							<?php
								$editArr = array(
													'title'=>$label['edit'],
													'class'=>"formTip editAdditionalInfo",
													'id'=>$id,
													'toggleDivForm'=>'REVIEWSForm-Content-Box', 
													'section'=>'#review', 
													'titlehere'=>$title, 
													'writer'=> $writer, 
													'description'=> $description, 
													'embed'=>$embedvalue, 
													'externalUrl'=>$ExternalUrl,
													'urlType'=>$urlType, 
													'languageId'=> $languageId, 
													'publishDate'=>$date
												);
								echo anchor('javascript://void(0);', '<div class="cat_smll_edit_icon"></div>',$editArr);	
							?>
						</div>
					</div>
					<?php } ?>
					<div class="clear"></div>
				</div>
				<?php
			}?>
		</div><?php
	}
	echo '<div class="row pl20 '.$dn.'" id="reviewNoRecords">';
	if($userId == $ownerId ){
		echo anchor('javascript://void(0);', $label['add'],array('class'=>'a_orange formTip','title'=>$label['REVIEWS'],'onclick'=>"$('#REVIEWSForm-Content-Box').show();"));
	 }else{
			echo "No Record Found.";
	} 
	echo '</div>';
	?>
	
</div>
<script> HideShowAddOption('reviews','<?php echo $countAddInfo;?>','<?php echo $this->config->item('addInfoLimitation');?>'); </script>
