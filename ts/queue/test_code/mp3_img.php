<h1>mp3 with image</h1>
<?php 
$Source =  dirname(__FILE__).'/testing_file.mp3';
$Destination =  dirname(__FILE__).'/mp3_img.mp3';

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
