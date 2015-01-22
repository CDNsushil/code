<ul>
			<li>
				<div class="row b">
					<div class="cell pr20 width300px"><?php echo 'Template';?></div>
										
					<div class="cell pl20 width_32"><?php echo 'Lang';?></div>
				</div>
				</li>
		<?php
			foreach($email_templates as $email_templates_i =>$email_templates_detail){	
				$detail_template_url = site_url(SITE_AREA_SETTINGS.'manage_templates/detail/'.$email_templates_detail['id']);					
		?>
		<li>
			
			<div class="row" >
				<div class="cell pr20 width300px wordWrap">
					<a class="ptr hoverOrange clr_437394" href="<?php echo $detail_template_url;?>" >
						<?php echo $email_templates_detail['subject'];?>&nbsp;
					</a>
				</div>
						
				<div class="cell pl20 width_32"><?php echo $email_templates_detail['lang'];?></div>
			</div>
			
		</li>
		<?php					
			}
		?>
		</ul>	
		
		<?php
		if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){
			if($section=='tmail'){
				$returnUrl = base_url('admin/settings/manage_templates/tmail_tmp');
			}else{
				$returnUrl = base_url('admin/settings/manage_templates/email_tmp');
			}
			?>
			<div class="pt15 ml28 mt7 mr15">
				<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>$returnUrl,"divId"=>"showTemplateList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
			</div>
			<div class="clear"></div>
			<?php 
		} ?>
	
	
