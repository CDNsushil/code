<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$browseid='newsVideo';
?>
<div class="width400px fr">
		<div class="tac pb20">
			<h3>Add News Video</h3>
		</div>
		<div class="width320px row fr " >
			<div id="uploadFileByJquery"></div>
			<div class="line"></div>
		<div class="seprator_15 clear "></div>
		</div>
		<?php
			//here news video upload form
			$this->load->view("common/admin_video_upload");
			$countPR=0;
			$icon='video1.png';
			if(!empty($videoFile) && $videoFile > 0 && $MediaFileData){
				
					
					?>
					
					<div class="row fr  width320px pb10">
					  <div class=" cell  extract_content_bg " id="rowData3">
						<div class="extract_img_wp "> 
							<img src="<?php echo base_url('images/icons/'.$icon);?>" class="formTip ptr maxWH30 ma">
						</div>
						<!--extract_img_wp-->
						<div class="extract_heading_box width220px"><?php 
						echo ($MediaFileData['isExternal']=="f")? substr($MediaFileData['fileName'],0,20).'....':"Embed Video";?></div>
						<!--extract_heading_box--> 
															<!--extract_quota_box-->
						<div class="extract_button_box">
							<?php
							
							$matreialData = array("fileInput" => '', "isExternal" => $MediaFileData['isExternal'], "fileId" => $MediaFileData['fileId'], "fileName" => $MediaFileData['fileName'], "fileSize" => $MediaFileData['fileSize']);
							$jsonVideoData=json_encode($matreialData); ?>
							
							<script>var data = <?php echo $jsonVideoData;?>;</script>
							
							<div title="Delete" class="small_btn formTip"><a onclick="deleteNewsVideoRowAdmin('MediaFile','fileId','<?php echo $MediaFileData['fileId'];?>','','','','<?php echo $pressReleaseId;?>','<?php echo $MediaFileData['fileId'];?>',1,'Are you sure you want to delete?');" href="javascript:void(0)"><div class="cat_smll_plus_icon"></div></a></div>
							<div class="small_btn formTip" title="Edit"><a onclick="fillVideoFormValue(data, '#uploadElementForm<?php echo $browseid?>')" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
						</div>
					  </div>
					</div>	
					
									
					<?php
			}
			else{ ?>
				<div class="row fr  width320px pb10 opacity_4">
					  <div class=" cell  extract_content_bg " id="rowData3">
						<div class="extract_img_wp "> 
							<img src="<?php echo base_url('images/icons/'.$icon);?>" class="formTip ptr maxWH30 ma">
						</div>
						<!--extract_img_wp-->
						<div class="extract_heading_box width220px">Add Video</div>
						<!--extract_heading_box--> 
															<!--extract_quota_box-->
						<div class="extract_button_box">
						<?php
							$videoFileId = (!empty($videoFile) && $videoFile > 0)?$videoFile:0;
							$matreialData = array("fileInput" => '', "isExternal" => 'f', "fileId" => 0, "fileName" => '', "fileSize" => 0);
							$jsonVideoData=json_encode($matreialData); ?>
							
							<script>var data = <?php echo $jsonVideoData;?>;</script>
							
						  <div class="small_btn formTip" title="Add"><a onclick="fillVideoFormValue(data, '#uploadElementForm<?php echo $browseid?>')" href="javascript:void(0)"><div class="cat_smll_add_icon"></div></a></div>
						</div>
					  </div>
				</div>	
				
				<?php
			} ?>
			<div class="seprator_25 clear "></div>
</div>

