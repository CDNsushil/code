<?php
	$title=(isset($testiData) && !empty($testiData))?$testiData[0]->title:'';
	$description=(isset($testiData) &&  !empty($testiData))?$testiData[0]->description:'';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html>
<head>
	
	<title>Product Promotion !</title>
	
	<meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type" />
	<style type="text/css">
	.list a {color: #cc0000; text-transform: uppercase; font-family: Verdana; font-size: 11px; text-decoration: none;}

	</style>
		<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#submit').click(function(){
		var size = $('#size').val();
		var color = $('#color').val();
		var form_action = $('#form').attr('action');
		alert(form_action+'/'+size+'/'+color);
		window.location = form_action+'/'+size+'/'+color;
		return false;
	});
});
	</script>
	
</head>
<body marginheight="0" topmargin="0" marginwidth="0" bgcolor="#c5c5c5" leftmargin="0">
<form name="banner_form" action="<?php if(!empty($banner_url)): echo $banner_url; endif;?>" method="">
<table cellspacing="0" border="0"  background-color: #c5c5c5;" cellpadding="0" width="100%">
	
	<tr>
		
		<td valign="top">

			<table cellspacing="0" border="0" align="center" style="background: #fff; border-right: 1px solid #ccc; border-left: 1px solid #ccc;" cellpadding="0" width="600">
				<tr>
					<td valign="top">
						<!-- header -->
						<table cellspacing="0" border="0" height="100" cellpadding="0" width="600">
						
						<tr>
							<td  style="text-align:center; padding: 10 0px; color:#5C6F7B; font-size: 20px; font-family: Georgia; font-style: italic;">
								SYRECOHK
							</td>
						</tr>
						<tr>
								<td class="article-title"  valign="top" style="padding: 10px 20px 10px; color:#5C6F7B; font-family: Georgia; font-size: 14px; font-weight: bold;" width="600">
									<singleline label="Title">
										Hello {user_name}, 
									</singleline>
								<div style="padding: 10 0px; color:#F16531; font-size: 14px; font-family: Georgia; font-style: italic;">Buy Now this product !!</div>	
								
							</td>
						</tr>
				</table></td>
				<tr>
					<td>
						<!-- content -->
					
						<table cellspacing="0" border="0" cellpadding="0" height="200" width="600">
							
							<tr>
								<td class="article-title" height="45" valign="top" style="padding: 0px 20px 10px; color:#5C6F7B; font-family: Georgia; font-size: 14px; font-weight: bold;" width="600">
									<singleline label="Title">
							
										<?php
										 $width=''; $height=''; 
										 if(!empty($data) && $data->image_type==1): $width='70'; $height='70'; endif;
										 if(!empty($data) && $data->image_type==2): $width=$data->image_width; $height=$data->image_height; endif;
										$banner_img='';
										if(!empty($data)){
											$banner_img = $data->image_url;
										}
										
										if(!empty($data) && $data->upload_type==1){
											$banner_img = base_url().$data->upload_path.$data->upload_image_name;
										} 
										?>
										
										<div style="clear:both;">
											
											
										<div class="" style="background: none repeat scroll 0 0 rgb(255, 255, 255);border: 1px solid rgb(232, 232, 232);padding: 15px 15px 10px;box-shadow: 0 1px 2px #ccc;text-align: center;height: 250px;display: table;">
										<div class="" style="display: table-cell; vertical-align: middle;height: 250px; width:550px;">
											<input type="image" src="<?php echo $banner_img;?>" width="<?php echo $width;?>" height="<?php echo $height;?>" alt="No Image" title="Buy Now" style="max-height:250px; max-width:385px;">
                                        </div>
                                    </div>
										
											
										</div>
										
										<div style="width:550px; text-align:center; padding: 0 20px 10px; color: #000; font-size: 14px; font-family: Georgia; line-height: 10px;">
												
												<div class="main-title"  valign="top" style="padding: 10 0px; color:#5C6F7B; font-size: 12px; font-family: Georgia; font-style: italic; text-align:center;</div>" width="600" colspan="2">
														<?php if(!empty($data)){ echo $data->banner_name; }?></div>
												
												<?php if(!empty($data)): echo 'Price : '.$data->banner_price.$data->currency_type; endif; ?>
											</div>
								</td>
									
							</tr>
								<?php if(!empty($title)): ?>
							<tr>
								<td>
									<div class="" style="max-width: 98%;height: 6px;position: relative; margin: 10px 0px 20px 20px; color:#009EC2; font-weight:bold;">
										
										 <div class="">My Testmonials</div>
									</div>
								</td>
							</tr>
						
							<tr>
								<td>
									<singleline label="Title">
										<div style="margin: 0px 0px 10px 20px; color:#5C6F7B; font-family: Georgia; font-size: 14px; font-weight: bold;" >
											<?php  echo $title.'.'; ?>
										</div>
									</singleline>
								</td>
							</tr>
							<tr>
								<td>
									
									<div style="margin: -8px 10px 10px 20px; color:#5C6F7B; font-family: Georgia; font-size: 13px;" >
										 <?php  echo $description.'.'; ?>
									</div>
									
								</td>
							</tr>
							<?php endif; ?>
							<tr>
								<td class="content-copy" valign="top" style="padding-left: 20px;" >
									
										<input type="image" value="Buy Now" src="<?php echo base_url().APPPATH.'themes/referral/img/buy_now.png' ?>" />
								</td>
							</tr>
							
							<tr>
							<td class="copyright"  align="center" valign="top" style="padding: 30px 10px; color: #009EC2; font-family: Verdana; font-size: 10px; text-transform: uppercase; line-height: 20px;" width="600" colspan="2">
									<multiline label="Description">www.syrecohk.com </multiline>
								</td>
							</tr>
						
						</table>
						</repeater>
						<!--  / content -->
					</td>
				</tr>
				</table></td>

</table>
</form>
</body>
</html>
