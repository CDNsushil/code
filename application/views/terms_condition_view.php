<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
?>
<html>
	<head>
	
	<link rel="shortcut icon" href="<?php echo base_url('images/favicon.ico'); ?>" />
	
	<title><?php echo $this->config->item('termsncondtion');	?></title>
    <style>
        body{
             margin:0px;
             padding:0px;
            }
            
        #codeigniter-debug-toolbar {
            display:none;
        } 
    </style>
	</head>
	<body>
 <iframe src="<?php echo $url;  ?>" width="100%" height="100%" ></iframe>
	</body>
<html>
