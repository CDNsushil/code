<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<ul>
	<li>
		<div class="row">			
			<div class="cell width150px tac b"><?php echo $this->lang->line('visitorsIpAddress');?></div>
			<div class="cell width120px tac b"><?php echo $this->lang->line('visitorsCity');?></div>
			<div class="cell width120px tac b"><?php echo $this->lang->line('visitorsCountry');?></div>
			<div class="cell width120px tac b"><?php echo $this->lang->line('visitorsregion');?></div>
			<div class="cell width100px tac b"><?php echo $this->lang->line('visitorsLatitude');?></div>
			<div class="cell width100px tac b"><?php echo $this->lang->line('visitorsLogitude');?></div>
			<div class="cell width100px tac b"><?php echo $this->lang->line('visitorsDate');?></div>
			
			<div class="cell"><?php //echo $this->lang->line('admin_status');?></div>
		</div>
	</li>

<?php

	if(isset($visitorList) && !empty($visitorList)){
		foreach($visitorList as $visitors){ 	?>
			<li>
				<div class="row">					
					<div class="cell width150px tac"><?php echo !empty($visitors['ip_address'])?$visitors['ip_address']:'&nbsp;';?></div>
					<div class="cell width120px tac"><?php echo !empty($visitors['city'])?$visitors['city']:'&nbsp;';?></div>
					<div class="cell width120px tac"><?php echo !empty($visitors['country'])?$visitors['country']:'&nbsp;';?></div>
					<div class="cell width120px tac wordWrap"><?php echo !empty($visitors['region'])?$visitors['region']:'&nbsp;';?></div>				
					<div class="cell width100px tac"><?php echo !empty($visitors['latitude'])?$visitors['latitude']:'&nbsp;';?></div>
					<div class="cell width100px tac"><?php echo !empty($visitors['longitude'])?$visitors['longitude']:'&nbsp;';?></div>				
					<div class="cell width100px tac "><?php echo !empty($visitors['date'])?$visitors['date']:'&nbsp;';?></div>				
					
			</li>
		<?php
		}
	}
	?>
	<li>
		<?php
		if(isset($items_total)  && isset($items_per_page) && $items_total >  $items_per_page){?>
			<div class="pagingWrapper">
					<div class="clearfix"></div>
					<div class="pt15 ml28 mt7 mr15">
						<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url('admin/settings/manage_visitors'),"divId"=>"showVisitorsList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design')); ?>
					</div></div>
			<div class="clear"></div>
			<?php 
		} ?>
	</li>
</ul>

