<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(ROOTPATH.'application/newtcpdf/config/lang/eng.php');
require_once(ROOTPATH.'application/newtcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(15, 10, 15);

//set auto page breaks
//$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetAutoPageBreak(TRUE, 10);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);

//Set custom fonts
$museo_slab_500 = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/museo_slab_500.ttf', 'TrueTypeUnicode', '', 32);
$OpenSans_bold = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/OpenSans-Bold-webfont.ttf', 'TrueTypeUnicode', '', 32);
$Opensans_semibold = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/opensans-semibold.ttf', 'TrueTypeUnicode', '', 64);
$helvetica_bold = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/19693_hvbl____.ttf', 'TrueTypeUnicode', '', 64);
$opensans_condbold = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/OpenSans-CondBold-webfont.ttf', 'TrueTypeUnicode', '', 64);
$helvetica_medium = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/helveticaneue-medium.ttf', 'TrueTypeUnicode', '', 72);
$opensans_regular = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/OpenSans-Regular-webfont.ttf', 'TrueTypeUnicode', '', 64);
$helvetica_regular = $pdf->addTTFfont(K_PATH_FONTS.'/custom_fonts/fonts/4864.ttf', 'TrueTypeUnicode', '', 64);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();


$knifeImgPath = ROOTPATH.'images/ticket_images/knife.svg';
$event_img = ROOTPATH.'images/ticket_images/event_tic.svg';
//$toad_logo = ROOTPATH.'images/toademaillogo_invoice.jpg';
$toad_logo = ROOTPATH.'images/ticket_images/pdflolgotop.svg';
$bottom_toad_logo = ROOTPATH.'images/ticket_images/tablelogo.svg';
$bottom_border = ROOTPATH.'images/ticket_images/pdfborder.png';
$default_logo = ROOTPATH.'images/ticket_images/square.svg';
$invoiceCount = count($eventInvoiceData);
$htmlBody = '';
$htmlHeader = '';
//Set some content to print

$htmlHeader.='<table>
	<tr>
		<td style="font-family:'.$museo_slab_500.';color:#f15c34; width:310px;font-size:24pt;text-align:left;line-height:8px;">
			Tickets 
		</td>
		<td style="font-family:'.$opensans_regular.';text-align:right;"><font style="color:#666666;"> Brought to you by</font><br/>
			<img src="'.$toad_logo.'">
		</td>
	</tr>
</table>';


$htmlHeader.= <<<EOD
<table>
	<tr>
		<td style="border-bottom: 1px solid #bdbec1" width="625px">	
		</td>
	</tr>
	<tr>
		<td style="height:8mm;">&nbsp;</td>
	</tr>
</table>
EOD;

$htmlBody .= $htmlHeader;

for($i=0;$i<count($eventInvoiceData);$i++){
	//Get all details of ticket event
	$ticketInfo = json_decode($eventInvoiceData[$i]->ticketInfo);
	//Set time formate
	$timeExp =explode(':' , $ticketInfo->startTime);	
	
	if(!empty($timeExp[1])) {
		$timeExp[1] = $timeExp[1];
	}else {
		$timeExp[1] = '';
	}
	$timeFormate = $timeExp[0].':'.$timeExp[1];		
	//Set day name like Sat
	$dayFormate = date("D", strtotime($ticketInfo->date));
	//Set day name like Saturday
	$fullDay = date("l", strtotime($ticketInfo->date));
	//Set date day like 13
	$dateNumeric = date("d", strtotime($ticketInfo->date));
	//Set date month & year like Apr 2013
	$monthYearFormate = date("M  Y", strtotime($ticketInfo->date));
	//Set date formate like Apr 13 April 2013
	$fullMonthYearFormate = date("d F  Y", strtotime($ticketInfo->date));
	//Set category Name
	if(isset($eventInvoiceData[$i]->category)){
		if($eventInvoiceData[$i]->category=='Free Tickets'){
			$ticketCategory = 'Free Ticket';
		}else{
			$ticketCategory = $eventInvoiceData[$i]->category;
		}
	}else{
		$ticketCategory = '';
	}
	$sessionTitle = (isset($ticketInfo->venueName) && !empty($ticketInfo->venueName)) ?$ticketInfo->venueName:'';
	$venueName = (isset($ticketInfo->venue) && !empty($ticketInfo->venue)) ? $ticketInfo->venue:'';
	$address = (isset($ticketInfo->address) && !empty($ticketInfo->address)) ? $ticketInfo->address:'';
	$city = (isset($ticketInfo->city) && !empty($ticketInfo->city)) ? $ticketInfo->city:'';
	$zip = (isset($ticketInfo->zip) && !empty($ticketInfo->zip)) ? $ticketInfo->zip:'';
	$state = (isset($ticketInfo->state) && !empty($ticketInfo->state)) ? $ticketInfo->state:'';
	$country = (isset($ticketInfo->country) && !empty($ticketInfo->country)) ? userCountryName($ticketInfo->country):'';
	$eventTitle = (isset($ticketInfo->Title) && !empty($ticketInfo->Title)) ?$ticketInfo->Title:'';
	$url = (isset($ticketInfo->url) && !empty($ticketInfo->url)) ? $ticketInfo->url:'';	
	$phoneNumber = (isset($ticketInfo->phoneNumber) && !empty($ticketInfo->phoneNumber)) ? $ticketInfo->phoneNumber:'';
	if(isset($eventInvoiceData[$i]->price) && !empty($eventInvoiceData[$i]->price)){
		$price = '<tr>
				<td style="font-family:'.$opensans_condbold.';color: #231f20;text-align:center;font-size:13pt;">$'.$eventInvoiceData[$i]->price.'</td>
			</tr>';
	}else{
		$price = '<tr>
				<td></td>
			</tr>';
	}
	$eventTitle = str_replace("&apos;","'",$eventTitle);
	$sessionTitle = str_replace("&apos;","'",$sessionTitle);
	
	$html[$i] = '<table style="border:8px solid #f15c34;" cellspacing="0" cellpadding="0">
		<tr>
			<td style="border-right:8px solid  #f15c34; vertical-align: top; width:130px;">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table>
								<tr>
									<td style="font-family:'.$OpenSans_bold.';border-bottom: 1px solid #F15921;line-height:3px;color:#595a5c;font-size:10pt;">
									'.$dayFormate.'
									</td>
								</tr>
								<tr>
									<td></td>
								</tr>
								<tr>
									<td>
										<table>
											<tr>
												<td style="color:#ed1c24;font-weight:bold;width:25px;font-size:55px;height: 20px;line-height:1px;">'.$dateNumeric.'</td>
												<td style="font-family:'.$Opensans_semibold.';color:#595a5c;width:110px;font-size:10pt;line-height:2px;">'.$monthYearFormate.'</td>
											</tr>
											<tr>
												<td style="width:52px;"></td>
												<td style="font-family:'.$Opensans_semibold.';color:#595a5c;text-align:left;font-size:10pt;line-height:-1px;height: 20px;">'.$timeFormate.'</td>
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td style="text-align:center;">
										<img src="'.$default_logo.'">
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>			
			<td style="font-family:'.$opensans_regular.';border-right: 1px dashed #f15c34;vertical-align: top;width:355px">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table >
								<tr>
									<td style="border-bottom: 1px solid #fff;line-height:3px;width:50px;"></td>
									<td style="font-family:'.$Opensans_semibold.';border-bottom: 1px solid #F15921;line-height:3px;color:#231f20;width:auto;font-size:10pt;">'.$sessionTitle.'</td>
								</tr>
								<tr>
									<td style="width:50px;"></td>
									<td style="font-family:'.$OpenSans_bold.';color:#231f20;width:220px;font-size:10pt;">
									'.$venueName.'</td>
								</tr>
								<tr>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$address.'</td>
								</tr>';
					
					if($city!="")
					{
					$html[$i] .=	'<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$city.'</td></tr>';
					}
					
					if($zip!="")
					{
					$html[$i] .=	'<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$zip.'</td>
									</tr>';
					}
				
					$html[$i] .= '
								
								<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$state.'</td>
								</tr>
								<tr>
									<td style="width:50px;"></td>
									<td style="color:#414142;">'.$country.'</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td>
							<table>	
								<tr>
									<td style="font-family:'.$opensans_condbold.';border-top:solid 1px #444; border-bottom:solid 1px #444; color:#595a5c;font-size:15pt;">'.$eventTitle.'
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
			<td style="width:140px;">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table>
								<tr>
									<td style="font-family:'.$helvetica_bold.';text-align:center;font-size:9pt;color: #595a5c;">'.getUserEnterpriseName($eventInvoiceData[$i]->userId).'<br/></td>
								</tr>
								<tr>
									<td style="font-family:'.$Opensans_semibold.';color:#f15a2b;text-align:center;font-size:10pt;">'.$ticketCategory.'</td>
								</tr>
								'.$price.'
								<tr>
									<td style="color: #818385;font-weight:bold;text-align:center;">ONE<br/></td>
								</tr>
								
								<tr>
									<td style="color: #414142;text-align:center;">'.$fullDay.'</td>
								</tr>
								<tr>
									<td style="font-family:'.$opensans_regular.';color: #414142;text-align:center;">'.$fullMonthYearFormate.'</td>
								</tr>
								<tr>
									<td style="color: #414142;text-align:center;">'.$timeFormate.'</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		
			
		<tr>
			<td style="border-right:8px solid  #f15c34; width:130px;">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table>
								<tr>
									<td style="font-family:'.$Opensans_semibold.';color: #f15a2b;text-align:center;font-size:10pt;">'.$ticketCategory.'</td>
								</tr>
								'.$price.'
								<tr>
									<td style="font-family:'.$Opensans_semibold.';color: #bdbec1;text-align:center;font-size:14pt;line-height:1px;">ONE</td>
								</tr>
							</table>
						</td>
					</tr>			
				</table>
			</td>
			<td style="border-right: 1px dashed #f15c34;width:355px">
				<table cellpadding="6" cellspacing="6">
					<tr>
						<td>
							<table>
								<tr>
									<td>
										<table>
											<tr>
												<td style="height:3mm;">&nbsp;</td>
												<td style="height:3mm;">&nbsp;</td>
											</tr>
											<tr>
												<td style="font-family:'.$Opensans_semibold.';color:#595a5c;width:210px;font-size:10pt;">'.$phoneNumber.'</td>
												<td style="font-family:'.$helvetica_regular.';color:#595a5c;font-size:10pt;">'.$eventInvoiceData[$i]->userName.'</td>
											</tr>
											<tr>
												<td style="font-family:'.$opensans_regular.';color:#414142;width:210px;font-size:9pt;">'.$url.'</td>
												<td style="font-family:'.$helvetica_regular.';color: #f15a2b;font-size:10pt;">'.$eventInvoiceData[$i]->ticketNumber.'</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>			
				</table>
			</td>
			<td style="width:140px;">
				<table cellpadding="6" cellspacing="6">	
					<tr>
						<td style="font-family:'.$helvetica_regular.';color: #f15a2b;text-align:center;font-size:10pt;line-height:12px;">'.$eventInvoiceData[$i]->ticketNumber.'																	
						</td>
					</tr>																							
				</table>
			</td>
		</tr>
	</table>
	<table style="width:686px">
		<tr>
			<td style="width:617px;"></td>
			<td><img src="'.$knifeImgPath.'" style="line-height:3px"></td>
		</tr>
		<tr>
			<td style="height:2mm;">&nbsp;</td>
		</tr>
	</table>';
	$htmlBody .= $html[$i];
	if($i % 2 == 1){
		$invoicelast = $invoiceCount-1;
		if($i!=$invoicelast){	
			$htmlBody .='<table style="width:686px">
			<tr>
				<td style="height:80mm;">&nbsp;</td>
			</tr>
			</table>';	
			$htmlBody .= $htmlHeader;
		}
	}	
}		
$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $htmlBody, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);


/* get count of ticket table*/
/*$string_count= strlen(strip_tags($html[0]));

if($string_count>1755){
	
	for ($i = 0; $i < 3; $i++) {
	   $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $htmlBody, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

		if ($i < 3 - 1) {
			$pdf->AddPage();
		}
		// Reset pointer to the last page
		$pdf->lastPage();	
	}
}else{
	
	for ($i = 0; $i < 2; $i++) {
	   $pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $htmlBody, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

		// Reset pointer to the last page
		$pdf->lastPage();
	}
}
	
//echo $htmlBody;die;
//Print text using writeHTMLCell()

//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $htmlBody, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);
*/
// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.

// This condition for if user want to dwonload 
if($isDownload=='yes')
{
	$pdf->Output('event_ticket.pdf', 'I');
}else
{
	$pdf->Output('invoices/event_ticket.pdf', 'F'); 
} 

