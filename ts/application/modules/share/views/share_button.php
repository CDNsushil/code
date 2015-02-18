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
		  $onclickFunction = "getShortLink('".$url."','share');" ;	
		  $class="black_link_hover";
		  $linkclass="dash_link_hover";
		  $mouseEvent = 'onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" ';
		  $title= "";
	
	    } else {
		         $onclickFunction ='';	
		         $class="opacity_4 formTip";
		         $linkclass="opacity_4 formTip";
		         $mouseEvent = ' ';
				// $title=$this->lang->line('ntPublishMsg'); 
				$title= "";	        
		   }			
				
			
	if($viewType=='showcase') { ?>		
					  
						<div class="tds-button01 cell btn_share_wrapper">				  
							<a class="<?php echo $class ?>" title="<?php echo $title ?>" onclick="<?php echo $onclickFunction ?>" <?php echo $mouseEvent ?> ><span class="mr3 pr10">
								 <div class="btn_share_icon fr ml10 pr0"></div>
								  <div class="Fright"><?php echo $this->lang->line('share');?></div>
							  </span>
							</a>
						</div>							
						
		      <?php   } else 		      
		                  {	?> 
						  <span>
							 <a onclick="<?php echo $onclickFunction ?>" class="<?php echo $shareClass.' '.$linkclass;?>" title ="<?php echo $title ?>" >
								<?php echo $this->lang->line('share');?>
							</a> <!-- Sending PostId in encrypted Form for Security-->
                         </span>
                  <?php  } ?>
                  
                  
<script type="text/javascript">

	
  function getShortLink (url,viewType) {	
 // alert(divId+'TBX'+textBoxId+'URL'+url);
 	
		$.ajax
		({     
			type: "POST",
			dataType: 'json',
			data:{url:url},			
			url: "<?php echo base_url(lang().'/shortlink/addShortLink') ?>",

				success: function(msg){  
									
						 if(viewType=='share') {															
							openUserLightBox('popupBoxWp','popup_box','/share/socialShare',msg.shortlink);
						 }
						   else if(viewType=='email') {						   
								  openUserLightBox('popupBoxWp','popup_box','/share/shareEmail',msg.shortlink);
						}      
				}
		});			
	}	
</script>
