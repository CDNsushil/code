<h1>m4a with no image</h1>
<?php 
$Source =  dirname(__FILE__).'/_EK_LADKI_KO_DEKHA_TO_11.m4a';
$Destination =  dirname(__FILE__).'/m4a_not_img.mp3';

   if(file_exists($Source))
   	{
		$command= "ffmpeg -y -i '".$Source."' -vcodec mjpeg -qscale 1 '".$Destination."'";
		//$command= "'".$Source."' -vcodec mjpeg -qscale 1 '".$Destination."'";
	
		echo $command;
		echo "<br><br><br><br><br>";
		
		exec($command." 2>&1", $output);
		echo "<pre>";
		var_dump($output);
		echo "</pre>";
	}
	else
	{
		echo "file not found.";
	}
	
	

?>
