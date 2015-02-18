<div class="row form_wrapper">
<?php if(strcmp($this->router->class,'work')!=0){
	
	?>
	<div class="row">
		<div class="cell frm_heading">
			<h1>
				<?php 
					echo $label['Promoheading'];
				?>
			</h1>
		</div>
		<?php echo $header;?>		
	</div>	
<?php } // End If work class check?>
	<div class="row position_relative">
	<?php 
	
		//LEFT SHADOW STRIP
		echo Modules::run("common/strip");
	?>
	<div class="row">		
		<div class="label_wrapper cell">
			<div class="lable_heading">
				<h1><?php echo $label['PromoImageInfo'] ?></h1>
			</div>
		</div><!--label_wrapper-->
		<div class="cell frm_element_wrapper">
			<div class="tds-button-top">
				<?php
				
				
				
					$attr = array('onclick'=>'canceltoggle(1);');
					echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',$attr);					
				?>		
			</div>	
		</div><!-- END cell frm_element_wrapper -->
	</div><!-- END row -->
	
		<div id="PromoForm-Content-Box" class="row">
		<?php $action = $this->router->class.'/'.$this->uri->segment(2).'PromotionalImages/'.$promoImageId.'/'.$mediaType; 		  
		 
		echo Modules::run("mediatheme/promoMediaForm",$promoImageId,'','TDS_UpcomingProjectMedia',$mediaType); ?>
		
		<div class="row seprator_27"></div>  
		</div> <!-- PromoForm-Content-Box-->	
		<div class="row">
		
			<div class="label_wrapper cell">
				<label class="select_field"><?php echo $label['PromoImage'] ?></label>
			</div><!--label_wrapper-->
			<div class="cell frm_element_wrapper">
				<?php echo Modules::run("mediatheme/index",$promoImageId,'',$eventPromoImages); ?>
			</div><!-- END cell frm_element_wrapper -->
		</div><!-- END row -->
	</div>
</div><!-- END row form_wrapper -->
