
<div class="contentcontainer">
	<div class="headings altheading">		
		<div class="fLeft">
			<h2><?php echo $this->lang->line('admin_message'); ?></h2>
		</div>
		
		<div class="fRight">
			<a class="linkText" href="<?php echo base_url()."admin_message/messages/1/".$message->to;?>">
				<h3><?php echo $this->lang->line('admin_all_message'); ?></h3>
			</a>
		</div>	
		<div class="clear"></div>
	</div>
	<div class="contentbox">
		<?php if(count($message)>0){?>
						<!-- ---------message list row start-------------->
						<div class="message_Listpage confirm_box" >
							
							<div class="head-box div-title-text">	
								
									<div class="name_box_wrapper fLeft">
											<div class="user_box">
												<img src="<?php  echo getimage('user', 2,$message->to);?>" width="40px" height="40px" />
											</div><!--user_box-->
											
											<div class="user_name-box">
												<?php echo $message->to_firstname." ".$message->to_lastname; ?>
											</div>
									</div><!--name_box_wrapper-->
									<div class="fRight">
											Date : <?php echo date("d F, Y",strtotime($message->created)); ?>
									</div>
									<div class="clear"></div>
								
							</div>
														
							
							  <!-- message counter -->							  
							  <div class="messageDetailBox div-title-text">								
								<p class="message_title div-title-text">FROM : <?php echo $message->from_firstname." ".$message->from_lastname; ?></p>
								<div>
									<?php
									$attachment=get_message_attachment_list($message->id); 
									if($attachment!=''){
									?>
									<div class="fLeft"><p>Attachment : </p></div>
									<div class="fLeft"><?php echo $attachment;?></div>
									<div class="clear"></div>
									<?php } ?>
								</div>
								<div class="messageDetailBox">
									<p class="message_text"><?php echo $message->message;?></p>																	
								</div>
							  </div>
							 
		   				
						  <!-- message delete button -->						  
						  <div class="clear"></div>
						</div>
						<!-- ---------message list row end-------------->		
		<?php
				
		}else{?>
			<div class="message_Listpage">
			<h1>No messages found.</h1>
			</div>
		<?php } ?>		
			
	</div>
	
</div>	
