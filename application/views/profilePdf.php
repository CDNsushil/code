<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(ROOTPATH.'application/newtcpdf/config/lang/eng.php');
require_once(ROOTPATH.'application/newtcpdf/tcpdf.php');
$profileUserName= $proval[0]->profileFName.' '.$proval[0]->profileLName;

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, false, 'ISO-8859-1', false);
// set document information
//$pdf->SetCreator('testing');
//$pdf->SetAuthor('test');
//$pdf->SetTitle('TCPDF Example 033');
//$pdf->SetSubject('TCPDF Tutorial');
//$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData('', PDF_HEADER_LOGO_WIDTH, $profileUserName, '');
//$pdf->SetHeaderData('', '', '', '', '' ,array(0,64,255), array(0,64,128));

//$pdf->setFooterData($tc=array(0,64,0), $lc=array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 13));
//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
//$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//Set footer font
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', 10));

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------
// set default font subsetting mode
//$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.

$pdf->SetFont('dejavusans', '', 10, '', true);
//$pdf->SetFont('helvetica', '', 10, '', true);
// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Define all data from profile
$synopsis = $proval[0]->synopsis;
//$availability=$proval[0]->availability;
$noticePeriod = $proval[0]->noticePeriod;
$remunerationRequired = $proval[0]->remunerationRequired;
$languagesKnown = $proval[0]->languagesKnown;
$nationality = $proval[0]->nationality;
$visaAvailable = $proval[0]->visaAvailable;
$education = $proval[0]->education;
$achievmentsAndAwards = $proval[0]->achievmentsAndAwards;
$countriesInterestWorking = $proval[0]->countriesInterestWorking;
$minContractMonth = $proval[0]->minContractMonth;
$maxContractMonth = $proval[0]->maxContractMonth;
$isContractWork = $proval[0]->isContractWork;

if(isset($countriesInterestWorking) && !empty($countriesInterestWorking)) {
	$InterestedCountry = explode('|',$countriesInterestWorking);
}
//Set remuneration value
$remunerationRate = '';
if($proval[0]->remunerationRate==1){
	$remunerationRate = 'per annum';
}
else if($proval[0]->remunerationRate==2){
	$remunerationRate = 'per month';
}
else if($proval[0]->remunerationRate==3){
	$remunerationRate = 'per week';
}
else if($proval[0]->remunerationRate==4){
	$remunerationRate = 'per hour';
}

//Manage top right Address fields
if(!empty($proval[0]->profileAdd)) {
	$profileAdd = $proval[0]->profileAdd;
}
else{
	$profileAdd = '';
}
if(!empty($proval[0]->profileStreet)) {
	$profileStreet = $proval[0]->profileStreet;
}
if(!empty($proval[0]->profileCity)) {
	$profileCity = $proval[0]->profileCity;
}
if(!empty($proval[0]->profileState)) {
	$profileState = $proval[0]->profileState;
}
if(!empty($proval[0]->profileZip)) {
	$profileZip = $proval[0]->profileZip;
}
if(!empty($proval[0]->countryName)) {
	$countryName = $proval[0]->countryName;
}

//Manage phone and email field
if(!empty($proval[0]->profileEmail)) {
	$stringEmail= $proval[0]->profileEmail;
} else {
	$stringEmail= '';
}
if(!empty($proval[0]->profilePhone)) {
	if(!empty($proval[0]->profileEmail)) {
		$profilePhone=$proval[0]->profilePhone;
	}else{
		$profilePhone=$proval[0]->profilePhone;
	}
} else {
	$profilePhone= '';
}

//Set availabilty formate
$availability = ($proval[0]->availability=='freelance')?"Freelance":($proval[0]->availability=='fullTime'?"Full - Time":($proval[0]->availability=='partTime'?"Part - Time":($proval[0]->availability=='casual'?"Casual":'')));

//Get pdf profile image
if(!empty($proval[0]->filePath) && !empty($proval[0]->fileName) && file_exists(ROOTPATH.$proval[0]->filePath.$proval[0]->fileName)) {
	$imgPath = ROOTPATH.$proval[0]->filePath.$proval[0]->fileName;
} else {
	$imgPath =  '';
}
$base_url = site_url();
//Set some content to print

if(!empty($imgPath)) {
$html = '<table>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="width:90px; border-bottom:1px solid #CCCCCC; font-size:0px;">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td style="border:1px solid #CCCCCC;"><img src="'.$imgPath.'" hspace="0"/></td>
							</tr>
						</table>
					</td>	
					<td style="width:470px;">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td style="border-bottom:1px solid #CCCCCC; text-align:right;" >
									<span style="font-size:45px;font-weight:bold;">'.$profileUserName.'</span><br/>';
										if(isset($profileAdd) && !empty($profileAdd) ) {
											$html .= $profileAdd;
										}
										if(!empty($profileAdd) && empty($profileStreet)) {
											$html .= '<br>';	
										}
										if(!empty($profileAdd) && !empty($profileStreet)) {
											$html .= ' and ';	
										}
										if(isset($profileStreet) && !empty($profileStreet)) {
											$html .= $profileStreet.'<br>';
										}
										
										if(isset($profileCity) && !empty($profileCity)) {
											$html .= $profileCity;
										}
										if(!empty($profileCity) && (!empty($profileState) || !empty($profileZip) || !empty($countryName))) {
											$html .= ', ';
										}
										if(isset($profileState) && !empty($profileState)) {
											$html .= $profileState;
										}
										if(!empty($profileState) && (!empty($profileZip) || !empty($countryName))) {
											$html .= ', ';
										}
										if(isset($profileZip) && !empty($profileZip)) {
											$html .= $profileZip;
										}
										if(!empty($profileZip) &&  !empty($countryName)) {
											$html .= ', ';
										}
										if(isset($countryName) && !empty($countryName)) {
											$html .= $countryName.'<br>';
										}else{
											$html .= '<br>';
										}
										if(isset($profilePhone) && !empty($profilePhone)) {
											$html .= $profilePhone;
										}
										if(!empty($profilePhone) && !empty($stringEmail)) {
											$html .= ', ';
										}
										if(isset($stringEmail) && !empty($stringEmail)) {
											$html .= $stringEmail;
										}
								$html .= '</td>	
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
	</table>';
}
else {
	$html = '<table>
	<tr>
		<td>
			<table cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td style="height:90px;width:90px;">	
					</td>	
					<td style="width:470px;">
						<table cellpadding="0" cellspacing="0" border="0">
							<tr>
								<td style="height:4mm; ">&nbsp;</td>
							</tr>
							<tr>
								<td style="border-bottom:1px solid #CCCCCC; text-align:right;" >
									<span style="font-size:45px;font-weight:bold;"> '.$profileUserName.'</span><br/>';
										if(isset($profileAdd) && !empty($profileAdd)) {
										$html .= $profileAdd;
										}
										if(!empty($profileAdd) && empty($profileStreet)) {
										$html .= '<br>';	
										}
										if(!empty($profileAdd) && !empty($profileStreet)) {
										$html .= ' and ';	
										}
										if(isset($profileStreet) && !empty($profileStreet)) {
										$html .= $profileStreet.'<br>';
										}
										if(isset($profileCity) && !empty($profileCity)) {
										$html .= $profileCity;
										}
										if(!empty($profileCity) && (!empty($profileState) || !empty($profileZip) || !empty($countryName))) {
											$html .= ', ';
										}
										if(isset($profileState) && !empty($profileState)) {
										$html .= $profileState;
										}
										if(!empty($profileState) && (!empty($profileZip) || !empty($countryName))) {
											$html .= ', ';
										}
										if(isset($profileZip) && !empty($profileZip)) {
										$html .= $profileZip;
										}
										if(!empty($profileZip) &&  !empty($countryName)) {
											$html .= ', ';
										}
										if(isset($countryName) && !empty($countryName)) {
										$html .= $countryName.'<br>';
										} else{
											$html .= '<br>';
										}
										if(isset($profilePhone) && !empty($profilePhone)) {
										$html .= $profilePhone;
										}
										if(!empty($profilePhone) && !empty($stringEmail)) {
											$html .= ', ';
										}
										if(isset($stringEmail) && !empty($stringEmail)) {
										$html .= $stringEmail;
										}
								$html .= '</td>	
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
	</table>';
}
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
if(!empty($availability) || !empty($noticePeriod) || !empty($remunerationRequired) || !empty($languagesKnown) || !empty($nationality) || !empty($visas)) {
	
	$html .='
		<table>
		<tr>
			<td style="font-size: 45px; font-weight: normal;">Personal Details</td>
		</tr>
		<tr>
			<td style="height:4mm; ">&nbsp;</td>
		</tr>
		
		</table>';
	
}

if(!empty($availability)) {
	$html .= '
	<table>
		<tr>
			<td style="width:170px; font-weight:normal; color:#666666">Availability</td>
			<td>'.$availability.'</td>
		</tr>
	</table>';
	
	if(!empty($minContractMonth) && !empty($maxContractMonth) && $isContractWork=='t') {	
		$html .= '
		<table>
			<tr>
				<td style="width:170px; font-weight:normal; color:#666666">Interested in Contract Work</td>
				<td>From '.$minContractMonth .' to '.$maxContractMonth.' months</td>
			</tr>
		</table>';
	}
}	
if(!empty($noticePeriod)) {
	$html .= '
		<table>
			<tr>
				<td style="width:170px; font-weight:normal; color:#666666">Notice period</td>
				<td>'.$noticePeriod.'</td>
			</tr>
		</table>';
}	
if(!empty($remunerationRequired)) {
	$html .= '
		<table>
			<tr>
				<td style="width:170px; font-weight:normal; color:#666666">Renumeration</td>
				<td>'.$remunerationRequired.' '.$remunerationRate.'</td>
			</tr>
			<tr>
				<td style="width:170px; font-weight:normal; color:#666666">&nbsp;</td>
				<td>&nbsp;</td>
					</tr>
		</table>';
}	
if(!empty($languagesKnown)) {
	$html .= '
		<table>
			<tr>
				<td style="width:170px; font-weight:normal; color:#666666">Languages</td>
				<td>'.$languagesKnown.'</td>
			</tr>
		</table>';
}	
if(!empty($nationality)) {
	$html .= '
		<table>
			<tr>
				<td style="width:170px; font-weight:normal; color:#666666">Nationality</td>
				<td>'.$nationality.'</td>
			</tr>
		</table>';
}	

if(!empty($visas)) {
	
for($i=0;$i<count($visas);$i++)
{
	if($i==0) {
	$html .= '
	<table>
		<tr>	
			<td style="width:170px; font-weight:normal; color:#666666">Visa(s)</td>
			<td style="width:170px;">'.$visas[$i]['visaType'].', '.$visas[$i]['visaCountry'].'</td>
		</tr>
	</table>';
}
else {
	$html .= '
	<table>
		<tr>	
			<td style="width:170px; font-weight:normal; color:#666666"></td>
			<td style="width:170px;">'.$visas[$i]['visaType'].', '.$visas[$i]['visaCountry'].'</td>
		</tr>
	</table>';
}
}
}
$html .= '
		<table>
			<tr>
				<td style="width:170px; font-weight:normal; color:#666666">Interested in Working in</td>';

if(!empty($InterestedCountry) && is_array($InterestedCountry)){ 	
$html .= '<td>';
	for($i=0;$i<count($InterestedCountry);$i++)
	{			
		if($i!=0) {
			if($i==1) {
				$html .= getCountry($InterestedCountry[$i]);
			} else {
				$html .= ', '.getCountry($InterestedCountry[$i]);
			}
		}
	 }
$html .= '</td>';
 } else {
 $html .= '<td>All</td>';
 }
 $html .= '</tr>
		</table>';
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
			<td style="font-size: 35px; font-weight: normal; width:170px;">'.$educations[$i]->year_from.' - '.$educations[$i]->year_to.'</td>
			<td>
				<table>
					<tr>
						<td style="width:450px;">'.$educations[$i]->degree.'</td>
					</tr>
					<tr>
						<td style="width:450px;">'.$educations[$i]->university.'</td>
					</tr>
					<tr>
					<td style="height:1mm;">&nbsp;</td>
					</tr>
				</table>
			</td>
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
		<td style="height:8mm; ">&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 45px; font-weight: normal;">Employment History</td>
	</tr>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
</table>
EOD;
}

if(!empty($workHistory)) {
	
	for($i=0;$i<count($workHistory);$i++)
	{
		if($workHistory[$i]['empEndDate']=='0'){ 
			$endDate = 'Present';
		}else{
			$endDate = $workHistory[$i]['empEndDate'];
		}
		
	$html .= '
	<table cellspacing="0" cellpadding="0" border="0">
		<tr>	
			<td style="padding-right:5px; width:200px; color:#666666">'.$workHistory[$i]['empStartDate'].' - '.$endDate.'</td>
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
				<td><span style="font-weight:bold;">'.$refrance[$i]['refFName'].' '.$refrance[$i]['refLName'].'</span></td>
			</tr>';
		if(!empty($refrance[$i]['refCompName'])) {	
			$html .= '<tr>	
				<td style="color:#CCCCCC; padding-right:5px; width:200px;">Company</td>
				<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
				<td>'.$refrance[$i]['refCompName'].'</td>
			</tr>';
		}
		if(!empty($refrance[$i]['refEmail'])) {	
			$html .= '<tr>	
				<td style="color:#CCCCCC; padding-right:5px; width:200px;">Email Address</td>
				<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
				<td>'.$refrance[$i]['refEmail'].'</td>
			</tr>';
		}
		if(!empty($refrance[$i]['refContact'])) {	
			$html .= '<tr>	
				<td style="color:#CCCCCC; padding-right:5px; width:200px;">Phone Number</td>
				<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
				<td>'.$refrance[$i]['refContact'].'</td>
			</tr>';
		}	
		$html .= '<tr>
				<td style="height:4mm;">&nbsp;</td>
			</tr>
		</table>';
	}
}

if(!empty($recommandation)) {
//Get Users profile Recommandation
$html .= <<<EOD
<table>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
	<tr>
		<td style="font-size: 45px; font-weight: normal;">Recommendations from
Toadsquare Members</td>
	</tr>
	<tr>
		<td style="height:4mm; ">&nbsp;</td>
	</tr>
</table>
EOD;
}

if(isset($recommandation) && !empty($recommandation)) {
	for($i=0;$i<count($recommandation);$i++)
	{
	$userShowcaseUrl = site_url().'showcase/aboutme/'.$recommandation[$i]->tdsUid;
	$html .= '
	<table>
		<tr>	
			<td style="color:#CCCCCC; padding-right:5px; width:200px;">Name</td>
			<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
			<td><span style="font-weight:bold;"><a href="'.$userShowcaseUrl.'" style="text-decoration: none;color:#000;">'.$recommandation[$i]->firstName.' '.$recommandation[$i]->lastName.'</a></span></td>
		</tr>
		<tr>	
			<td style="color:#CCCCCC; padding-right:5px; width:200px;">Comment </td>
			<td style="border-left:1px solid #CCCCCC; width:10px;"></td>
			<td style="width:360px;">'.$recommandation[$i]->recommendations.'</td>
		</tr>
		<tr>
			<td style="height:4mm;">&nbsp;</td>
		</tr>
	</table>';
	}	
}
//echo $html;die;
// Print text using writeHTMLCell()

$pdf->writeHTMLCell($w=0, $h=0, $x='', $y='', $html, $border=0, $ln=1, $fill=0, $reseth=true, $align='', $autopadding=true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
    
$pdf->Output('profile_information.pdf', 'I');
?>

