<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$formName='auctionBidForm';
$formAttributes = array(
	'name'=>$formName,
	'id'=>$formName
);

//Set price details as pr minimum bid price
$priceDetails = getDisplayPrice($minimumBidPrice,1); //Get price details
$topBidderRes = getBidderInfo($auctionId,1);
if(isset($topBidderRes) && !empty($topBidderRes)){
	$minBid = $topBidderRes;
} else {
	$minBid = $priceDetails['displayPrice']+1;
}

//$minBid = $priceDetails['displayPrice']+1;

$projectPriceInput = array(
	'name'	    => 'bidPrice',
	'id'	    => 'bidPrice',
	'value'	    => (!empty($userBidPrice))?$userBidPrice:'',
	'maxlength'	=> 50,
	'class'     => 'NumGrtrZero required bdr_bbb width90 float_none ml5',
	'min'       => $minBid,
	'size'	    => 5,
	'type'	    => 'text',
);

$auctionIdInput = array(
	'name'	=> 'auctionId',
	'id'	=> 'auctionId',
	'value'	=>  $auctionId,
	'type'	=> 'hidden'
);

$bidIdInput = array(
	'name'	=> 'bidId',
	'id'	=> 'bidId',
	'value'	=>  (isset($bidId) && $bidId !='') ?$bidId : 0,
	'type'	=> 'hidden'
);

$minBidPriceInput = array(
	'name'	=> 'minimumBidPrice',
	'id'	=> 'minimumBidPrice',
	'value'	=> $priceDetails['displayPrice'],
	'type'	=> 'hidden'
);

//Get top bidding info
$bidderList = getBidderInfo($auctionId,5);

//auction data
$auctionId          =  $auctionData->auctionId;
$minimumBidPrice    =  $auctionData->minBidPrice;
$startDate          =  $auctionData->startDate;
$endDate            =  $auctionData->endDate;
$isAuctionClosed    =  $auctionData->isAuctionClosed;

//Set current and auction end date
$currentDate            =  date("Y-m-d");
$currentDateTimeStamp   =  time();
$endDateTimeStamp       =  strtotime($endDate);
$auctioStartDate        =  date("d-M-Y", strtotime($startDate));
$auctioEndDate          =  date("d-M-Y", strtotime($endDate));
$auctionLeftTime        =  timeleft($endDate);

//bid data 
$bidId       =  (!empty($userBidData[0]->bidId))?$userBidData[0]->bidId : 0 ;
$bidPrice    =  (!empty($userBidData[0]->price))?$userBidData[0]->price : 0 ;
?>

<div class="poup_bx width500 shadow">
   <div class="close_btn position_absolute" onclick="$(this).parent().trigger('close');"></div>
   <h3 class="red fs21  text_alighC pb10">Place Bid</h3>
   <div class="bdrb_afafaf"></div>
   <div class="search_box_wrap  mt25 ">
      <div class="clearb">
         <p class="fs14 font_bold fl"> Time Left <span class="red pl10 whitespace_now"> <?php echo $auctionLeftTime; ?></span> </p>
         <div class="fr mr10"> <?php echo $auctioStartDate; ?> - <?php echo $auctioEndDate; ?>  GMT+1 </div>
      </div>
        <?php 
            echo form_open(base_url(lang().'/auction/setProductBid'),$formAttributes);
            echo form_input($minBidPriceInput); 
            echo form_input($auctionIdInput); 
            echo form_input($bidIdInput);
        ?>
          <div class="clearb  ml5">
             <span class="pr12 fl mt30 " >
                <?php echo $currencySign;?>
                <?php echo form_input($projectPriceInput); ?>
                <p class="clearb  pl17 pt3 fs13 "> Minimum Bid  <?php echo $currencySign.$minimumBidPrice ; ?></p>
             </span>
             <span class="font_bold mb10 fl mt30 fs15">Current Bid <span class="red"><?php echo $currencySign.$currentBidPrice ; ?></span></span>
                <?php 
                if($tdsUid==$loggedUserId) { //show alert if product owner and bid user are same
                    $beforeBidProduct = "You must be logged in to bid a product";
                    $canNotBid = $this->lang->line('Youcannotbidfromyourself');
                    $functionBidProject = "if(checkIsUserLogin('".$beforeBidProduct."')){customAlert('".$canNotBid."')}";
                } else { //submit form is users are diffrent
                    $functionBidProject = "$('#auctionBidForm').submit();";
                }
                ?>
             <button onclick="<?php echo $functionBidProject ?>" class="green_button red min_w138" type="button">Place Bid </button>
            
          </div>
       <?php echo form_close(); ?>       
      <div class="clearb ml20 pt15 fs13"> <span>You are bidding for</span> <span class="pl20 pr5"> <b class="red pr7 pl7">12</b>Video Files </span> <span> <b class="red pl7 pr7">1</b>DVD </span> <a class="btn_review fr" href=""> Shipping Charges. </a> </div>
   </div>
   <div class="bgfbfbfb bdte5e5 mb20 pt15 pb15 bdbe5e5 pl30 pr30 ml-30 width100_per">
      <span class="color_666 fs21 mb14 ">Last 5 Bids</span> <span class="fs12 pl15"> Number of bids <b class="pl5 fs13"><?php echo $countBidResult; ?></b></span>
      <table class="buy_table fs14 ">
         <thead>
            <tr>
               <th class="width_114"> Date </th>
               <th class="width_280"> Members Name </th>
               <th class="width_90"> Amount </th>
            </tr>
         </thead>
         <tbody>
            <?php
            if(isset($bidderList) && !empty($bidderList)){
            foreach ($bidderList as $bidData){ 
                //Get users showcase details
                $getUserShowcase = showCaseUserDetails($bidData->userId);
                //Set users image
                $userDefaultImage=($getUserShowcase['creative']=='t')?$this->config->item('defaultCreativeImg'):(($getUserShowcase['associatedProfessional']=='t')?$this->config->item('defaultAssProfImg'):(($getUserShowcase['enterprise']=='t')?$this->config->item('defaultEnterpriseImg'):''));
                if($getUserShowcase['userImage']!='') {
                    $userImage=$getUserShowcase['userImage'];
                }
                $userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
                $userImage=getImage($userImage,$userDefaultImage);    
                 ?>
            <tr>
               <td> <?php echo date("d/m/Y",strtotime($bidData->modifiedDate));?> </td>
               <td> <?php echo $getUserShowcase['userFullName']?></td>
               <td> <?php echo $currencySign.$bidData->price;?></td>
            </tr>
            <?php } } ?>
            
         </tbody>
      </table>
   </div>
   <ul class="fs13 donat_ul">
      <li class="icon_2"> You need a <a href="">PayPal</a> account to buy from third-party Sellers. </li>
      <li>Your bid includes the Toadsquare Service Fee; the greater of EUR 0.40 / USD 0.50 or 15 percent. It doesn’t include Consumption Tax (VAT, GST, Sales Tax etc.). The Service Fee is non-refundable. Taxes will be added, if applicable, as you checkout. </li>
      <li>After the auction is complete we will let you know if you win. You then have 7 (seven) days to complete the purchase. We will add the purchase to your <a href="#">Wish List</a> found from <b>Your Toadsquare</b> > <b>Your Shopping Cart</b>. </li>
      <li>Shipping is arranged by the seller who will update you through Toadsquare. </li>
      <li>Downloads and Pay Per View are available for 14 days. </li>
   </ul>
</div>

<script>
	$(document).ready(function(){
       $.extend($.validator.messages, {
            required: "",
            number: ""
        });
        
		$("#auctionBidForm").validate({
			submitHandler: function() {
				/*var minimumBidPrice = $('#minimumBidPrice').val();
				var bidPrice        = $('#bidPrice').val();
				if(Number(bidPrice)<=Number(minimumBidPrice)) {
					$('#priceError').show();
					$('#bidPrice').addClass('error');
					return false;
				}*/
					
				$('#searchResultDiv').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading.gif" />');
				var fromData=$("#auctionBidForm").serialize();
				$.post(baseUrl+language+'/auction/postBidPrice',fromData, function(data) {
					if(data){
						$('#messageSuccessError').html('<div class="successMsg">'+data.msg+'</div>');
						refreshPge();
					}
				},"json");
			}
		});
		
		//Check bid price compare with min bid price
		/*$('#bidPrice').change(function(){
			var minimumBidPrice = $('#minimumBidPrice').val();
			var bidPrice        = $('#bidPrice').val();
			if(Number(bidPrice)<=Number(minimumBidPrice)) {
				$('#bidPrice').addClass('error');
				$('#priceError').show();	
			}
		});*/
		
		//hide price error on get price val
		$('#bidPrice').keypress(function() {
			$('#priceError').hide();
		});
	});
	
	$('.parent').hover(function(){
	$(this).find('.orange_clr_imp').toggleClass('gray_color')
	});
</script>
