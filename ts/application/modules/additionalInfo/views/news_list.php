<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="label_wrapper cell bg-non">
		<!--<div class="lable_heading"><h1><?php echo $label['NEWS'];?></h1></div>-->
	</div>
<div class="small_frm_wp" >
	<div class="seprator_13 row"></div>
	<?php
	$dn='';
	$countAddInfo=count($news);
	if($countAddInfo>0){
		$dn='dn';?>
		<div id="newsDataHeading" class="row">
			<?php
				/*<div class="cell padding_left_20">
					<div class="defaultP padding_top4">
						<input type="checkbox" name="checkAll" id="checkAll" value="0" onclick="checkUncheck(this,0,'.checkBoxNews')"  />  
					</div>
				</div>*/
			?>

			<div class="cell title_small_frm pl20">
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
		
		<div id="newsData">
			<?php
			foreach($news as $k=>$item){
				if($item->newsPublishDate==NULL) $date = date("d F Y", strtotime($item->newsCreatedDate));
				else $date = date("d F Y", strtotime($item->newsPublishDate));	
				$publishDate = date("Y-m-d", strtotime($item->newsPublishDate));
				$title = htmlentities(addslashes($item->newsTitle),ENT_QUOTES);
				$writer = htmlentities(addslashes($item->newsWriter),ENT_QUOTES);
				$description = htmlentities(addslashes($item->newsDescription),ENT_QUOTES);
				$embedvalue = urlencode($item->newsEmbed);
				$ExternalUrl = $item->newsExternalUrl;
				$id=$item->newsId;
				$languageId=$item->newsLanguage;
				$urlType=$item->newsUrlType;
				$newsElementTitle=(isset($item->newsElementTitle))?$item->newsElementTitle:'';
				$associatedNewsElementId=(isset($item->associatedNewsElementId))?$item->associatedNewsElementId:0;
				$projId=(isset($item->projId))?$item->projId:0;
				
				?>		
				<div class="row extract_content_bg_PR" id="rowNews<?php echo $id;?>">
					<?php /*
					<div class="cell padding_left_20">
						<div class="defaultP padding_top4">
							<input class="checkBoxNews" type="checkbox" name="newsId" value="<?php echo $id;?>" />  
						</div>
					</div>*/
					?>
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
													'section'=>'#news',
													'tbl'=>'AddInfoNews',
													'field'=>'newsId',
													'checkbox'=>'checkBoxNews',
													'rowData'=>'#rowNews'
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
													'toggleDivForm'=>'NEWSForm-Content-Box', 
													'section'=>'#news', 
													'titlehere'=>$title, 
													'ElementTitle'=>$newsElementTitle, 
													'associatedElementId'=>$associatedNewsElementId, 
													'projId'=>$projId, 
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
		</div>
			<?
	}
	echo '<div class="row pl20 '.$dn.'" id="newsNoRecords">';
	if($userId == $ownerId ){
		echo anchor('javascript://void(0);', $label['add'],array('class'=>'a_orange formTip','title'=>$label['NEWS'],'onclick'=>"$('#NEWSForm-Content-Box').show();"));
	 }else{
			echo "No Record Found.";
	} 
	echo '</div>';
	?>
</div>
<script> HideShowAddOption('news','<?php echo $countAddInfo;?>','<?php echo $this->config->item('addInfoLimitation');?>'); </script>
