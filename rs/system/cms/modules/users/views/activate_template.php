
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

    $firstName = (isset($name) && !empty($name))?$name:'';
 	$activationUrl= (isset($activation_url) && !empty($activation_url))?$activation_url:'';
 	$message= (isset($msg) && !empty($msg))?$msg:'NO Meaage Found!';
 	$sub= (isset($title) && !empty($title))?$title:'NO Title Found!';
 	$contact_email= (isset($contactEmail) && !empty($contactEmail))?$contactEmail:'';

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
	
	<title>Account activation</title>
	
	<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
	<style type="text/css">
	.list a {color: #cc0000; text-transform: uppercase; font-family: Verdana; font-size: 11px; text-decoration: none;}

	</style>
	
	
</head>
<body marginheight="0" topmargin="0" marginwidth="0" bgcolor="#c5c5c5" leftmargin="0">

<table cellspacing="0" border="0"  background-color: #c5c5c5;" cellpadding="0" width="100%">
	
	<tr>
		
		<td valign="top">

			<table cellspacing="0" border="0" align="center" style="background: #fff; border-right: 1px solid #ccc; border-left: 1px solid #ccc;" cellpadding="0" width="600">
				<tr>
					<td valign="top">
						<!-- header -->
						<table cellspacing="0" border="0" height="157" cellpadding="0" width="600">
							<tr>
								
								<td class="header-text" height="25" valign="top" style="color: #999; font-family: Verdana; font-size: 10px; text-transform: uppercase; padding: 0 20px;" width="540" colspan="2">
								</td>
								
							</tr>
							<tr>
								<td class="main-title" height="13" valign="top" style="padding: 0 20px; color:#F16531; font-size: 25px; font-family: Georgia; font-style: italic;" width="600" colspan="2">
									<singleline label="Title">	<?php echo $sub; ?></singleline>
								</td>
								<td class="header-bar" valign="top" style="color: ##009EC2; font-family: Verdana; font-size: 10px; text-transform: uppercase; padding: 0 20px; height: 15px; text-align: right;" width="200">
									<currentdayname /> <currentday /> <currentmonthname /> <currentyear />
								</td>
								
						
						<!-- / header -->
					
				</table></td>
				<tr>
					<td>
						<!-- content -->
						<repeater>
						<table cellspacing="0" border="0" cellpadding="0" height="200" width="600">
							<tr>
								<td class="article-title" height="45" valign="top" style="padding: 20px 20px 10px; color:#5C6F7B; font-family: Georgia; font-size: 16px; font-weight: bold;" width="600">
									<singleline label="Title">
									Hello <?php echo ucfirst($firstName); ?>, 
									<br>	
									<br>	
										<?php echo $msg; ?></singleline>
									<br><br>
									Contact: 	<singleline label="Title"> <?php echo $contact_email; ?></singleline>
								</td>
							</tr>
							
							
							<tr>
								<td class="content-copy" valign="top" style="padding: 0 20px 10px; color: #000; font-size: 14px; font-family: Georgia; line-height: 10px;">
									  <br>
									  <multiline label="Description">Please click here : <a href="<?php echo $activationUrl; ?>" style="color:#352C65"><?php echo $activationUrl; ?></a></multiline>
								</td>
							</tr>
							
							<tr>
								<td class="article-title" height="25" valign="middle" style="padding: 20px 20px 10px; color:#5C6F7B; font-family: Georgia; font-size: 16px; font-weight: bold;" width="600">
								
								
								</td>
							</tr>
							
						</table>
						</repeater>
						<!--  / content -->
					</td>
				</tr>
				<tr>
					<td valign="top" width="600">
						<!-- footer -->
						<table cellspacing="0" border="0" height="202" cellpadding="0" width="600">
							<tr>
								<td height="20" valign="top" width="600" colspan="2">
								</td>
							</tr>
							<tr>
								<td class="copyright" height="100" align="center" valign="top" style="padding: 0 20px; color: #009EC2; font-family: Verdana; font-size: 10px; text-transform: uppercase; line-height: 20px;" width="600" colspan="2">
									<multiline label="Description">www.syrecohk.com <br />	</multiline>
								</td>
							</tr>
						</table>
						<!-- / end footer -->
					</td>
				</tr></table></td>

</table>
</body>
</html>
