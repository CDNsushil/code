<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php

if(!isset($NatureId) || $NatureId =='') $NatureId = 1;
$location = $this->uri->segment(3);
$EventId  = $this->uri->segment(4);
if(isset($EventId) && $EventId>0 && $EventId !='')
$currentEventId = $EventId;
else
$currentEventId = 0;

$classSelected = "class='Main_btn_box Main_select'";
$class ="class='Main_btn_box'";

$setBackUrl = array('backurl'  => $this->router->method);

$this->session->set_userdata($setBackUrl);
$currentBackUrl      = $this->session->userdata('backurl');

//$currentBackshowcaseId      = $this->session->userdata('showcaseId');
?>

<div class="Main_btn_wp"> 
<div <?php echo $classSelected; ?> style="padding-left:20px;">
<?php

if(isset($currentBackeventId) && $currentBackeventId>0)
	$eventURL = 'event/index/'.$currentBackeventId;
else
	$eventURL = 'event/index/'.$currentEventId;	
echo anchor('event/index', '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['event'].'</div></div>',array('class'=>'commonfontfamily'));

?>
		
</div><!--main_btn_wp-->
</div><!--Main_btn_wp-->

<?php
//one menu for Event Notification Only
if($NatureId ==1) {
?>
<div class="Main_btn_wp"> 

<div <?php if((strcmp($location,'eventForm')==0) || (strcmp($location,'index')==0)) { echo $classSelected; }else{ echo $class; } ?> style="padding-left:20px;">
<?php if((strcmp($location,'eventForm')==0) || (strcmp($location,'index')==0)) {?>
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label>'.$label['eventNotification'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->			
<?php 
}
else
{
echo anchor('event/eventForm/'.$currentEventId, '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['eventNotification'].'</div></div>',array('class'=>'commonfontfamily'));
}
?>		
</div><!--main_btn_wp-->
</div><!--Main_btn_wp-->
<?php
} 
?>



<?php
//one menu for Event Notification Only
if($NatureId ==2) {
?>
<div class="Main_btn_wp"> 

<div <?php if((strcmp($location,'eventForm')==0) || (strcmp($location,'index')==0)) { echo $classSelected; }else{ echo $class; } ?> style="padding-left:20px;">
<?php if((strcmp($location,'eventForm')==0) || (strcmp($location,'index')==0)) {?>
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label>'.$label['eventDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->			
<?php 
}
else
{
echo anchor('event/eventForm/'.$currentEventId, '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['eventDescription'].'</div></div>',array('class'=>'commonfontfamily'));
}
?>		
</div><!--main_btn_wp-->
<?php

//To show further description only

if($currentEventId>0)  
$class_Main_btn_left = 'class="Main_btn_left"';
else
$class_Main_btn_left = 'class="Main_btn_left_inactive"';

if($currentEventId==0) { 
	
?>

<div <?php echo $class;  ?> >

<div <?php echo $class_Main_btn_left;?>>
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['furtherDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->
<?php
}
else{
?>
<div <?php if((strcmp($location,'eventFurtherDesc')==0)) { echo $classSelected; }else{ echo $class; } ?>>
<?php if(strcmp($location,'eventFurtherDesc')==0) {?>
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['furtherDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->

<?php 
}
else{

echo anchor('event/eventFurtherDesc/'.$currentEventId.'/'.$NatureId, '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['furtherDescription'].'</div></div>',array('class'=>'commonfontfamily'));
} 
}
?>
</div><!--main_btn_wp-->

<?php

//To show event Additional Info Form only

if($currentEventId==0) { 
?>
<div <?php echo $class;  ?> >

<div  <?php echo $class_Main_btn_left;?>>
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['additionalInformation'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->
<?php
}
else{
?>
<div <?php if((strcmp($location,'eventAdditionalInfoForm')==0)) { echo $classSelected; }else{ echo $class; } ?>>
<?php if(strcmp($location,'eventAdditionalInfoForm')==0) {?>
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['additionalInformation'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->

<?php 
}
else{

echo anchor('event/eventAdditionalInfoForm/'.$currentEventId.'/'.$NatureId, '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['additionalInformation'].'</div></div>',array('class'=>'commonfontfamily'));
} 
}
?>
</div><!--main_btn_wp-->

</div><!--Main_btn_wp-->
<?php
} 
?>

<?php
//launchEvent Sub Menu
if(((strcmp($location,'launchEventForm')==0)|| (strcmp($location,'launchEvent')==0)) && $NatureId ==3){ 
?>
<div class="Main_btn_wp "> 
<div  class="Main_btn_box  Main_select" style="padding-left:20px;">
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label>'.$label['launchDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->			
</div><!--main_btn_wp-->		

</div><!--Main_btn_wp-->
<?php
}
?>



<?php
//one menu for Event Notification Only
if($NatureId ==4) {
?>
<div class="Main_btn_wp"> 

<div <?php if((strcmp($location,'eventForm')==0) || (strcmp($location,'index')==0)) { echo $classSelected; }else{ echo $class; } ?> style="padding-left:20px;">
<?php if((strcmp($location,'eventForm')==0) || (strcmp($location,'index')==0)) {?>
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label>'.$label['eventDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->			
<?php 
}
else
{
echo anchor('event/eventForm/'.$currentEventId, '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['eventDescription'].'</div></div>',array('class'=>'commonfontfamily'));
}
?>		
</div><!--main_btn_wp-->
<?php

//To show further description only
if($currentEventId>0)  
$class_Main_btn_left = 'class="Main_btn_left"';
else
$class_Main_btn_left = 'class="Main_btn_left_inactive"';

if($currentEventId==0) { 
?>
<div <?php echo $class;  ?> >

<div <?php echo $class_Main_btn_left;?>>
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['furtherDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->
<?php
}
else{
?>
<div <?php if((strcmp($location,'eventFurtherDesc')==0)) { echo $classSelected; }else{ echo $class; } ?>>
<?php if(strcmp($location,'eventFurtherDesc')==0) {?>
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['furtherDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->

<?php 
}
else{

echo anchor('event/eventFurtherDesc/'.$currentEventId.'/'.$NatureId, '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['furtherDescription'].'</div></div>',array('class'=>'commonfontfamily'));
} 
}
?>
</div><!--main_btn_wp-->

<?php

//To show event Additional Info Form only

if($currentEventId==0) { 
?>
<div <?php echo $class;  ?> >

<div <?php echo $class_Main_btn_left;?>>
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['furtherDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->
<?php
}
else{
?>
<div <?php if((strcmp($location,'eventAdditionalInfoForm')==0)) { echo $classSelected; }else{ echo $class; } ?>>
<?php if(strcmp($location,'eventAdditionalInfoForm')==0) {?>
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['additionalInformation'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->

<?php 
}
else{

echo anchor('event/eventAdditionalInfoForm/'.$currentEventId.'/'.$NatureId, '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['additionalInformation'].'</div></div>',array('class'=>'commonfontfamily'));
} 
}
?>
</div><!--main_btn_wp-->


<?php

//To show event Additional Info Form only

if($currentEventId==0) { 
?>
<div <?php echo $class;  ?> >

<div <?php echo $class_Main_btn_left;?>>
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['launchDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->
<?php
}
else{
?>
<div <?php if((strcmp($location,'launchEventForm')==0)) { echo $classSelected; }else{ echo $class; } ?>>
<?php if(strcmp($location,'launchEventForm')==0) {?>
<div class="Main_btn_left">
<div class="Main_btn_right">
	<?php echo '<label class="commonfontfamily">'.$label['launchDescription'].'</label>';?>
</div><!--Main_btn_right-->
</div><!--Main_btn_left-->

<?php 
}
else{

echo anchor('event/launchEventForm/'.$currentEventId.'/'.$NatureId, '<div class="Main_btn_left"><div class="Main_btn_right">'.$label['launchDescription'].'</div></div>',array('class'=>'commonfontfamily'));
} 
}
?>
</div><!--main_btn_wp-->


</div><!--Main_btn_wp-->
<?php
} 
?>
