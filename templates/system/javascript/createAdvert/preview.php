<?php
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("createAdvert") or die(mysql_error());

if(isset($_GET)){
$id = $_GET['view'];	
}else{	
$id = '6';
}
$sql = "SELECT * FROM  `advert`  where id='".$id."'";
$query = mysql_query($sql);
$getData= mysql_fetch_assoc($query);
$serverPath = 'http://localhost/gradx/';
$code = $getData['html'];

$searchArray = array("{server_path}");
$replaceArray = array($serverPath);
$newCode=str_replace($searchArray, $replaceArray, $code);
echo $newCode;
?>
