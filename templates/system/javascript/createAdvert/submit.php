<?php 

mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("createAdvert") or die(mysql_error());

if(isset($_POST['show_generate_code'])){
	
	$show_generate_code = html_entity_decode($_POST['show_generate_code']);
	
	echo $show_generate_code;die();
	$sql = 'INSERT INTO advert (`html`) VALUES ("'.$show_generate_code.'")';
	mysql_query($sql);
	//echo "1 record added";
}

?>
