<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div id="MediaFileIdDiv"></div>
<div class="width400px fr">
		<div class="tac pb20">
			<h3>Add Supporting Documents</h3>
		</div>
		<div class="width320px row fr " >
			<div id="uploadFileByJquery"></div>
			<div class="line"></div>
		<div class="seprator_15 clear "></div>
		</div>
		<?php
			$this->load->view("manage_common/admin_upload_file",array('section'=>$section));
			$countPR=0;
			if($PressReleaseNewsMaterial){
				$countPR=count($PressReleaseNewsMaterial);
				foreach($PressReleaseNewsMaterial as $i=>$matreial){
					$showPopup="";
					switch($matreial['fileType']){
						case 1:
							$icon='image.png';
							$showPopup='onclick="openPlayerLightBox(\'popupBoxWp\',\'popup_box\',\'/common/openCommonImage\',\''.$matreial['fileId'].'\',\'0\',\'0\',\'0\')"';
					
						break;
						
						case 2:
							$icon='video1.png';
							$showPopup='onclick="openPlayerLightBox(\'popupBoxWp\',\'popup_box\',\'/common/playCommonVideo\',\''.$matreial['fileId'].'\',\'0\',\'0\',\'0\')"';
						
						break;
						
						case 3:
							$icon='icon_music.png';
						break;
						
						case 4:
							if(strstr($matreial['fileName'], 'pdf') || strstr($matreial['fileName'], 'PDF')){
								$icon='adobepdficon.png';
							}else{
								$icon='docsfile.png';
							}
						break;
						
					}
					$fileDescription=encode(urlencode($matreial['filePath']).'+'.$matreial['fileName'].'+'.$matreial['rawFileName']);
					$jsonData=json_encode($matreial);
					?>
					<script>var data<?php echo $matreial['id'].$matreial['fileId'];?> = <?php echo $jsonData;?>;</script>
					<div class="row fr  width320px pb10">
					  <div class=" cell  extract_content_bg " id="rowData3">
						<div class="extract_img_wp "> 
							<img <?php echo $showPopup; ?> src="<?php echo base_url('images/icons/'.$icon);?>" class="formTip ptr maxWH30 ma">
						</div>
						<!--extract_img_wp-->
						<div class="extract_heading_box width220px"><?php echo $matreial['fileTitle']?></div>
						<!--extract_heading_box--> 
															<!--extract_quota_box-->
						<div class="extract_button_box">
							<div title="Delete" class="small_btn formTip"><a onclick="deleteTabelRowAdmin('PressReleaseNewsMaterial','id','<?php echo $matreial['id'];?>','','','','<?php echo $matreial['fileId'];?>',1,'Are you sure you want to delete?');" href="javascript:void(0)"><div class="cat_smll_plus_icon"></div></a></div>
							<div class="small_btn formTip" title="Edit"><a onclick="fillFormValue(data<?php echo $matreial['id'].$matreial['fileId'];?>, '#uploadElementForm')" href="javascript:void(0)"><div class="cat_smll_edit_icon"></div></a></div>
						</div>
					  </div>
					</div>	
					<div class="clear"></div>	
									
					<?php
				}
			}
			for($l=$countPR; $l<6; $l++){ ?>
				<div class="row fr  width320px pb10 opacity_4">
					  <div class=" cell  extract_content_bg " id="rowData3">
						<div class="extract_img_wp "> 
							<img src="<?php echo base_url('images/icons/docsfile.png');?>" class="formTip ptr maxWH30 ma">
						</div>
						<!--extract_img_wp-->
						<div class="extract_heading_box width220px">File <?php echo ($l+1)?></div>
						<!--extract_heading_box--> 
															<!--extract_quota_box-->
						<div class="extract_button_box">
						  <div class="small_btn formTip" title="Add"><a onclick="fillFormValue('0', '#uploadElementForm')" href="javascript:void(0)"><div class="cat_smll_add_icon"></div></a></div>
						</div>
					  </div>
				</div>	
				<div class="clear"></div>	
				<?php
			} ?>
</div>

