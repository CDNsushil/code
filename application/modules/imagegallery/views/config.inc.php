<?php
// for absolute path http://www.mysite.com/userfiles/ or for relative path userfiles/ 
$ImageGalleryPath =  MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/';
$ShowImageGalleryPath =  base_url().'media/'.LoginUserDetails('username').'/project/blog/gallery/';
define("_baseurl",  base_url()); 
define("_showpath",  $ShowImageGalleryPath); 
define("_path",  $ImageGalleryPath); 
define("_folder", $ImageGalleryPath); // For example userfiles/
?>