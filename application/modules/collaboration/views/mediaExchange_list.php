<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$browseId='_cm';
$defCoverImage=$this->config->item('defaultMediaImg_s');
$mainCoverImage = '';
$coverImage = addThumbFolder($mainCoverImage,$suffix='_xxs',$thumbFolder ='thumb',$defCoverImage);	
$coverImage = getImage($coverImage,$defCoverImage);

if(isset($mediaData) && count($mediaData) > 0 && !empty($mediaData) ) {
	foreach($mediaData as $i=>$data ){
			$getExplodeArr = explode(":",$data->fileLength);
			$data->hh = $getExplodeArr[0];
			$data->mm = $getExplodeArr[1];
			$data->ss = $getExplodeArr[2];
			$data->wordCount = $data->fileLength;
			
			$membersId=explode(',', substr($data->membersId, 1, (strlen($data->membersId)-2)));
			$members= getMEmembersDetails($membersId);
			
			$data->membersId = $membersId;
			$data->members = $members;

		// set cover image by file type
		if($data->isExternal=="f"){
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
		
		
		$data=$data;
		
		$jsonData=json_encode($data);
	?>
		<script>var dataCM<?php echo $i;?> = <?php echo $jsonData;?>;</script>
		<div class="row" id="CG<?php echo $i;?>">
			<div class="label_wrapper cell"><div class="labeldiv"><span>File <?php echo ($i+1);?></span></div></div>									 
			<div id="CGData<?php echo $i;?>" class="cell frm_element_wrapper extract_content_bg">
				
				<div class="cell ptr" onclick="lightBoxWithAjax('popupBoxWp','popup_box','/collaboration/mediaExchangeDetails/',dataCM<?php echo $i;?>);">
					<div class="extract_img_wp"> 
						<img class="formTip ptr maxWH30 ma" src="<?php echo $coverImageShow;?>"  title="<?php echo $data->title; ?>"  />
					</div>
					<!--extract_heading_box-->
					<div class="extract_heading_box"> <?php  echo  getSubString($data->title,50); ?> </div>
				</div>
				
				<!--extract_button_box-->
				<div class="extract_heading_box width100px"> <?php  echo date("d M Y", strtotime($data->fileCreateDate)); ?> </div>
				<?php if($userId==$ownerId){?>
				<div class="extract_button_box">
					<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:collaborationMediaDelete(<?php echo $data->exchangeId;?>,<?php echo $data->fileId;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
					<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#collaborationMediaFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
				</div>
				<?php } ?>
			</div>
			<div class="clear"></div>
		</div>
		
	<?php  	
	
	
	}
	echo '<div class="seprator_25 clear"></div>	';
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
		$('.membersIdCheckbox').attr('checked',false);
		//set default menu active
		$("#fileMenu"+browseId).addClass("active"); 
		$("#embedMenu"+browseId).removeClass("active"); 
		//-----------file add condition------------//
			$.each(data, function(key, value){
			  if($(formId+' form [name=' + key + ']') !='undefind'){
				  $(formId+' form [name=' + key + ']').val(value);
			  }
			});
			
			if(data.membersId != 'undefind'){
				$.each(data.membersId, function(k, val){
				 $('#membersId'+val).attr('checked',true);
				});
				
				showHideMebers('#membersId0');
			}
			
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
			runTimeCheckBox();
		$('#browseId').val(browseId);
	}
</script>
