<?php
  $dbconn3 = pg_connect("host=94.242.251.14 port=5432 dbname=toadsquare user=postgres password=8899-hijk");
 if($dbconn3){
	 echo "DB is connected";
 }else{
	  echo "DB is not connected";
}
?>
