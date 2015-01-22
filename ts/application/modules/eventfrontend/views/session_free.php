<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$tickets=$tickets[0];
$maxPurchaseTickets=$maxPurchaseTicketsLimit=$this->config->item('maxPurchaseTickets');
?>
  <div class="sessionT_ticketdetail_msg"></div>
  <div class="seprator_15"></div>
  <div class="sessionT_cat_list_box">
	<div class="sessionT_cat_list ml10 mr10 ">
	  <div class="cell width_265 pl25 pr5 orange_color">Maximum <?php echo $maxPurchaseTickets;?> Free Tickets</div>
	  <div class="cell pl5 position_relative height4 width_73">
		<select name="myselect3" class="main_SELECT width70px ticketPrice<?php echo $tickets['SessionId']?>" TicketId="<?php echo $tickets['TicketId']?>"  ticketPrice="<?php echo $tickets['spacialPrice'];?>" ticketPriceDiv="#ticketTotalPrice<?php echo $tickets['TicketId']?>" sumOfPriceDiv="#sumOfPrice<?php echo $tickets['SessionId']?>" onchange="calculateTicketPrice('.ticketPrice<?php echo $tickets['SessionId']?>');">
			<?php
			
				$maxPurchaseTickets=($tickets['Quantity'] < $maxPurchaseTickets)?$tickets['Quantity']:$maxPurchaseTickets;
				for($i=0; $i<=$maxPurchaseTickets; $i++){
					echo '<option value="'.$i.'">'.$i.'</option>';
				}
			?>
		</select>
	  </div>
	</div>
	<div class="seprator_20"></div>
	<?php
		$this->load->view('orgniser_venue_view',array('venueOrgniserDetails'=>$venueOrgniserDetails,'section'=>'eventSession'));
		$beforePurchaseLoggedIn=$this->lang->line('beforePurchaseLoggedIn');
		
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			if($userId == $loggedUserId) {	
				$canNotBuy = $this->lang->line('Youcannotbuyfromyourself');
				$functionPurchaseTicket="if(checkIsUserLogin('".$beforePurchaseLoggedIn."')){customAlert('".$canNotBuy."')}";
			}else{
				
				$whereTTL=array("ticketId"=>$tickets['TicketId'],"userId"=>$loggedUserId);
				$countPurchaseTicket=countResult('TDS_TicketTransectionLog',$whereTTL);
				
				$remainingPurchaseTicketsLimit=($maxPurchaseTicketsLimit-$countPurchaseTicket);
				if($remainingPurchaseTicketsLimit < 0){
					$remainingPurchaseTicketsLimit=0;
				}
				
				$functionPurchaseTicket="if(checkIsUserLogin('".$beforePurchaseLoggedIn."')){purchaseTicket('.ticketPrice".$tickets['SessionId']."','".$tickets['SessionId']."','0','".$remainingPurchaseTicketsLimit."');}";
			}
		}else{
			$functionPurchaseTicket="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforePurchaseLoggedIn."')";
		}
	?>
	<div class="Fright mr20"><a class="red_btn" onclick="<?php echo $functionPurchaseTicket;?>" onmouseup="mouseup_red_btn(this)" onmousedown="mousedown_red_btn(this)"><span class="font_size18 lineH24 pb2"><?php echo $this->lang->line('getTickets');?></span></a></div>
	<div class="clear seprator_15"></div>
	<div class="pl10 pr10 f11">
 <span class="fl"> *</span> <span class="pl10">After your purchase we will email you your Tickets and a Sales Record. You can also see these from your Purchases page in your Cart.</span>
 <span class="fl"> *</span> <span class="pl10">You can Sign In to <a target="_blank" class="underline a_orange" href="<?php echo base_url('tips/front_tips/34'); ?>">Meeting Point</a> from your Purchases page.</span><br/>
</div>
	
	
	
	
  </div>
