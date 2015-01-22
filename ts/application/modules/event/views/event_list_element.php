<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

	
		<?php
		$value['live'] = '<span class="live">Live</span>';
		$value['online'] = '<span class="online">Online</span>';
		//Path for clock images
		$value['redClock'] = 'images/icons/clockred.png';
		$value['blueClock'] = 'images/icons/clockblue.png';
		$value['yellowClock'] = 'images/icons/clockyellow.png';

		//Path for category images
		$value['ticketA'] = 'images/icons/ticketA.png';
		$value['ticketB'] = 'images/icons/ticketB.png';
		$value['ticketC'] = 'images/icons/ticketC.png';
         //echo $value['NatureId'];
		// CHECKING TYPE OF EVENT AND RENDERING IT'S TEMPLATE
		switch (1) {
			case 1:
				$this->load->view('event_notification_list');
				break;
			case 2:
				$this->load->view('event_normal_list',$value);
				break;
			
			case 4:
				$this->load->view('event_with_launch_list',$value);
				break;
				
			default:
				$this->load->view('launch_event_list',$value);
					
		}
		//END FOR SWITCH CASE
		

?>
