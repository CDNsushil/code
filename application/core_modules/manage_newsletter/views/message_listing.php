<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<?php
	foreach($messageLog as $messageLog_i =>$messageLogDetail){
	?>
		<div class="ver_contact_wp parent">
			<a href="<?php echo site_url().'admin/settings/manage_newsletter/view_message/'.$messageLogDetail['id'];?>">	
				<div class="ver_contact_user_pic_box">
					<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td align="center" valign="middle"><img src="<?php echo site_url().'images/default_thumb/toadsquare_default.jpg';?>" class="max_h_41 max_w_41"  /></td>
						</tr>
					</table>
				</div>
                
                <div class="var_name_wp width160px">
					<div class="var_name_label">
						<?php echo 'Subject' ; ?>
                    </div><!--var_name_label-->
                        
					<div class="var_name  b font_size11 inboxView height30">
					<!--Sample text from subject of Tmail-->
                        <?php echo getSubString($messageLogDetail['subject'],50) ?>
					</div><!--var_name_label-->    
                </div><!--var_name_wp-->
                <div class="var_name_wp width305px">
					<div class="var_name_label">
						<?php echo 'Body' ; ?>
                    </div><!--var_name_label-->
                        
					<div class="var_name  b font_size11 inboxView height30">
					<!--Sample text from subject of Tmail-->
                        <?php echo substr(strip_tags($messageLogDetail['message']),0,100) ?>
					</div><!--var_name_label-->    
                </div><!--var_name_wp-->
                
                <div class="var_datbox_wp width140px">
               	<div class="var_name_label ml30">
                    <?php echo $this->lang->line('Date');?>
                </div><!--var_name_label-->
                        
                 <div class="var_name  b font_size11 inboxView height30 ml30">
                    <?php echo  dateFormatView($messageLogDetail['sentDate'],'d M Y') ?>                        
                </div><!--var_name_label-->
                        
                </div>
			</a>  
                <div class="var_line_divider">
                </div><!--var_line_divider-->
              
          
        <div class="tds-button-top modifyBtnWrapper pr20 mt18">
			<a original-title="Delete" href="<?php echo base_url().SITE_AREA_SETTINGS.'manage_newsletter/delete_msg/'.$messageLogDetail['id'];?>" class="formTip ml6" onClick="return confirm('Are you sure you want to delete?')"><span><div class="projectDeleteIcon"></div></span></a> 
		</div>
                                        
        </div><!--ver_contact_wp-->
	<?php
	}
	?>
	<?php
	if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?>
		
			<div class="pt15 ml28 mt7 mr15">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_newsletter/index'),"divId"=>"showUserList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
		</div>
		<div class="clear"></div>
	<?php } ?>
		

		
