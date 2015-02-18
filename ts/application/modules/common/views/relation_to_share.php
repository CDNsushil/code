<?php
$userId = $this->uri->segment('4');
$loggedUserId=isloginUser();
	if($relation){
		if(isset($relation['entityTitle']) && $relation['entityTitle']!='')
			$entityTitle = str_replace(array('"',"'"), array('&quot;',"&apos;"),$relation['entityTitle']);
		else 
			$entityTitle = '';
		
		if(isset($relation['shareType']) && $relation['shareType']!='')
			$shareType = $relation['shareType'];
		else 
			$shareType = '';
			
		if(isset($relation['shareLink']) && $relation['shareLink']!='')
			$shareLink = $relation['shareLink'];
		else 
			$shareLink = '';
			
		if(isset($relation['id']) && $relation['id']!='')
			$id = $relation['id'];
		else 
			$id = '';			
			if(isset($relation['class']) && $relation['class']!='')
			$class = $relation['class'];
		else 
			$class = '';
			
			if(isset($relation['title']) && $relation['title']!='')
			$title = $relation['title'];
		else 
			$title = '';
			
			if(isset($relation['emailClass']) && $relation['emailClass']!='')
			$emailClass = $relation['emailClass'];
		else 
			$emailClass = 'icon_email';
			
			
			if(isset($relation['shareClass']) && $relation['shareClass']!='')
			$shareClass = $relation['shareClass'];
		else 
			$shareClass = 'icon_share';
			
			
		if(isset($relation['shortlinkClass']) && $relation['shortlinkClass']!='')
			$shortlinkClass = $relation['shortlinkClass'];
		else 
			$shortlinkClass = 'icon_getshort';
			
		//To show diffrent button type in Showcase N Dasboard	
		if(isset($relation['viewType']) && $relation['viewType']!='')
			$viewType = $relation['viewType'];
		else 
			$viewType = '';
			
		// To Pass Preview Method & Desable Button when Preview Mode
		if(isset($relation['isPreviewMethod']) && $relation['isPreviewMethod']!='')
			$moduleMethod = $relation['isPreviewMethod'];		
					
			
		if(!is_array($relation)){
			$relation[]=$relation;
		}
		
		// if Mode is preview disable shortlink buttons
	   $moduleMethod = (isset($moduleMethod) && ($moduleMethod!='')) ? $moduleMethod :'';
		
		
		?>
		<script>
			$(document).ready(function(){
				//alert("sharePost<?php echo $id;?>");	
				$("#sharePost<?php echo $id;?>").validate({
					submitHandler: function() {			
					 AJAX('<?php echo base_url(lang().'/common/sendEmail');?>','shareLinkEmail<?php echo @$id;?>',$('#toAddress<?php echo @$id;?>').val(),$('#relationbody<?php echo @$id;?>').val(),'<?php echo $entityTitle;?>','<?php echo $shareType;?>','<?php echo $shareLink;?>');
					 $('.toAddress').val('');
					 $('.relationbody').val('');	
					 return false;
					}
				});
			});
		</script>			
				<?php
					 
					 if(in_array('email', $relation)){
						 $isPublished=isset($relation['isPublished'])?$relation['isPublished']:'f';
						 if(isset($isPublished) && $isPublished=='t' && ($moduleMethod!='preview'))
							{				
							  $onclickFunction = "getShortLink('".$shareLink."','email');" ;	
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
						
						  if($viewType=='showcase') { ?>
						  
						 <div class="tds-button01 cell btn_share_wrapper">				  
							<a class="<?php echo $class ?>" title="<?php echo $title ?>" <?php echo $mouseEvent ?> onclick="<?php echo $onclickFunction ?>" ><span class="mr3 pr10">
								 <div class="btn_email_icon fr ml10 pr0"></div>
								  <div class="Fright"><?php echo $this->lang->line('emaillink');?></div>
							  </span>
							</a>
						</div>	
												
						
		      <?php   } else 
		
		                  { ?>	 					 
					        <span>
								<a class="<?php echo $emailClass ?>  relationemail <?php echo $class ?> dash_link_hover" title="<?php echo $title ?>"  onclick="<?php echo $onclickFunction ?>">
								   <?php echo $this->lang->line('emaillink');?>
								</a>
							</span>
					 
					 
					 <?php } }  
					 					 
					 if(in_array('share', $relation)){
						 ?>
						
							<?php $isPublished=isset($relation['isPublished'])?$relation['isPublished']:'f';
								//$urlToShare = encode($shareLink);//we have pass the encoded url for security purpose
								$urlToShare = $shareLink;
								echo Modules::run("share/shareButton",$urlToShare,$shareClass,$viewType,$isPublished,$moduleMethod);								
							?>
												
						<?php
					 }
					 
					 if(in_array('show', $relation)){
						 $showClass='';
						 if(isset($relation['entityId']) && $relation['entityId'] > 0 ){
							$projectType=isset($relation['projectType'])?$relation['projectType']:'';
							$showTooLTip=($projectType=='filmNvideo')?$this->lang->line('showbuttonToolTipKeyCastKrew'):$this->lang->line('showbuttonToolTipKeyPersonal');
							$showTooLTip=($projectType=='musicNaudio')?$this->lang->line('showbuttonToolTipBandMembers'):$showTooLTip;
							$function="lightBoxWithAjax('popupBoxWp','popup_box','/showproject/form/','".$relation['entityId']."','".$relation['elementid']."','".$projectType."')";
						 }else{
							  $showTooLTip='';
						 }
						
						 $isPublished=isset($relation['isPublished'])?$relation['isPublished']:'f';
						 if($isPublished!='t'){
							$function="customAlert('".$this->lang->line('canNotShowProject')."')"; 
							$showClass='class="opacity_4"';
						 }
						 ?>
						<span <?php echo $showClass;?>><a href="javascript:void(0);" onclick="<?php echo $function;?>" class="icon_invite  relationemail formTip dash_link_hover" title="<?php echo $showTooLTip;?>" ><?php echo $this->lang->line('show');?></a></span>
						<?php
					 }
					 
					if(in_array('getShortLink', $relation)){
						?>
						<!-- <span><a class="<?php //echo $shortlinkClass ?> getshortlink" onclick="showShortLinkDiv('getshortlink<?php //echo $id;?>');" ><?php //echo $this->lang->line('getShortLink');?></a></span> -->
						 <?php 								
							echo Modules::run("shortlink/shortlinkButton",$data=array('linkBoxId'=>'gsInput'.$id,'url'=> $shareLink,'shortlinkClass'=>$shortlinkClass,'isPublished'=>$isPublished,'isPreview'=>$moduleMethod));								
						}
						
					if(in_array('getFrontShortLink', $relation)){
						?>
						<!-- <span><a class="<?php //echo $shortlinkClass ?> getshortlink" onclick="showShortLinkDiv('getshortlink<?php //echo $id;?>');" ><?php //echo $this->lang->line('getShortLink');?></a></span> -->
						 <?php 								
							echo Modules::run("shortlink/shortlinkFrontButton",$data=array('linkBoxId'=>'gsInput'.$id,'url'=> $shareLink,'shortlinkClass'=>$shortlinkClass,'isPublished'=>$isPublished,'isPreview'=>$moduleMethod));								
						}
					
						if(in_array('invite', $relation)){
							 ?>
							<span><a class="icon_invite  relationemail black_link_hover"  onclick="showEmailDiv('shareLinkEmail<?php echo $id;?>');"><?php echo $this->lang->line('invite');?></a></span>
							<?php
						}					
					
					 if(in_array('postOnPost', $relation)){
						
						 if($loggedUserId>0){
							  $gotourl = 'blogshowcase/postchild/'.$userId.'/'.$postData->postId.'/'.$postData->blogId;
							  echo anchor($gotourl,'<span><div class="icon_getshort">'.$this->lang->line('postOnPost').'</div></span>'); 
						  }
						 else{
							  $gotourl="openLightBox('popupBoxWp','popup_box','/auth/login','')";
							  echo anchor('javascript://void(0);','<span><div class="icon_getshort">'.$this->lang->line('postOnPost').'</div></span>',array('onclick'=>$gotourl)); 
							 }
						 
					 }				

				
				  if(in_array('meetingPoint', $relation)){
				?>		
				  <div class="tds-button fr pr70"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#" style="background-position: 0px -38px;"><span class="btn_meeting" style="background-position: right -38px;"> <div class="icon-meeting-btn">&nbsp;</div>
                              <div class="btn_content_wp">Meeting<br>
                                <div style="float:left; width:auto; margin:0px; height:auto">Point</div>
                                <div style="float:right; width:auto; height:auto; font-size:11px; font-weight:bold; padding-top:1px; margin-left:23px;"> 220</div>
                     </div></span></a> 
                   </div>
				 
                  <?php 
                  }
                  ?>
				<div class="clear"></div>
			</div><!--blog_links_wrapper-->	
			
			
			<!-- To get short link used the common id (already presnet in dsscreen) for div adjust the css -->
			<div id="getshortlink<?php echo $id;?>" class="row width405px getshortlinkPage dn_imp" style="position:absolute;">
						
				<div class="row">
					<div class="cell"><input type="text" value="<?php echo $shareLink; ?>" id="gsInput<?php echo $id;?>" readonly name="getshortlink"  class="width405px" onfocus="this.select();" /></div> 
				</div>
				<div class="row pt10">
					<?php 
					/*<div class="cell">
						<div class="tds-button floatRight">
							<?php echo anchor('javascript://void(0);', '<span>Ok</span>',array('id'=>'okgetshortlink','class'=>'getshortlink','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
						</div>
					</div>*/
					?>
					<div class="cell">
						<div class="tds-button floatRight">
							<a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span onclick="copyStr(this,'<?php echo $shareLink; ?>')"> <?php echo $this->lang->line('copy');?> </span></a>
							<?php echo anchor('javascript://void(0);', '<span>'.$this->lang->line('cancel').'</span>',array('id'=>'cancelgetshortlink','onclick'=>'hideRelationDiv(\'getshortlink'.$id.'\');','class'=>'getshortlink','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
						</div>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			
			<!-- To send email used the common id (already presnet in dsscreen) for div adjust the css -->
			<div  id="shareLinkEmail<?php echo $id;?>" class="width405px shareLinkEmail dn" style="position:absolute;">
				<?php				

				$formAttributes = array(
					'name'=>'sharePost'.$id,
					'id'=>'sharePost'.$id,
					'class'=>'sharePost width405px'					
				);
				
				echo form_open('common/sendEmail',$formAttributes);
				
				?>		
				<div class="row">
					<div class="cell"><?php echo $this->lang->line('toAddress');?></div>
				</div>
			    <div class="row">
					<div class="cell">
					<?php
					$toAddress = array(
						'name'	=> 'toAddress',
						'id'	=> 'toAddress'.$id,
						'value'	=> '',
						'maxlength'	=> 160,
						'size'	=> 30,
						'class'       => 'toAddress formTip frm_Bdr required email width405px',
						'title'       => $this->lang->line('emailLimitMSG'),
					);

					$relationbody = array(
						'name'	=> 'relationbody',
						'id'	=> 'relationbody'.$id,
						'value'	=> '',	
						'class'       => 'relationbody frm_Bdr heightAuto rz required width405px',
						'title'       => $this->lang->line('description'),
						'wordlength'=>"5,50",
						'onkeyup'=>"checkWordLen(this,50,'tagLimit')"						
					);
					
					echo form_input($toAddress);
					?>
					
					</div> 					
				</div>
				<div class="row seprator_10"></div>
				<div class="row">
					<div class="cell"><?php echo $this->lang->line('message');?></div>
				</div>
				<div class="row">
					<div class="cell">
					<?php
					echo form_textarea($relationbody);
					?>
					</div> 				
				</div>
				<div class="row pt10">
					<div class="cell">
						 <div class="tds-button Fleft"><button type="submit" name="submit" value="Send" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span><div class="Fleft"><?php echo $this->lang->line('sendMail');?></div> <div class="icon-save-btn"></div></span></button></div>
					</div>
					<div class="cell">
						<div class="tds-button floatRight">
							<?php echo anchor('javascript://void(0);', '<span>'.$this->lang->line('cancel').'</span>',array('id'=>'cancelemail','onclick'=>'hideRelationDiv(\'shareLinkEmail'.$id.'\');','class'=>'relationemail','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>							
						</div>
					</div>
				</div>
				<div class="clear"></div>
	<?php 
	echo form_close(); 
		
	}
?>
<script>
function goto(url){
	alert(url);
	}
</script>
