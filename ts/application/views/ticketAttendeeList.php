<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Attendees List: Toadsquare -</title>

<link href="<?php echo base_url('images/favicon.ico');?>" rel="shortcut icon">
<link rel="stylesheet" rev="stylesheet" href="style.css" type="text/css" media="all" /> <link rel="stylesheet" rev="stylesheet" href="print.css" type="text/css" media="print" />
<style>

@font-face {
	font-family: 'MuseoSlab-500';
	src: url('<?php echo base_url('templates/fonts/museo_slab_500.eot');?>');
	src: url('<?php echo base_url('templates/fonts/museo_slab_500.eot?#iefix');?>') format('embedded-opentype'),
		 url('<?php echo base_url('templates/fonts/museo_slab_500.woff');?>') format('woff'),
		 url('<?php echo base_url('templates/fonts/museo_slab_500.ttf');?>') format('truetype'),
		 url('<?php echo base_url('templates/fonts/museo_slab_500.svg#museo_slab_500');?>') format('svg');
	font-weight: normal;
	font-style: normal;
}
		
@font-face {
    font-family: 'OpenSansRegular';
    src: url('<?php echo base_url('templates/fonts/OpenSans-Regular-webfont.eot');?>');
    src: url('<?php echo base_url('templates/fonts/OpenSans-Regular-webfont.eot?#iefix');?>') format('embedded-opentype'),
         url('<?php echo base_url('templates/fonts/OpenSans-Regular-webfont.woff');?>') format('woff'),
         url('<?php echo base_url('templates/fonts/OpenSans-Regular-webfont.ttf');?>') format('truetype'),
         url('<?php echo base_url('templates/fonts/OpenSans-Regular-webfont.svg#OpenSansRegular');?>') format('svg');
    font-weight: normal;
    font-style: normal;
}

@font-face {
    font-family: 'OpenSansBold';
    src: url('<?php echo base_url('templates/fonts/OpenSans-Bold-webfont.eot');?>');
    src: url('<?php echo base_url('templates/fonts/OpenSans-Bold-webfont.eot?#iefix');?>') format('embedded-opentype'),
         url('<?php echo base_url('templates/fonts/OpenSans-Bold-webfont.woff');?>') format('woff'),
         url('<?php echo base_url('templates/fonts/OpenSans-Bold-webfont.ttf');?>') format('truetype'),
         url('<?php echo base_url('templates/fonts/OpenSans-Bold-webfont.svg#OpenSansBold');?>') format('svg');
    font-weight: normal;
    font-style: normal;
}
</style>
</head>
<body style="margin:0 auto; padding:0; background:#ffffff; font-family:Arial, Helvetica, sans-serif">
	<table width="650" cellspacing="0" cellpadding="0" border="0" align="center" style="margin-bottom:100px; font-size:12px;">
    	<tr>
        	<td style="padding-top:25px; color:#f15921; font-size:28px; letter-spacing:1px; font-family: 'MuseoSlab-500';" valign="bottom">
				Attendees List
            </td>
    
            <td style="text-align:right; padding-top:27px;">
				<font style="color:#666666;"> Brought to you by</font><br>
             <img width="200" src="<?php echo base_url(); ?>images/toademaillogo_invoice.jpg"  alt="Attendees"/>
            </td>  
        </tr>
        <tr>
        	<td colspan="2" style="border-bottom:solid 1px #d4d4d4; color:#555555; font-size:15px; line-height:12px; font-family: 'OpenSansRegular';">
				<?php 
				if(isset($sessionVanue) && !empty($sessionVanue)){
					echo $sessionVanue;
					}else{ 
						//echo "Prague Primary School Xmas Concert";
					}?>	
            </td>
        </tr>

		<?php 
		
		if(isset($ticketTransactionData) && !empty($ticketTransactionData)) {
			foreach($ticketTransactionData as $i => $ticketTransactionDetail)
			{
				//Set current date time
				$current_date = date("Y-m-d H:i:s");	
				//if($ticketTransactionDetail['sessionDate'] >= $current_date) 
				{ ?>
					<tr>
						<td colspan="2">
							<table> 
								<tr>
									<td colspan="2" style="font-size:14px; padding-top:40px; border-bottom:solid 1px #f15921; font-family: 'OpenSansBold';line-height:13px;">
										<?php echo $ticketTransactionDetail['eventTitle'];?>
									</td>
								</tr>
								<tr>
									<?php 
									//Set full day name like Monday
									$fullDay = date("l", strtotime($ticketTransactionDetail['sessionDate']));
									//Set date formate like 26 October 2013
									$dateFormate = date("d F  Y", strtotime($ticketTransactionDetail['sessionDate']));
									//Set time formate like 18h30
									$timeExp1 =explode(' ' , $ticketTransactionDetail['sessionDate']);
									$timeExp =explode(':' , $timeExp1[1]);
									if(!empty($timeExp[1])) {
										$timeExp[1] = $timeExp[1];
									}else {
										$timeExp[1] = '';
									}										
									$timeFormate = $timeExp[0].':'.$timeExp[1];				
									?>
									<td colspan="2" style="font-size:14px; font-family: 'OpenSansRegular';line-height:9px;">
										<?php echo $fullDay;?>, <font style="font-family: 'OpenSansBold';"><?php echo $dateFormate;?> </font> <font style="font-family: 'OpenSansBold';color:#f15921">&nbsp; <?php echo $timeFormate;?> </font>
									</td>
								</tr>
								<tr>
									<td colspan="2">
										<table width="100%" style="margin-top:20px; font-family: 'OpenSansRegular'; font-size:14px;" cellpadding="0" cellspacing="0">
											<?php 
											$counts = 1;
											if((isset($ticketTransactionDetail['ticketSessionList'])) && (!empty($ticketTransactionDetail['ticketSessionList']))){
											
												foreach($ticketTransactionDetail['ticketSessionList'] as $tSList){
													
											    ?>
												<tr <?php if($counts % 2 != 0){?>bgcolor="#f3f3f4"<?php }?> style="line-height:20px; line-height:26px;"> 
													<td width="60px;"><?php echo $counts;?>.</td>
													<td width="330px;"><?php echo $tSList->userName; ?></td>
													<td width="170px;"><?php echo $tSList->ticketNumber; ?></td>
													<td width="140px"><?php echo $tSList->category; ?></td>
													<td width="115px;">$<?php echo $tSList->price; ?></td>
													<td width="44px;"><img src="<?php echo base_url('images/ticket_images/checkbox_email.png');?>" alt="check"/> </td>
												</tr>
											<?php $counts++; }}?>
										</table>				  
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<?php 
				}
			}  
		}?>
    </table>   
</body>
</html>


