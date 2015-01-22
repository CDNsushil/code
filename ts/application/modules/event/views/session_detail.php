<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
?>

<?php

if(count($sesTimes)>0){
	$isesTimesFormAttributes = array(
		'name'=>'sesTimesListForm',
		'id'=>'sesTimesListForm'
	);

	$sessionIdForDelete = array(
		'name'=>'sessionIdForDelete',
		'id'=>'sessionIdForDelete',
		'type'=>'hidden'
	);
	$returnUrl = base_url($this->uri->uri_string());
	
	//To Delete The Session
	echo form_open('additionalInfo/shiftSessionTime',$isesTimesFormAttributes);
	echo form_input($sessionIdForDelete);	
	echo '<input type="hidden" value="'.$returnUrl.'" name="returnUrl" id="returnUrl" />';
	echo form_close();
	//End Form
	
	$countRecord =  count($sesTimes)-1;
	$isesTimes = 0; 

		
	foreach($sesTimes as $k=>$sesTimesItem)
	{
	 //echo '<pre />';
	// print_r($sesTimesItem);
	// print_r($Tickets);
		$timeDiff = getTimeDiff($sesTimesItem->startTime,$sesTimesItem->endTime);
		
		list($diffhour, $diffmin, $diffsec) = explode(":", $timeDiff);
		
		$actualTime = $diffhour.':'.$diffmin;
		/*
		if($diffhour>0 && $diffmin>0) $actualTime = $diffhour.':';
		else $actualTime = $diffhour;
		if($diffhour<=0) $diffmin ='00:'.$diffmin;
		if($diffmin!=0) $actualTime .= $diffmin;
		
		*/
		$sessionDate = substr($sesTimesItem->date,0,-9);
		list($starthour, $startmin, $startsec) = explode(":", $sesTimesItem->startTime);
	
		if(substr($starthour,0,1) ==0) $starthour = substr($starthour,1);
		if(substr($startmin,0,1) ==0) $startmin = substr($startmin,1);
		
		list($endhour, $endmin, $endsec) = explode(":", $sesTimesItem->endTime);
		
		if(substr($endhour,0,1) ==0) $endhour = substr($endhour,1);
		if(substr($endmin,0,1) ==0) $endmin = substr($endmin,1);
		
		$sessionStartTime = $starthour.':'.$startmin;
		
		list($hour, $min, $sec) = explode(":", $sesTimesItem->startTime);
		$startTime = $hour.':'.$min;
		/*
		if($starthour>0 && $startmin>0) $sessionStartTime = $starthour.':';
		else $sessionStartTime = $starthour;
		if($starthour<=0) $startmin = '00:'.$startmin;
		if($startmin!=0) $sessionStartTime .= $startmin;
		*/
		
		$sessionEndTime = $endhour.':'.$endmin;
		/*
		if($endhour>0 && $endmin>0) $sessionEndTime = $endhour.':';
		else $sessionEndTime = $endhour;
		if($endhour<=0) $endmin = '00:'.$endmin;
		if($endmin!=0) $sessionEndTime .= $endmin;
		*/
		//FOR ADDRESS DEFINING VARIABLE
		$addressInfo = '--';
				if(isset($sesTimesItem->venueName) &&  $sesTimesItem->venueName!='')
				{
					$addressInfo = getSubString($sesTimesItem->venueName,20);
				}
				/*
				if(isset($sesTimesItem->city) &&  $sesTimesItem->city!='')
				{
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.$sesTimesItem->city;
					else $addressInfo = $sesTimesItem->city;
				}
				
				if(isset($sesTimesItem->country) &&  $sesTimesItem->country!='' &&  $sesTimesItem->country!=0)
				{
					
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.getCountry($sesTimesItem->country);
					else $addressInfo = getCountry($sesTimesItem->country);
				}
				
				if(isset($sesTimesItem->state) &&  $sesTimesItem->state!='')
				{
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.$sesTimesItem->state;
					else $addressInfo = $sesTimesItem->state;
				}
				
				if(isset($sesTimesItem->zip) &&  $sesTimesItem->zip!='')
				{
					if(isset($addressInfo ) &&  $addressInfo !='')$addressInfo .= ','.$sesTimesItem->zip;
					else $addressInfo = $sesTimesItem->zip;
				}
				*/
				
		if(isset($sesTimesItem->url)&& $sesTimesItem->url!=''){			
			if(strpos($sesTimesItem->url, "http://")==0) $sessURL = $sesTimesItem->url;
			else $sessURL = "http://".$sesTimesItem->url;
		}else $sessURL = "";

		
		$redBorder3px=($isBlocked=='t')?'redBorder3px':'';
		$expiryDateColor=($isExpired=='t')?'red':'';
	?>
	
	<div class="row blog_wrapper new_theme_second_gray  new_theme_bdr <?php echo $redBorder3px;?>">
		<div class="blog_box  pt4 pb3 new_theme_second_gray">
		<div class="row">
		<div class="cell blog_left_wrapper width_100_per">
		
		<div class="date_vedio_wp">
			<div class="date_vedio_box">
				<span class="date_label_vedio">Date</span> <span class="date_value_vedio"><?php echo date("d F Y", strtotime($sessionDate));?></span>
			</div><!--date_vedio_box-->
			
			<div class="date_vedio_box width225px">
				<span class="date_label_vedio">URL</span> <span class="date_value_vedio"><?php echo getSubString($sessURL,20);?></span>
			</div><!--date_vedio_box-->			
			
			<div class="date_vedio_box">
				<span class="date_label_vedio">Venue</span> <span class="date_value_vedio"><?php echo $addressInfo;?></span>
			</div><!--date_vedio_box-->
			
			<div class="date_vedio_box">
				<span class="date_label_vedio">Time</span> <span class="date_value_vedio"><?php echo $startTime;?></span>
			</div><!--date_vedio_box-->
		</div><!--date_vedio_wp-->
		 
		  <div class="new_theme_small_btn_wp">		
			<div class="tds-button-top"> 	
				
			<?php
			/*$uri_url = $this->uri->uri_string();
			$url = (substr($uri_url, -1) == '/') ? substr($uri_url, 0, -1) : $uri_url; // remove trailing slash if present
			$urlparts = explode('/', $url); // explode on slash
			array_pop($urlparts); // remove last part
			$post_url = implode($urlparts, '/'); // put it back together
			* 
			launchwitheventlaunchevent/
			*/
			
			if(strcmp($this->router->method,'launchwithevent')==0 || strcmp($this->router->method,'launch')==0){
				$section='launch';
				$post_url='event/'.$this->router->method.'/launchsession/'.$sesTimesItem->launchEventId;
				//echo anchor(base_url($post_url), '<div class="projectEditIcon"></div>');
				$launchSessionForm = array('id'=>'sessionForm'.$sesTimesItem->sessionId,'name'=>'sessionForm'.$sesTimesItem->sessionId);
				echo form_open($post_url,$launchSessionForm); 	
				echo '<input name="sessionId" value='.$sesTimesItem->sessionId.' type ="hidden" />';
				echo '<input name="LaunchEventId" value='.$sesTimesItem->launchEventId.' type ="hidden" />';
				echo '<input name="NatureId" value='.$NatureId.' type ="hidden" />';
				echo form_close();
				
				if($isArchive=='f' && $isBlocked=='f' && $isExpired=='f'){
					echo anchor('javascript://void(0);', '<div class="projectEditIcon"></div>',array('onclick'=>"$('#sessionForm$sesTimesItem->sessionId').submit();"));	  	  
				}
				
				if($isPublished=='t'){
					$sesionPreviw=base_url(lang().'/eventfrontend/sessionTickets/'.$userId.'/'.$sesTimesItem->launchEventId.'/launch');
					$previeTooltip=$this->lang->line('view');
				}else{
					$previeTooltip=$this->lang->line('preview');
					$sesionPreviw=base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$sesTimesItem->launchEventId.'/sessionTickets/launch');
				}
				
			}
			else{
				$section='event';
				$post_url='event/'.$this->router->method.'/eventsession/'.$sesTimesItem->eventId;
				$eventSessionForm = array('id'=>'sessionForm'.$sesTimesItem->sessionId,'name'=>'sessionForm'.$sesTimesItem->sessionId);
				echo form_open($post_url,$eventSessionForm); 	
				echo '<input name="currentSessionId" value='.$sesTimesItem->sessionId.' type ="hidden" />';
				echo '<input name="eventId" value='.$sesTimesItem->eventId.' type ="hidden" />';
				echo '<input name="NatureId" value='.$NatureId.' type ="hidden" />';
				echo form_close();
				
				if($isArchive !='t' && $isBlocked !='1' && $isExpired !='t'){
					echo anchor('javascript://void(0);', '<div class="projectEditIcon"></div>',array('onclick'=>"$('#sessionForm$sesTimesItem->sessionId').submit();"));	  
				}
				
				if($isPublished=='t'){
					$sesionPreviw=base_url(lang().'/eventfrontend/sessionTickets/'.$userId.'/'.$sesTimesItem->eventId.'/event');
					$previeTooltip=$this->lang->line('view');
				}else{
					$previeTooltip=$this->lang->line('preview');
					$sesionPreviw=base_url(lang().'/eventfrontend/preview/'.$userId.'/'.$sesTimesItem->eventId.'/sessionTickets/event');
				}
				
			
			}
			
			if($isArchive !='t' && $isBlocked !='1' && $isExpired !='t'){	?>
				 <a class="ml6 formTip" title="<?php echo $previeTooltip;?>" target="_blank" href="<?php echo $sesionPreviw; ?>"><div class="projectPreviewIcon"></div></a>	
				 <?php
			 }
			 
			 if($isBlocked != 't'){
				 
				 /*$attr = array("title"=>$this->lang->line('delete'),'class'=>'formTip delSess ml6','myDelSessionId'=>encode($sesTimesItem->sessionId));
				 echo anchor('javascript://void(0);','<div class="projectDeleteIcon"></div>',$attr);*/
					
				$deleteFunction="changeStatusAsDeleted('EventSessions','sessionId','".$sesTimesItem->sessionId."','".$section."','".$this->lang->line('sureDelMsg')."');";
				?> 
				<a href="javascript:void(0);" class="formTip ml6" onclick="<?php echo $deleteFunction;?>" title="<?php echo $this->lang->line('delete');?>"><span><div class="projectDeleteIcon"></div></span></a> 
				<?php
			}
			 ?>  
		   </div>
		 </div><!--new_theme_small_btn_wp-->  
		 <div class="clear"></div>		  	 
		</div>
	</div><!--first row-->
<div class="clear"></div>
<?php 
//If none ticket is selected then donot show ticket info
if($sesTimesItem->eventSellstatus !='') { ?>
<div class="row mt3">
<div class="sales_box_wp">
	<?php
	$catSpan = '';
	$avialableSpan = '';
	$priceSpan = '';
	$soldSpan = '';
	$saleSpan = '';
	$totalSale = '';
	//echo '<pre />';print_r($Tickets);
	foreach($Tickets as $k=>$TicketsItem)
	{
		//echo '<pre />';print_r($TicketsItem);
	if(($TicketsItem->isCategoryA=='t' ||$TicketsItem->isCategoryB=='t' ||$TicketsItem->isCategoryC=='t' ||$TicketsItem->Free=='t') && $TicketsItem->Quantity>0){
		//echo $sesTimesItem->sessionId.' == '.$TicketsItem->SessionId;
	if($sesTimesItem->sessionId == $TicketsItem->SessionId){ 
		//echo '<pre />';print_r($TicketsItem);
	 $categoryName = getFieldValueFrmTable('Title',$anyTable='MasterTicketCategories','TicketCategoryId',$TicketsItem->TicketCategoryId,'TicketCategoryId');
	 
	 $catSpan .= '<span>'.$categoryName[0]->Title.'</span>';
	 $avialableSpan .= '<span>'.$TicketsItem->Quantity.'/'.$TicketsItem->Quantity.'</span>';
	 if($TicketsItem->TicketCategoryId == 4)
	 $priceSpan .= '<span> Free </span>';
	 else
	 $priceSpan .= '<span>€ '.$TicketsItem->Price.'</span>';
	 
	 $soldSpan .= '<span> 0 </span>';
	 
	 if($TicketsItem->TicketCategoryId == 4)
	 $saleSpan .= '<span> Free </span>';
	 else
	 $saleSpan .= '<span> € 0 </span>';
	 $totalSale = 0; 	 
	}	
	}
	}
if($catSpan=='')$catSpan='-';
if($priceSpan=='')$priceSpan='-';
if($avialableSpan=='')$avialableSpan='-';
if($soldSpan=='')$soldSpan='-';
	?>
	<div class="sales_box_cat">
		<div class="sales_cat_label"> &nbsp;</div>
		<?php echo $catSpan;?>
	</div>
	
	<div class="sales_box_cat">
	<div class="sales_cat_label">Price</div>
		<?php echo $priceSpan;?>
	</div>	
	
	<div class="sales_box_cat">
	<div class="sales_cat_label">Available</div>
		 <?php echo $avialableSpan;?>
	</div>	
	
	<div class="sales_box_cat">
	<div class="sales_cat_label">Sold</div>
		<?php echo $soldSpan;?>
	</div>	
	
	<div class="sales_box_cat bg-non">
	<div class="sales_cat_label">Sales</div>
	<?php echo $saleSpan;?>
	 <div class="sales_total_box">€ 
		<?php echo ($totalSale=='')?0:$totalSale;?>
	 </div><!--total_box-->
	</div>		

</div>
 <div class="sales_btn_wp">
	<div class="session_box"><?php echo $this->lang->line('session'); ?></div>
	<div class="session_box"><?php echo $this->lang->line('meetingPoint'); ?> 0</div>
	</div><!--sales_btn_wp-->

	</div><!-- End blog_box -->
	
<?php } ?>
<div class="row seprator_5"></div>
	</div>
	<!--blog_box-->
	</div><!-- End blog_wrapper -->
	<div class="shadow_blog_box"> </div>
<?php 
	
	}//end foreach
	
}
?>

<script language="javascript" type="text/javascript">
$(document).ready(function() {

	$(".delSess").click(function() {
		var conBox = confirm('<?php echo $this->lang->line('sureDelMsg')?>');
		if(conBox)
		{			
			var myDelSessionId = $(this).attr('myDelSessionId');
			$("#sessionIdForDelete").val(myDelSessionId);
			$('#sesTimesListForm').submit();
			return true;
		}
		else
		{
			return false;
		}
	});
});

</script>
