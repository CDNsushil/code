<?php
class lib_image_config{


private $mediaConfig = array();
private $mediaType = ''; 
private $mediaSize = ''; 

private $mediaThumbVersionFolder = ''; 

private $mediaOrignalSuffix = ''; 

private $imageMimeType = ''; 

private $mediaBigWidth = ''; 
private $mediaBigHeight = ''; 
private $mediaBigSuffix = ''; 

private $mediaMediumWidth = ''; 
private $mediaMediumHeight = ''; 
private $mediaMediumSuffix = ''; 

private $mediaSmallWidth = ''; 
private $mediaSmallHeight = ''; 
private $mediaSmallSuffix = ''; 

private $mediaExtraSmallWidth = ''; 
private $mediaExtraSmallHeight = ''; 
private $mediaExtraSmallSuffix = ''; 

 /**
 * Constructor
 */
function __construct(){
   
log_message('debug', "lib_img_config Initialized");

$this->CI =& get_instance();
//load libraries
$this->CI->load->database();
$this->CI->config->load('image_config');		
$this->mediaType = $this->CI->config->item('mediaTypeImages');	
$this->mediaSize = $this->CI->config->item('mediaSize');	
$this->mediaThumbVersionFolder = $this->CI->config->item('mediaThumbVersionFolder');	
$this->imageMimeType = $this->CI->config->item('imageMimeType');
	
$this->mediaBigWidth = $this->CI->config->item('mediaBigWidth');	
$this->mediaBigHeight = $this->CI->config->item('mediaBigHeight');
$this->mediaBigHeight = $this->CI->config->item('mediaBigHeight');

$this->mediaMediumWidth = $this->CI->config->item('mediaMediumWidth');	
$this->mediaMediumHeight = $this->CI->config->item('mediaMediumHeight');
$this->mediaMediumSuffix = $this->CI->config->item('mediaMediumSuffix');

$this->mediaSmallWidth = $this->CI->config->item('mediaSmallWidth');	
$this->mediaSmallHeight = $this->CI->config->item('mediaSmallHeight');
$this->mediaSmallSuffix = $this->CI->config->item('mediaSmallSuffix');	

$this->mediaExtraSmallWidth = $this->CI->config->item('mediaExtraSmallWidth');	
$this->mediaExtraSmallHeight = $this->CI->config->item('mediaExtraSmallHeight');
$this->mediaExtraSmallSuffix = $this->CI->config->item('mediaExtraSmallSuffix');		
}

public function getImgConfigValue()
 {
	
	$variables['mediaConfig']['mediaType'] = $this->mediaType;

 	$variables['mediaConfig']['mediaSize'] = $this->mediaSize;
 	$variables['mediaConfig']['mediaThumbVersionFolder'] = $this->mediaThumbVersionFolder;
 	$variables['mediaConfig']['mediaOrignalSuffix'] = $this->mediaOrignalSuffix;
 	$variables['mediaConfig']['imageMimeType'] = $this->imageMimeType;

	$variables['mediaConfig']['mediaBigWidth'] = $this->mediaBigWidth;
 	$variables['mediaConfig']['mediaBigHeight'] = $this->mediaBigHeight;
 	$variables['mediaConfig']['mediaBigSuffix'] = $this->mediaBigSuffix;

	$variables['mediaConfig']['mediaMediumWidth'] = $this->mediaMediumWidth;
 	$variables['mediaConfig']['mediaMediumHeight'] = $this->mediaMediumHeight;
 	$variables['mediaConfig']['mediaMediumSuffix'] = $this->mediaMediumSuffix;

	$variables['mediaConfig']['mediaSmallWidth'] = $this->mediaSmallWidth;
 	$variables['mediaConfig']['mediaSmallHeight'] = $this->mediaSmallHeight;
 	$variables['mediaConfig']['mediaSmallSuffix'] = $this->mediaSmallSuffix;

	$variables['mediaConfig']['mediaExtraSmallWidth'] = $this->mediaExtraSmallWidth;
 	$variables['mediaConfig']['mediaExtraSmallHeight'] = $this->mediaExtraSmallHeight;
 	$variables['mediaConfig']['mediaExtraSmallSuffix'] = $this->mediaExtraSmallSuffix;
 	
  
  return $variables;

 }//function getValues

}//end Class lib_img_config

?>
