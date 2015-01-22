<?php 
$Source =  dirname(__FILE__).'/dummy.pdf';
$Destination =  dirname(__FILE__).'/dummy.swf';

			define('swf2pdf_LIBRARY', 'pdf2swf ');
	
		$exec_string = swf2pdf_LIBRARY . $Source.'  -o '.$Destination;
		
		echo $exec_string;
		echo "<br><br>";
		passthru($exec_string);
		
		
   if(file_exists($Destination))
   	{
		//passthru ("ffmpeg -y -i '".$Source."' -crf 25.0 -vcodec libx264 -acodec libfaac -ar 48000 -coder 1 -flags +loop -cmp +chroma -partitions +parti4x4+partp8x8+partb8x8 -me_method hex -subq 6 -me_range 16 -g 250 -keyint_min 25 -sc_threshold 40 -i_qfactor 0.71 -b_strategy 1 -qcomp 0.6 -qmin 0 -qmax 69 -qdiff 4 -bf 3 -refs 8 -direct-pred 3 -trellis 2 -wpredp 2 -rc-lookahead 60 -threads 0 '".$Destination."'",$result);
		echo "file converted";
	}
	else
	{
		echo "file not found.";
	}
	
/*
 
 $command= "ffmpeg -y -i '".$Source."' -crf 25.0 -vcodec libx264 -acodec libfaac -ar 48000 -coder 1 -flags +loop -cmp +chroma -partitions +parti4x4+partp8x8+partb8x8 -me_method hex -subq 6 -me_range 16 -g 250 -keyint_min 25 -sc_threshold 40 -i_qfactor 0.71 -b_strategy 1 -qcomp 0.6 -qmin 0 -qmax 69 -qdiff 4 -bf 3 -refs 8 -direct-pred 3 -trellis 2 -wpredp 2 -rc-lookahead 60 -threads 0 '".$Destination."'";
		//passthru ("ffmpeg -y -i '".$Source."' -crf 25.0 -vcodec libx264 -acodec libfaac -ar 48000 -coder 1 -flags +loop -cmp +chroma -partitions +parti4x4+partp8x8+partb8x8 -me_method hex -subq 6 -me_range 16 -g 250 -keyint_min 25 -sc_threshold 40 -i_qfactor 0.71 -b_strategy 1 -qcomp 0.6 -qmin 0 -qmax 69 -qdiff 4 -bf 3 -refs 8 -direct-pred 3 -trellis 2 -wpredp 2 -rc-lookahead 60 -threads 0 '".$Destination."'",$result);
		//echo "file converted";
		
		exec($command." 2>&1", $output);
		echo "<pre>";
		var_dump($output);
		echo "</pre>"; 
 */ 
 

?>
