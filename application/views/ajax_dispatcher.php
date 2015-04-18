<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
</head>
<body>
	<div id="wrapper"><?php
    if(!empty($alert))
        //echo $alert;
    ?><?=$alert;?></div>
	<form method="POST" onSubmit="return false">
		<input type="text" name="jemail" id="jemail" /><br/>
		<input type="submit" value="Validate with No JavaScript!" />
	</form>
	<input type="submit" id="submit" value="Validate with JavaScript!" />
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
	<script src="http://192.168.0.226/framework/CodeIgniter_2.0.3/application/aana/action.js" type="text/javascript"></script>	
</body>
</html>