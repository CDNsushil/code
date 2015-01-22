<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php echo $this->lang->line('portfolio');?></h1>
		</div>
	<?php echo $header;?>
	</div>
	
	<div class="row tab_wp pt2">
		<?php 
		echo $this->load->view('mediatheme/mediaAccordView',$video);
		echo $this->load->view('mediatheme/mediaAccordView',$audio);
		echo $this->load->view('mediatheme/mediaAccordView',$writMater);
		echo $this->load->view('mediatheme/mediaAccordView',$imageShowcase);
		?>
	</div>
	
	
	<div class="clear"></div>
</div>

<script>
	function editMediaWs(mediaAttr,toggleId){
		var rawFileName = mediaAttr.rawFileName;
		var isExternal  = mediaAttr.isExternal;
		var embbededURL  = mediaAttr.embbededURL;
		embbededURL  = embbededURL.replace(/\&lt;/g, "<");
		embbededURL  = embbededURL.replace(/\&gt;/g, ">");
		if(rawFileName != '' && rawFileName != null && (rawFileName.length > 4) && (isExternal != 't')){
			if($('#uploadFileSection'+toggleId))
				$('#uploadFileSection'+toggleId).hide()
			if($('#rawFileNameContainerDiv'+toggleId))
				$('#rawFileNameContainerDiv'+toggleId).show()
			if($('#rawFileNameDiv'+toggleId))
				$('#rawFileNameDiv'+toggleId).html(rawFileName);
		}else{
			if($('#rawFileNameContainerDiv'+toggleId))
				$('#rawFileNameContainerDiv'+toggleId).hide()
			if($('#uploadFileSection'+toggleId))
				$('#uploadFileSection'+toggleId).show()
			if($('#rawFileNameDiv'+toggleId))
				$('#rawFileNameDiv'+toggleId).html('');
		}
		if(isExternal=='f'){
			$('#isExternal'+toggleId).val('f');
			if('#uploadFileSection'+toggleId)
			$('#uploadFileSection'+toggleId).hide();
		}else{
			$('#isExternal'+toggleId).val('t');
			if('#uploafFileButton'+toggleId)
				$('#uploafFileButton'+toggleId).hide();
			if('#Uploadvideo'+toggleId)
				$('#Uploadvideo'+toggleId).hide();
			
			if('#embedButton'+toggleId)
				$('#embedButton'+toggleId).show();
			if('#EmbeddedURL'+toggleId)
				$('#EmbeddedURL'+toggleId).show();
		}
		if($('#embbededURL'+toggleId))
		$('#embbededURL'+toggleId).val(embbededURL);
		
		var mediaPromoId = $(mediaAttr).attr('mediaPromoId');
		var galTitle = $(mediaAttr).attr('mediaTitle');
		var mediafileId = $(mediaAttr).attr('mediafileId');
		var galAltText = $(mediaAttr).attr('mediaDesc');
		var imageName = $(mediaAttr).attr('filename');
		var passImage = $(mediaAttr).attr('passimage');			
		var new_img_src = $('#galImg_'+mediaPromoId).attr('src');		
		$('#<?php echo @$imageShowcase['toggleId']?>promoImage').attr('src',passImage);	
		$('#promoImage').attr('src',passImage);	
		$('#mediaSrc'+toggleId).attr('src',new_img_src);	
			
		$('#mediaId'+toggleId).val(mediaPromoId);
		$('#fileId'+toggleId).val(mediafileId);
		$('#mediaTitle'+toggleId).val(galTitle);
		$('#mediaDescription'+toggleId).val(galAltText);
							 
		$('.promoImageCount').css("display","block");
		$('#'+toggleId+'Form-Content-Box').slideDown("slow");
		$('#fileInput'+toggleId).removeClass('required');		
	
	}	


</script>
