<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		if(isset($tickets) && is_array($tickets) && count($tickets) > 0){
		$maxPurchaseTickets=$this->config->item('maxPurchaseTickets');
?>
  <div class="sessionT_ticketdetail_msg"></div>
  <div class="seprator_15"></div>
  <div class="sessionT_cat_list_box">
		<?php
		$ct=count($tickets);
		$tp=0;
		?>
		<div class="sessionT_cat_listT"></div>
		<div class="sessionT_cat_listM">
			<?php
			$total_tickets = 0;
			foreach($tickets as $tkey=>$ticket){ 
				 $minTicketQty=0;
				 $total_tickets +=$ticket['Quantity'];
				if($ticket['Quantity'] > 0){
					$priceDetails=getDisplayPrice($ticket['Price'],$seller_currency);
					$tp=(($tp+$priceDetails['displayPrice'])* $minTicketQty);?>
					 <div class="sessionT_cat_list ml10 mr10 ">
						<div class="cell width_165 pl5 pr5 orange_color text_alignC"><?php echo $ticket['categoryTitle']?></div>
						<div class="cell width_65 pr12 font_OpenSansBold clr_white bg_sessionT_cat pt2 text_alignC"><?php echo $currencySign.' '.$priceDetails['displayPrice'];?></div>
						<div class="cell pl5 position_relative height4 width_73">
						  <select name="myselect3" class="main_SELECT width70px ticketPrice<?php echo $ticket['SessionId']?>" TicketId="<?php echo $ticket['TicketId']?>"  ticketPrice="<?php echo $priceDetails['displayPrice'];?>" ticketPriceDiv="#ticketTotalPrice<?php echo $ticket['TicketId']?>" sumOfPriceDiv="#sumOfPrice<?php echo $ticket['SessionId']?>" onchange="calculateTicketPrice('.ticketPrice<?php echo $ticket['SessionId']?>');">
							<?php 
								$maxPurchaseTickets=($ticket['Quantity'] < $maxPurchaseTickets)?$ticket['Quantity']:$maxPurchaseTickets;
								for($i=0; $i<=$maxPurchaseTickets; $i++){
									echo '<option value="'.$i.'">'.$i.'</option>';
								}
							?>
						  </select>
						</div>
						<div class="cell pt2 width_66 text_alignR" id="ticketTotalPrice<?php echo $ticket['TicketId']?>"><?php echo $currencySign.' '.number_format($priceDetails['displayPrice']* $minTicketQty,2);?></div>
					  </div>
					  <?php
					  if($ct > ($tkey+1)){
						echo '<div class="seprator_18"></div>';
					  }
				}
			} 
			?>
		</div>
		
		<div class="sessionT_cat_listB"></div>
		<div class="seprator_30"></div>
		<div class="bdr_Borange_D font_opensansSBold font_size14 ml100 mr20"><span class="Fright mr18" id="sumOfPrice<?php echo $ticket['SessionId']?>"><?php echo $currencySign.' '.$tp;?></span><span class=" Fright width_60"><?php echo $this->lang->line('total');?></span>
		  <div class="clear"></div>
		</div>
		<div class="seprator_30"></div>
		<?php
		$this->load->view('orgniser_venue_view',array('venueOrgniserDetails'=>$venueOrgniserDetails,'section'=>'eventSession'));
		$beforePurchaseLoggedIn=$this->lang->line('beforePurchaseLoggedIn');
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			if($userId == $loggedUserId) {	
				$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
				$functionPurchaseTicket="if(checkIsUserLogin('".$beforePurchaseLoggedIn."')){customAlert('".$canNotBuy."')}";
			}else{
				$functionPurchaseTicket="if(checkIsUserLogin('".$beforePurchaseLoggedIn."')){purchaseTicket('.ticketPrice".$ticket['SessionId']."','".$ticket['SessionId']."','1');}";
			}
		}else{
			$functionPurchaseTicket="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforePurchaseLoggedIn."')";
		}
		
		?>
		<div class="Fright mr20">
			<a class="red_btn" onclick="<?php echo $functionPurchaseTicket;?>" onmouseup="mouseup_red_btn(this)" onmousedown="mousedown_red_btn(this)"><span class="font_size18 lineH24 pb2"><?php echo $this->lang->line('buyTickets');?></span></a>
		</div>
	<div class="clear seprator_10"></div>
<div class="pl10 pr10 pb10 f11">
<?php
$minimumComission0 = number_format($this->config->item('minimumComission0'),2) ; //=  0.40
$minimumComission1 = number_format($this->config->item('minimumComission1'),2); 	//=  0.50 
$commisionPercentage = $this->config->item('commisionPercentage'); 	//=  15;
?>


<span class="fl"> *</span> <span class="pl10"> This price includes the Toadsquare Service Fee of the greater of EUR 
<?php echo $minimumComission0; ?> (USD <?php echo $minimumComission1; ?>) or <?php echo $commisionPercentage; ?> 
percent. It does not include Consumption Tax (VAT, GST, Sales Tax 
etc.). The Service Fee is not refundable. Taxes will be added, if 
applicable, as you checkout.</span>
 <span class="fl"> *</span> <span class="pl10">   After your purchase we will email you your Tickets and a Sales Record. You can also see these from your Purchases page in your Cart.</span>
<div class='inline'>
 <span class="fl"> *</span> <span class="pl10"> You need a PayPal account to buy from third-party Sellers.</span></div> 
 <span class="fl"> *</span> <span class="pl10"> You can Sign In to <a target="_blank" 
class="underline a_orange" 
href="<?php echo base_url('tips/front_tips/34'); ?>">Meeting Point</a> 
 from your Purchases page.</span>
</div>
  </div>
   <?php } ?>                         
                         
