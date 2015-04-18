<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
if(count($products)>0){
?>
<div class="row">
<div class="cell" style="width:500px;"><h3><?php echo $label['title'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="width:175px;"><h3><?php echo $label['writerName'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell"><h3><?php echo $label['Date'];?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>
<div class="row heightSpacer"> &nbsp;</div>	
<?php

foreach($products as $productsItem)
{

	if($productsItem->productModifiedDate==NULL) $productDate = date("F d, Y", strtotime($productsItem->productDateCreated));
	else $productDate = date("F d, Y", strtotime($productsItem->productModifiedDate));
	
?>
		
<div class="row">
<div class="cell" style="max-width:500px;min-width:500px;"><?php echo $productsItem->productTitle;?></h3></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:150px;min-width:150px;"><?php echo $userFullName;?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
<div class="cell" style="max-width:100px;"><?php echo $productDate;?></div><div class="cell" style="padding-left:10px;">&nbsp;</div>
</div>
<div class="row heightSpacer"> &nbsp;</div>	
<?php
}
}
else{
echo '<div id="PRODUCTS-No-Records">';
echo $label['clickHere'].$label['associateElements'].anchor('javascript://void(0);', $label['PRODUCTS'],array('class'=>'formTip','title'=>$label['PRODUCTS'],'onclick'=>'showRelatedForm(\'PRODUCTSForm-Content-Box\',\'PRODUCTS-No-Records\');'));
echo '</div>';
echo '<div class="row heightSpacer"> &nbsp;</div>';

}
?>
