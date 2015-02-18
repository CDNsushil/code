<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	$redirectUrl = base_url(lang().'/mediafrontend/'.$this->router->method.'/'.$userId.'/'.$project['projId']);
	$elements_array = search_nested_arrays($project,'elements');
	//echo '<pre />';print_r($elements_array);die;
	//echo '<pre />';print_r($elements_array);die;
	$entityId_array = search_nested_arrays($elements_array,'entityId');
	//	echo '<pre />';print_r($entityId_array);die;
	$entityId = $entityId_array[0];
	$imagePath_array = search_nested_arrays($elements_array,'imagePath');
	$title_array = search_nested_arrays($project,'title');
	$elementId_array = search_nested_arrays($project,'elementId');
	$isExternal_array = search_nested_arrays($project,'isExternal');
	$file_path_array = search_nested_arrays($project,'filePath');
	//$file_name_array = search_nested_arrays($project,'fileName');
	
	
	/************Player show parameter start****************/
	
	$file_id_array = search_nested_arrays($project,'fileId');
	$file_filePath = search_nested_arrays($project,'filePath');
	$entityId_array = search_nested_arrays($project,'entityId');
	$elementId_array = search_nested_arrays($project,'elementId');
	$projId_array = search_nested_arrays($project,'projId');
	$file_fileName = search_nested_arrays($project,'fileName');
	
	
	/************player show paramerte end*********************/
	
	
	for($j = 0; $j <count($imagePath_array); $j++){
		$img_array[$j] = @$imagePath_array[$j];
	}	
	
	for($j = 0; $j <count($file_id_array); $j++) {		
	
		$mediaId = $file_id_array[$j];
		$filePath = $file_filePath[$j];
		$elementEntityId = $entityId_array[$j];
		$elementId = $elementId_array[$j];
		$projectId = $projId_array[$j];
		
		$fileName = $filePath.$file_fileName[$j];	
		
		if($isExternal_array[$j] == "t") {
			//get external video src 
			$src =  getExternalMediaSrc($filePath,$mediaId,$elementEntityId,$elementId,$projectId);
			$getSrc = $src[0];
			$isvalidUrl = ($src[1])?true:false;
			$video_array[$j] = $getSrc;	 
		}else {
			// This code will be play uploaded mp4 video
			
			$isFileExist = getMediaImage($fileName);		
		    if($isFileExist!=''){
			  $getSrc = base_url().'en/player/getMainPlayerIframe/'.$mediaId.'_full/'.$elementEntityId.'/'.$elementId.'/'.$projectId;	
			  $video_array[$j] = $getSrc;			
		     }		
			
			$isvalidUrl=true;
		}   
							
	}		
	
	
	$img_array['img_array'] = $img_array;
	$img_array['title_array'] = $title_array;
	$img_array['elementId'] = $elementId_array;
	$img_array['redirectUrl'] = $redirectUrl;
	$img_array['video_array'] = $video_array;	
	$popup_videos=$this->load->view('popup_videos',$img_array , true);
	
	if (!array_filter($img_array['video_array'])) {
			$showGallery =0; // No Image to show
		}else {
			$showGallery =1;					
		}  ?>
		
	<script>
		var popup_videos=<?php echo json_encode($popup_videos);?>;
	</script>

<div class="seprator_25"></div>
<?php if($showGallery==1){   ?>
<div class="row summery_right_archive_wrapper width_auto">
	<h1 class="sumRtnew_strip clr_white"><?php echo $this->lang->line('gallery');?>
		 <div class="text_indent0 Fright mr28 ">
			 <a class="veiw_gallary_btn" onmouseup="mouseup_viewG_btn(this)" onmousedown="mousedown_viewG_btn(this)" onclick="loadPopupData('popupBoxWp','popup_box',popup_videos);"> <div class="Fleft ">View</div><div class="btn_gallary_icon"></div></a>
		</div>
	</h1>
</div>

<?php } else { ?>

<div class="row summery_right_archive_wrapper width_auto">
	<h1 class="sumRtnew_strip clr_white"><?php echo $this->lang->line('gallery');?>
		 <div class="text_indent0 Fright mr28 ">
			 <a class="veiw_gallary_btn opacity_4 formTip"> <div class="Fleft ">View</div><div class="btn_gallary_icon"></div></a>
		</div>
	</h1>
</div>

<?php } ?>
