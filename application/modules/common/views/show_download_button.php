<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if( $globalProjDownloadable =='t' && $elementPresent=='t')//if any donwloadable elemnt is presnet then show the PPV button && element are presnet for project
{
		
	if(isLoginUser() == false){
		$loginId=0;
	}else
	{
		$loginId=isLoginUser();
	}
			
	$tdsUid = (isset($tdsUid) && ($tdsUid!='')) ? $tdsUid : 0;		
	$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
	$functionBuyButton = ($tdsUid == $loginId)?"customAlert('".$canNotBuy."')":'';

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

	if(@$price>0  && $isGlobalDownload=='t') { 
	  $priceDetails = getDisplayPrice($price,$seller_currency);
		if(strcmp($buttonStyle,'big')==0) {
			?>       
			<div class="<?php echo $buttonClass;?>">
			  <a target="_blank" href='<?php echo $downloadLink;?>' onclick="return checkIsUserLogin('<?php echo $beforeDownloadLoggedIn;?>');"> <div class="huge_btn Price_btn_style ptr" onmousedown="mousedown_huge_button(this)" onmouseup="mouseup_huge_button(this)" ><?php echo $this->lang->line('project_download');?> <br>
				<?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice'];?>
			   </div></a>
			  <?php //echo $shippingView = $this->load->view('shipping/shipping_frontend_view',array('elementId'=>$elementId,'entityId'=>$entityId),true);?>
			<div class="clear"></div>
			</div> 
			<?php 
		}
		else { ?>
			<div class="tds-button01 cell mr3"> 
				<a target="_blank" href='<?php echo $downloadLink;?>' onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" onclick="return checkIsUserLogin('<?php echo $beforeDownloadLoggedIn;?>');">
					<span>
						<?php echo $this->lang->line('project_download').'&nbsp;'.$priceDetails['currencySign'].'&nbsp;'.$priceDetails['displayPrice'];?>
					</span>
				</a> 
			</div>
			<?php 
		}
	} //end if price>0
}
?>
