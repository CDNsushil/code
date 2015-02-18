<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(ROOTPATH.'application/newtcpdf/config/lang/eng.php');
require_once(ROOTPATH.'application/newtcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);
// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetAuthor('Nicola Asuni');
//$pdf->SetTitle($profileFName);
//$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
//$pdf->SetHeaderData('', '', '', '', '' ,array(0,64,255), array(0,64,128));

$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set default font subsetting mode
$pdf->setFontSubsetting(true);


// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('helvetica', '', 10, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Define all data from profile
$synopsis=$proval[0]->synopsis;
$availability=$proval[0]->availability;
$noticePeriod=$proval[0]->noticePeriod;
$remunerationRequired=$proval[0]->remunerationRequired;
$languagesKnown=$proval[0]->languagesKnown;
$nationality=$proval[0]->nationality;
$visaAvailable=$proval[0]->visaAvailable;
$education=$proval[0]->education;
$achievmentsAndAwards=$proval[0]->achievmentsAndAwards;
$title= $proval[0]->profileFName;
$string= $proval[0]->profileAdd.',  '.$proval[0]->profileStreet.',  '.$proval[0]->profileZip.',  '.$proval[0]->countryName;
$stringEmail=$proval[0]->profileEmail;
$profilePhone=$proval[0]->profilePhone;
//$imgPath=$_SERVER['DOCUMENT_ROOT'].'/toadsquare/'.$proval[0]->filePath.$proval[0]->fileName;

$imgPath=  ROOTPATH.$proval[0]->filePath.$proval[0]->fileName;
// Set some content to print

$html = <<<EOD
<table>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="height:90px;width:90px;">
						<img src="$imgPath" width="90px" height="90px" />
					</td>	
					<td style="width:470px;">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td style="height:4mm; ">&nbsp;</td>
							</tr>
							<tr>
								<td style="border-bottom:1px solid #CCCCCC; text-align:right;" >
									<span style="font-size:45px;font-weight:normal;"> $title</span><br/>
									$string<br/>
									 Tel +$profilePhone  Email $stringEmail
								</td>	
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td style="height:8mm; ">&nbsp;</td>
	</tr>
	</table>
EOD;

if(!empty($synopsis)) {
	$html .=<<<EOD
	<table>
	<tr>
		<td style="font-size: 45px; font-weight: normal;">Summary</td>
	</tr>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
	<tr>
		<td width="570px">$synopsis</td>
	</tr>
	
	<tr>
		<td style="height:8mm; ">&nbsp;</td>
	</tr>
	</table>
EOD;
}

$html .=<<<EOD
	<table>
	<tr>
		<td style="font-size: 45px; font-weight: normal;">Personal Details</td>
	</tr>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="width:130px; font-weight:normal; color:#666666">Availability</td>
					<td>$availability</td>
				</tr>
				<tr>
					<td style="width:130px; font-weight:normal; color:#666666">Notice period</td>
					<td>$noticePeriod</td>
				</tr>
				<tr>
					<td style="width:130px; font-weight:normal; color:#666666">Renumeration</td>
					<td>$remunerationRequired</td>
				</tr>
				<tr>
					<td style="width:130px; font-weight:normal; color:#666666">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td style="width:130px; font-weight:normal; color:#666666">languages</td>
					<td>$languagesKnown</td>
				</tr>
				<tr>
					<td style="width:130px; font-weight:normal; color:#666666">Nationality</td>
					<td>$nationality</td>
				</tr>
			</table>
		</td>
	</tr>
	</table>
EOD;

if(!empty($visas)) {
for($i=0;$i<count($visas);$i++)
{
	if($i==0) {
$html .= '
	<table>
		<tr>	
			<td style="width:130px; font-weight:normal; color:#666666">Visas</td>
			<td style="width:170px;">'.$visas[$i]->visaType.'</td>
		</tr>
	</table>';
}
else {
	$html .= '
	<table>
		<tr>	
			<td style="width:130px; font-weight:normal; color:#666666"></td>
			<td style="width:170px;">'.$visas[$i]->visaType.'</td>
		</tr>
	</table>';
}
}
}

if(!empty($educations)) {
	
	$html .=<<<EOD
	<table>
	<tr>
		<td style="height:8mm; ">&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 45px; font-weight: normal;">Education</td>
	</tr>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
	</table>
EOD;
}

//Get Educational information
if(!empty($educations)) {
for($i=0;$i<count($educations);$i++)
{
$html .= '
	<table>
		<tr>	
			<td style="font-size: 45px; font-weight: normal; width:130px;">'.$educations[$i]->year_from.'-'.$educations[$i]->year_to.'</td>
			<td style="width:170px;">'.$educations[$i]->university.'</td>
			<td style="width:250px;">'.$educations[$i]->degree.'</td>
		</tr>
	</table>';
}
}
if(!empty($achievmentsAndAwards)) {
//Get Achivements & Awards details
$html .= <<<EOD
<table>
	<tr>
		<td style="height:8mm; ">&nbsp;</td>
	</tr>
	
	<tr>
		<td style="font-size: 45px; font-weight: normal;">Achievements & Awards</td>
	</tr>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
	<tr>
		<td>$achievmentsAndAwards</td>
	</tr>
	
</table>
EOD;
}

if(!empty($workHistory)) {
//Get Users profile work history
$html .= <<<EOD
<table>
	<tr>
		<td style="height:10mm; ">&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 45px; font-weight: normal;">Employment History
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="padding-top:10px; text-align:right">
						<span style="color:#CCCCCC; font-size:45px;font-weight:normal;"> $title</span>								
					</td>	
				</tr>
			</table>	
		</td>		
	</tr>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
</table>
EOD;
}

if(!empty($workHistory)) {
for($i=1;$i<=count($workHistory);$i++)
{
$html .= '
<table cellspacing="0" cellpadding="0" border="0">
	<tr>	
		<td style="padding-right:5px; width:200px; color:#666666">'.$workHistory[$i]['empStartDate'].'-'.$workHistory[$i]['empEndDate'].'</td>
		<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
		<td style="width:360px;">
			<span style="font-weight:bold;">'.$workHistory[$i]['empDesignation'].'</span><br/>
			'.$workHistory[$i]['compName'].'<br/>
			'.$workHistory[$i]['compCity'].'<br/><br/>
			'.$workHistory[$i]['empAchivments'].'<br/>			
		</td>
	</tr>
</table>
<table>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
</table>';

}
}

if(!empty($refrance)) {
//Get Users profile Refrances
$html .= <<<EOD
<table>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 45px; font-weight: normal;">References</td>
	</tr>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
</table>
EOD;
}	
if(!empty($refrance)) {
for($i=1;$i<=count($refrance);$i++)
{
$html .= '
<table>
	<tr>	
		<td style="color:#CCCCCC; padding-right:5px; width:200px;">Name</td>
		<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
		<td><span style="font-weight:bold;">'.$refrance[$i]['refFName'].$refrance[$i]['refLName'].'</span></td>
	</tr>
	<tr>	
		<td style="color:#CCCCCC; padding-right:5px; width:200px;">Company</td>
		<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
		<td>'.$refrance[$i]['refCompName'].'</td>
	</tr>
	<tr>	
		<td style="color:#CCCCCC; padding-right:5px; width:200px;">Email Address</td>
		<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
		<td>'.$refrance[$i]['refEmail'].'</td>
	</tr>
	<tr>	
		<td style="color:#CCCCCC; padding-right:5px; width:200px;">Phone Number</td>
		<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
		<td>'.$refrance[$i]['refContact'].'</td>
	</tr>
	<tr>
		<td style="height:4mm;">&nbsp;</td>
	</tr>
</table>';
}
}


// Print text using writeHTMLCell()

//$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
    
 //$pdf->WriteHTML($this->getBuffer(), true);

$pdf->Output('%PDF-profile_information.pdf', 'I');
