<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

//get loggedIn userId
$loginId         =   (isLoginUser())?isLoginUser():0;

//project and entityId
$entityId  = (isset($entityId))?$entityId:0;
$projectId = (isset($projectId))?$projectId:0;

//auction data
$auctionId          =  $auctionData->auctionId;
$minimumBidPrice    =  $auctionData->minBidPrice;
$startDate          =  $auctionData->startDate;
$endDate            =  $auctionData->endDate;
$endDate = str_ireplace("00:00:00","23:59:59",$endDate);// End date Up to 23:59:59 
$isAuctionClosed    =  $auctionData->isAuctionClosed;
//Set current and auction end date
$currentDate            =  date("Y-m-d");
$currentDateTimeStamp   =  time();
$endDateTimeStamp       =  strtotime($endDate);
$auctioStartDate        =  date("d-M-Y", strtotime($startDate));
$auctioEndDate          =  date("d-M-Y", strtotime($endDate));
$auctionLeftTime        =  timeleft($endDate);

//current bid data
$currentBidPrice    =  (!empty($currentBidData[0]->price))?$currentBidData[0]->price:0;

//user bid data 
$bidId           =  (!empty($userBidData[0]->bidId))?$userBidData[0]->bidId : 0 ;
$userBidPrice    =  (!empty($userBidData[0]->price))?$userBidData[0]->price : 0 ;

$isAcutionFinish  = false; // set default for auction not finish

// check auction is not finish
if($endDateTimeStamp<=$currentDateTimeStamp){
    $isAcutionFinish  = true;
}


if(!empty($loggedUserId)){
	if($ownerId != $loggedUserId) {	//true when login user not a project owner
		$beforeBidProject = "You must be logged in to bid a ".$section;
		if($endDateTimeStamp>=$currentDateTimeStamp) {
			$bidProject = $this->load->view('auction/projectBid_New',array('auctionId'=>$auctionId,'minimumBidPrice'=>$minimumBidPrice,'bidId'=>$bidId,'currentBidPrice'=>$currentBidPrice,'userBidPrice'=>$userBidPrice,'currencySign'=>$currencySign,'auctioEndDate'=>$auctioEndDate,'tdsUid'=>$ownerId,'loggedUserId'=>$loggedUserId,'countBidResult'=>$userBidCount), true);?>
			<script>
			var BidPrice<?php echo $auctionId;?>=<?php echo json_encode($bidProject);?>
			</script>
			<?php  $functionBidProject = "if(checkIsUserLogin('".$beforeBidProduct."')){loadPopupData('popupBoxWp','popup_box',BidPrice".$auctionId.")}";
		} else {
			$beforeBidProduct = "You must be logged in to bid a ".$section;
			$endBiddate = $this->lang->line('endBiddate');
			$functionBidProject="if(checkIsUserLogin('".$beforeBidProduct."')){customAlert('".$endBiddate."')}";
		}
    }else{
            $beforeBidProduct = "You must be logged in to bid a product";
            $canNotBid = $this->lang->line('Youcannotbidfromyourself');
            
            //check preview mode
            if(previewModeActive()){
                $canNotBid = $this->lang->line('Youcannotbuyfromyourselfpreview');
            }
            
            $functionBidProject = "if(checkIsUserLogin('".$beforeBidProduct."')){customAlert('".$canNotBid."')}";
    }    
        
} else {
	$beforeBidProduct = "You must be logged in to bid a ".$section;		
	$functionBidProject="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeBidProduct."')";
}
?>
<?php 
//aunction finish condition
if($isAcutionFinish){ ?>
<div class="auctionPopUP <?php echo ($showview=="project")?' fl':' fr'; ?>">    
<button class="text_alighC  green_button min_w138 fl" type="button"><?php echo $this->lang->line('m_auction_finished'); ?></button>
<div class="sap_20"></div>
<span class="fl fs12 lineH14"><?php echo $this->lang->line('m_winning_bid'); ?></span> <span class="red fr  fs12 lineH14 font_bold"><?php echo $currencySign.number_format($currentBidPrice,2); ?></span>
</div>
<?php }else{ ?>    

<?php if($showview=="project") { ?>
<div class="clearb auctionPopUP">
    <p>
       <span class="red pr5"><?php echo $this->lang->line('m_auction_heading'); ?></span>
       <?php echo $auctioStartDate; ?> - <?php echo $auctioEndDate; ?>
    </p>
    <p class="fs13 font_bold  pt10">
       Time Left
       <span class="red pl10 whitespace_now"> <?php echo $auctionLeftTime; ?></span>
    </p>
    <div class="sap_15"></div>
    
    <button  onclick="<?php echo $functionBidProject ?>" class="text_alighC  green_button min_w138 fl" type="button">
        <?php echo $this->lang->line($industryType.'_bid_button'); ?>
    </button>
   
    <div class=" fr musicelementbid">
       <div class="fs12 lineH12">
          <span class="min_w100 pr5"> Current Bid</span>
          <span class="red fs14 font_bold"><?php echo $currencySign.number_format($currentBidPrice,2); ?></span>
       </div>
       <div class="fs12 pt6">
          <span class="min_w100 pr5">Minimum Bid </span>
          <span class="fs14"><?php echo $currencySign.$minimumBidPrice ; ?></span>
       </div>
       <div class="fs12 pt4">
          <span class="min_w100 pr5">Number of bids</span>
          <span class="fs14 font_bold"><?php echo $userBidCount; ?></span>
       </div>
    </div>
    <?php echo $this->load->view('shipping/shipping_frontend_view_new',array('elementId'=>$elementId,'entityId'=>$entityId),true);?>
</div>
<?php  }elseif($showview=="projectelement"){ ?>
   <button class="text_alighC  green_button min_w138 fl " onclick="<?php echo $functionBidProject ?>"  type="button"><?php echo $this->lang->line($industryType.'_bid_button'); ?></button>
<?php  } } ?>

<?php 
/*
 *   //saparator show in project page
    if($showview=="project"){
        echo '<div class="sap_20 bb_e7e7e7"></div><div class="sap_20 "></div>';
    }
*/
?>
