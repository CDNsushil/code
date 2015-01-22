<?php 
class Resize extends CI_Controller {	
	 
  function index($newRunTimeWidth,$newRunTimeHeight,$filename)
  {
			header('Content-type: image/jpeg');
			
			$filename = base64_decode($filename);
			
			//$imgName = explode("/", strrev($filename));
			
			//$extArray = explode(".", strrev($filename));
			
			//Get Extension Here
			//$fileExtn = strrev($extArray[0]);
			//echo 'Extension:<pre />';
			//print_r($fileExtn);
			//die;
			
			list($width, $height) = getimagesize($filename);
			
			if($width>$height)
			{
				$new_width	=	$newRunTimeWidth;
				$new_height =  $height 	* ((($newRunTimeWidth*100)/$width)/100);
			}
			
			if($width<$height)
			{
				$new_height	=	$newRunTimeWidth;
				$new_width 	= 	$width 	* ((($newRunTimeHeight*100)/$height)/100);
			}
			
			if($width<$newRunTimeWidth && $height<$newRunTimeHeight)
			{
				 $new_width=$width;
				 $new_height=$height;	
			}
			
			$image_p = imagecreatetruecolor($new_width, $new_height);
			$image = imagecreatefromjpeg($filename);
			imagecopyresampled($image_p, $image, 0, 0 , 0, 0, $new_width, $new_height, $width, $height);
			imagejpeg($image_p, null, 100);		
 }
}//End Class
