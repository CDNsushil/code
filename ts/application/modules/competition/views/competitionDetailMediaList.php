<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

	if(!empty($competitionMediaData) && is_array($competitionMediaData)){
?>	
<div class="seprator_40"> </div>
<div class="pl16">
<?php 
	$rowCount=1;
	$mediaFileLength='';
	foreach($competitionMediaData as $competitionMedia){ 
	switch($competitionMedia->fileType){
	case 1:
		$mediaFileType = $this->lang->line('mediaFileTypeNameImage');
		if($competitionMedia->fileWidth!="" && $competitionMedia->fileHeight){
			$mediaFileLength = '- '.$competitionMedia->fileWidth.$competitionMedia->fileUnit.' X '.$competitionMedia->fileHeight.$competitionMedia->fileUnit;
		}else{
			$mediaFileLength='';
		}
	break;	
	case 2:
		$mediaFileType = $this->lang->line('mediaFileTypeNameVideo');
		if($competitionMedia->fileLength=="00:00:00"){
			$mediaFileLength='';
		}else{
			$mediaFileLength = '- '.getTimeFormate($competitionMedia->fileLength);
		}
	break;
	case 3:
		$mediaFileType = $this->lang->line('mediaFileTypeNameAudio');
		if($competitionMedia->fileLength=="00:00:00"){
			$mediaFileLength='';
		}else{
			$mediaFileLength = '- '.getTimeFormate($competitionMedia->fileLength);
		}
	break;
	case 4:
		$mediaFileType = $this->lang->line('mediaFileTypeNameText');
		if(!empty($competitionMedia->fileLength)){
			$mediaFileLength = '- '.$competitionMedia->fileLength.' words';
		}else{
			$mediaFileLength='';
		}
	break;
}	
?>
	<!--media row start-->
		<div class="row">
			<div class="colomboxLeft">
				<?php echo $this->lang->line('mediaLable'); ?> <?php echo $rowCount; ?>
			</div>
			<div class="colomboxRight font_size15 bdr_non">
				<div>
					<?php echo $mediaFileType; ?> <?php echo $mediaFileLength; ?>
				</div>
				<div class="font_opensans clr_333 font_size13 mt2">
					<?php echo $competitionMedia->description; ?>
				</div>
			</div>
			<div class="clear">
			</div>
			<div class="seprator_15">
			</div>
		</div>
	<!--media row end-->
<?php $rowCount++; }  ?> 
</div>
<?php } ?>
