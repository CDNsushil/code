<ul>
			<li>
				<div class="row b">
					<div class="cell pr20 width150px"><?php echo $this->lang->line('username');?></div>
					<div class="cell pr20 width200px"><?php echo $this->lang->line('subject');?></div>
					<div class="cell pr20 width300px "><?php echo $this->lang->line('suggestion');?></div>
					<div class="cell pr20 width100px"><?php echo $this->lang->line('date');?></div>
				</div>
				</li>
		<?php
			foreach($suggestions as $suggestion_i =>$suggestion_detail){
				if($suggestion_detail['sender_id']!=''){
					$userInfo = showCaseUserDetails($suggestion_detail['sender_id']);	
					
					 if(!isset($userInfo['userFullName']) || empty($userInfo['userFullName']) || $userInfo['userFullName'] ==' '){
					 }else{
					?>
						<li>
						<div class="row">
							<div class="cell pr20 width150px "><?php echo $userInfo['userFullName'];?></div>
							<div class="cell pr20 width200px wordWrap"><?php echo $suggestion_detail['subject'];?>&nbsp;</div>
							<div class="cell pr20 width300px wordWrap "><?php echo $suggestion_detail['suggestion']; ?>&nbsp;</div>
							<div class="cell pr20 width100px"><?php echo dateFormatView($suggestion_detail['suggestion_date'],'d M Y');?></div>
						</div>
						</li>
					<?php
					}
				}	
			}
		?>
	</ul>	

	<?php
	if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?>
		<div class="pt15 ml28 mt7 mr15">
			<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_suggestions/index'),"divId"=>"showSuggestionsList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
		</div>
		<div class="clear"></div>
		<?php 
	} ?>
