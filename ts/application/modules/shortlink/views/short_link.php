<?php
if(isset($shareClass) && $shareClass!='')
			$shareClass = $shareClass;
		else 
			$shareClass = 'icon_share'; 
			
if(isset($viewType) && $viewType!='')
			$viewType = $viewType;
		else 
			$viewType = '';	
			
if(isset($isPreview) && $isPreview!='')
			$isPreview = $isPreview;
		else 
			$isPreview = '';				
			
			
	if(isset($isPublished) && $isPublished=='t' && ($isPreview!='preview') )
		{				
		  $onclickFunction = "generateShortLink('".$linkBoxId."','".urlencode($url)."');" ;	
		  $class="";
		  $mouseEvent = 'onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" ';
		  $title= "";
	
	    } else {
		         $onclickFunction ='';	
		         $class="opacity_4 formTip";
		         $mouseEvent = '';
				 //$title=$this->lang->line('ntPublishMsg'); 
				  $title= "";        
		   }				
			
		


		if($viewType=='showcase') { ?>

				<div class="tds-button01 cell btn_share_wrapper">				  
					<a class="<?php echo $class ?>" title="<?php echo $title ?>" <?php echo $mouseEvent ?>  onclick="<?php echo $onclickFunction ?>" ><span class="pr10">
						<div class="btn_link_icon fr ml10 pr0"></div>
						<div class="Fright"><?php echo $this->lang->line('getShortLink');?></div>
						</span>
					</a>
				</div>							

<?php   } else

		  { ?>         

			<span>
				<a class="<?php echo $shortlinkClass ?> getshortlink <?php echo $class ?> dash_link_hover" title = "<?php echo $title ?>" onclick="<?php echo $onclickFunction ?>" >
					<?php echo $this->lang->line('getShortLink');?>
				</a>
			</span> 

<?php    } ?>
    
                        
                            
<script type="text/javascript">

	
	function generateShortLink (textBoxId,url) {	
		// alert(divId+'TBX'+textBoxId+'URL'+url);

		$.ajax
		({     
			type: "POST",
			dataType: 'json',
			data:{url:url},			
			url: "<?php echo base_url(lang().'/shortlink/addShortLink') ?>",

			success: function(msg){ 	
				openLightBox('popupBoxWp','popup_box','/shortlink/shortlinkPopup',msg.shortlink,textBoxId);											
				// showShortLinkDiv(divId);                
				// $('#'+textBoxId).val(msg.shortlink);
			}
		});			
	}	
		

</script>
