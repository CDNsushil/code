<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<td width="800" valign="top" class="fv_content_bg">
	<?php
	$isRecord=false;
	if($elements){
		$imagetype = $fileConfig['defaultImage_m'];
		$imagetype_xs=$fileConfig['defaultImage_xs'];
		$imagetype_s=$fileConfig['defaultImage_s'];
		$method=$methodName=$industryType;
		$thumbFolder='thumb';
		$elementHeading=$elements[0]['projName'];
		$tdsUid=$elements[0]['tdsUid'];
		
		$userInfo =showCaseUserDetails($tdsUid);
		if(isset($userInfo['enterprise']) && $userInfo['enterprise'] == 't'){
			$creative_name= $userInfo['enterpriseName'];
		}else{
			$creative_name= $userInfo['userFullName'];
		}
		?>
		<div class="row  pl6 pr6 pt10 pb10">
			<h1 class="sumRtnew_strip clr_white"><?php echo $elementHeading;?></h1>
			<div class="grey mt5"><?php echo $creative_name;?></div>
			<div class="mt11  global_shadow rightBoxBG pl6 pr6 pt10 width_766">
				  <ul>
						<?php
						$pieceSrartFrom=1;
						$rowCount=2;
						foreach($elements as $e=>$element){
							$fileName=trim($element['fileName']);
							$filePath=trim($element['filePath']);
							$fpLen=strlen($filePath);
							if($fpLen > 0 && substr($filePath,-1) != '/'){
								$filePath=$filePath.'/';
							}
							$file=$filePath.$fileName;
							if(is_file($file)){
								$isRecord=true;
								if($industryType=='photographyNart'){
									if($element['projSellstatus']){
										$thumbFolder='watermark';
									}
									$thumbImage = addThumbFolder($element['filePath'].$element['fileName'],'_xs',$thumbFolder);	
									$elementImage=getImage($thumbImage,$imagetype_xs,'');
									$elementImage=$element['isExternal']=='t'?trim($element['filePath']):$elementImage;
								}else{
									$thumbImage = addThumbFolder($element['imagePath'],'_xs');	
									$elementImage=getImage($thumbImage,$imagetype_xs);
								}
								$elementTextColor='';
								 
								$craveCount=$element['craveCount']>0?$element['craveCount']:0;
								$viewCount =$element['viewCount']>0?$element['viewCount']:0;
								
								$cravedALL='';
								$loggedUserId=isloginUser();
								if($loggedUserId > 0){
									$where=array(
													'tdsUid'=>$loggedUserId,
													'entityId'=>$entityId,
													'elementId'=>$element['elementId']
												);
									$countResult=countResult('LogCrave',$where);
									$cravedALL=($countResult>0)?'cravedALL':'';
								}else{
									$cravedALL='';
								}
								  
															
								$downloadDetails=array(
											'ownerId'=>$element['tdsUid'],
											'entityId'=>$entityId,
											'elementId'=>$element['elementId'],
											'projectId'=>$element['projId'],
											'fileId'=>$element['fileId'],
											'tableName'=>'Project',
											'primeryField'=>'projId',
											'elementTable'=>$elemetTable,
											'elementPrimeryField'=>'elementId',
											'isElement'=>1,
											'buyerId'=>$buyerId,
											'dwnId'=>$dwnId
								);
								$downloadLink=$downloadDetails['ownerId'].'+'.$downloadDetails['entityId'].'+'.$downloadDetails['elementId'].'+'.$downloadDetails['projectId'].'+'.$downloadDetails['fileId'].'+'.$downloadDetails['tableName'].'+'.$downloadDetails['primeryField'].'+'.$downloadDetails['elementTable'].'+'.$downloadDetails['elementPrimeryField'].'+'.$downloadDetails['isElement'].'+'.$downloadDetails['buyerId'].'+'.$downloadDetails['dwnId'];
								$downloadLink=encode($downloadLink);
								$downloadLink=lcfirst($downloadLink);
								$downloadLink=base_url(lang().'/download/file/'.$downloadLink);
								
								$lenghtString='';
								
								if($element['fileType']=='image' || $element['fileType']==1){
									$lenghtString=($element['fileHeight'] > 0 && $element['fileWidth'] > 0)? $element['fileHeight'].'&nbsp;x&nbsp;'.$element['fileWidth'].'&nbsp;'.substr(@$element['fileUnit'],0,2):''; 
									if($lenghtString!=''){
											$lenghtString='Dimensions: '.$lenghtString;
									}
								}
								elseif($element['fileType']=='video' || $element['fileType']==2){
									$lenghtString=($element['fileLength']=='0:0:0' || $element['fileLength']=='00:00:00')?'':$element['fileLength'];
									if($lenghtString!=''){
											$lenghtString='Length: '.$lenghtString;
									}
								}elseif($element['fileType']=='audio' || $element['fileType']==3){
									$lenghtString=($element['fileLength']=='0:0:0' || $element['fileLength']=='00:00:00')?'':$element['fileLength'];
									if($lenghtString!=''){
											$lenghtString='Length: '.$lenghtString;
									}
								}
								elseif($element['fileType']=='text' || $element['fileType']==4){
									$lenghtString=($element['wordCount'] > 0)?$element['wordCount'].'&nbsp;'.$this->lang->line('words'):'';
									if($lenghtString!=''){
											$lenghtString='Word Count: '.$lenghtString;
									}
								}
								
								if(is_numeric($element['fileSize']) && $element['fileSize'] > 0){
									$fileSize=bytestoMB($element['fileSize'],'mb');
									if($lenghtString !=''){
										$lenghtString.="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Size: $fileSize ".$this->lang->line('mb');
									}else{
										$lenghtString="Size: $fileSize ".$this->lang->line('mb');
									}
									
								}

								?>						
								<li class="height80">
								  <a class="" href='<?php echo $downloadLink;?>' onmousedown="mousedown_tds_download('#dwnFileBtrn<?php echo $element['elementId'];?>')" onmouseup="mouseup_tds_download('#dwnFileBtrn<?php echo $element['elementId'];?>')">
									  <div class="row recent_box_wrapper01 mH70" >
										  <div class="cell recent_thumb_PApage thumb_absolute01 ptr" >
											<div class="AI_table">
											  <div class="AI_cell"> <img class="max_w68_h68 bdr_cecece" src="<?php echo $elementImage;?>"></div>
											</div>
										  </div>
										  <div class="row ml70 ">
											<div class="row recent_two_line01 height_30 lh25 pl20 fm_os"><?php echo getSubString($element['title'],100);?></div>
											
											<div class="row SMA_blog_status_bar width_687">
												<div class="fl pl15 pt5 ">
													<?php echo $lenghtString;?>
												</div>
												<div class="fr ml50 ">
													<div class="download_btn Fright"><div id="dwnFileBtrn<?php echo $element['elementId'];?>" ><span class="font_opensans min_widht63">Download</span></div> </div>
												</div>
												<div class="mt7 fr ">
													<div class="blogS_view_btn fl minwidth ml8"><span class="inline"><?php echo $viewCount;?></span></div>
													<div class="blogS_crave_btn fl minwidth ml20 <?php echo $cravedALL;?>"><span class="inline"><?php echo $craveCount;?></span></div>
												</div>
											</div>
										  </div>
										
										<div class="clear"></div>
									  </div>
								  </a>
							  </li>
								<?php
								$rowCount++;
							}
						}
						?>
				  </ul>
			</div>
		</div>
		<?php
	}
	
	if(!$isRecord){
		echo '<div class="p10 red">'.$this->lang->line('noRecord').'</div>';
		//redirectToNorecord404();
	} ?>
</td>
<td class="advert_column"  valign="top">
	<div class="cell advert_column ">
	  <div class="seprator_5"></div>
		<div class="ad_box ml11 mt10 mb10"><?php $this->load->view('common/adv_vertical'); ?></div>
	</div>
</td>
<?php
/* End of file media.php */
/* Location: ./application/module/media/view/media.php */
/* Wriiten By Sushil Mishra */

