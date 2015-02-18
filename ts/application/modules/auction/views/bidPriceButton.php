<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
if(isLoginUser() == false) {
	$loginId=0;
}else{
	$loginId=isLoginUser();
}
$tdsUid = (isset($tdsUid) && ($tdsUid!='')) ? $tdsUid : 0;		
$loggedUserId=isloginUser();

$entityId = isset($entityId)?$entityId:0;
$projectId = isset($projectId)?$projectId:0;

//Set current and auction end date
$currentDate   =  date("Y-m-d");
$auctioEndDate =  date("Y-m-d", strtotime($auctioEndDate));

//Get users auction bid records count
$whereAuction = array(
	'userId'=>$loggedUserId,
	'auctionId'=>$auctionId										
);
$countBidResult = countResult('AuctionBids',$whereAuction);
if($countBidResult==0 || empty($countBidResult )) {
	$countBidResult = 0;
}

if($loggedUserId > 0){
	//if($tdsUid != $loggedUserId) {	//true when login user not a project owner
		$beforeBidProject = "You must be logged in to bid a ".$section;
		if($auctioEndDate>=$currentDate) {
			$bidProject = $this->load->view('auction/projectBid',array('Title' =>$title,'auctionId'=>$auctionId,'minimumBidPrice'=>$minimumBidPrice,'bidId'=>$bidId,'bidPrice'=>$bidPrice,'currencySign'=>$currencySign,'auctioEndDate'=>$auctioEndDate,'tdsUid'=>$tdsUid,'loggedUserId'=>$loggedUserId), true);?>
			<script>
			var BidPrice<?php echo $auctionId;?>=<?php echo json_encode($bidProject);?>
			</script>
			<?php  $functionBidProject = "if(checkIsUserLogin('".$beforeBidProduct."')){loadPopupData('popupBoxWp','popup_box',BidPrice".$auctionId.")}";
		} else {
			$beforeBidProduct = "You must be logged in to bid a ".$section;
			$endBiddate = $this->lang->line('endBiddate');
			$functionBidProject="if(checkIsUserLogin('".$beforeBidProduct."')){customAlert('".$endBiddate."')}";
		}
	//}else{  
		//$beforeBidProduct = "You must be logged in to bid a ".$section;
		//$canNotBid = $this->lang->line('Youcannotbidfromyourself');
		//$functionBidProject="if(checkIsUserLogin('".$beforeBidProduct."')){customAlert('".$canNotBid."')}";
	//}  	        
} else {
	$beforeBidProduct = "You must be logged in to bid a ".$section;		
	$functionBidProject="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBidProduct."')";
}?>

<div class="position_relative hiddenspace fr pt15">
	<div class="huge_btn Price_btn_style ptr black_link_hover ml6" onclick="<?php echo $functionBidProject ?>"><?php echo $this->lang->line('productBid');?></div>
	<!-- load shipping charges view -->
<?php echo $shippingView = $this->load->view('shipping/shipping_frontend_view',array('elementId'=>$elementId,'entityId'=>$entityId),true);?>
</div>	
<div class="clear"></div>
