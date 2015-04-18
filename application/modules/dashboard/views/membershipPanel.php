
<div class="row">
      <div class="cell frm_heading">
        <h1>Membership</h1>
      </div>
	<div class="cell frm_element_wrapper pt1">						   
		<div class="tds-button-big Fright"><a href="<?php echo base_url(); ?>dashboard/" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span>Dashboard</span></a></div>					   
			<div class="tds-button-big Fright"> 
				<a href="<?php echo base_url(); ?>dashboard/globalsettings" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span>Global Settings</span></a>  
			</div>
		<div class="row line1 mr3"></div>   								
	
	</div>	
</div>


<div class="clear"></div>


<div class="row tab_wp pt2 ">


<div class="row">
        <div class="cell tab_left">
          <div class="tab_heading">Product Status</div>
          <!--tab_heading-->
        </div>
        <div class="cell tab_right"> 
        
        
          <div class="tab_btn_wrapper width_100_per">
          
            <div class="abc_wp">
                         	
                         </div><!--abc_wp-->  
                         
            <div class="tds-button-top">
              <!-- Post Edit Icon -->
                <a class="formTip" original-title="">
					<span><div toggledivid="product_status_box" id="newsToggleIcon" class="projectToggleIcon toggle_icon" style="background-position: -1px -144px;"></div></span>
				</a>         
         
              
              </div>
          </div>
         
          
        </div><!--cell tab_right-->
        </div><!--row--> 
        
     





<div class="clear"></div>

<div id="product_status_box" class="form_wrapper toggle frm_strip_bg ">
        <div class="row">
          <div class="tab_shadow"> </div>
        </div>


<div class="row" id="newsDataHeading">
				  
		
		<div class="cell label_wrapper bg-non"></div>
		<div class="cell frm_element_wrapper">
			<div class="cell date_small_frm" style="width: 50px;">
				<span class="orange_color">Quantity</span>
			</div>
			
			<div class="cell date_small_frm" style="width: 50px;">
				<span class="orange_color">Used</span>
			</div>
			
			<div class="cell date_small_frm" style="width: 50px;">
				<span class="orange_color">Free</span>
			</div>
				
				<div class="cell date_small_frm" style="width: 160px;">
				<span class="orange_color">Date of First Save</span>
			</div>
			
			<div class="cell date_small_frm" style="width: 160px;">
				<span class="orange_color">Expiry Date</span>
			</div>
			</div><!--cell frm_element_wrapper-->
			
			
			
			<div class="clear"></div>
			
			<div class="line1 mr10"></div>
				  
				  </div>	<!--newsDataHeading-->


<!--<div id="pagingContent">-->
<?php $count1 = 0; ?>
<?php if(!empty($containerData)) {
	$count1=count($containerData);
		foreach($containerData as $condata) { ?>
		
		<div class="row">
		<div class="cell label_wrapper"><label><?php echo $condata->pkgName;?></label></div>
		<div class="cell frm_element_wrapper">
		<div class="cell date_small_frm" style="width: 50px;"><?php echo $condata->pkgMaxEntity;?></div>
        <div class="cell date_small_frm" style="width: 50px;"> <?php echo ($condata->usedSize)/(1024*1024)." MB";?></div>
        <div class="cell date_small_frm" style="width: 50px;"><?php echo (($condata->pkgSize)/(1024*1024) - ($condata->usedSize)/(1024*1024))." MB";?></div>
        <div class="cell date_small_frm" style="width: 160px;"><?php echo date("d M Y",strtotime($condata->createdDate));?></div>
        <div class="cell date_small_frm" style="width: 160px;"><?php echo date("d M Y",strtotime($condata->expiryDate));?></div>
		</div><!--cell frm_element_wrapper-->
		</div><!--row-->
		
		
		
<?php 
		} 
	}
	else 
	{ 
		echo "<div align='center'>No record found</div> ";
	}
	?>              
                
<!--</div>pagingContent-->



	


<div class="clear"></div>
</div>  <!--form_wrapper toogle frm_strip_bg-->


 
 
 <div class="clear"></div>
 
 <div class="row">
        <div class="cell tab_left">
          <div class="tab_heading">Package Available</div>
          <!--tab_heading-->
        </div>
        <div class="cell tab_right"> 
        
        
          <div class="tab_btn_wrapper width_100_per">
          
            <div class="abc_wp">
                         	
                         </div><!--abc_wp-->  
                         
            <div class="tds-button-top">
              <!-- Post Edit Icon -->
                <a class="formTip" original-title="">
					<span><div toggledivid="package_info_box" id="newsToggleIcon" class="projectToggleIcon toggle_icon" style="background-position: -1px -144px;"></div></span>
				</a>         
         
              
              </div>
          </div>
         
          
        </div><!--cell tab_right-->
        </div><!--row--> 
        
     





<div class="clear"></div>

<div id="package_info_box" class="form_wrapper toggle frm_strip_bg ">
        <div class="row">
          <div class="tab_shadow"> </div>
        </div>


<div class="row" id="newsDataHeading">
			
			<div class="cell label_wrapper bg-non"></div>	
			
			<div class="cell frm_element_wrapper">  
			<div class="cell date_small_frm" style="width: 50px !important;">
				<span class="orange_color">Space</span>
			</div>
			
			<div class="cell date_small_frm" style="width: 50px !important;">
				<span class="orange_color">Quantity</span>
			</div>
			
			<div class="cell date_small_frm" style="width: 50px !important;">
				<span class="orange_color">Price</span>
			</div>
				
				<div class="cell date_small_frm" style="width: 240px !important;">
				<span class="orange_color">Validity</span>
			</div>
			
			<div class="cell date_small_frm" style="width: 60px !important;">
				<span class="orange_color">Action</span>
			</div>
			</div><!--cell frm_element_wrapper-->
			
			<div class="clear"></div>
			
			<div class="line1 mr10"></div>
				  
</div>	<!--newsDataHeading-->

<!--<div id="pagingContent">-->
<?php $count = 0; ?>
<?php if(!empty($membershipData)) {
	$count=count($membershipData);
		foreach($membershipData as $memdata) { ?>
		
        <div class="row">
		<div class="cell label_wrapper"><label><?php echo $memdata->pkgName;?></label></div>
		<div class="cell frm_element_wrapper">  
         
                 <div class="cell date_small_frm" style="width: 50px !important;"><?php echo $size = ($memdata->pkgSize)/(1024*1024) >= 1024 ? ($memdata->pkgSize)/(1024*1024*1024)." GB":($memdata->pkgSize)/(1024*1024)." MB";?></div>
                  <div class="cell date_small_frm" style="text-align: center; width: 50px !important;"> <?php echo $memdata->pkgMaxEntity;?></div>
                  <div class="cell date_small_frm" style="width: 50px !important;"><?php echo "$".$memdata->pkgPrice;?></div>
                  <div class="cell date_small_frm" style="width: 240px !important;"><?php echo "For ".round($memdata->pkgValidity/30)." months from date of First Save";?></div>
                  <div class="cell date_small_frm abc_wp" style="width: 60px !important;"><a href="#">Buy Now</a></div>
        </div><!--cell frm_element_wrapper-->
        </div><!--row-->        
              
<?php 
		} 
	}
	else 
	{ 
		echo "<div align='center'>No record found</div> ";
	}
	?>                
                
<!--</div>pagingContent-->



<div class="clear"></div>
</div>  <!--form_wrapper toogle frm_strip_bg-->
 

 
    </div><!--row tab_wp pt2-->
<div class="row">
<div class="tab_shadow"></div>
</div>
