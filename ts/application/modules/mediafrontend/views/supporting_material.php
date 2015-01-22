<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
	
if($suportLinks && is_array($suportLinks) && count($suportLinks) > 0){
	/*echo "<pre>";
		print_r($suportLinks);
	echo "</pre>";*/
	?>
		 
	<div class="row summery_right_archive_wrapper width_auto">
		<h1 class="sumRtnew_strip <?php echo $clr_white;?>">Supporting Material</h1>
		<div class="seprator_6"></div>
		<?php
			foreach($suportLinks as $k=> $links)
			{
			  
			   if(!empty($links['title'])){
				$supportingImage=$links['image'];
				$section=$links['section'];
				if($section=='filmNvideo' || strstr($section,'FvElement')){
					$sectionHeading=$this->lang->line('filmNvideo');
					$imagetype = $this->config->item('filmNvideoImage_xxs');
				}
				elseif($section=='musicNaudio' || strstr($section,'MaElement')){
					$sectionHeading=$this->lang->line('musicNaudio');
					$imagetype = $this->config->item('musicNaudioImage_xxs');
				}
				elseif($section=='photographyNart' || strstr($section,'PaElement')){
					$sectionHeading=$this->lang->line('photographyNart');
					$imagetype = $this->config->item('photographyNartImage_xxs');
				}
				elseif($section=='writingNpublishing' || strstr($section,'WpElement')){
					$sectionHeading=$this->lang->line('writingNpublishing');
					$imagetype = $this->config->item('writingNpublishingImage_xxs');
				}
				elseif($section=='educationMaterial' || strstr($section,'EmElement')){
					$sectionHeading=$this->lang->line('educationMaterial');
					$imagetype = $this->config->item('educationMaterialImage_xxs');
				}
				elseif(strstr($section,'Events')){
					$sectionHeading=$this->lang->line('event');
					$imagetype = $this->config->item('defaultEventImg_xxs');
				}
				elseif(strstr($section,'Launch')){
					$sectionHeading=$this->lang->line('launch');
					$imagetype = $this->config->item('defaultEventImg_xxs');
				}
				else{
					$sectionHeading='';
					$imagetype = '';
					
				}
				
				$link=getFrontEndLink($links['entityid_from'],$links['elementid_from']);
				
				$supportingImage=addThumbFolder($supportingImage,$suffix='_xxs',$thumbFolder ='thumb',$defaultThumb=$imagetype);
				if(strstr($section,'PaElement') && $links['fileId']){
					$fileDetails=getDataFromTabel('MediaFile', $field='*',  $whereField='fileId', $links['fileId'], $orderBy='', $order='', $limit=1 );
					if($fileDetails){
						$file=$fileDetails[0];
						if($file->isExternal=='t'){
								$supportingImage=($file->filePath!='')?$file->filePath:'';
						}else{
							$supportingImage=$file->filePath.=$file->fileName;
							$supportingImage=addThumbFolder($supportingImage,$suffix='_xxs',$thumbFolder ='thumb',$defaultThumb=$imagetype);
						}
					}
				}
				$supportingImage=getImage($supportingImage,$imagetype);
				
				?>
				<a target="_blank" href="<?php echo $link;?>">
					<div class="row SMA_recent_box_wrapper_small mt4 mb5">
					  <div class="cell thumb_small ml9">
						<div class="AI_table">
						  <div class="AI_cell"><img border="0" class="blog_small_thumb" src="<?php echo $supportingImage;?>"></div>
						</div>
					  </div>
					  <div class="cell font_opensansSBold ml17 clr_Lgrey  width200px oh rowHeight40 dash_link_hover"><?php echo $sectionHeading;?><br><span class="clr_Lblack"><?php echo string_decode($links['title']);?></span> </div>
					  <div class="clear"></div>
					</div>
					<div class="line4 ml15"></div>
				</a>
				<?php
			}
		}
		?>
		<div class="clear"></div>
	 </div>
	<?php
}?>
			
