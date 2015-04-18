<?php

$sessionCommonId = 0;
$counter = 0;
$recordCount=0;

//FOR LOOP STARTS FOR MAIN FOREACH FOR SESSION TIME
foreach($sessionList as $sessSet => $multiSess)
{
	$sessionCount = 0;
				
	//-------------------------------------------------
	//Foreach For Session and Related Tickets 
	//-------------------------------------------------
	foreach($multiSess as $sessKey => $subSession) {
			$recordCount = count($multiSess);
			
			//Making Address Empty To Assinged With New Values
			
			$addressInfo='';
			
			if(isset($subSession['sessionId'])){
				
				
				$currSessId = $subSession['sessionId'];
				
				//FOR ADDRESS DEFINING VARIABLE
				if(isset($subSession['address']) &&  $subSession['address']!='')
				{
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.$subSession['address'];
					else $addressInfo = $subSession['address'];
				}
				
				if(isset($subSession['city']) &&  $subSession['city']!='')
				{
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.$subSession['city'];
					else $addressInfo = $subSession['city'];
				}
				
				if(isset($subSession['country']) &&  $subSession['country']!=''  &&  $subSession['country']!=0)
				{
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.getCountry($subSession['country']);
					else $addressInfo = getCountry($subSession['country']);
				}
				
				if(isset($subSession['state']) &&  $subSession['state']!='')
				{
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.$subSession['state'];
					else $addressInfo = $subSession['state'];
				}
				
				if(isset($subSession['zip']) &&  $subSession['zip']!='')
				{
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.$subSession['zip'];
					else $addressInfo = $subSession['zip'];
				}
				
				if(isset($subSession['url']) &&  $subSession['url']!='')
				{					
					if(strpos($subSession['url'], "http://")) $sessURL = $subSession['url'];
					else $sessURL = "http://".$subSession['url'];

					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ',<a href="'.$sessURL.'" target="_blank"> '.$label['venueURL'].'</a>';
					else $addressInfo = '<a href="'.$sessURL.'" target="_blank">'.$label['venueURL'].'</a>';;
				}					
				
				if(($sessionCount%2)==0 &&($sessionCount != 0)) {
					//echo '<br/>---------------End Div--------------';
					echo '</div>';
				}
				if($sessionCount == 0 || ($sessionCount%2)==0) {
					//echo '-------------Start Div-----------';
					echo '<div class="row pt2"></div><div class="row">';
				}
				
				?>
				<!-- MAIN DIV STARTING FROM HERE-->
				<div class="cell">&nbsp;</div>
				<div class="cell sessTime">
					<div class="row">
						<div class="cell minMaxWidth100px" align="center">
							<?php $incremented = $sessionCount+1; echo $label['session'].$incremented;?>
						</div><!-- End Cell -->
						<div class="cell minMaxWidth100px" align="center">
							<?php echo $label['venue']; ?>
						</div><!-- End Cell -->
					</div><!-- End Row -->
					
					<div class="row">
						<div class="cell minMaxWidth100px">
							<div class="row">
							<div class="cell minMaxWidth100px" align="center"><?php echo date("d m y", strtotime($subSession['date']));?>
							</div><!-- End Cell -->
							</div><!-- End Row --> 
							<div class="row">
							<div class="cell width45px" align="center"><?php echo substr($subSession['startTime'],0, -3); ?>
							</div><!-- End Cell -->
							<div class="cell pr5">&nbsp;</div>
							<div class="cell width45px" align="center"><?php echo substr($subSession['endTime'],0, -3);?>
							</div><!-- End Cell -->
							</div><!-- End Row --> 
						</div><!-- End Cell -->
						<div class="cell minMaxWidth100px">
							<?php echo $addressInfo; ?>
						</div><!-- End Cell -->
					</div><!-- End Row -->
					
					<div class="row"><div class="cell" align="center">
					<?php
					
					//STARTS LOOP TO DISPLAY TIKET DITAIL FOR SESSION
					foreach($multiSess[$currSessId] as $tickKey => $ticketDetail) 
					{
						$ticketAText=''; $ticketBText='';$ticketCText=''; $ticketFreeText='';
						//ASSINGING  TICKET QUANTITY,PRICE,TITLE AND IMAGES TO GET DESPLAYED ACCORDINGLY
						
						if($ticketDetail['TicketCategoryId'] == 1)
						{
							$ticketAText = $ticketDetail['Title'].','.$ticketDetail['Price'].'|'.$ticketDetail['Quantity'];
							$ticketAPrice = $ticketDetail['Price'];
							$ticketAQuantity = $ticketDetail['Quantity'];
							$ticketASrc = '<img src="'.getImage($ticketA).'" alt="'.$ticketAText.'" title="'.$ticketAText.'"  class="formTip minMax24px"  />';
						}
						
						if($ticketDetail['TicketCategoryId'] == 2)
						{
							$ticketBText = $ticketDetail['Title'].','.$ticketDetail['Price'].'|'.$ticketDetail['Quantity'];
							$ticketBPrice = $ticketDetail['Price'];
							$ticketBQuantity = $ticketDetail['Quantity'];
							$ticketBSrc = '<img src="'.getImage($ticketB).'" alt="'.$ticketBText.'" title="'.$ticketBText.'"  class="formTip minMax24px"  />';
						}
						
						if($ticketDetail['TicketCategoryId'] == 3)
						{
							$ticketCText = $ticketDetail['Title'].','.$ticketDetail['Price'].'|'.$ticketDetail['Quantity'];
							$ticketCPrice = $ticketDetail['Price'];
							$ticketCQuantity = $ticketDetail['Quantity'];
							$ticketCSrc = '<img src="'.getImage($ticketC).'" alt="'.$ticketCText.'" title="'.$ticketCText.'"  class="formTip minMax24px"  />';
						}
						
						if($ticketDetail['TicketCategoryId'] == 4)
						{
							$ticketFreeText = $ticketDetail['Title'].','.$label['free'].'|'.$ticketDetail['Quantity'];
							$ticketFreePrice = $label['free'];
							$ticketFreeQuantity = $ticketDetail['Quantity'];
							$ticketFreeSrc = '<img src="'.getImage($ticketA).'" alt="'.$ticketFreeText.'" title="'.$ticketFreeText.'"  class="formTip minMax24px"  />';
						}
					?>
										
					<!-- Show ticket detail -->
					
					<?php if(isset($ticketAText) && $ticketAText!='') { ?>					
					<div class="cell" align="center">
					<?php echo $ticketASrc;?>
					<div class="row">
						<div class="cell"><?=$label['currency'].$ticketAPrice;?></div><!-- End Cell -->
						<div class="cell pl2">&nbsp;</div>
						<div class="cell"><?=$ticketAQuantity;?></div><!-- End Cell -->
					</div><!-- End Row -->
					</div><!-- End Cell -->
					<div class="cell pr10">&nbsp;</div>
					<?php } ?>
					
					<?php if(isset($ticketBText) && $ticketBText!='') { ?>
					<div class="cell" align="center">
					<?php echo $ticketBSrc;?>
					<div class="row">
						<div class="cell"><?=$label['currency'].$ticketBPrice;?></div><!-- End Cell -->
						<div class="cell pl2">&nbsp;</div>
						<div class="cell"><?=$ticketBQuantity;?></div><!-- End Cell -->
					</div><!-- End Row -->
					</div><!-- End Cell -->					
					<div class="cell pr10">&nbsp;</div>
					<?php } ?>
					
					<?php if(isset($ticketCText) && $ticketCText!='') { ?>
					<div class="cell" align="center">
					<?php echo $ticketCSrc;?>
					<div class="row">
						<div class="cell"><?=$label['currency'].$ticketCPrice;?></div><!-- End Cell -->
						<div class="cell pl2">&nbsp;</div>
						<div class="cell"><?=$ticketCQuantity;?></div><!-- End Cell -->
					</div><!-- End Row -->
					</div><!-- End Cell -->					
					<div class="cell pr10">&nbsp;</div>
					<?php } ?>
					
					<?php if(isset($ticketFreeText) && $ticketFreeText!='') { ?>
					<div class="cell" align="center">
					<?php echo $ticketFreeSrc;?>
					<div class="row">
						<div class="cell"><?=$ticketFreePrice;?></div><!-- End Cell -->
						<div class="cell pl10">&nbsp;</div>
						<div class="cell"><?=$ticketFreeQuantity;?></div><!-- End Cell -->
					</div><!-- End Row -->
					</div><!-- End Cell -->
					<?php } ?>
					
					<!-- End Show ticket detail -->
					<?php						
					}
					//ENDING LOOP TO DISPLAY TIKET DETAIL FOR SESSION
					?>
				</div><!-- End Cell -->
				</div><!-- End Row -->
				</div>
				
				<!-- MAIN DIV ENDS HERE-->
			<?php				
			$sessionCount++;				
			}			
			$counter++;	
	}	
		//To close the div for last records
			if(($counter == $recordCount) && $recordCount!=0) {
				//echo '<br />------------Last--End-------';
				echo '</div>';
				echo '<div class="row heightSpacer">&nbsp;</div>';
			}
}
?>
