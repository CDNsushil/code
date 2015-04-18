<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
	 $itemCount=count($elements);

		if($elements){
						$r=0;
						$deleteCache=$indusrty.'_'.$projectId.'_'.$userId;
	                    $imagetype=$fileConfig['defaultImage'];
						foreach($elements as $k=>$element){
							$r++;
							
								if($indusrty=='photographyNart'){
									$src=getImage($element->filePath.$element->fileName,$imagetype);
								}else{
									$src=getImage($element->imagePath,$imagetype);
								}
								$isExternal=$element->isExternal;
								if($isExternal=='t'){
									$file=urlencode($element->filePath);
									$fileType='external';
								}else{
									$file=$element->filePath.$element->fileName;
								}
								if($element->wordCount > 0) $lenghtString= $element->wordCount.'&nbsp;'.$this->lang->line('words').'&nbsp;'; 
								elseif($element->fileLength > 0) $lenghtString= number_format(($element->fileLength/1048576),2).'&nbsp;'.$this->lang->line('mb');
								else $lenghtString= '';
								
								$jsonData=array(
									'entityId'=>$entityId,
									'title'=>$element->title,
									'fileLength'=>$lenghtString,
									'imgSrc'=>$src,
									'rawFileName'=>$element->rawFileName,
									'tags'=>$element->tags,
									'description'=>$element->description,
									'productionCompany'=>$element->productionCompany,
									'elementId'=>$element->elementId
								);
								if(strlen($element->tags)==0 && strlen($element->description)==0 &&  strlen($element->productionCompany)==0){
									$smallIcon='cat_smll_add_icon';
									$titleIcon='add';
								}else{
									$smallIcon='cat_smll_edit_icon';
									$titleIcon='edit';
								}
								$jsonData=json_encode($jsonData);
								
								$createdDate = $element->createdDate?$element->createdDate:date('Y-m-d');
								$createdDate = date('d M Y',strtotime($createdDate));
								
								$listLabel = (isset($industryType) && ($industryType=='reviews')) ? $this->lang->line('reviewListlabel') : $this->lang->line('article');
								
								?>
								<div class="row" id="row<?php echo $element->elementId;?>">
								
								<script>
									 var data<?php echo $element->elementId;?> = <?php echo $jsonData;?>;
								</script>
									
								
								 <div class="label_wrapper cell"> <div class="labeldiv"> <span><?php echo $listLabel;?></span> <?php echo $createdDate;?> </div></div>
								  <!--label_wrapper-->
								  <div id="rowData<?php echo  $element->elementId;?>" class=" cell frm_element_wrapper extract_content_bg">
									<div class="extract_img_wp"> 
										<img class="formTip ptr maxWH30 ma" src="<?php echo $src;?>" title="<?php echo $element->title; ?>" />
									</div>
									<!--extract_img_wp-->
									<div class="extract_heading_box"> <?php echo getSubString($element->title,25); ?> </div>
									<!--extract_heading_box-->
									<div class="extract_quota_box"> <?php echo $lenghtString;?></div>
									<?php
									if($elements[$k]->isBlocked != 't'){	?>
										<div class="extract_button_box">
										<?php 
										//TO shoe text accroding to publish/unpublish/hide property of a button
										 if($elements[$k]->isPublished =='t' && $elements[$k]->isBlocked !='t') 
											echo '<div class="cell orange_color mr12">'.$this->lang->line('yes_published').'</div>';
										 else if($elements[$k]->isPublished !='t' && $elements[$k]->isBlocked !='t')
											echo '<div class="cell orange_color fmoss mr12">'.$this->lang->line('not_published').'</div>';
										 else if( $elements[$k]->isBlocked =='t')	
											echo '<div class="cell orange_color mr12">'.$this->lang->line('yes_blocked').'</div>';
										?>	
										<div class="small_btn" title="<?php echo $this->lang->line($titleIcon);?>"><a href="javascript:void(0)" onclick="changeFurtherDescriptionFormValue(data<?php echo $element->elementId;?>)"><div class="<?php echo $smallIcon;?>"></div></a></div>
										
										<!---make video image as project conver image code start--->	
										<?php 
										if(isset($elements[$k]->isProjectImage) && $elements[$k]->isProjectImage=="f" && $elements[$k]->imagePath!="" && $elements[$k]->isPublished =='t' && $elements[$k]->isBlocked !='t'){ ?> 
												<div  class="small_btn formTip" title="<?php echo $this->lang->line('prmtnalPrimaryImg');?>"><a href="javascript:void(0)" onclick="makeProjectImage('<?php echo $elemetTable;?>',<?php echo $elements[$k]->projId; ?>,<?php echo $elements[$k]->elementId; ?>)" ><div class="cat_smll_star_icon"></div></a></div>	 
										<?php } ?>
										<!---make video image as project conver image code end--->
										
										</div><?php 
									} ?>
									
									
									
								  </div>
								</div>
								<?php
						}
					}
		 
		   
?> 

<div class="clear"></div>
<div class="clear seprator_10"></div>
<!-- PAGINATION -->  
<?php
if($items_total >  $perPageRecord){
	?>
	<div class="row">
		<div class=" cell width_200 Cat_wrapper">&nbsp;</div>
		<div class="cell width_569 margin_left_16 pagingWrapper">
			<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/media/'.$indusrty.'/editProject/furtherDescription/'.$projectId),"divId"=>"furtherDescriptionList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
			<div class="clear"></div>
		</div>
	</div>
	<?php
}
?>
