<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="label_wrapper cell bg-non"><!--<div class="lable_heading"><h1><?php echo $label['INTERVIEWS'];?></h1></div>--></div>
<div class="small_frm_wp" >
	<div class="seprator_13 row"></div>
	<?php
	$dn='';
	$countAddInfo=count($interviews);
	if(count($interviews)>0){
		$dn='dn';
	?>
		<div id="intervDataHeading" class="row">
			<div class="cell title_small_frm padding_left_20">
				<span class="orange_color"><?php echo $label['title'];?></span>
			</div>

			<div class="cell writer_name_small_frm">
				<span class="orange_color"><?php echo $label['interviewer'];?></span>
			</div>

			<div class="cell date_small_frm">
				<span class="orange_color"><?php echo $label['datePublish'];?></span>
			</div>
			<div class="clear"></div>
			<div class=" mr10"></div>
		</div>
		
		<div id="intervData">
			<?php
			foreach($interviews as $k=>$item){

				if($item->intervPublishDate==NULL) $date = date("d F Y", strtotime($item->intervCreatedDate));
				else $date = date("d F Y", strtotime($item->intervPublishDate));	

				$publishDate = date("Y-m-d", strtotime($item->intervPublishDate));
				$title = htmlentities(addslashes($item->intervTitle),ENT_QUOTES);
				$writer = htmlentities(addslashes($item->intervWriter),ENT_QUOTES);
				$embedvalue = urlencode($item->intervEmbed);
				$description = htmlentities(addslashes($item->intervDescription),ENT_QUOTES);
				$ExternalUrl = $item->intervExternalUrl;
				$id=$item->intervId;
				$languageId=$item->intervLanguage;
				$urlType=$item->intervUrlType;
				
			?>		
				<div class="row extract_content_bg_PR" id="rowInterview<?php echo $id;?>">
					
					<!--<div class="cell padding_left_20">
						<div class="defaultP padding_top4">
							<input class="checkBoxInterview" type="checkbox" name="intervId" value="<?php echo $id;?>" />  
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
													'section'=>'#interv',
													'tbl'=>'AddInfoInterview',
													'field'=>'intervId',
													'checkbox'=>'checkBoxInterview',
													'rowData'=>'#rowInterview'
												);
								echo anchor('javascript://void(0);', '<span><div class="cat_smll_plus_icon"></div></span>',$delArr);	
							?>
						</div>
						<div class="small_btn">
							
							<?php
								$editArr = array(
												'title'=>$label['edit'],
												'class'=>"formTip editAdditionalInfo",
												'id'=>$id,
												'toggleDivForm'=>'INTERVIEWSForm-Content-Box', 
												'section'=>'#interv', 
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
					<?php }?>
					<div class="clear"></div>
				</div>
				<?php
			}?>
		</div>
			<?
	}
	echo '<div class="row pl20 '.$dn.'" id="intervNoRecords">';
	if($userId == $ownerId ){
		echo anchor('javascript://void(0);', $label['add'],array('class'=>'a_orange formTip','title'=>$label['INTERVIEWS'],'onclick'=>"$('#INTERVIEWSForm-Content-Box').show();"));
	 }else{
			echo "No Record Found.";
	} 
	echo '</div>';
	?>
	
</div>
<script> HideShowAddOption('interv','<?php echo $countAddInfo;?>','<?php echo $this->config->item('addInfoLimitation');?>'); </script>
