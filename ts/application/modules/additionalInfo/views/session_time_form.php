<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
//echo $currentType.'-----------------------------------';
///For limit the date picker dates by picking main event or launch start,end or launch created date
$minDateTemp = 0;
$maxDateTemp = 0;
//echo 'eventId:'.$eventId.' launchEventId:'.$launchEventId;
	if($eventId>0 && (isset($launchEventId) &&($launchEventId<=0 || $launchEventId==''))){
		
		//Setting the start and finish date for an event		
		$dateDetail = getDataFromTabel('Events','StartDate,FinishDate','EventId',$elementId);
		$sectionId=9;
		
		if(isset($dateDetail[0]->StartDate) && $dateDetail[0]->StartDate !=''){
			$minDateTemp = $dateDetail[0]->StartDate;
			//$minDateTemp = date('Y, m, d',strtotime($minDateTemp));
			$minDateTemp =getPreviousOrFututrDate($minDateTemp, '-1 month' ,'Y, m, d');
			
		}
		if(isset($dateDetail[0]->FinishDate) && $dateDetail[0]->FinishDate !=''){
			$maxDateTemp = $dateDetail[0]->FinishDate;
			//$maxDateTemp = date('Y, m, d',strtotime($maxDateTemp));
			$maxDateTemp = getPreviousOrFututrDate($maxDateTemp, '-1 month' ,'Y, m, d'); //(decresed by one month as required by datepicker)
		}
	//echo 'event minDateTemp:'.$minDateTemp.', maxDateTemp:'.$maxDateTemp;

	}
	else{
		
		//Setting the start and  finish (6 months ahead the created date) date for launch		
		$dateDetail = getDataFromTabel('LaunchEvent','LaunchEventCreated','LaunchEventId',$launchEventId);
		$sectionId=15;
		if(isset($dateDetail[0]->LaunchEventCreated) && $dateDetail[0]->LaunchEventCreated !=''){
			$minDateTemp = $dateDetail[0]->LaunchEventCreated;
			//$minDateTemp = date('Y, m, d',strtotime($minDateTemp));
			$minDateTemp =getPreviousOrFututrDate($minDateTemp, '-1 month' ,'Y, m, d');
			$maxDateTemp = date('Y-m-d',(strtotime($dateDetail[0]->LaunchEventCreated)+(60*60*24*30*6)));
			$maxDateTemp =getPreviousOrFututrDate($maxDateTemp, '-1 month' ,'Y, m, d');			
		}
//echo 'launch:minDateTemp:'.$minDateTemp.', maxDateTemp:'.$maxDateTemp;

	}

//Check session status

if(isset($currentType) && $currentType!=2){
	$required = 'required';
	$select_field = 'select_field';
}else{
	$required = '';
	$select_field = '';
}

?>
<script>
$(document).ready(function(){	
	$("#sessionTimeForm").validate({});	
	$("#sessiondate").datepicker({<?php echo ($minDateTemp>0)?'minDate:new Date('.$minDateTemp.')':'';?> <?php echo ($maxDateTemp>0)?',maxDate:new Date('.$maxDateTemp.')':'';?>});
});
</script>
<?php	
	
	$seller_currency=LoginUserDetails('seller_currency');
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);
	//echo '<pre />';print_r($fillSessions);
	$sessionTimeFormAttributes = array(
		'name'=>'sessionTimeForm',
		'id'=>'sessionTimeForm',
		'section' => '#session',
		'toggleDivForm' =>'SESSIONTIMEForm-Content-Box'
	);

	$currentDate = array(
		'name'	=> 'currentDate',
		'id'	=> 'currentDate',	
		'value'	=> date('Y-m-d'),	
		'type' =>'hidden'
	);

	if(@$fillSessions['date']!='') $fillSessionsDate = date("d F Y", strtotime(substr(@$fillSessions['date'],0,-9)));

	$sessionDate = array(
		'name'	=> 'date',
		'id'	=> 'sessiondate',
		'class'	=> 'BdrCommon required',	
		'value'	=> @$fillSessionsDate,		
		'title' =>$this->lang->line('currentDateMsg'),	
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50,
		'rows'	=> 5,
		'style' => 'width:154px;',
		'readonly' => 'readonly'
	);

/*
$eventStartTime = array(
	'name'	=> 'startTime',
	'id'	=> 'sessionstartTime',
	'class'	=> 'BdrCommon formTip required error',
	'title'=>  $label['eventStartTime'],
	'value'	=> set_value('startTime'),
	'placeholder'	=> $label['eventStartTime'],
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 30,
	'style' => 'width:128px;'
);

$eventEndTime = array(
	'name'	=> 'endTime',
	'id'	=> 'sessionendTime',
	'class'	=> 'BdrCommon formTip required error',
	//'dateGreaterThan'=>'#sessionstartTime',
	'title'=>  $label['eventEndTime'],
	'value'	=> set_value('endTime'),
	'placeholder'	=> $label['eventEndTime'],
	'minlength'	=> 2,
	'maxlength'	=> 10,
	'size'	=> 30,
	'style' => 'width:128px;'
); 
*/

	$address = array(
		'name'	=> 'address',
		'id'	=> 'sessionaddress',
		'class'	=> 'width556px '.$required.'',	
		'value'	=> set_value('address',@$fillSessions['address']),
		//'placeholder'	=> $label['address'],
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50,
		
	); 

	$address2 = array(
		'name'	=> 'address2',
		'id'	=> 'sessionaddress2',
		'class'	=> 'width556px',	
		'value'	=> set_value('address2',@$fillSessions['address2']),
		//'placeholder'	=> $label['address'],
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50,
		
	); 

	$city = array(
		'name'	=> 'city',
		'id'	=> 'sessioncity',
		'class'	=> 'width556px ',	
		'value'	=>set_value('city',@$fillSessions['city']),
		//'placeholder'	=> $label['city'],
		//'minlength'	=> 2,
		'maxlength'	=> 30,
		'size'	=> 50	
	);

	$state = array(
		'name'	=> 'state',
		'id'	=> 'sessionstate',
		'class'	=> 'width556px '.$required.'',	
		'value'	=> set_value('state',@$fillSessions['state']),
		//'placeholder'	=> $label['state'],
		//'minlength'	=> 2,
		'maxlength'	=> 30,
		'size'	=> 50	
	);

	$zipcode = array(
		'name'	=> 'zip',
		'id'	=> 'sessionzip',
		'class'	=> 'BdrCommon width556px',	
		'value'	=> set_value('zip',@$fillSessions['zip']),
		//'placeholder'	=> $label['zipcode'],
		'maxlength'	=> 15,
		'size'	=> 50	
	);

	$country = array(
		'name'	=> 'country',
		'id'	=> 'sessioncountry',
		'class'	=> 'BdrCommon width556px '.$required.'',	
		'value'	=> set_value('country'),
		//'placeholder'	=> $label['country'],
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50	
	);


	$addUrl = array(
		'name'	=> 'url',
		'id'	=> 'sessionurl',
		'class'	=> 'BdrCommon width556px web_url',	
		'value'	=> set_value('url',@$fillSessions['url']),
		//'placeholder'	=> $label['addUrl'],
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50	
	);

	$phoneno = array(
		'name'	=> 'phoneNumber',
		'id'	=> 'phoneNumber',
		'class'	=> 'width556px',
		'value'	=> set_value('phoneNumber',@$fillSessions['phoneNumber']),
		'maxlength'	=> 15,
		'size'	=> 50,
		
	);

	$email = array(
		'name'	=> 'venueEmail',
		'id'	=> 'venueEmail',
		'class'	=> 'width556px formTip email',
		'value'	=> set_value('venueEmail',@$fillSessions['venueEmail']),
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50
	);


	$venueName = array(
		'name'	=> 'venueName',
		'id'	=> 'venueName',
		'class'	=> 'width556px formTip '.$required.'',
		'value'	=> set_value('venueName',@$fillSessions['venueName']),
		//'minlength'	=> 2,
		'maxlength'	=> 50,
		'size'	=> 50,
		
	);

	
	$defaultTime = $this->config->item('defaultTime');
	$sessionStartTime = $sessionEndTime  = $defaultTime;

	if(strcmp(@$fillSessions['startTime'],$defaultTime)==0 || @$fillSessions['startTime']=='')
		$sessionStartTime = $defaultTime;
	else 
		$sessionStartTime = substr(@$fillSessions['startTime'],0,-3);

	if(strcmp(@$fillSessions['endTime'],$defaultTime)==0 || @$fillSessions['endTime']=='')
		$sessionEndTime = $defaultTime;
	else 
		$sessionEndTime = substr(@$fillSessions['endTime'],0,-3);

	$eventStartTime = array(
		'name'	=> 'eventstartime',
		'id'	=> 'starttime',
		'class'	=> 'time required',	
		//'onblur' =>"validateHhMm(this)",
		'value'	=> $sessionStartTime,
		'gurutva'	=> 'testing me',
		'size'	=> 6
	);

	$eventEndTime = array(
		'name'	=> 'eventendtime',
		'id'	=> 'endtime',	
		'class'	=> '',	
		'endTimeRange'	=> '#starttime',
		//'onblur' =>"validateEndHhMm(this)",
		'title'	=> $this->lang->line('endTimeMsg'),	
		'value'	=> $sessionEndTime,	
		'size'	=> 6
	);
	
	$sessionTitle = array(
		'name'	=> 'sessionTitle',
		'id'	=> 'sessionTitle',
		'class'	=> 'width556px ',	
		'value'	=>set_value('sessionTitle',@$fillSessions['sessionTitle']),
		'maxlength'	=> 100,
		'size'	=> 50	
	);
	//echo '<pre />';print_r($fillSessions);
?>

<div class="dn" id="uploadElementForm" style="display: block;">
<div class="upload_media_left_top row"></div><!--upload_media_left_top-->

<?php echo form_open('additionalInfo/saveAddInfoSession',$sessionTimeFormAttributes); ?>
<div class="upload_media_left_box">
	
	<input type="hidden" value="<?php echo (@$fillSessions['sessionId']!='')?@$fillSessions['sessionId']:0;?>" name="sessionId" id="sessionId" />
	<input type="hidden" value="" name="formtype" />
	<input type="hidden" value="<?php echo $eventId;?>" name="eventId" id="eventId" />
	<input type="hidden" value="<?php echo $launchEventId;?>" name="launchEventId" id="launchEventId" />
	<input type="hidden" value="<?php echo $returnUrl;?>" name="returnUrl" id="returnUrl" />
	<input type="hidden" value="<?php echo $sectionId;?>" name="sectionId" id="sectionId" />

	 <div class="row"> 	
		 <div class="label_wrapper cell">
			 <label class="select_field"><?php echo $label['date']; ?></label>
		 </div><!--label_wrapper-->	
		 <div class="cell frm_element_wrapper required ">
		   <div class="cell">
			<?php echo form_input($currentDate);  echo form_input($sessionDate); ?>
		   </div>
			<div class="cell widthSpacer10">&nbsp;</div>
			<div class="cell pt5">
				<img class="ptr" src="<?php echo base_url('images/icons/calendar.png');?>" onclick='$("#sessiondate").focus();' />
				<div class="red"><?php echo form_error($sessionDate['name']); ?></div>
			</div>	
		</div><!--from_element_wrapper-->  
	</div> <!--row -->
		
	<div class="row"> 
		 <div class="label_wrapper cell">
			 <label class="select_field"><?php echo $label['eventStartTime']; ?></label>
		 </div><!--label_wrapper-->	 
		 <div class="cell frm_element_wrapper required ">
		   <?php echo form_input($eventStartTime); ?>
		  <div class="red"><?php echo form_error($eventStartTime['name']); ?></div>		
		</div><!--from_element_wrapper-->  
	</div> <!--row -->
	
	<div class="row"> 	
		<div class="label_wrapper cell">
			 <label><?php echo $label['eventEndTime']; ?></label>
		</div><!--label_wrapper-->	
		<div class="cell frm_element_wrapper required ">
		   <?php echo form_input($eventEndTime); ?>
		   <div class="red"><?php echo form_error($eventEndTime['name']); ?></div>		
		</div><!--from_element_wrapper-->  
	</div> <!--row -->

	<div class="row"> 	
		<div class="label_wrapper cell">
			 <label><?php echo $label['title']; ?></label>
		</div><!--label_wrapper-->	
		<div class="cell frm_element_wrapper required ">
		   <?php echo form_input($sessionTitle); ?>
		   <div class="red"><?php echo form_error($sessionTitle['name']); ?></div>		
		</div><!--from_element_wrapper-->  
	</div> <!--row -->
	
	<div class="row heightSpacer"> &nbsp;</div>	
	<div class="row">
		<div class="cell">
		<div class="title-content">
			<div class="title-content-left">
			<div class="title-content-right">
			<div class="title-content-center"  onmouseover="this.style.cursor='pointer'">	
				 <div class="label_wrapper cell">
				  <div class="lable_heading">
						<h1><?php echo $label['addLocation']; ?></h1>
				  </div><!-- lable_heading -->
				</div><!-- label_wrapper cell-->		
			</div><!-- End class="title-content-center" -->
			</div><!-- End class="title-content-right" -->
			</div><!-- End class="title-content-left" -->
			</div><!-- End class="title-content" -->
		</div>
	</div>
	
	<div class="row">
		<div class="cell label_wrapper"><label class="<?php echo $select_field;?>"><?php echo $label['venueName'];?></label></div>
			<div class="cell frm_element_wrapper" >
				<?php echo form_input($venueName); ?>
				<div class="red"><?php echo form_error($venueName['name']); ?></div>
		</div>
	 </div>
     <div class="row"> 	
		 <div class="label_wrapper cell">
			 <label class="<?php echo $select_field;?>"><?php echo $label['address1']; ?></label>
		 </div><!--label_wrapper-->
		 <div class="cell frm_element_wrapper required ">
		   <?php echo form_input($address); ?>
		 <div class="red"><?php echo form_error($address['name']); ?></div>		
		</div><!--from_element_wrapper-->  
	 </div> <!--row -->
	 
     <div class="row">	
		 <div class="label_wrapper cell">
			 <label><?php echo $label['address2']; ?></label>
		 </div><!--label_wrapper-->	
		 <div class="cell frm_element_wrapper required ">
		   <?php echo form_input($address2); ?>
		 <div class="red"><?php echo form_error($address2['name']); ?></div>		
		 </div><!--from_element_wrapper-->  
	</div> <!--row -->

    <div class="row">	
		 <div class="label_wrapper cell">
			 <label><?php echo $label['twnRcity']; ?></label>
		 </div><!--label_wrapper-->	
		 <div class="cell frm_element_wrapper required ">
		   <?php echo form_input($city); ?>
		 <div class="red"><?php echo form_error($city['name']); ?></div>		
		</div><!--from_element_wrapper-->  
	</div> <!--row -->

     <div class="row"> 	
		 <div class="label_wrapper cell">
			 <label class="<?php echo $select_field;?>"><?php echo $label['state']; ?></label>
		 </div><!--label_wrapper-->		
		 <div class="cell frm_element_wrapper required ">
		   <?php echo form_input($state); ?>
		 <div class="red"><?php echo form_error($state['name']); ?></div>		
		</div><!--from_element_wrapper-->  
	</div> <!--row -->		
			
   <div class="row"> 	
	 <div class="label_wrapper cell">
		 <label><?php echo $label['zipcode']; ?></label>
	 </div><!--label_wrapper-->	 

	 <div class="cell frm_element_wrapper ">
	   <?php echo form_input($zipcode); ?>
	 <div class="red"><?php echo form_error($zipcode['name']); ?></div>		
	 </div><!--from_element_wrapper-->  
  </div> <!--row -->  
  	
  <div class="row">
		<div class="cell label_wrapper"><label class="<?php echo $select_field;?>"><?php echo $label['country'];?></label></div>
		<div class="cell frm_element_wrapper">
			<div class="fl" id="projectTypeList" >
				<?php	
				
				if(@$fillSessions['country']>0)
					$countryValue = @$fillSessions['country'];
				else 	
					$countryValue = 0;	
						 
					echo form_dropdown($country['name'] , $countries,  $countryValue ,'id="country" class="single '.$required.'"');						
				?>
				<script>setSeletedValueOnDropDown('country', '<?php echo $countryValue; ?>');</script>
			</div>
			<div class="row wordcounter"><?php echo form_error('selectRating'); ?></div>
		</div>
	</div>	
	
  <div class="row"> 
	 <div class="label_wrapper cell">
		 <label><?php echo $label['addUrl']; ?></label>
	 </div><!--label_wrapper-->		 

	 <div class="cell frm_element_wrapper required ">
	  <?php echo form_input($addUrl); ?>
	 <div class="red"><?php echo form_error($addUrl['name']); ?></div>	
	 </div><!--from_element_wrapper-->  
  </div> <!--row --> 
	
	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $this->lang->line('emailAddress'); ?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_input($email); ?>
			<div class="red"><?php echo form_error($email['name']); ?></div>
		</div>
	</div>	

	<div class="row">
		<div class="cell label_wrapper"><label><?php echo $this->lang->line('phoneNo'); ?></label></div>
		<div class="cell frm_element_wrapper" >
			<?php echo form_input($phoneno); ?>
			<div class="red"><?php echo form_error($phoneno['name']); ?></div>
		</div>
	</div>
		
<div class="seprator_27 row"></div>
<div class="seprator_25 clear row"></div>
<?php 	
	
		if(isset($fillSessions['eventSellstatus']) && $fillSessions['eventSellstatus']=='f')
		{
			$sellStatus = ''; 
			$noneStatus = ''; 
			$freeStatus = 'checked="checked"'; 
		}
		else if(isset($fillSessions['eventSellstatus']) && $fillSessions['eventSellstatus']=='t')
		{
			$sellStatus = 'checked="checked"'; 
			$freeStatus = '';
			$noneStatus = '';
		}
		else{
			$sellStatus = ''; 
			$freeStatus = ''; 
			$noneStatus = 'checked="checked"'; 
		}		
?>	
	<div class="row">
		<div class="cell label_wrapper"> <label class="select_field"><?php echo $label['tickets'];?></label></div>
		<div class="cell frm_element_wrapper">
			<div class="row pt5">					
				<div class="cell defaultP" onClick="sell();">
				  <input type="radio" id="eventSellstatus" name="eventSellstatus" <?php echo $sellStatus;?> value="true" onClick="sell();"  />
				</div>				
				<div class="cell mr8">
				  <label class="lH25"><?php echo $label['sellTicket'];?></label>
				</div>
				
				<div class="cell defaultP " onclick="free();">
					<input type="radio" id="eventSellstatusf" name="eventSellstatus" value="false" <?php echo $freeStatus;?> onClick="free();" />
				</div>				
				<div class="cell mr8">					
				  <label class="lH25"><?php echo $label['free'];?></label>
				</div>
				
				
				<div class="cell defaultP " onclick="noTicket();">
					<input type="radio" id="eventNoTicket" name="eventSellstatus" value="" <?php echo $noneStatus;?> onClick="noTicket();" />
				</div>				
				<div class="cell">					
				  <label class="lH25"><?php echo $label['noneTicket'];?></label>
				</div>
			 </div>
			 <div class="row f11 pt5"><?php echo $this->lang->line('yourSellerSetting1').'<a href="'.base_url('dashboard/globalsettings').'" class="ptr dash_link_hover">'.$this->lang->line('yourSellerSetting2').'</a>'.$this->lang->line('yourSellerSetting3');?></div>
		 </div>
		  
	</div>	
		
<div class="row line1 mr11"></div>
<?php 

	//Ticket Category Defined in Config(head.php) File

	$configTicketCategory = $this->config->item('ticketCategory');
	$configTicketCategoryKey = array_keys($this->config->item('ticketCategory'));

	$freeTicketCategoryId = 4;

	$tick_count = 0;

	foreach ($masterTickets as $i => $masterTicketsObj) 
	{
		$masTicketDBValue = (@$fillSessions['ticketId'.$masterTicketsObj->TicketCategoryId]!='')?@$fillSessions['ticketId'.$masterTicketsObj->TicketCategoryId]:'';	
		$PriceScheduleIdDBValue = (@$fillSessions['PriceScheduleId'.$masterTicketsObj->TicketCategoryId]!='')?@$fillSessions['PriceScheduleId'.$masterTicketsObj->TicketCategoryId]:0;		
		?>
		<input type="hidden" value="<?php echo (isset($masTicketDBValue) && @$masTicketDBValue!='')?$masTicketDBValue:0;?>" name="ticketId[<?php echo $configTicketCategoryKey[$masterTicketsObj->TicketCategoryId-1];?>]" id="ticketId<?php echo $masterTicketsObj->TicketCategoryId;?>" />
		<input type="hidden" value="<?php echo (isset($PriceScheduleIdDBValue) && @$PriceScheduleIdDBValue!='')?$PriceScheduleIdDBValue:0;?>" name="PriceScheduleId[<?php echo $configTicketCategoryKey[$masterTicketsObj->TicketCategoryId-1];?>]" id="PriceScheduleId<?php echo $masterTicketsObj->TicketCategoryId;?>" />
		<?php
		$tick_count++;
		if($masterTicketsObj->TicketCategoryId == $freeTicketCategoryId) 
		{ 
			$free_array[$tick_count]=$masterTicketsObj;
		}
		else
		{
			$sell_array[$tick_count]=$masterTicketsObj;	
		}		
	}
	?>
	

<!-- SHOW SELL CATEGORY TICKETS -->
 <div class="seprator_20 clear row"></div>                 
<div id="sellticket" class="">
	<div class="row ">
		<div class="cell width_200">
			<div class="lable_heading"><h1><?php echo $label['tickets']; ?></h1></div> 
		</div>
		<div class="font_opensansSBold ml78 fl width_85 orange_clr_imp mt-4 lineH16"> <?php echo $label['ticketsAvail']; ?>  </div>
			<div class="font_opensansSBold ml34 fl width_85 orange_clr_imp mt-4 lineH16"> <?php echo $label['ticketPrice']; ?> </div>
			<div class="font_opensansSBold ml72 fl width_85 orange_clr_imp mt-4 lineH16"> <?php echo $this->lang->line('tsCommision');?>  </div>
			<div class="font_opensansSBold ml24 fl pt5   clr_white text_alignR consumebg_top height_15"> <?php echo $this->lang->line('displayPrice');?> </div>
		<div class="clear"></div>
	</div>
<?php

	foreach ($sell_array as $i => $sellarrayObj) {	
		$freeClass = "cat";
		$ticketIdDBValue = 0;
		
		if((strcmp($configTicketCategory[$configTicketCategoryKey[0]],$sellarrayObj->Title)==0)) $CatValue = $configTicketCategoryKey[0];
		if(strcmp($configTicketCategory[$configTicketCategoryKey[1]],$sellarrayObj->Title)==0) $CatValue = $configTicketCategoryKey[1];
		if(strcmp($configTicketCategory[$configTicketCategoryKey[2]],$sellarrayObj->Title)==0) $CatValue = $configTicketCategoryKey[2];
		
		$ticketCheckBoxDBValue = (@$fillSessions['ticketCheckBox'.$sellarrayObj->TicketCategoryId]==1)?TRUE:FALSE;		
		$ticketDBValue = (@$fillSessions['ticket'.$sellarrayObj->TicketCategoryId]!='')?@$fillSessions['ticket'.$sellarrayObj->TicketCategoryId]:'';	
		$priceDBValue = ((@$fillSessions['price'.$sellarrayObj->TicketCategoryId]!='') && (@$fillSessions['price'.$sellarrayObj->TicketCategoryId]!=''>0))?@$fillSessions['price'.$sellarrayObj->TicketCategoryId]:'';		
		$ticketIdDBValue = ((@$fillSessions['ticketId'.$sellarrayObj->TicketCategoryId]!='') && (@$fillSessions['ticketId'.$sellarrayObj->TicketCategoryId]>0))?@$fillSessions['ticketId'.$sellarrayObj->TicketCategoryId]:0;		
		$ticketCheckBox = array(
			'name'        => 'ticketCheckBox['.$configTicketCategoryKey[$sellarrayObj->TicketCategoryId-1].']',
			'id'          => 'ticketCheckBox'.$sellarrayObj->TicketCategoryId,
			'value'       => $CatValue,
			'class' => 'priceSchRel '.$freeClass,
			'priceSchRel' => $sellarrayObj->TicketCategoryId,
			//'onblur'=>"checkTicket('ticketCheckBox".$masterTicketsObj->TicketCategoryId."')"
		);
		if( $i==1 || (isset($fillSessions['ticketCheckBox'.$sellarrayObj->TicketCategoryId]) && $fillSessions['ticketCheckBox'.$sellarrayObj->TicketCategoryId]==1)){
				$ticketCheckBox['checked']=true;
		}
		
		$ticket = array(
			'name'	=> 'ticket['.$configTicketCategoryKey[$sellarrayObj->TicketCategoryId-1].']',
			'id'	=> 'ticket'.$sellarrayObj->TicketCategoryId,
			'value'  =>  @$ticketDBValue,
			'placeholder'	=> $label['addAvailability'],			
			'maxlength'	=> 50,
			'size'	=> 20,
			'onblur'=>"placeHoderHideShow(this,'".$label['addAvailability']."','show')" ,
			'onclick'=>"placeHoderHideShow(this,'".$label['addAvailability']."','hide')"
		);
		if( $i==1 || (isset($fillSessions['ticketCheckBox'.$sellarrayObj->TicketCategoryId]) && $fillSessions['ticketCheckBox'.$sellarrayObj->TicketCategoryId]==1)){
			$ticket['class']='fl price_input width100px required NumGrtrZero special2 '.$freeClass;
		}else{
			$ticket['class']='fl price_input_disable width100px special2 '.$freeClass;
		}
		
		$priceDBValue=(isset($priceDBValue) && $priceDBValue > 0)?$priceDBValue:0;
		$priceDetails=getDisplayPrice($priceDBValue,$seller_currency);
		
		
		$price = array(
			'name'	=> 'price['.$configTicketCategoryKey[$sellarrayObj->TicketCategoryId-1].']',
			'id'	=> 'price'.$sellarrayObj->TicketCategoryId,
			'value'  => $priceDBValue,
			'maxlength'	=> 50,
			'size'	=> 20,
			'onkeyup'=>"getDisplayPrice(this,'".$seller_currency."','#totalCommision".$sellarrayObj->TicketCategoryId."','#displayPrice".$sellarrayObj->TicketCategoryId."')"
		);
		if( $i==1 || (isset($fillSessions['ticketCheckBox'.$sellarrayObj->TicketCategoryId]) && $fillSessions['ticketCheckBox'.$sellarrayObj->TicketCategoryId]==1)){
			$price['class']='fl price_input width100px required NumGrtrZero '.$freeClass;
		}else{
			$price['class']='fl price_input_disable width100px '.$freeClass;
		}
		?>			
		<input type="hidden" value="<?php echo $sellarrayObj->TicketCategoryId;?>" name="ticketCatId[]" id="ticketCatId" />
		<div class="row">
			<div class="label_wrapper cell height_24 ">
			  <label class="select_field_contav height_24 lineH24 label_bg_position"><?php echo $sellarrayObj->Title; ?></label>
			</div>
			<div class=" cell frm_element_wrapper pt0 min_hauto">
			  <div class="consumebg">
				<div class="row">
				  <div class="fl">
					<div class="price_trans_wp">
					  <div class="price_trans_checkbox_wp Fleft">
						<div class="defaultP mt2 ml20 ">
						  <?php 
							echo form_checkbox($ticketCheckBox);
						  ?>
						</div>
					  </div>
					  <div class="font_opensansSBold ml5 fl width120px"> <?php echo form_input($ticket); ?> </div>
						<div class="font_opensansSBold  width120px fl"> <?php echo form_input($price); ?> </div>
						 <div class="font_opensansSBold ml60 fl widht_63 pt2 mr14" id="totalCommision<?php echo $sellarrayObj->TicketCategoryId;?>">
							<?php echo $priceDetails['currencySign'].' '.$priceDetails['totalCommision']?>
						 </div>
						 <div class="font_opensansSBold ml16 fl pt2 widht_72 clr_white text_alignR pr19 pl16" id="displayPrice<?php echo $sellarrayObj->TicketCategoryId;?>">
							<?php echo $priceDetails['currencySign'].' '.$priceDetails['displayPrice']?>
						 </div>
					</div>
				  </div>
				</div>
				<div class="clear"> </div>
			  </div>
			</div>
			<div class="clear"></div>
		</div>		
	
<?php  } ?>
	<div class="row">
		<div class="cell width_200">&nbsp;</div>
		<div class="fl width_330 height_21"> </div>
		<div class="font_opensansSBold ml24 fl width_85 height4 pt2"> </div>
		<div class="font_opensansSBold ml26 fl pt2  widht_72 clr_white text_alignR pr19 pl16 consumebg_bottom"> </div>
		<div class="clear"></div>
	</div>
</div> <!-- End for sell ticket-->
<!-- SHOW THE FREE CATEGORY TICKETS -->
<div id="freeticket" class="dn">
	<div class="row"> 
			<div class="label_wrapper cell">
			  <div class="lable_heading">
					<h1><?php echo $label['tickets']; ?></h1>
			  </div> <!-- lable_heading-->
			</div><!-- label_wrapper cell-->
			
			<div class="cell frm_element_wrapper">
				<span class="clear_seprator"></span>
				<div  class="cell width45px">
				   <label class="orange">&nbsp;<?php // echo $label['categories']; ?></label>
				</div>
				
				<div class="cell pl12 width130px">
					<label class="orange"><?php echo $label['ticketsAvail']; ?></label> 
				</div>
				<div class="cell pl25">&nbsp;</div>
				<div class="cell galAltText">
					<label class="orange"><?php //echo $label['ticketPrice']; ?></label>
				</div>
				<div class="cell width100px">
					<label class="orange"><?php echo $this->lang->line('tsCommision');?></label>
				</div>
				<div class="cell">
					<label class="orange"><?php echo $this->lang->line('displayPrice');?></label>
				</div>
		   </div>			 
	</div><!--row -->
<?php 
foreach ($free_array as $i => $freearrayObj) {
	  				
		$freeClass = "free";		
		
		if(strcmp($configTicketCategory[$configTicketCategoryKey[3]],$freearrayObj->Title)==0) $CatValue = $configTicketCategoryKey[3];		
		
		$freeTicketIdDBValue = 0;
		$freeticketCheckBoxDBValue = (@$fillSessions['ticketCheckBox'.$freearrayObj->TicketCategoryId]==1)?TRUE:FALSE;	
		$ticketDBValue = (@$fillSessions['ticket'.$freearrayObj->TicketCategoryId]!='')?@$fillSessions['ticket'.$freearrayObj->TicketCategoryId]:'';	
		$freeTicketIdDBValue = ((@$fillSessions['ticketId'.$freearrayObj->TicketCategoryId]!='') && (@$fillSessions['ticketId'.$freearrayObj->TicketCategoryId]>0))?@$fillSessions['ticketId'.$freearrayObj->TicketCategoryId]:0;		
			
		$ticketCheckBox = array(
			'name'        => 'ticketCheckBox['.$configTicketCategoryKey[3].']',
			'id'          => 'ticketCheckBox'.$freearrayObj->TicketCategoryId,
			'value'       => $CatValue,
			'class' => 'priceSchRel '.$freeClass,
			'priceSchRel' => $freearrayObj->TicketCategoryId,
			//'onblur'=>"checkTicket('ticketCheckBox".$masterTicketsObj->TicketCategoryId."')"
		);
		if( isset($fillSessions['ticketCheckBox'.$freearrayObj->TicketCategoryId]) && $fillSessions['ticketCheckBox'.$freearrayObj->TicketCategoryId]==1){
				$ticketCheckBox['checked']=true;
		}
		$ticket = array(
			'name'	=> 'ticket['.$configTicketCategoryKey[3].']',
			'id'	=> 'ticket'.$freearrayObj->TicketCategoryId,
			'class'	=> 'BdrCommon required NumGrtrZero '.$freeClass,
			'value'  => @$ticketDBValue,
			'placeholder'	=> $label['addAvailability'],
			
			'maxlength'	=> 50,
			'size'	=> 20,
			'style'=> 'width:120px;',
			'onblur'=>"placeHoderHideShow(this,'".$label['addAvailability']."','show')" ,
			'onclick'=>"placeHoderHideShow(this,'".$label['addAvailability']."','hide')"			
		);
		
		?>
		<input type="hidden" value="<?php echo $freearrayObj->TicketCategoryId;?>" name="ticketCatId[]" id="ticketCatId" />
		<!--input type="hidden" value="<?php echo $CatValue;?>" name="ticketCheckBox[]" id="ticketCheckBox<?php echo $freearrayObj->TicketCategoryId;?>" /-->
		
			<div class="row">	
			 <div class="label_wrapper cell">
				 <label><?php if(strcmp($configTicketCategory[$configTicketCategoryKey[3]],$freearrayObj->Title)==0) echo $label['freeTicket']; else echo $freearrayObj->Title; ?></label> 
				</div><!--label_wrapper-->	
						
				<div class="cell defaultP mt10 ml20"><?php //$ticketCheckBox['type'] = 'hidden'; echo form_checkbox($ticketCheckBox);?></div>			
				<div class="cell width50px">&nbsp;</div>
				<div class="cell mt10"><?php echo form_input($ticket); ?></div>
				<div class="cell width50px">&nbsp;</div>
				<div class="cell mt10"><?php echo '&nbsp;'.$label['freeTicketText1'].$this->config->item('eventFreeTickets').$label['freeTicketText2'];?>
				</div>
				<div class="seprator_25 clear"></div>
			</div>	
<?php } ?>

</div><!-- End for free ticket-->
<div id="atleastoneticket"  class="dn row ">
	<div class="label_wrapper cell bg_none">&nbsp;</div><!-- label_wrapper cell-->
	<div class="cell frm_element_wrapper error"><?php echo $this->lang->line('atLeastOnePrice');?></div>
</div>


<?php echo $this->load->view('session_early_bird_form');?>

<div id="consumptionTaxSettingsDiv" class="row">

	<?php 
	if($moduleMethod=='launchsession'){
		$projectId=$launchEventId;
	}else{
		$projectId=$eventId;
	}
	echo Modules::run("counsumptiontax/counsumptiontaxForm",getMasterTableRecord('EventSessions'),$sessionId,$projectId); ?>
</div>
<!-- Below Show Save And Cancel Button -->
<div class="clear"></div>

	<div class="row">
		<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->
		<div class=" cell frm_element_wrapper pagingWrapper">
			<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->				
			<?php
									
				$button = array('saveOnClick');
				echo Modules::run("common/loadButtons",$button); 
				
				if(strcmp($this->router->method,'launch')!=0) {
					$button = array('cancelHide','uploadElementForm');
					echo Modules::run("common/loadButtons",$button); 
				}
									
			?>	
			<div class="row"><div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('allReqFieldMsg');?></div></div>
			<!--add additional instructions-->
			<?php 
			
			if(isset($projectId) || isset($launchEventId)){
				if($moduleMethod=='events' || $moduleMethod=='eventwithlaunch'){	
					if($moduleMethod=='eventwithlaunch'){
						$index_url = site_url(lang()).'/event/eventwithlaunch/eventwithlaunchdetail';
					}else{
						$index_url = site_url(lang()).'/event/'.$moduleMethod.'/eventdetail/'.$projectId;
					}
			?>
			<div class="row makeShowcaseBetter">
				<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('makeShowcaseBetterMsgChange');?>
				<a href="<?php echo site_url(lang()).'/event/'.$moduleMethod.'/eventFurtherDesc/'.$projectId;?>" target="_blank">Promotional Material</a> or <a href="<?php echo site_url(lang()).'/event/'.$moduleMethod.'/eventprmaterial/'.$projectId;?>" target="_blank">PR Material</a>.</div>
			</div>
			<div class="row makeShowcaseBetter">
				<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('previewPublishInfoChange');?>
				<a href="<?php echo $index_url;?>" target="_blank">Index page</a>.</div>
			</div>
			
			<?php
			} if($moduleMethod=='launch' || $moduleMethod=='launchwithevent') {
				if($moduleMethod=='launchwithevent'){
						$index_url = site_url(lang()).'/event/eventwithlaunch/eventwithlaunchdetail';
					}else{
						$index_url = site_url(lang()).'/event/'.$moduleMethod.'/launchdetail/'.$launchEventId;
					}
			?>
			<div class="row makeShowcaseBetter">
				<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('makeShowcaseBetterMsgChange');?>
				<a href="<?php echo site_url(lang()).'/event/'.$moduleMethod.'/launchpromomaterial/'.$launchEventId;?>" target="_blank">Promotional Material</a> or <a href="<?php echo site_url(lang()).'/event/'.$moduleMethod.'/launchprmaterial/'.$launchEventId;?>" target="_blank">PR Material</a>.</div>
			</div>	
			<div class="row makeShowcaseBetter">
				<div class="cell">*&nbsp;</div><div class="cell" ><?php echo $this->lang->line('previewPublishInfoChange');?>
				<a href="<?php echo $index_url;?>" target="_blank">Index page</a>.</div>
			</div>
			<?php }
			}?>
			
		</div>
		
	</div>
</div>
</form>

<div class="upload_media_left_bottom row"></div><!--upload_media_left_bottom-->

<div class="seprator_5 clear"></div>
</div>
<?php 
$getLoggedIntdsUid = isLoginUser();
$whereCondition = array('tdsUid'=>$getLoggedIntdsUid);
$getEntriesCount = countResult('UserSellerSettings',$whereCondition);
?>

<?php //echo '<pre />';print_r($fillSessions);echo '<pre />';print_r($configTicketCategoryKey);echo $configTicketCategory[$configTicketCategoryKey[3]];print_r($configTicketCategory);?>
<script type="text/javascript">

	function submitform()
	{	
	
		var countticket = 0; 
		var val ='';
			if($("#eventSellstatus").is(':checked'))
			{	
				//If sell and no price is entered
				$('.special2').each(function () {
					val = $(this).attr('value');					
					if(val=='')
					{
					  countticket=(countticket+1);
					}					
				});	
				if(countticket>=3) {
				   $('#atleastoneticket').show();
				   $('#atleastoneticket').removeClass('dn');
				}
				else {
				   $('#atleastoneticket').hide();
				   $('#atleastoneticket').addClass('dn');
				}
			
				if($("#eventSellstatus").val()){
					<?php 
					//--------This code for checking seller info for paid session-------//
					if($getEntriesCount==0) { ?>
						customAlert('Please fill seller information from <a class="underline clr_F15921" href="<?php echo base_url('dashboard/globalsettings'); ?>">global setting</a> before save any product for sell');
					return false
					<?php } ?>  
				}
			
		}
		return true;	
	}

$("#starttime").mask("ho:nm");
$("#endtime").mask("ho:nm");

//when sell radio button is checked unset all the free related input values
function sell(){	
	if($("#eventSellstatus").is(':checked')){	
		
		//Empty the ticket value			
		<?php
		foreach ($masterTickets as $i => $masterTicketsObj) {			
		}
		?>
		runTimeCheckBox();
		$("#freeticket").hide();
		$("#sellticket").show();
		$("#consumptionTaxDiv").show();
		if($( '.cat:checked' ).length>0) {
			if($('#earlyBirdStatus').is(':checked')==true){
					$("#earlyBird").show();
					$("#earlyBirdComplete").show();
			}
			else{
				$("#earlyBird").hide();
				//$("#earlyBirdComplete").hide();
			}
			$("#earlyBirdComplete").show();
		}
		else 
		{
			$("#earlyBirdComplete").hide();
			$("#earlyBird").hide();
			$('#earlyBirdStatus').removeAttr('checked');
		}
		
		$('#ticket1').removeClass('price_input_disable');
		$('#ticket1').addClass('fl price_input required NumGrtrZero ');
		
		$('#price1').removeClass('price_input_disable');
		$('#price1').addClass('fl price_input required NumGrtrZero ');
		
	}
	
}

//when free radio button is checked unset all the sell related input values
function free(){
	
	if($("#eventSellstatusf").is(':checked')){
		
		$('#ticket4').removeClass('price_input_disable');
		$('#ticket4').addClass('fl price_input required NumGrtrZero ');

		var <?php echo 'ticketId4';?> = $(this).attr('<?php echo 'ticketId4';?>');
		$('#<?php echo 'ticketId4';?>').val(<?php echo  @$fillSessions['ticketId4'];?>);
		var <?php echo 'ticket4';?> = $(this).attr('<?php echo 'ticket4';?>');
		$('#<?php echo 'ticket4';?>').val(<?php echo  @$fillSessions['ticket4'];?>);
		$("#sellticket").hide();
		$("#earlyBirdComplete").hide();		
		$("#atleastoneticket").hide();	
		$("#consumptionTaxDiv").hide();	
		$("#freeticket").show();
		
		
				
		runTimeCheckBox();
	}
}

//when none radio button is checked unset all the sell related input values
function noTicket(){
	
	if($("#eventNoTicket").is(':checked')){
		
		$("#sellticket").hide();
		$("#earlyBirdComplete").hide();		
		$("#atleastoneticket").hide();	
		$("#consumptionTaxDiv").hide();	
		$("#freeticket").hide();
		
		
				
		runTimeCheckBox();
	}
}

//calling by default values
free();
sell();
runTimeCheckBox();
function changeClass(id){
	
	$('#'+id).addClass("required");
}


$(document).ready(function(){
  
    if($('#sessiondate').val()=='') $('#sessiondate').attr('dateGreaterThan','#currentDate');
    else $('#sessiondate').removeAttr('dateGreaterThan');
	$('.priceSchRel').click(function() {
		//if any of the category checkbox is checked then date field get activated
		if($( '.cat:checked' ).length>0) { $('#speStartDate1').removeAttr('disabled');$("#earlyBirdComplete").show(); }
		else { $('#speStartDate1').attr('disabled','disabled');$("#earlyBirdComplete").hide(); }
		
			if($(this).is(':checked')==true)
			{
				var reference = $(this).attr('priceSchRel');				
				var ticketCurr ='ticket'+reference;	
				var priceCurr ='price'+reference;	
				var spePriceCurr ='speStartPrice'+reference;	
				var earlyCurr ='early'+reference;	
				//alert(reference+ticketCurr+priceCurr);
				$('#'+ticketCurr).removeAttr('disabled');
				$('#'+priceCurr).removeAttr('disabled');
				$('#'+spePriceCurr).removeAttr('disabled');
				
				$('#'+ticketCurr).removeClass('price_input_disable');
				$('#'+ticketCurr).addClass('fl price_input required NumGrtrZero ');
				
				$('#'+priceCurr).removeClass('price_input_disable');
				$('#'+priceCurr).addClass('fl price_input required NumGrtrZero ');
				
				$('#'+earlyCurr).removeClass('dn');								
			}
			
			if($(this).is(':checked')==false)
			{
				var reference = $(this).attr('priceSchRel');		
				var ticketCurr ='ticket'+reference;	
				var priceCurr ='price'+reference;	
				var spePriceCurr ='speStartPrice'+reference;
				var earlyCurr ='early'+reference;
				//alert(reference+ticketCurr+priceCurr);
				//$('#'+spePriceCurr).attr('value','');
				$('#'+ticketCurr).attr('disabled','disabled');				
				$('#'+priceCurr).attr('disabled','disabled');				
				$('#'+spePriceCurr).attr('disabled','disabled');				
				
				$('#'+ticketCurr).removeClass('price_input required NumGrtrZero');
				$('#'+ticketCurr).addClass('fl price_input_disable ');
				$("label[for="+ticketCurr+"]").remove();
				$('#'+priceCurr).removeClass('price_input required NumGrtrZero');
				$('#'+priceCurr).addClass('fl price_input_disable ');	
				$("label[for="+priceCurr+"]").remove();
				$('#'+earlyCurr).addClass('dn');			
			}
	});	
	
});
	
function checkTicket() {
	var flag =0;
	
	$('input[type=checkbox]').each(function () {
		if( $(this).hasClass("priceSchRel")  && $(this).is(':checked')==true)
		{
			var reference = $(this).attr('priceSchRel');				
			var ticketCurr ='ticket'+reference;	
			var priceCurr ='price'+reference;	
			var spePriceCurr ='speStartPrice'+reference;
			var earlyBirdCurr ='early'+reference;
			//alert(reference+ticketCurr+priceCurr);
			$('#'+ticketCurr).removeAttr('disabled');
			$('#'+priceCurr).removeAttr('disabled');
			$('#'+spePriceCurr).removeAttr('disabled');
			$('#'+earlyBirdCurr).removeClass('dn');	
			$('#'+ticketCurr).addClass('required NumGrtrZero ');
			$('#'+priceCurr).addClass('required  NumGrtrZero ');	
			flag=1;		
		}
	});
	
	var checkboxcount =0;
	$('input[type=checkbox]').each(function () {
			checkboxcount = checkboxcount+1;
			
		if( $(this).hasClass("priceSchRel")  && $(this).is(':checked')==false)
		{			
			var reference = $(this).attr('priceSchRel');
		
			if(checkboxcount==1)
			{
				$('#ticketCheckBox'+reference).attr('checked','checked');
				$('#speStartDate'+reference).removeAttr('disabled');
				$('#speStartPrice'+reference).removeAttr('disabled');
				runTimeCheckBox();
			}				
			else
			{				
				var ticketCurr ='ticket'+reference;	
				var priceCurr ='price'+reference;	
				var spePriceCurr ='speStartPrice'+reference;
				var earlyBirdCurr ='early'+reference;
				//alert(reference+ticketCurr+priceCurr);
				$('#'+ticketCurr).attr('disabled','disabled');
				$('#'+priceCurr).attr('disabled','disabled');
				$('#'+spePriceCurr).attr('disabled','disabled');
				$('#'+earlyBirdCurr).addClass('dn');
				$('#'+ticketCurr).removeClass('required NumGrtrZero ');
				$('#'+priceCurr).removeClass('required NumGrtrZero ');	
			}		
		}
	});
	
	if($("#eventSellstatusf").is(':checked')) { $("#earlyBirdComplete").hide();free();}
	else { $("#earlyBirdComplete").show(); }
	
	if($('.cat:checked').length>0 && ($("#eventSellstatus").is(':checked'))) 
	{ 
		$("#eventSellstatus").attr('checked','checked'); 
		$("#eventSellstatusf").removeAttr('checked');
		$("#eventNoTicket").removeAttr('checked');
		
		if($("#earlyBirdStatus").is(':checked'))
		$("#earlyBird").show();
		else
		$("#earlyBird").hide();
		$("#earlyBirdComplete").show();
		$("#freeticket").hide();			
	}
	else if($("#eventSellstatusf").is(':checked')){ 
		$("#eventSellstatusf").attr('checked','checked'); 
		$("#earlyBirdComplete").hide(); 
		$("#eventSellstatus").removeAttr('checked');
		$("#eventNoTicket").removeAttr('checked');
		$("#sellticket").hide();
		$("#earlyBird").hide();
		$("#earlyBirdComplete").hide();
		$("#freeticket").show();
		 free();
	}else{			
		$("#eventNoTicket").attr('checked','checked'); 
		$("#sellticket").hide();
		$("#eventSellstatusf").removeAttr('checked');
		$("#earlyBirdComplete").hide(); 
		$("#eventSellstatus").removeAttr('checked');	
		$("#atleastoneticket").hide();	
		$("#consumptionTaxDiv").hide();	
		$("#freeticket").hide();		
		noTicket();
	}	
}

checkTicket();

function validateEndHhMm(id)
{
	$('#'+id).addClass("time");
	$('#'+id).attr('time',"(#endtime).val()");
}
runTimeCheckBox();
</script>

