<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<script type="text/javascript">
function styleMe() {
  if(window.top && window.top.location.href != document.location.href) {
  // I'm small but I'm not alone

    // all parent's <link>s
    var linkrels = window.top.document.getElementsByTagName('link');
    // my head
    var small_head = document.getElementsByTagName('head').item(0);
    // loop through parent's links
    for (var i = 0, max = linkrels.length; i < max; i++) {
      // are they stylesheets
      if (linkrels[i].rel && linkrels[i].rel == 'stylesheet') {
         // create new element and copy all attributes
        var thestyle = document.createElement('link');
        var attrib = linkrels[i].attributes;
        for (var j = 0, attribmax = attrib.length; j < attribmax; j++) {
          thestyle.setAttribute(attrib[j].nodeName, attrib[j].nodeValue);
        }

         // add the newly created element to the head
        small_head.appendChild(thestyle);

      }
    }

    // maybe, only maybe, here we should remove the kid's own styles...

  } else {
    alert('I hate to tell you that, but you are an orphant :(  ');
  }
}
styleMe();
</script>

<?php
$browseBlogImgJs = '_blogImg';

	$inputArray = array(
		'name'	=> 'fileInput'.$browseBlogImgJs,
		'value'	=> '',
		'class' => 'width200px',
		'id'	=> 'fileInput'.$browseBlogImgJs,
		'type'	=> 'text'
	);
	
	$fileNameInput = array(
		'name'	=> 'fileName'.$browseBlogImgJs,
		'value'	=> '',
		'id'	=> 'fileName'.$browseBlogImgJs,
		'type'	=> 'hidden'
	);
	
	$fileSize = array(
		'name'	=> 'fileSize'.$browseBlogImgJs,
		'value'	=> '',
		'id'	=> 'fileSize'.$browseBlogImgJs,
		'type'	=> 'hidden'
	);
	
	$isExternal = array(
			'name'	=> 'isExternal',
			'value'	=> 'f',
			'id'	=> 'isExternal',
			'type'	=> 'hidden'
	);
	
	$lastInsertedMediaId = array(
			'name'	=> 'lastInsertedMediaId',
			'value'	=> '',
			'id'	=> 'lastInsertedMediaId',
			'type'	=> 'hidden'
	);
	echo form_input($fileNameInput);
	echo form_input($isExternal);
	echo form_input($fileSize);
	echo form_input($lastInsertedMediaId);
	$galleryFolderPath = MEDIAUPLOADPATH.LoginUserDetails('username').'/project/blog/gallery/';//defining the path to upload images
		
		// To create the nested structure, the $recursive parameter 
		// to mkdir() must be specified.
		if (!file_exists($galleryFolderPath)) {
			if (!mkdir($galleryFolderPath, 0777, true)) {
				die('Failed to create folders...');
			}
		}
	$attr = array('name'=>'blogMedia','id'=>'blogMedia');
	echo form_open_multipart($this->uri->uri_string(),$attr);  
	
?>

<div class="row clear">
	<div id="uploadFileByJquery<?php echo @$browseBlogImgJs;?>"></div>
		<div id="FileContainer<?php echo @$browseBlogImgJs;?>" class="fr">

			<div class="fileInfo" id="fileInfo<?php echo @$browseBlogImgJs;?>">
				<div id="progressBar<?php echo @$browseBlogImgJs;?>" class="plupload_progress">
					<div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
						<div class="plupload_progress_container fl">
						<div id="plupload_progress_bar<?php echo @$browseBlogImgJs;?>" class="plupload_progress_bar"></div>
						</div>
				</div>
				<span id="percentComplete<?php echo @$browseBlogImgJs;?>" class="percentComplete fl"></span>
		</div>
		<div id="dropArea<?php echo @$browseBlogImgJs;?>"></div>
		</div>
</div>

<div class="cell" id="Uploadvideo<?php echo @$browseBlogImgJs;?>">				

<div id="FileUpload<?php echo @$browseBlogImgJs;?>" >
	<div class="row">
		<div class="cell"><?php echo form_input($inputArray); ?></div>
		<div class="cell">
			<div class="tds-button" id="browsebtn<?php echo @$browseBlogImgJs;?>">
			<a onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></a>  </div>
		</div>
	</div>
	<div id="fileError<?php echo @$browseBlogImgJs;?>" class="row wordcounter orange"></div>
</div>
</div>
<div class="clear"></div>  
</div><!--browse_box-->
<?php echo form_close(); ?>

