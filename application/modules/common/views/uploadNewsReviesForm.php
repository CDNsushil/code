<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
	
	$required=@$required?'required':'';
	$select_field=$required=='required'?'select_field':'';
	$typeOfFile=isset($typeOfFile)?$typeOfFile:4;
	$UNRS=$EB=$EU=$UB=$UF=$WB=$WA='';
	if( $isWrittenFileExternal =='1'){
		
		$EMC='';
		$VFMC='black';
		$WFMC='';
		$EUS='dn';
		$VFS='';
		$AWS='dn';
		if($editFlag){
			$UNRS='dn';
		}
	}elseif( $isWrittenFileExternal =='2'){
		$EMC='black';
		$VFMC='';
		$WFMC='';
		$EUS='';
		$VFS='dn';
		$AWS='dn';
		if($editFlag){
			$UB=$UF=$WB=$WA='dn';
		}
	}else{
		$EMC='';
		$VFMC='';
		$WFMC='black';
		$EUS='dn';
		$VFS='dn';
		$AWS='';
		if($editFlag){
			$EB=$EU=$UB=$UF='dn';
		}
	}
	
	$isWrittenFileExternalInput = array(
		'name'	=> 'isWrittenFileExternal',
		'value'	=> $isWrittenFileExternal,
		'id'	=> 'isWrittenFileExternal',
		'type'	=> 'hidden'
	);
	
	$fileNameInput = array(
		'name'	=> 'fileName',
		'value'	=> $fileName,
		'id'	=> 'fileName',
		'type'	=> 'hidden'
	);
	
	$fileSize = array(
		'name'	=> 'fileSize',
		'value'	=> $fileSize,
		'id'	=> 'fileSize',
		'type'	=> 'hidden'
	);
	
	$typeOfFile = array(
		'name'	=> 'fileType',
		'value'	=> $typeOfFile,
		'id'	=> 'fileType',
		'type'	=> 'hidden'
	);
	
	$inputArray = array(
		'name'	=> 'fileInput',
		'class'	=> 'width480px '.$required,
		'value'	=> '',
		'id'	=> 'fileInput',
		'type'	=> 'text',
		'readonly'	=> true
	);
	
	$embedArray = array(
		'id'	=> 'embbededURL',
		'name'	=> 'embbededURL',
		'class'	=> 'width546px embededURL '.$required,
		'value'=>$embedCode
	);
	
	$articleInput = array(
		'id'	=> 'article',
		'name'	=> 'article',
		'class'	=> 'width556px height_128 rz required '.$required,
		'rows' => 5,
		'cols' => 45,
		'value'=>@$article
	);
	//file type to get dynamically changed based on selection
	echo form_input($fileNameInput);
	echo form_input($fileSize);
	echo form_input($isWrittenFileExternalInput);
	echo form_input($typeOfFile);
?>

<script type="text/javascript">
	bkLib.onDomLoaded(function() {
		var myNicEditor = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','subscript','superscript','link','unlink']});
		myNicEditor.panelInstance('article');
	});
</script>
<div id="uploadFileByJquery"></div>
<div id="uploadNewsReviewsSection" class="row width_791 <?php echo $UNRS;?>">
	<div class="label_wrapper cell">
	  <label class="<?php echo $select_field;?>"><?php echo $label;?></label>
	</div>
<!--label_wrapper-->
	<div class=" cell frm_element_wrapper">
		<?php /*<div id="embedButton" class="tds-button mr8 fl <?php echo $EB;?>"> <a href="javascript:void(0)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="embedArticleMenu" showDiv="EmbeddedURL" onclick="showSpecificSection(this,2);" class="<?php echo $EMC;?> hm"><?php echo $this->lang->line('embed');?></span></a> </div> */?>
		<div id="uploafFileButton" class="tds-button mr8 fl <?php echo $UB;?>"> <a href="javascript:void(0)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="uploadArticleMenu" showDiv="Uploadvideo" onclick="showSpecificSection(this,1);" class="<?php echo $VFMC;?> hm"><?php echo $this->lang->line('upload');?></span></a> </div>
		<div id="writeButton" class="tds-button mr8 fl <?php echo $WB;?>"> <a href="javascript:void(0)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span id="writeArticleMenu" showDiv="writeArticle" onclick="showSpecificSection(this,0);" class="<?php echo $WFMC;?> hm"><?php echo $this->lang->line('write');?></span></a> </div>
		<div class="row seprator_8"></div>
		<div class="<?php echo $AWS;?> <?php echo $WA;?> sss"  id="writeArticle"> 
			<?php echo form_textarea($articleInput); ?>
			<div class="row wordcounter orange" id="articleMsg"></div>
		</div>
		<div class="<?php echo $VFS;?> <?php echo $UF;?> sss" id="Uploadvideo">
			<div id="FileUpload">
					<div class="fl"><?php echo form_input($inputArray); ?></div>
					<div class="tds-button fl ml5" id="browsebtn"> <a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><?php echo $this->lang->line('browse')?></span></a></div>
					<div id="fileError" class="row wordcounter orange"></div>
					<div class="pro_li_content fl pl20 mt5 mb5"><?php echo $this->lang->line('fileSizeMSG'); ?></div>
			</div>
		</div>
		<div class="seprator_5"></div>
	</div>
</div>
			  

<script type="text/javascript">
	
	function showSpecificSection(obj,val){
		var showDiv = $(obj).attr('showDiv');
		$('.sss').each(function(index){
				$(this).hide();
		});
		$('.hm').each(function(index){
				$(this).attr('class','');
		});
		$(obj).attr('class','hm black');
		$('#'+showDiv).show();
		$('#isWrittenFileExternal').val(val);
	}
	uploadMediaFiles('<?php echo $filePath;?>','<?php echo $fileType;?>','<?php echo $fileMaxSize;?>','',0,1);
</script>
