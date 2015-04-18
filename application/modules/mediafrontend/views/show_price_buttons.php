<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$mainProjectFlag = 't';
if(isset($project['elements']) && count($project['elements'])>0){//check if no element is present
	if($project['projSellstatus']!='t'){
		$mainProjectFlag = 'f';
	}
	elseif(($project['isprojPrice']=='f' && $project['isprojDownloadPrice']=='f' && $project['isprojPpvPrice']=='f')){
		$mainProjectFlag = 'f'; //If main project is free then all elements are available for download
	}

	$isMajor=($project['showPrice']=='f')?true:false;

	$priceBtnDetails = array(
		'ownerId'=>$userId,
		'projEntityId'=>$projEntityId,
		'entityId'=>$elementEntityId,
		'sectionId'=>$buttonElement['sectionId'],
		'elementId'=>$buttonElement['mediaElementId'],
		'projectId'=>$project['projId'],
		'fileId'=>$buttonElement['mediaId'],
		'tableName'=>'Project',
		'primeryField'=>'projId',
		'elementTable'=>$elemetTable,
		'elementPrimeryField'=>'elementId',
		'isElement'=>1,
		'isMajor'=>$isMajor,
		'projSellstatus'=>($project['projSellstatus']=='t')?true:false,
		'isprojPrice'=>($project['isprojPrice']=='t')?true:false,
		'projPrice'=>$project['projPrice'],
		'isprojDownloadPrice'=>($project['isprojDownloadPrice']=='t')?true:false,
		'projDownloadPrice'=>$project['projDownloadPrice'],
		'isPrice'=>($buttonElement['isPrice']=='t')?true:false,
		'isDownloadPrice'=>($buttonElement['isDownloadPrice']=='t')?true:false,
		'price'=>$buttonElement['price'],
		'downloadPrice'=>$buttonElement['downloadPrice'],
		'isprojPpvPrice'=>($project['isprojPpvPrice']=='t')?true:false,
		'projPpvPrice'=>$project['projPpvPrice'],
		'isPerViewPrice'=>($buttonElement['isPerViewPrice']=='t')?true:false,
		'perViewPrice'=>$buttonElement['perViewPrice'],
		'fileName'=>$buttonElement['fileName'],
		'filePath'=>$buttonElement['filePath'],
		'isExternal'=>$buttonElement['isExternal'],
		'isDefault'=>$buttonElement['default'],
		'seller_currency'=>$seller_currency,
		'isGlobalDownload'=>$isGlobalDownload,
		'isGlobalPPV'=>$isGlobalPPV,
		'isMajor'=>$isMajor,
		'elementPresent'=>isset($buttonElement['elementPresent'])?$buttonElement['elementPresent']:'f',
		'globalProjDownloadable'=>$globalProjDownloadable
	);
//echo '<pre />';print_r($priceBtnDetails);
	if(($buttonElement['isPrice']=='f' && $buttonElement['isDownloadPrice']=='f' && $buttonElement['isPerViewPrice']=='f')|| $buttonElement['default']=='t' || $mainProjectFlag=='f' ){
		
			$buttonElement['isExternal'] = isset($buttonElement['isExternal'])?$buttonElement['isExternal']:'f';
			
			$mediaFilePresent = $buttonElement['filePath'].$buttonElement['fileName'];
			
			if(!isset($buttonElement['buttonStyle']) || $buttonElement['buttonStyle']=='small'){
				if(($buttonElement['isExternal']!='t' || $buttonElement['fileType']=='text' || $buttonElement['fileType']==4) && $buttonElement['mediaId'] > 0 && $globalProjDownloadable =='t' && is_file($mediaFilePresent) || ($project['projectType']=='reviews' || $project['projectType']=='news')){
				?>
					<div class="morapiece_strip font_opensans font_size18 text_indent34 <?php echo @$buttonElement['pieceTextClass'];?>"><?php echo @$pieceTitle;?></div>
					<div class="clear"></div> 
				<?php
				}
			}		
			if(($buttonElement['fileType']=='text' || $buttonElement['fileType']==4) || ($project['projectType']=='reviews' || $project['projectType']=='news')){
			
			if($buttonElement['isExternal']!='t' && $buttonElement['mediaId'] > 0 && $project['projectType']=='reviews') {   ?>
				<div class="Fright">
					<div class="tds-button01 cell mr3 Fright">
						<a onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)" href="#" onclick="openLightBox('popupBoxWp','popup_box','/common/swfVideo','<?php echo @$buttonElement['mediaId'];  ?>','<?php echo @$buttonElement['entityId'];  ?>','<?php echo @$buttonElement['mediaProjectId'];  ?>','<?php echo @$buttonElement['mediaElementId'];  ?>');"  class="black_link_hover" >
						<span><?php echo $this->lang->line('read'); ?></span>
						</a>
					</div>
				</div>
			<?php	}  
			
			if($project['projectType']=='news') { ?>
				<div class="Fright">
					<div class="tds-button01 cell mr3 Fright">
						<a onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)" href="#" onclick="openLightBox('popupBoxWp','popup_box','/common/swfVideo','<?php echo @$buttonElement['mediaId'];  ?>','<?php echo @$buttonElement['entityId'];  ?>','<?php echo @$buttonElement['mediaProjectId'];  ?>','<?php echo @$buttonElement['mediaElementId'];  ?>');"  class="black_link_hover" >
						<span><?php echo $this->lang->line('read'); ?></span>
						</a>
					</div>
				</div>
			<?php  }  ?>
			
			<?php 
			}
			?>
			<div class="Fright">
			<?php
			if($buttonElement['isExternal']!='t' && $buttonElement['mediaId'] > 0){
				$downloadButtonParams['buttonStyle']=(!isset($buttonElement['buttonStyle']) || $buttonElement['buttonStyle']=='small')?'small':'big';
				$downloadButtonParams['downloadDetails']=$priceBtnDetails;
				$this->load->view('media_download_button',$priceBtnDetails);
			}
			?>
			</div>
			<div class="clear"></div>
			<?php
	}else{
		
			//qunatityFlag will be true if we want to display button according to Quanitty present default it is false
			$qunatityFlag='t';

			//shippingFlag will be true if we want to display button according to shippingFlag present default it is true
			$shippingFlag = 't';

			//Array is passed to give property of price button to get shown on the basisi of those
			$productButtonProperty = array(
				'price'=>@$buttonElement['price'],
				'priceFlag'=>$buttonElement['isPrice'],
				'quantity'=>@$buttonElement['quantity'],
				'elementId'=>$project['projectId'],
				'entityId'=>$projEntityId,
				'projId'=>$project['projectId'],
				'sectionId'=>$sectionId,
				'shippingFlag'=>$shippingFlag,
				'qunatityFlag'=>$qunatityFlag,
				'seller_currency'=>$seller_currency,
				'buttonClass'=>' ',
				'tdsUid'=>@$buttonElement['tdsUid'],
				'buttonStyle'=>isset($buttonElement['buttonStyle'])?$buttonElement['buttonStyle']:'small'
			);
			
			//Array is passed to give property of download button to get shown on the basisi of those
			$downloadButtonProperty = array(
				'price'=>@$buttonElement['downloadPrice'],
				'showFlag'=>$buttonElement['isDownloadPrice'],
				'seller_currency'=>$seller_currency,
				'buttonClass'=>' ',
				'tdsUid'=>@$buttonElement['tdsUid'],
				'buttonStyle'=>isset($buttonElement['buttonStyle'])?$buttonElement['buttonStyle']:'small'
			);
			//Array is passed to give property of download button to get shown on the basisi of those
			$PPVButtonProperty = array(
				'price'=>@$buttonElement['perViewPrice'],
				'showFlag'=>$buttonElement['isPerViewPrice'],
				'seller_currency'=>$seller_currency,
				'buttonClass'=>' ',
				'isMajor'=>$isMajor,
				'tdsUid'=>@$buttonElement['tdsUid'],
				'buttonStyle'=>isset($buttonElement['buttonStyle'])?$buttonElement['buttonStyle']:'small'
			);
			
			$downloadButtonProperty['downloadDetails']=$priceBtnDetails;
			$productButtonProperty['priceBtnDetails']=$priceBtnDetails;
			$PPVButtonProperty['priceBtnDetails']=$priceBtnDetails;
			
			$productButton = Modules::run("common/showPriceButton",$productButtonProperty);						
			//$downloadButton = $this->load->view('media_download_button',$priceBtnDetails,true);					
			if($isGlobalDownload=='t'|| $isMajor)
				$downloadButton = $this->load->view('media_download_button',$priceBtnDetails,true);	
			else	
				$downloadButton = '';	
						
			$PPVButton = Modules::run("common/showPPVButton",$PPVButtonProperty);
		
	if(@$productButton['view']!='' || @$downloadButton !='' ||@$PPVButton['view']!=''){								
	?>

	<div class="morapiece_strip font_opensans font_size18 text_indent34 <?php echo @$buttonElement['pieceTextClass'];?>"><?php echo @$pieceTitle;?></div>
	<div class="clear"></div> 

	<div class="Fright"><?php echo @$productButton['view'].@$downloadButton.@$PPVButton['view'];	?></div>
	<div class="clear"></div> 
	<?php  } //else echo '<div class="seprator_5"></div>';
	}
}

?>

