<script type="text/javascript" src="<?php echo base_url('player/flowplayer/flowplayer-3.2.4.min.js');?>"></script>
<?php

$CI = get_instance(); 
$pathToSystemJs=$CI->config->item('system_js');
$pathToUploadPlg=base_url().$pathToSystemJs."jquery-plugin/upload-1.0/";
					
$showcaseSetPath = array(
	'name'	=> 'showcaseSetPath',
	'id'	=> 'showcaseSetPath',
	'value'	=> set_value('showcaseSetPath'),
	'maxlength'	=> 80,
	'size'	=> 30,
	'class'       => 'formTip width556px',
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
	'class'       => 'formTip width556px',
	'size'	=> 30,
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
	'style' => 'width:366px',
	'rows'      => 3,
    'cols'      => 65,
	'class'       => 'formTip width556px ',
	'title'       =>  $label['showcaseDesc'],
);

$userfile =	array(
	'name'        => 'userfile',
	'id'          => 'userfile',
	);

$postMediaGalleryPathTrue = '';
if(isset($recordSet) &&($recordSet->mediaName !=''))
{
	$postMediaGalleryPath = base_url().'media/'.LoginUserDetails('username').'/workshowcase/Videos/'.$recordSet->mediaName;
	
	$postMediaGalleryPathTrue =  getImage($postMediaGalleryPath);
	//echo $postMediaGalleryPathTrue;
	$MediaGalleryAttribute = @getimagesize($postMediaGalleryPath); //To get image attributes
	$countGalleryCount = count($MediaGalleryAttribute);
	$postMediaGalleryPath = 'media/'.LoginUserDetails('username').'/workshowcase/Videos/'.$recordSet->mediaName;
	//echo $postMediaGalleryPath;
}
?>

<?php
					
if(!empty($recordSet))
$urlVariable= $recordSet->mediaId;
else
$urlVariable= 0;
$attributes = array('name' => 'myForm', 'id' => 'addMoreVideos');
			echo form_open_multipart('workprofile/workshowcase/addMoreVideos/'.$urlVariable,$attributes);?>
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
				<h1>Add Video</h1>
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
function calcelForm()
	{
		location.href=baseUrl+language+"/workprofile/workshowcase/showWorkShowcaseVideos";
	}
function submitform()
{
    document.myForm.submit();  
}</script>



<script type="text/javascript" charset="utf-8">
	 function PlayVideo(file, duration){
		$f("videoFile", "<?php echo base_url();?>player/flowplayer/flowplayer-3.2.7.swf", {

			// common clip: these properties are common to each clip in the playlist
			clip: { 
				// by default clip lasts 5 seconds
			  scalincg: "fit",
			  autoPlay: false,
			  autoBuffer: true,
			  image:true
			},
			
			// playlist with four entries
			playlist: [
				{url: file}
			],
			
			// show playlist buttons in controlbar
			 plugins:  {
				controls: {
					playlist: true,
					// use tube skin with a different background color
				url: '<?php echo base_url();?>player/flowplayer/flowplayer.controls-air-3.2.5.swf', 
					backgroundColor: '#aedaff'
				}
			},
			play: {
				label: null,
				replayLabel: "click to play again"
			}
		});
	}
<?php
	if(isset($postMediaGalleryPath) && $postMediaGalleryPath!=''){
 		echo 'PlayVideo("'.$postMediaGalleryPath.'")';
	}
?>
</script>
