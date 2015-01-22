<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$downloadLink='#';
if(isset($downloadDetails['ownerId']) && isset($downloadDetails['entityId']) && isset($downloadDetails['elementId']) && isset($downloadDetails['projectId']) && isset($downloadDetails['fileId']) && isset($downloadDetails['tableName']) && isset($downloadDetails['primeryField']) && isset($downloadDetails['elementTable']) && isset($downloadDetails['elementPrimeryField']) && isset($downloadDetails['isElement'])){
	if($downloadDetails['isElement']==0){
		$downloadLink=base_url(lang().'/mediafrontend/downloadfile/'.$userId.'/'.$downloadDetails['elementId'].'/'.$industryType);
	}else{
		$downloadLink=$downloadDetails['ownerId'].'+'.$downloadDetails['entityId'].'+'.$downloadDetails['elementId'].'+'.$downloadDetails['projectId'].'+'.$downloadDetails['fileId'].'+'.$downloadDetails['tableName'].'+'.$downloadDetails['primeryField'].'+'.$downloadDetails['elementTable'].'+'.$downloadDetails['elementPrimeryField'].'+'.$downloadDetails['isElement'];
		$downloadLink=encode($downloadLink);
		$downloadLink=lcfirst($downloadLink);
		$downloadLink=base_url(lang().'/download/file/'.$downloadLink);
	}
}
$beforeDownloadLoggedIn=$this->lang->line('beforeDownloadLoggedIn');
if(isset($buttonStyle) && $buttonStyle=='big'){ ?>
	<div class="cell position_relative hiddenspaceDonate ptr">
		 <a target="_blank" href='<?php echo $downloadLink;?>' onclick="return checkIsUserLogin('<?php echo $beforeDownloadLoggedIn;?>');"><div class="huge_btn Price_btn_style" onmouseup="mouseup_huge_button(this)" onmousedown="mousedown_huge_button(this)"><span class="pt8 pb8"><?php echo $this->lang->line('download');?></span></div></a>
	</div>
	<?php 
}else { ?>
	<div class="fr">
		<div class="tds-button01 cell mr3"> 
			<a target="_blank"  href='<?php echo $downloadLink;?>' onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" onclick="return checkIsUserLogin('<?php echo $beforeDownloadLoggedIn;?>');">
				<span class="mr0" style="background-position: right 0px;">
					<?php echo $this->lang->line('download');?>
				</span>
			</a> 
		</div>
	</div>
	<?php 
} ?>
