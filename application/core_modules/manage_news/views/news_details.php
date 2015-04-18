<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="pall3">
	<div class="bg_f3f3f3 pall8">
		<div class="enterprise_boxcon bg_white pt50 pb50 pr50 pl115 shedow_prnews pr">
			<a href="<?php echo base_url('news/index');?>"><div class="wpnewsclose2013 right15 "></div></a>
			<div class="row">
			  <div class="fl bdr5_f15921 lineH30  font_size24 font_opensansLight clr_231f20 letter_Spoint2 pb10">
				<?php echo $title;?>
			  </div>
			  <div class="clear"></div>
			  <div class="seprator_10"></div>
			  <div class="font_opensans font_size14 clr_5"><?php echo dateFormatView($date,'d F Y');?></div>
			</div>
			<div class="seprator_40"></div>
			
			<div class="row pr minH120">
				<div class="fl width_510 bdrR_ccc">
					
					<!----  <img alt="videoimh" src="<?php //echo base_url('images/videoimg.png');?>">-->
					 
					<?php 
					 
					$getFileId = $this->model_common->getDataFromTabelWhereIn('PressReleaseNews', $field='videoFile',  $whereField='id', $whereValue=$id, $orderBy='id', $order='ASC', $whereNotIn=0);
					
					if(!empty($getFileId))
					{
						$getFileId = $getFileId[0];
			
						if(!empty($getFileId['videoFile']) && $getFileId['videoFile'] > 0)
						{
							
							echo '<div class="">';
							/****************Show news video code here************/
					
								$mediaId = $getFileId['videoFile'];
								//$mediaId = 4747;
								$elementEntityId= 0;
								$elementId= 0;
								$projectId= 0;	
								$entityId = 0;		 
								//get media file type 
								$getType = $this->model_common->getDataFromTabelWhereIn('MediaFile', $field='fileType,isExternal,filePath',  $whereField='fileId', $whereValue=$mediaId, $orderBy='fileId', $order='ASC', $whereNotIn=0);
								if($getType[0]['isExternal']=="t")
								{
									//get external video src 
									$src =  getExternalMediaSrc($getType[0]['filePath'],$mediaId,$elementEntityId,$elementId,$projectId); 
									  
								}else
								{
									$src = base_url().'en/player/getPlayerIframe/'.$mediaId.'_full/'.$entityId.'/'.$elementId.'/'.$projectId;
								}
								
								echo  ' <iframe src="'.$src.'" width="467" height="264" class="bg_313131_imp" frameborder="0"  webkitAllowFullScreen mozallowfullscreen allowFullScreen scrolling="no"></iframe>';			
						
							/****************Show  news video code here************/
						
							echo '</div>
								  <div class="clear"></div>
								  <div class="seprator_45"></div>';
						}
					} ?>
			
				   <div class="width_465 font_size13 NIC"> 
				   		   <div class="bdrB_f15921 pb10 width_465">
								   <a target="_blank" href="<?php echo $url; ?>" class="font_size16 clr_f1592a"><?php echo $url; ?></a>
										</div>
							<div class="seprator_20"></div>   
						<?php echo $description;?>
					</div>
				 </div> 
				 
				 <div class="fr min_width236">
					 <?php
			$countPR=0;
			if($PressReleaseNewsMaterial){
				$countPR=count($PressReleaseNewsMaterial);
				foreach($PressReleaseNewsMaterial as $i=>$matreial){
					
					switch($matreial['fileType']){
						case 1:
							$icon='image.png';
						break;
						
						case 2:
							$icon='video1.png';
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
					//$fileDescription=encode($matreial['filePath'].'+'.$matreial['fileName'].'+'.$matreial['rawFileName']);
					$fileDescription=encode($matreial['fileId']);
					?>
					<div class="row">
						<a target="_blank" href="<?php echo base_url(lang().'/common/downloadFile/'.$fileDescription);?>"><div class="ml20"><img src="<?php echo base_url('images/icons/'.$icon);?>" /> </div>
							<div class="clear"></div>
							<div class="font_size13 clr_58595b mt5 ml30"><?php echo $matreial['fileTitle']?></div>
						</a>
					</div>
					<div class="seprator_27"></div>
					
					<?php
				}
				echo '<div class="seprator120"></div>';
			}?>
			
			<div class="row pa bottom_0 right_56">
					<div class="font_size14 clr_808285">Media Contact:</div>
					<div class=" seprator_22"></div> 
				   <div class="font_size12 clr_808285 lineh_20"> Gabriela Dvoráková<br />
					Best Communications<br />
					+420 601 357 066<br />
					gabriela.dvorakova@bestcg.com 
					</div>
					</div>
				 </div>
				 <div class="clear"></div>
			</div> <!-- /row -->
			
			<div class="seprator_74"></div>
		   
		   <div class="row font_opensans mt15">
			  <?php	
				$currentUrl = base_url().uri_string();
	        	$relation = array('getShortLink', 'email','share','entityTitle'=> $title, 'shareType'=>'news', 'shareLink'=> $currentUrl,'id'=> 'Project'.$id,'entityId'=>101,'elementid'=>$id,'projectType'=>$id,'isPublished'=>'t','viewType'=>'showcase');
		        $this->load->view('common/relation_to_share',array('relation'=>$relation));
	         ?>	
		</div>
		</div> <!-- enterprise_boxcon -->
	</div>
</div>
<!--<div class="seprator120"></div>-->

<!--End cmslist of title -->
