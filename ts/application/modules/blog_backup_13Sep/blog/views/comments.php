<div class="Right_side_panel" style="background-color:#FFFFFF">
Comments

<span class="clear_seprator "></span>

<?php
if($postCommentsQuery->num_rows>0){
foreach($postCommentsResults as $row){
//Mr WordPress on July 6, 2011 at 5:55 pm said:

	$comDateCreated = date("F d, Y", strtotime($row->comDateCreated));
	$comDateCreated .=' at '.date("h:m A", strtotime($row->comDateCreated));
	$commentPostedBy ='<strong>'.$row->firstName.'&nbsp;'.$row->lastName.'</strong>&nbsp;';
?>
	<div><?php echo $commentPostedBy.'on '.$comDateCreated;?> said:</div><div style="float:left;"><?php echo $row->comDesc; ?></div>	
	<span class="clear_seprator "></span>
<?php	
}//End ForEach
}else echo 'No Comments Posted!';
?>

</div>