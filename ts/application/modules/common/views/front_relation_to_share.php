<?php
$userId = $this->uri->segment('4');
$loggedUserId=isloginUser();
	if($relation){
		if(isset($relation['entityTitle']) && $relation['entityTitle']!='')
			$entityTitle = $relation['entityTitle'];
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
			
			
			
		if(!is_array($relation)){
			$relation[]=$relation;
		}?>
		<script>
			$(document).ready(function(){
				//alert("sharePost<?php echo $id;?>");	
				$("#sharePost<?php echo $id;?>").validate({
					submitHandler: function() {			
						 AJAX('<?php echo base_url(lang().'/common/sendEmail');?>','shareLinkEmail<?php echo $id;?>',$('#toAddress<?php echo $id;?>').val(),$('#relationbody<?php echo $id;?>').val(),'<?php echo $entityTitle;?>','<?php echo $shareType;?>','<?php echo $shareLink;?>');
						 $('.toAddress').val('');
						 $('.relationbody').val('');	
						 return false;
				  }
				});
			});
		</script>
			
				<?php
					 
					 if(in_array('email', $relation)){
						 ?>
						<div class="tds-button01 cell ">
							<a href="#"  class="relationemail" onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)" onmouseover="mousedown_tds_button01(this)" onmouseout="mouseup_tds_button01(this)" onclick="showEmailDiv('shareLinkEmail<?php echo $id;?>');">
							<span class="mr0">
							  <div class="btn_email_icon"></div>
							  <div class="Fright"><?php echo $this->lang->line('email');?></div>
							</span>
							</a> 
                      </div>
					
						<?php
					 }
					 
					 if(in_array('share', $relation)){
						 ?>
						 <span>
							<?php 
								$urlToShare = encode($shareLink);//we have pass the encoded url for security purpose
								echo Modules::run("share/shareButton",$urlToShare);								
							?>
						</span>
						
						<?php
					 }
					 
					 if(in_array('show', $relation)){
						 ?>
						<span><a class="icon_invite  relationemail" ><?php echo $this->lang->line('show');?></a></span>
						<?php
					 }
					 
					if(in_array('getShortLink', $relation)){
						?>
						 <span><a class="icon_getshort  getshortlink" onclick="showShortLinkDiv('getshortlink<?php echo $id;?>');" ><?php echo $this->lang->line('getShortLink');?></a></span>
						
						<?php
					 }
					
					 if(in_array('invite', $relation)){
						 ?>
						<span><a class="icon_invite  relationemail"  onclick="showEmailDiv('shareLinkEmail<?php echo $id;?>');"><?php echo $this->lang->line('invite');?></a></span>
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
				
                  ?>
				<div class="clear"></div>
			</div><!--blog_links_wrapper-->	
			
			
			<!-- To get short link used the common id (already presnet in dsscreen) for div adjust the css -->
			<div id="getshortlink<?php echo $id;?>" class="row width405px getshortlinkPage dn" style="position:absolute;">
						
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
							<a href="javascript:void(0);" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span onmouseover="copyStr(this,'<?php echo $shareLink; ?>')"> <?php echo $this->lang->line('copy');?> </span></a>
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
