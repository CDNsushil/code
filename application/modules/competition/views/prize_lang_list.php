<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

	$competitionprizeQuantity = $this->config->item('competitionprizeQuantity');
	
	$isBlockEdit=false;
	if(isCompetitionPublished($competitionId)){
		$isBlockEdit=true;
	}
	$rowNumber=0;
	if(isset($prizeData) && count($prizeData) > 0 && !empty($prizeData) ) {
		foreach($prizeData as $k=>$data){
			 
			
			 $mainprizeImg = $data->image;
			 $coverImage='';
			 $defCoverImage=$this->config->item('defaultcompetitonImg73X110');
			 $coverImage = addThumbFolder($mainprizeImg,$defCoverImage);	
			 $prizeImg = getImage($coverImage,$defCoverImage);
			
				//this section if competition is published and it have 
				if($isBlockEdit && $data->prizeLangId > 0)
				{
					$rowNumber ++;
					$order = $rowNumber;
				}
				
				// this section for competition is not published		
				if(!$isBlockEdit){	
					$order = $data->order;
				}
					
				switch($order){
					 
						case 1:
							$placeString= $order.'st Place';
						break;
							
						case 2:
							$placeString= $order.'nd Place';
						break;
						
						case 3:
							$placeString= $order.'rd Place';
						break;
						
						default:
							$placeString= $order.'th Place';
						break;
				}
			
			
			if(is_numeric($data->prizeLangId) && ($data->prizeLangId > 0)){
				$opacity_4='';
				$isPrizeAdded=true;
			}else{
				$data->prizeLangId = 0;
				$data->title = 'Add '.$placeString.' Prize';
				$opacity_4 = 'opacity_4';
				$isPrizeAdded=false;
			}
			$jsonData=json_encode($data); 
			
			//----------if published the show this section--------//
			if($isBlockEdit && $data->prizeLangId > 0)
			{
			?>
			<script>var dataCG<?php echo $k;?> = <?php echo $jsonData;?>;</script>
			<div class="row" id="CG<?php echo $data->prizeLangId;?>">
				<div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $placeString;?></span></div></div>									 
				<div id="CGData<?php echo $k;?>" class="cell frm_element_wrapper extract_content_bg">
					<!--extract_img_wp-->
					<div class="extract_img_wp <?php echo $opacity_4;?>"> 
						<img class="formTip ptr maxWH30 ma" src="<?php echo $prizeImg;?>"  title="<?php echo $data->title; ?>"  />
					</div>
					<!--extract_heading_box-->
					<div class="extract_heading_box <?php echo $opacity_4;?>"> <?php  echo  getSubString($data->title,50); ?> </div>
					
					<!--extract_button_box-->
					<div class="extract_button_box">
						<?php
							if($isPrizeAdded){ 
								if($isBlockEdit){ ?>
									<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="return isDeleteBlock()" ><div class="cat_smll_plus_icon"></div></a></div>
								<?php }else{ ?>
									<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('CompetitionPrizeLang','prizeLangId','<?php echo $data->prizeLangId;?>','','','','#CG','','','',1,'<?php echo $this->lang->line('confirmMsgDelPrizeLang');?>')" ><div class="cat_smll_plus_icon"></div></a></div>
								<?php } ?>
								<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCG(dataCG<?php echo $k;?>,'#competitionPrizeForm');" ><div class="cat_smll_edit_icon"></div></a></div>
							<?php
							}else{ ?>
								 <div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="fillFormValueCG(dataCG<?php echo $k;?>,'#competitionPrizeForm');"><div class="cat_smll_add_icon"></div></a></div>
								<?php
							}
						?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<?php
			}
			
			//----------if published the show this section--------//
			if(!$isBlockEdit)
			{ ?>	
			<script>var dataCG<?php echo $k;?> = <?php echo $jsonData;?>;</script>
			<div class="row" id="CG<?php echo $data->prizeLangId;?>">
				<div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $placeString;?></span></div></div>									 
				<div id="CGData<?php echo $k;?>" class="cell frm_element_wrapper extract_content_bg">
					<!--extract_img_wp-->
					<div class="extract_img_wp <?php echo $opacity_4;?>"> 
						<img class="formTip ptr maxWH30 ma" src="<?php echo $prizeImg;?>"  title="<?php echo $data->title; ?>"  />
					</div>
					<!--extract_heading_box-->
					<div class="extract_heading_box <?php echo $opacity_4;?>"> <?php  echo  getSubString($data->title,50); ?> </div>
					
					<!--extract_button_box-->
					<div class="extract_button_box">
						<?php
							if($isPrizeAdded){ 
								if($isBlockEdit){ ?>
									<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="return isDeleteBlock()" ><div class="cat_smll_plus_icon"></div></a></div>
								<?php }else{ ?>
									<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('CompetitionPrizeLang','prizeLangId','<?php echo $data->prizeLangId;?>','','','','#CG','','','',1,'<?php echo $this->lang->line('confirmMsgDelPrizeLang');?>')" ><div class="cat_smll_plus_icon"></div></a></div>
								<?php } ?>
								<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCG(dataCG<?php echo $k;?>,'#competitionPrizeForm');" ><div class="cat_smll_edit_icon"></div></a></div>
							<?php
							}else{ ?>
								 <div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="fillFormValueCG(dataCG<?php echo $k;?>,'#competitionPrizeForm');"><div class="cat_smll_add_icon"></div></a></div>
								<?php
							}
						?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<?php 	
			}	
			
		}
	}
