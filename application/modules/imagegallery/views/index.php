<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$systemCSS=base_url($this->config->item('system_css'));
$systemJS = base_url($this->config->item('system_js'));

error_reporting(E_ALL ^ E_NOTICE);
include("config.inc.php");
// upload
if ($_GET['action']=="upload") {
	$file_name=$_FILES["ffoto"]["name"];
	$file_size=$_FILES["ffoto"]["size"];
	$file_type=$_FILES["ffoto"]["type"];
	$path=$ImageGalleryPath;
	copy($_FILES['ffoto']['tmp_name'], $path.$file_name) ;
	$message='<p><b>Your file has been uploaded successfully</b></p>';
} else if ($_GET['action']=="delete") {
	unlink($_GET['file']);
}
// Crear carpeta
if ($_GET['action']=="create_folder") {
	$path=$_POST['folder'];
	mkdir($path.$_POST['fname'], 0777);
}
if ($_GET['action']=="delete_folder") {
	//echo 'folder deleted:'.$_GET['id'];
	rmdir($_GET['id']);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editor</title>
<script language="javascript" src="<?php echo $systemJS;?>/jquery-lib/multiple-upload/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="<?php echo $systemJS;?>/jquery-lib/multiple-upload/jqueryFileTree.js"></script>
<script type="text/javascript" src="<?php echo $systemJS;?>/jquery-lib/jquery.form.js"></script>
<script language="javascript" src="<?php echo $systemJS;?>/jquery-lib/multiple-upload/jquery.jframe.js"></script>

<link href="<?php echo $systemCSS;?>/multiple-upload/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
<link href="<?php echo $systemCSS;?>/multiple-upload/file_manager.css" rel="stylesheet" type="text/css" />
<script language="javascript">
function loadMyFrame(url,target){
	jQuery(target).loadJFrame(url);
	
	$(target).loadJFrame(url);
}
</script>
<script language="javascript">

$(document).ready(function(){
   	$('#navBar').fileTree({ 
		//root: '../userfiles/', 
		root: '<?php echo _folder; ?>', 
		script: 'imagegallery/jqueryFileTree', 
		loadMessage: 'Loading...',
		exts: 'jpeg,jpg,png,gif,tiff,pdf' }
		, function(file) { 
			//alert(file);
			var myvar = 'imagegallery/file_details/'+file;
			//alert(myvar);
			loadMyFrame(myvar, '#fileDetails');
	});
	jQuery.fn.waitingJFrame = function () {
    	$(this).html("<b>loading...</b>");
	};		
});
</script>
</head>
<body>
<div id="fileWrapper" src="#">		
	<h2>File Manager</h2>
    
	<div id="navBar" class="demo" src="#"></div>
    <div id="fileDetails">
    	<?php
			echo $message;
		?>
    	Please select file to edit
    </div>
</div>	
<script language="javascript">
function upload_file(cual) {
	alert(cual);
	loadMyFrame('file_upload?folder='+cual, '#fileDetails');	
}
</script>    
</body>
</html>
