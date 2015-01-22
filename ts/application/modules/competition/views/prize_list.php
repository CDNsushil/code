<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	$competitionprizeQuantity = $this->config->item('competitionprizeQuantity');
	
	// if competition is published then show entered prizes list
	if(isCompetitionPublished($competitionId)){
		$competitionprizeQuantity = count($prizeData);
	}	
	
	$arraryData='';
	$i=0;
	if(isset($prizeData) && count($prizeData) > 0 && !empty($prizeData) ) {
		$countData = count($prizeData);
		foreach($prizeData as $k=>$data){
			$i++;
			switch($i){
					case 1:
						$placeString= $i.'st Place';
					break;
						
					case 2:
						$placeString= $i.'nd Place';
					break;
					
					case 3:
						$placeString= $i.'rd Place';
					break;
					
					default:
						$placeString= $i.'th Place';
					break;
				
			}
			$currentDiv='rowPrize'.$data->compPrizeId;
			$dataDiv='dataPrize'.$data->compPrizeId;
			
			$prizeImage=$data->image;
			$defaultcompetitonImage=$this->config->item('defaultcompetitonImage');
			$prizeImage = addThumbFolder($prizeImage,'_s');	
			$imgSrc = getImage($prizeImage,$defaultcompetitonImage);	
		
			$jsonData=array(
					'competitionId'=> $data->competitionId,
					'title'=>$data->title,
					'tagwords'=>$data->tagwords,
					'onelineDescription'=>$data->onelineDescription,
					'description'=>$data->description,
					'image'=>$imgSrc,
					'currency'=>$data->currency,
					'distributionType'=>$data->distributionType,
					'prize'=>$data->prize,
					'compPrizeId'=>$data->compPrizeId,		
					'compPrizeOrder'=>$data->order		
			);
			
			
			$currentData=array(
				'table'=>'CompetitionPrizes',
				'pKey'=>'compPrizeId',
				'pValue'=>$data->compPrizeId,
				'orderKey'=>'order',
				'orderValue'=>$data->order
			);
			
			$jsonData=json_encode($jsonData);
			$currentDataJson=json_encode($currentData);
			
			?>
			<script> var data<?php echo $i; ?> = <?php echo $jsonData;?>; 
			   var currentData<?php echo $i; ?> = <?php echo $currentDataJson;?>;
			</script>
			<?php
			if($i==1){
				$disbleUp='opacity_4';
				$functionUp='';
			}else{
				$disbleUp='';
				$swapUpData=array(
					'swpId'=>$prizeData[$k-1]->compPrizeId,
					'swpOrder'=>$prizeData[$k-1]->order
				);
				$jsonSwapUpData=json_encode($swapUpData);
				?>
				<script> var swapUpData<?php echo $i; ?> = <?php echo $jsonSwapUpData;?>; </script>
				<?php
				$functionUp='reArrangeRecordsOrder(currentData'.$i.',swapUpData'.$i.');';
			}
			if($k < ($countData-1)){
				$disbleDown='';
				$swapDownData=array(
					'swpId'=>$prizeData[$k+1]->compPrizeId,
					'swpOrder'=>$prizeData[$k+1]->order
				);
				
				$jsonSwapDownData=json_encode($swapDownData);
				?>
				<script> var swapDownData<?php echo $i; ?> = <?php echo $jsonSwapDownData;?>; </script>
				<?php
				$functionDown='reArrangeRecordsOrder(currentData'.$i.',swapDownData'.$i.');';	
			}else{
				$disbleDown='opacity_4';
				$functionDown='';
			}
			?>
			<div class="row" id="<?php echo $currentDiv?>">	
			
				<div class="label_wrapper cell">
					<label class=""> <?php echo $placeString; ?></label>
				</div>
					
				<!--label_wrapper-->
				<div id="<?php echo $dataDiv?>" class=" cell frm_element_wrapper extract_content_bg" >
					<div class="extract_img_wp"> 
						<img src="<?php echo $imgSrc ?>" class="formTip ptr maxWH30 ma" original-title="Extract of AKON">
					</div>
					
					<div class="extract_heading_box width_240"> <?php echo $data->title ?> </div>
					<!--extract_heading_box-->

					<div class="extract_quota_box width_60"><?php //echo $data->prize ?></div>

					<!--extract_quota_box-->
					<div class="extract_button_box">
							
						  <div title="Delete" class="small_btn formTip">
							<a onclick="deletcompetitionPrize(<?php echo$data->compPrizeId ?>,<?php echo $competitionId ?>)" href="javascript:void(0)">
								<div class="cat_smll_plus_icon"></div>
							</a>
						  </div>
						<div title="Edit" class="small_btn formTip"><a onclick="editVal(data<?php echo $i; ?>,'<?php echo $data->order; ?>')" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
						
						<div class="small_btn formTip <?php echo $disbleDown;?>" title="Move Down"><a  href="javascript:void(0);" onclick="<?php echo $functionDown; ?>"><div class="smll_down_arrow_icon"></div></a></div>
						<div class="small_btn formTip <?php echo $disbleUp;?>"  title="Move Up"><a href="javascript:void(0);" onclick="<?php echo $functionUp; ?>"><div class="smll_up_arrow_icon"></div></a></div>
					</div>
				</div>
			</div>
			<?php
		}
	} 

//------------showing prize prizes list----------//

	for($i=($i+1); $i <= $competitionprizeQuantity; $i++) { 
						
		switch($i){
				case 1:
					$placeString= $i.'st Place';
				break;
					
				case 2:
					$placeString= $i.'nd Place';
				break;
				
				case 3:
					$placeString= $i.'rd Place';
				break;
				
				default:
					$placeString= $i.'th Place';
				break;
			
		}
		 
				
		$competitonThumbImage='';
		$defaultcompetitonImage=$this->config->item('defaultcompetitonImage');
		$imgPath = 'media/'.$userName.'/competition';
		$imgSrc = getImage($competitonThumbImage,$defaultcompetitonImage);	
		?>
		
		<div class="row">
			
			<div class="label_wrapper cell">
			  <label class=""> <?php echo $placeString; ?></label>
			</div>
			
			<!--label_wrapper-->
			<div class=" cell frm_element_wrapper extract_content_bg " id="rowData3">
				<div class="extract_img_wp opacity_4"> 
				<a class="formTip" onclick="changeUploadMediyaFormValue(data3)" href="javascript:void(0)" original-title="Add">
				<img src="<?php echo $imgSrc ?>" class="formTip ptr maxWH30 ma" original-title="">
				</a>
				</div>
				<!--extract_img_wp-->
				<div class="extract_heading_box opacity_4">Add  <?php echo $placeString; ?></div>
				<!--extract_heading_box--> 
				<!--extract_quota_box-->
				<div class="extract_button_box">
				<div title="Add" class="small_btn formTip"><a onclick="addVal(<?php echo $competitionId ?>,'<?php echo $i; ?>')" href="javascript:void(0)"><div class="cat_smll_add_icon"></div></a></div>
			</div>
			</div>
		</div>
		
		<?php	

	} ?>
