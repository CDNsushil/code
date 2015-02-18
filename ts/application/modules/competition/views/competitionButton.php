<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');  

$button_Array['buttonType']=$buttonType;
$button_Array['buttonSection']=$buttonSection;
$button_Array['buttonDivClass']=$buttonDivClass;
$button_Array['competitionId']=$competitionId;
$button_Array['competitionEntryId']=$competitionEntryId;

// load  button div by button type
switch($buttonType){
	
	case 'shortlist':	
		$this->load->view('shortlistButton',$button_Array);
	break;
	
	case 'vote':	
		$this->load->view('voteButton',$button_Array);
	break;
	}
?>




