<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
if(count($works)>0){
?>
<div class="row">
<div class="cell" style="width:500px;"><h3><?php echo $label['title'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="width:175px;"><h3><?php echo $label['writerName'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><h3><?php echo $label['Date'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>
<div class="row heightSpacer"> &nbsp;</div>	
<?php

foreach($works as $worksItem)
{
	
	if($worksItem->workModifiedDate==NULL) $workDate = date("F d, Y", strtotime($worksItem->workDateCreated));
	else $workDate = date("F d, Y", strtotime($worksItem->workModifiedDate));
?>
		
<div class="row">
<div class="cell" style="max-width:500px;min-width:500px;"><?php echo $worksItem->workTitle;?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:150px;min-width:150px;"><?php echo $userFullName;?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:100px;"><?php echo $workDate;?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>
</div>
<?php
}
}
else{
echo '<div id="WORKS-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['WORK'],array('class'=>'formTip','title'=>$label['WORK'],'onclick'=>'showRelatedForm(\'WORKSForm-Content-Box\',\'WORKS-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>';
}
?>
