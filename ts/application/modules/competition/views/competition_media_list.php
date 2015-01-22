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
	foreach($competitionMediaData as  $competitionMediaShowData ){
			$getExplodeArr = explode(":",$competitionMediaShowData->fileLength);
			$arraryData[$competitionMediaShowData->fileOrder] = $competitionMediaShowData;
			$competitionMediaShowData->hh = $getExplodeArr[0];
			$competitionMediaShowData->mm = $getExplodeArr[1];
			$competitionMediaShowData->ss = $getExplodeArr[2];
			$competitionMediaShowData->wordCount = $competitionMediaShowData->fileLength;
			$competitionMediaShowData->isMediaSet = false;
		}
	} 

	for($i=0;$i<$competitionMediaLimit;$i++) { 
						
	switch($i){
			case 0:
				$peaceString= 'Main';
			break;
				
			default:
				$peaceString= 'Piece '.$i;
			break;
	}
	
	if(isset($arraryData[$i])) { 

		// set cover image by file type
		if($arraryData[$i]->isExternal=="f"){
		$mainCoverImageShow='';
			switch($arraryData[$i]->fileType){
				case 1:
					//"image";
					$mainCoverImageShow=$arraryData[$i]->filePath.$arraryData[$i]->fileName;
				break;
				case 2:
					// "video";
					$mainCoverImageShow = getVideoThumbFolder(@$arraryData[$i]->filePath.$arraryData[$i]->fileName);
				break;
				case 3:
					// "audio";
					$mainCoverImageShow=$this->config->item('defaultAudioIcon');
				break;
				case 4:
					// "text";
					$fullFileName = $arraryData[$i]->filePath.$arraryData[$i]->fileName;
					
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
		
		
		$data=$arraryData[$i];
		$opacity_4='';
		$data->mediaOrder = $i;
		$data->mediaFormAction = 'mediaEdit';
		$jsonData=json_encode($data);
	?>
		<script>var dataCM<?php echo $i;?> = <?php echo $jsonData;?>;</script>
		<div class="row" id="CG<?php echo $i;?>">
			<div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $peaceString;?></span></div></div>									 
			<div id="CGData<?php echo $i;?>" class="cell frm_element_wrapper extract_content_bg">
				<!--extract_img_wp-->
				<div class="extract_img_wp <?php echo $opacity_4;?>"> 
					<img class="formTip ptr maxWH30 ma" src="<?php echo $coverImageShow;?>"  title="<?php echo $data->title; ?>"  />
				</div>
				<!--extract_heading_box-->
				<div class="extract_heading_box <?php echo $opacity_4;?>"> <?php  echo  getSubString($data->title,50); ?> </div>
				<!--extract_button_box-->
				<div class="extract_button_box">
					<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:competitionMediaDelete(<?php echo $data->mediaId;?>,<?php echo $data->fileId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
					<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#competitionMediaFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
	<?php  }else{ 
		
		if(!$isBlockEdit){
		// get media type details
		$getCompetitionData  = $this->model_common->getDataFromTabel('Competition', $field='mediaType',  $whereField=array('competitionId'=>$competitionId), '', '', '',1);
		
		if(!empty($getCompetitionData)){
			if($getCompetitionData[0]->mediaType==NULL){
				$arrayDataAdd['isMediaSet'] = false;
			}	
			else{
				$arrayDataAdd['isMediaSet'] = true;
				$arrayDataAdd['mediaType'] = $getCompetitionData[0]->mediaType;
			}	
		}else{
				$arrayDataAdd['isMediaSet'] = false;
			}
		
		
			
		$arrayDataAdd['title'] = 'Add '.$peaceString.' File';
		$arrayDataAdd['mediaOrder'] = $i;
		$arrayDataAdd['mediaFormAction'] = 'mediaAdd';
		$opacity_4='opacity_4';
		$jsonData=json_encode($arrayDataAdd);
		?>
	
		<script>var dataCM<?php echo $i;?> = <?php echo $jsonData;?>;</script>
		<div class="row" id="CG<?php echo $i;?>">
			<div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $peaceString;?></span></div></div>									 
			<div id="CGData<?php echo $i;?>" class="cell frm_element_wrapper extract_content_bg">
				<!--extract_img_wp-->
				<div class="extract_img_wp <?php echo $opacity_4;?>"> 
					<img class="formTip ptr maxWH30 ma" src="<?php echo $coverImage;?>"  title="<?php echo$arrayDataAdd['title']; ?>"  />
				</div>
				<!--extract_heading_box-->
				<div class="extract_heading_box <?php echo $opacity_4;?>"> <?php  echo  getSubString($arrayDataAdd['title'],50); ?> </div>
				
				<!--extract_button_box-->
				<div class="extract_button_box">
					 <div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#competitionMediaFormDiv');"><div class="cat_smll_add_icon"></div></a></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
	<?php 
		}
	
	}	
	
	
	}
?>
<script>
	function fillFormValueCM(data,formId){
		
		
		var browseId = '<?php echo $browseId;?>';
		$('label.error').remove();
		$('input.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
		});
		if(!$(formId).is(":visible")){
				$(formId).slideToggle('slow');
		}
		//set default menu active
		$("#fileMenu"+browseId).addClass("active"); 
		$("#embedMenu"+browseId).removeClass("active"); 
		//-----------file add condition------------//
		if(data.mediaFormAction == 'mediaAdd'){
			$(formId+' form')[0].reset();
			//$(formId+' form input[type=hidden]').val('');
			//-------set lenght default value-----//
				$('#hh').val('00');
				$('#hh').selectBoxJquery('value', '00');
				$('#mm').val('00');
				$('#mm').selectBoxJquery('value', '00');
				$('#ss').val('00');
				$('#ss').selectBoxJquery('value', '00');
			
			//---------set deafult media type if set in criteria upload form----//
			if(!data.isMediaSet){
					$('#Uploadvideo<?php echo $browseId;?>').show();
					$('#FileUpload<?php echo $browseId;?>').show();
					$('#rawFileNameDiv<?php echo $browseId;?>').hide();
					$('#selectFileTypeDiv<?php echo $browseId;?>').show();
					$('#uploafFileButton<?php echo $browseId;?>').show();
					$('#embedButton<?php echo $browseId;?>').show();
					$('#EmbeddedURL<?php echo $browseId;?>').hide();
					//------show default lenght div-----//	
					$("#fileLengthDiv<?php echo $browseId;?>").show();
					$("#dimensionsDiv<?php echo $browseId;?>").hide();
					$("#wordCountDiv<?php echo $browseId;?>").hide(); 
			}else{
				//set media view if already set 
				if(data.mediaOrder=="0"){
					$('#selectFileTypeDiv<?php echo $browseId;?>').hide();
					$('#uploafFileButton<?php echo $browseId;?>').hide();
					$('#embedButton<?php echo $browseId;?>').hide();
					selectedFileTypeShow(data.mediaType);
				}else{
					// set default media view
					$('#Uploadvideo<?php echo $browseId;?>').show();
					$('#FileUpload<?php echo $browseId;?>').show();
					$('#rawFileNameDiv<?php echo $browseId;?>').hide();
					$('#selectFileTypeDiv<?php echo $browseId;?>').show();
					$('#uploafFileButton<?php echo $browseId;?>').show();
					$('#embedButton<?php echo $browseId;?>').show();
					$('#EmbeddedURL<?php echo $browseId;?>').hide();
					//------show default lenght div-----//	
					$("#fileLengthDiv<?php echo $browseId;?>").show();
					$("#dimensionsDiv<?php echo $browseId;?>").hide();
					$("#wordCountDiv<?php echo $browseId;?>").hide(); 
					selectedFileTypeShow('2');
				}
			}	
			
			//---------set deafult value in form----//
			$.each(data, function(key, value){
			  if($(formId+' form [name=' + key + ']') !='undefind'){
				  $(formId+' form [name=' + key + ']').val(value);
			  } });
		
			//$('#galImg_'+browseId).attr('src','<?php echo $defaultImagePath;?>');
		}else{
			
			$.each(data, function(key, value){
			  if($(formId+' form [name=' + key + ']') !='undefind'){
				  $(formId+' form [name=' + key + ']').val(value);
			  }
			});
			
			if(data.coverImage != 'undefind'){
				$('#galImg_'+browseId).attr('src',data.coverImage);
			}
			
			//set file length show 
			if(data.fileLength){
				if(data.hh && data.mm && data.ss){
					$('#fileLength').val(data.fileLength);
					data.hh=(data.hh.length==1)?'0'+data.hh:data.hh;
					$('#hh').val(data.hh);
					$('#hh').selectBoxJquery('value', data.hh);
					data.mm=(data.mm.length==1)?'0'+data.mm:data.mm;
					$('#mm').val(data.mm);
					$('#mm').selectBoxJquery('value', data.mm);
					data.ss=(data.ss.length==1)?'0'+data.ss:data.ss;
					$('#ss').val(data.ss);
					$('#ss').selectBoxJquery('value', data.ss);
				}
			}
			
			
			// set file height and width
			if(data.fileHeight){
				$('#fileHeight').val(data.fileHeight);
			}else{
				$('#fileHeight').val('');
			}
				
			if(data.fileWidth){
				$('#fileWidth').val(data.fileWidth);
			}else{
				$('#fileWidth').val('');
			}
				
			// set file unit	
			if(data.fileUnit) {		
			   setSeletedValueOnDropDown('fileUnit',data.fileUnit);	   
			} else if  (!data.fileUnit) {		  		  
					setSeletedValueOnDropDown('fileUnit','');		  
			}
			// set file type
			
			$('#fileType<?php echo $browseId;?>').val(data.fileType);
			
			// media file div hide and show 
			if(data.isExternal=="f"){
				$('#Uploadvideo<?php echo $browseId;?>').show();
				$('#FileUpload<?php echo $browseId;?>').hide();
				$('#rawFileNameDiv<?php echo $browseId;?>').show();
				$('#rawFileNameDiv<?php echo $browseId;?>').html(data.rawFileName);
				$('#selectFileTypeDiv<?php echo $browseId;?>').hide();
				$('#uploafFileButton<?php echo $browseId;?>').hide();
				$('#embedButton<?php echo $browseId;?>').hide();
				$('#EmbeddedURL<?php echo $browseId;?>').hide();
				$('#isExternal<?php echo $browseId;?>').val(data.isExternal);
			}else{
				$('#Uploadvideo<?php echo $browseId;?>').hide();
				$('#FileUpload<?php echo $browseId;?>').hide();
				$('#rawFileNameDiv<?php echo $browseId;?>').hide();
				$('#selectFileTypeDiv<?php echo $browseId;?>').hide();
				$('#uploafFileButton<?php echo $browseId;?>').hide();
				$('#embedButton<?php echo $browseId;?>').show();
				$('#EmbeddedURL<?php echo $browseId;?>').show();
				$('#embbededURL<?php echo $browseId;?>').val(data.filePath);
				$('#isExternal<?php echo $browseId;?>').val(data.isExternal);
			}
		//	console.log(data);
			switch(data.fileType){
				case '1':
					$("#fileLengthDiv<?php echo $browseId;?>").hide();
					$("#dimensionsDiv<?php echo $browseId;?>").show();
					$("#wordCountDiv<?php echo $browseId;?>").hide();
				break;
				case '4':
					$("#fileLengthDiv<?php echo $browseId;?>").hide();
					$("#dimensionsDiv<?php echo $browseId;?>").hide();
					$("#wordCountDiv<?php echo $browseId;?>").show();
				break;
				default:
					$("#fileLengthDiv<?php echo $browseId;?>").show();
					$("#dimensionsDiv<?php echo $browseId;?>").hide();
					$("#wordCountDiv<?php echo $browseId;?>").hide();
				break;
			}
			
		}
		$('#browseId').val(browseId);
	}
</script>
