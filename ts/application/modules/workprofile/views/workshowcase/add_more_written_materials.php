<?php
//echo 'post_media_gallery_form<pre />';
//print_r($postMediaGallery);
$CI = get_instance(); 
$pathToSystemJs=$CI->config->item('system_js');
$pathToUploadPlg=base_url().$pathToSystemJs."jquery-plugin/upload-1.0/";
					
$showcaseSetPath = array(
	'name'	=> 'showcaseSetPath',
	'id'	=> 'showcaseSetPath',
	'value'	=> set_value('showcaseSetPath'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'style' => 'width:405px',	
	'class'       => 'formTip Bdr4',
	'title'       =>  $label['showcaseSetPath'],
);
if(!empty($recordSet))
	$mediaTitleArr	= $recordSet->mediaTitle;
else
	$mediaTitleArr	= $showcaseTitle;
	
$mediaTitle = array(
	'name'	=> 'showcaseTitle',
	'id'	=> 'showcaseTitle',
	'value'	=> $mediaTitleArr,
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip width556px',
	'title'       =>  $label['showcaseTitle'],
);

if(!empty($recordSet))
	$mediaDescArr	= $recordSet->mediaDesc;
else
	$mediaDescArr	= $showcaseDesc;
$mediaDesc = array(
	'name'	=> 'showcaseDesc',
	'id'	=> 'showcaseDesc',
	'value'	=> $mediaDescArr,
	'style' => 'width:405px',	
	'rows'      => 2,
    'cols'      => 85,
	'class'       => 'formTip textarea',
	'title'       =>  $label['showcaseDesc'],
);

$userfile =	array(
	'name'        => 'userfile',
	'id'          => 'userfile',
	);
$postMediaGalleryPathTrue = '';
if(isset($recordSet) &&($recordSet->mediaName !=''))
{
	$postMediaGalleryPath = base_url().'media/'.LoginUserDetails('username').'/workshowcase/WrittenMaterial/'.$recordSet->mediaName;
	$postMediaGalleryPathTrue =  getImage($postMediaGalleryPath);
	$MediaGalleryAttribute = @getimagesize($postMediaGalleryPath); //To get image attributes
	$countGalleryCount = count($MediaGalleryAttribute);	
}
?>

<?php
					
if(!empty($recordSet))
$urlVariable= $recordSet->mediaId;
else
$urlVariable= 0;
$attributes = array('name' => 'myForm', 'id' => 'addMoreWrittenMaterial');
			echo form_open_multipart('workprofile/workshowcase/addMoreWrittenMaterial/'.$urlVariable,$attributes);?>
			<input type="hidden" name="mediaId" value="<?php if(!empty($recordSet)){ echo  $recordSet->mediaId;} else{ echo 0; }?>" />
			
<?php 

$img = '<img id="imgSrc" class="ma" src="'.getImage($postMediaGalleryPathTrue).'">';

$fileUpload = array(
	'name'	=> 'userfile',
	'class'	=> 'formTip btn_browse',
	'title'=>  'Upload Image file',
	'value'	=> '',
	'onchange'=> "$('#fileInput').val(this.value)",
	'onmousedown'=> "mousedown_tds_button(getElementById('browse_btn'));",
	'onmouseup'=> "mouseup_tds_button(getElementById('browse_btn'));"
);

$inputArray = array(
	'name'	=> 'fileInput',
	'class'	=> 'width300px fl',
	'value'	=> '',
	'id'	=> 'fileInput',
	'type'	=> 'text',
	'readonly' => true
);

?>


<link rel="stylesheet" href="<?PHP echo $pathToUploadPlg; ?>css/jquery.fileupload-ui.css">


<div class="row summery_post_wrapper">
		<?php echo Modules::run("common/strip");?>
		<div class="row">
			<div class="cell frm_heading">
				<h1>Add Written Material</h1>
			</div>
			<?php include('navigationMenu.php');?>
		</div>

		<?php echo Modules::run("mediatheme/promoImageForm",$label['showcaseSetPath'],$img ,$fileUpload,$inputArray,0);?>
		
		<div class="row">
			<div class="label_wrapper cell">
				<label><?php echo $label['showcaseTitle'];?></label>
			</div><!--label_wrapper-->
			<div class=" cell frm_element_wrapper">
				<?php echo form_input($mediaTitle); ?>
			</div>
			<?php echo form_error($mediaTitle['name']);
			echo isset($errors[$mediaTitle['name']])?$errors[$mediaTitle['name']]:'';  ?>
		</div><!--from_element_wrapper-->
		
		<?php 
			$value=$mediaDescArr;
			$value=htmlentities($value);
			$data=array('name'=>'showcaseDesc','value'=>$value, 'view'=>'description');
			echo Modules::run("common/formInputField",$data);
		?>
		<div class="seprator_27 row"></div>

		<div class="row">
			<div class="label_wrapper cell bg-non"></div><!--label_wrapper-->

			<div class=" cell frm_element_wrapper">
				<div class="Req_fld cell"><?php echo $this->lang->line('requiredFields');?></div><!--Req_fld-->
				<?php
					$button=array('save','cancel');
					echo Modules::run("common/loadButtons",$button); 
				 ?>
			</div>
		</div><!--from_element_wrapper-->

		<div class="clear"></div>
	</div>		
		
<script type="text/javascript">
function submitform()
{
    document.myForm.submit();  
}</script>
