<?php	
		$isPublished=isset($isPublished)?$isPublished:'f';
						 if(isset($isPublished) && $isPublished=='t')
							{				
							  $onclickFunction = "getShortLinkWp('".$shareLink."');" ;	
							  $class="";
							  $mouseEvent = 'onmouseup="mouseup_tds_button01(this)" onmousedown="mousedown_tds_button01(this)" ';
							  $title= "";
						
							} else {
									 $onclickFunction ='';	
									 $class="opacity_4 formTip";
									 $mouseEvent = ' ';
									 //$title=$this->lang->line('ntPublishMsg'); 
									 $title= ""; 
								   }
						  ?>				  
						
			<button type="button" onclick = "<?php echo $onclickFunction ?>" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" class="dash_link_hover"><span><div class="Fleft"><?php echo 'Email';?></div> <div class="email_icon"></div></span> 
						
				     
                  
                  
<script type="text/javascript">

	
  function getShortLinkWp (url) {	 
 	
		$.ajax
		({     
			type: "POST",
			dataType: 'json',
			data:{url:url},			
			url: "<?php echo base_url(lang().'/shortlink/workProfileShortLink') ?>",

				success: function(msg){								
											   
					 openUserLightBox('popupBoxWp','popup_box','/share/shareEmail',msg.shortlink);
								    
				}
		});			
	}	
</script>
