<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$competitionMediaLimit = $this->config->item('competitionMediaLimit');
$browseId='_cm';
$defCoverImage=$this->config->item('defaultMediaImg_s');
$mainCoverImage = '';
$coverImage = addThumbFolder($mainCoverImage,$suffix='_xxs',$thumbFolder ='thumb',$defCoverImage);	
$coverImage = getImage($coverImage,$defCoverImage);
$isBlockEdit=false;
if(isCompetitionPublished($competitionId)){
	$isBlockEdit=true;
}	
	$arraryData='';	
	if(isset($competitionMediaData) && count($competitionMediaData) > 0 && !empty($competitionMediaData) ) {
		
		
		foreach($competitionMediaData as $k=>$data ){
			$order = $data->fileOrder;
			switch($order){
					case 0:
						$peaceString= 'Main';
					break;
						
					default:
						$peaceString= 'Piece '.$k;
					break;
			}
			
			if($data->isExternal !="t"){
				$mainCoverImageShow='';
				switch($data->fileType){
					case 1:
						//"image";
						$mainCoverImageShow=$data->filePath.$data->fileName;
					break;
					case 2:
						// "video";
						$mainCoverImageShow = getVideoThumbFolder(@$data->filePath.$data->fileName);
					break;
					case 3:
						// "audio";
						$mainCoverImageShow=$this->config->item('defaultAudioIcon');
					break;
					case 4:
						// "text";
						$fullFileName = $data->filePath.$data->fileName;
						
						if($fullFileName && !empty($fullFileName)){
							$fileInfo=pathinfo($fullFileName);
							$getExtension= strtolower($fileInfo['extension']);
							// show icon if ext. is pdf
							if($getExtension=="pdf"){
								$mainCoverImageShow=$this->config->item('defaultPdfIcon');
							}else{
								$mainCoverImageShow=$this->config->item('defaultDocxIcon');
							}
						}
					break;
					default :
						// "no type define";
						$defCoverImageShow=$this->config->item('defaultMediaImg_s');
					break;
				}
				$defCoverImageShow=$this->config->item('defaultMediaImg_s');
				$coverImageShow = addThumbFolder($mainCoverImageShow,$suffix='_xxs',$thumbFolder ='thumb',$defCoverImageShow);	
				$coverImageShow = getImage($coverImageShow,$defCoverImageShow);
			}else{
				//set default image
				$coverImageShow = $coverImage;
			}
			
			if(is_numeric($data->mediaLangId) && ($data->mediaLangId > 0)){
				$opacity_4='';
				$isFileAdded=true;
			}else{
				$data->mediaLangId = 0;
				$data->title = 'Add '.$peaceString;
				$opacity_4 = 'opacity_4';
				$isFileAdded=false;
			} 
			$jsonData=json_encode($data);
			
			
			//----------if published the show this section--------//
			if($isBlockEdit && $data->mediaLangId > 0)
			{
			?>
				<script>var dataCM<?php echo $k;?> = <?php echo $jsonData;?>;</script>
				<div class="row" id="CG<?php echo $data->mediaLangId;?>">
					<div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $peaceString;?></span></div></div>									 
					<div id="CGData<?php echo $data->mediaLangId;?>" class="cell frm_element_wrapper extract_content_bg">
						<!--extract_img_wp-->
						<div class="extract_img_wp <?php echo $opacity_4;?>"> 
							<img class="formTip ptr maxWH30 ma" src="<?php echo $coverImageShow;?>"  title="<?php echo $data->title; ?>"  />
						</div>
						<!--extract_heading_box-->
						<div class="extract_heading_box <?php echo $opacity_4;?>"> <?php  echo  getSubString($data->title,50); ?> </div>
						<!--extract_button_box-->
						<div class="extract_button_box">
							<?php
								if($isFileAdded){ 
									
									if($isBlockEdit){ ?>
										<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="return isDeleteBlock()" ><div class="cat_smll_plus_icon"></div></a></div>
									<?php }else{ ?>
										<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('CompetitionMediaLang','mediaLangId','<?php echo $data->mediaLangId;?>','','','','#CG','','','',1,'<?php echo $this->lang->line('confirmMsgDelmediaLang');?>')" ><div class="cat_smll_plus_icon"></div></a></div>
									<?php } ?>
									<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueML(dataCM<?php echo $k;?>,'#competitionMediaFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
								<?php
								}else{ ?>
									 <div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="fillFormValueML(dataCM<?php echo $k;?>,'#competitionMediaFormDiv');"><div class="cat_smll_add_icon"></div></a></div>
									<?php
								}
							?>
							
							<!--<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $data->mediaId;?>,'#competitionMediaFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>-->
						</div>
					</div>
					<div class="clear"></div>
				</div>
			<?php
			}
			
			//----------if not published the show this section--------//
			if(!$isBlockEdit)
			{ ?>
				<script>var dataCM<?php echo $k;?> = <?php echo $jsonData;?>;</script>
				<div class="row" id="CG<?php echo $data->mediaLangId;?>">
					<div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $peaceString;?></span></div></div>									 
					<div id="CGData<?php echo $data->mediaLangId;?>" class="cell frm_element_wrapper extract_content_bg">
						<!--extract_img_wp-->
						<div class="extract_img_wp <?php echo $opacity_4;?>"> 
							<img class="formTip ptr maxWH30 ma" src="<?php echo $coverImageShow;?>"  title="<?php echo $data->title; ?>"  />
						</div>
						<!--extract_heading_box-->
						<div class="extract_heading_box <?php echo $opacity_4;?>"> <?php  echo  getSubString($data->title,50); ?> </div>
						<!--extract_button_box-->
						<div class="extract_button_box">
							<?php
								if($isFileAdded){ 
									
									if($isBlockEdit){ ?>
										<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="return isDeleteBlock()" ><div class="cat_smll_plus_icon"></div></a></div>
									<?php }else{ ?>
										<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href="javascript:void(0)" onclick="deleteTabelRow('CompetitionMediaLang','mediaLangId','<?php echo $data->mediaLangId;?>','','','','#CG','','','',1,'<?php echo $this->lang->line('confirmMsgDelmediaLang');?>')" ><div class="cat_smll_plus_icon"></div></a></div>
									<?php } ?>
									<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueML(dataCM<?php echo $k;?>,'#competitionMediaFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
								<?php
								}else{ ?>
									 <div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="fillFormValueML(dataCM<?php echo $k;?>,'#competitionMediaFormDiv');"><div class="cat_smll_add_icon"></div></a></div>
									<?php
								}
							?>
							
							<!--<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $data->mediaId;?>,'#competitionMediaFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>-->
						</div>
					</div>
					<div class="clear"></div>
				</div>
			<?php }	
		}
	} 
?>
