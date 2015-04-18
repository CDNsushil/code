<?php 
$hash = $_GET['h'];
$streamname = $_GET['v'];
$timestamp = $_GET['t'];
$current = time();
$token = 'sn983pjcnhupclavsnda';
$checkhash = md5($token . '/' . $streamname . $timestamp);
write_log("HASH==".$hash."===checkhash===".$checkhash."=====timestamp===".$timestamp."====current===".$current);
if (($current - $timestamp) <= 20 && ($checkhash == $hash)) {
$streamname =base64_decode($streamname);
//$streamname = '../'.$streamname;
$streamname = '../../../media/'.$streamname;
	$fsize = filesize($streamname);
  header('Content-Disposition: attachment; filename="' . $streamname . '"');
  if (strrchr($streamname, '.') == '.mp4') {
    header('Content-Type: video/mp4');
  }else if (strrchr($streamname, '.') == '.mov') {
    header('Content-Type: video/mov');
  } else if (strrchr($streamname, '.') == '.mp3') {
    header('Content-Type: video/mp3');
  } else {
    header('Content-Type: video/x-flv');
  }
  header('Content-Length: ' . $fsize);
  session_cache_limiter('nocache');
  header('Expires: Thu, 19 Nov 1981 08:52:00 GMT');
  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
  header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
  header('Pragma: no-cache');
  $file = fopen($streamname, 'rb');
  print(fread($file, $fsize));
  fclose($file);
  exit;
} else {
	//print_r($_GET);
	//echo ($current - $timestamp) ."<= 2 && ".$checkhash." == ".$hash;
  header('Location: secure');
}

function write_log($content) {
	$file = fopen("log.txt", 'w+');
  fwrite($file, $content);
  fclose($file);
}
?>
