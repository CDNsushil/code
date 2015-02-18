<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

    <div class="bg_white cart_pattern">
        <div class="seprator_6"></div>
          <div class="cart_top_header ml6 mr6">
            <div class="CSEprise_pattern minH110">
              <div class="cell">
                <div class="cart_top_header_heading"><?php echo $this->lang->line('shopping_cart'); ?> </div>
              </div>
              <div class="Fright">
                <div class="SCart_subMenu_outer mt10 mr10">
					
                <?php $this->load->view('purchase_common_menu'); ?>  
                  
                 </div>
                <div class="seprator_30"></div>
                
                
              </div>
              
               <div class="cart_main_nav_box fl mt7"> 
				<a href="<?php echo  base_url('cart/sales')?>" class="ml40 height37 ptr sale_hover">
                  <div class="mt9 mr8"><?php echo $this->lang->line('sales_menu'); ?></div>
                  </a>
              		<a href="<?php echo base_url('cart/sales_information')?>" class="ml10 selected height37 ptr sale_hover">
                  <div class="mt9 mr8"><?php echo $this->lang->line('sales_information'); ?></div>
                  </a>
                  <div class="clear"></div>
                  </div>
              
             
              
               <form action="<?php base_url('cart/sales_information')?>" method="get" name="search_sales_info" id="search_sales_info"> 
				 
					<div class="fr mr10">
						<div class="fl width170px clr_white">
						<label class="fl mt5"><?php echo $this->lang->line('show_by'); ?></label>
						  <div class="cell join_frm_element_wrapper confirmselect selectbox_small mr10 pl12 mt-5">
						  <?php $showArray = array(
								  'day'  => 'Day',
								  'month'    => 'Month',
								  'year'   => 'Year',
								  'project'   => 'Project'); 
							$js = 'id="show_by" style="width:100px"';	  
							echo form_dropdown('show_by', $showArray, $show_by, $js);	    ?>
					</div>
						</div>
						<?php
					
								$cls = ($show_by=='day' || $show_by=='month' || $show_by=='project')?" ":"dn";
								$cls_disable = ($show_by=='day' || $show_by=='month')?" ":"disabled";
							  	$cls_new = ($show_by=='year')?"":"dn";
							  	$cls_new_disable = ($show_by=='year')?"":"disabled";
							  	
							  	$cls_show = ($show_by=='project')?"bc_grey":"";
							  	$cls_disable = ($show_by=='project')?"disabled":"";
							  	
							  	$img_cls_show = ($show_by=='project')?"":"dn";
							  	$img_cls_hide = ($show_by=='project')?"dn":"";
							  	
						?>
						<!--------- this div for show calender day and month---------->
						
						 <div id="d_m_y_first"  class="fl height_30 date_picker width_212  <?php echo $cls; ?>">
							<p class="clr_white font_opensansSBold"><?php echo $this->lang->line('from'); ?> <input  <?php echo $cls_disable ?> type="text" name="from_date" id="from_date" value="<?php echo $from_date ?>" placeholder="DD  MM  YY" class="date-input <?php echo $cls_show ?>"  readonly>
							<img id="img_from_date" class="ptr <?php echo $img_cls_hide ?>" onclick='$("#from_date").focus();' class="ui-datepicker-trigger" src="<?php echo base_url('templates/default'); ?>/images/toadcalender_icon.png" alt="..." title="...">
							<img class="<?php echo $img_cls_show ?>" id="show_disable_form" class="ui-datepicker-trigger" src="<?php echo base_url('templates/default'); ?>/images/toadcalender_icon_gray.png" alt="..." title="...">
							</p>
						  </div>
						  
						 <div id="d_m_y_second" class="fl height_30 date_picker width196 ml10 <?php echo $cls; ?>">
							<p class="clr_white font_opensansSBold for_to_lab"><?php echo $this->lang->line('to'); ?> <input <?php echo $cls_disable ?> type="text"  dateGreaterThan="#from_date" value="<?php echo $to_date ?>" title="Enter correct date." name="to_date" id="to_date" placeholder="DD  MM  YY" class="date-input <?php echo $cls_show ?>" readonly>
							<img id="img_to_date"  class="ptr <?php echo $img_cls_hide ?>" onclick='$("#to_date").focus();' class="ui-datepicker-trigger" src="<?php echo base_url('templates/default'); ?>/images/toadcalender_icon.png" alt="..." title="...">
							<img class="<?php echo $img_cls_show ?>" id="show_disable_to" class="ui-datepicker-trigger" src="<?php echo base_url('templates/default'); ?>/images/toadcalender_icon_gray.png" alt="..." title="...">
							</p>
						 </div>
						 
						<!--------------this div for show calender day and month end---------------> 
						 
						 
						 <!--------- this div for show calender month and year start---------->
						 
						 <div id="m_y_first" class="fl height_30 date_picker width_212 <?php echo $cls_new; ?>">
							<p class="clr_white font_opensansSBold"><?php echo $this->lang->line('from'); ?> <input <?php echo $cls_new_disable ?>  type="text" name="from_date" id="from_date_m" value="<?php echo $from_date_1 ?>" placeholder="DD  MM  YY"  readonly><img class="ptr" onclick='$("#from_date_m").focus();' class="ui-datepicker-trigger" src="<?php echo base_url('templates/default'); ?>/images/toadcalender_icon.png" alt="..." title="..."></p>
						  </div>
						  
						 <div id="m_y_second"  class="fl height_30 date_picker width196 ml10 <?php echo $cls_new; ?>">
							<p class="clr_white font_opensansSBold for_to_lab"><?php echo $this->lang->line('to'); ?> <input  <?php echo $cls_new_disable ?> type="text"  monthYearGreaterThan="#from_date_m"  value="<?php echo $to_date_1 ?>" title="Enter correct date." name="to_date" id="to_date_m" placeholder="DD  MM  YY"  readonly><img class="ptr" onclick='$("#to_date_m").focus();' class="ui-datepicker-trigger" src="<?php echo base_url('templates/default'); ?>/images/toadcalender_icon.png" alt="..." title="..."></p>
						 </div>
						 
						 <!-------------this div for show calender month and year---------->
						 
						  
						  <div class="tds-button Fright ml18">  <button  onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" type="submit" value="Save" name="save"><span class="text-indent_0"><?php echo $this->lang->line('Refresh'); ?></span></button> </div>
						  
					  
					  </div>
              
				</form>
              
              
              
            </div>
          </div>
          
          <div class="seprator_25"></div>
          
          <div class="mh400">
			  
        <div class="cart_container_outer ">
         <!------------container start here--------->
        
        <!--<div class="cart_container mh390 bg_white">--> 
         
        <div id="showInbox"> 
         <?php 
         
            if($show_by!="project")
            {
				$this->load->view("sales_info_without_pro");
			}else
			{
				$this->load->view("sales_info_with_pro");
			}
         
         
         ?>
        </div>
        <!-------------container end here----------> 
          </div>
          
          
          </div>
          
          <div class="seprator_8"></div>
          
          
          
          
          
          
			
        </div>
        <!--front_end_mani_content_wp-->
 <script>
	 
$(document).ready(function(){	
			 $("#search_sales_info").validate({});
			 
			 $("#show_by").change(function() { 
				 
					if($(this).val()=="month" || $(this).val()=="day")
					{
						//img hide and show
						$("#img_from_date").show();
						$("#img_to_date").show();
						$("#show_disable_form").hide();
						$("#show_disable_to").hide();
						//input box hide and show
						$("#d_m_y_first").show();
						$("#d_m_y_second").show();
						$("#m_y_first").hide();
						$("#m_y_second").hide();
						$("#from_date_m").attr("disabled", "disabled"); 
						$("#to_date_m").attr("disabled", "disabled"); 
						$("#from_date").removeAttr("disabled"); 
						$("#to_date").removeAttr("disabled"); 
						$("#from_date").removeClass();
						$("#to_date").removeClass(); 
						$("#from_date").addClass("date-input");
						$("#to_date").addClass("date-input"); 
						
					}	
					if($(this).val()=="year")
					{
						$("#m_y_first").show();
						$("#m_y_second").show();
						$("#d_m_y_first").hide();
						$("#d_m_y_second").hide();
						$("#from_date").attr("disabled", "disabled"); 
						$("#to_date").attr("disabled", "disabled"); 
						$("#from_date_m").removeAttr("disabled"); 
						$("#to_date_m").removeAttr("disabled"); 
						$("#from_date").css( "background", "#ffffff"); 
						$("#to_date").css( "background", "#ffffff"); 
					}
					
					if($(this).val()=="project")
					{
						//img hide and show
						$("#img_from_date").hide();
						$("#img_to_date").hide();
						$("#show_disable_form").show();
						$("#show_disable_to").show();
						//input box hide and show
						$("#d_m_y_first").show();
						$("#d_m_y_second").show();
						$("#m_y_first").hide();
						$("#m_y_second").hide();
						$("#from_date_m").attr("disabled", "disabled"); 
						$("#to_date_m").attr("disabled", "disabled"); 
						$("#from_date").attr("disabled", "disabled"); 
						$("#to_date").attr("disabled", "disabled"); 
						$("#from_date").removeClass();
						$("#to_date").removeClass(); 
						$("#from_date").addClass("date-input bc_grey");
						$("#to_date").addClass("date-input bc_grey"); 
					}	
					
				 
				});
			 
			 
			 
			  });	 
	 
 function mousedown_tds_button_pur(obj){
obj.style.backgroundPosition ='0px -42px';
obj.firstChild.style.backgroundPosition ='right -42px';
}
function mouseup_tds_button_pur(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

 </script> 
 
 
 <script type="text/javascript">
  $(function () {
	  $('#to_date_m').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
  });
  
  $(function () {
	  $('#from_date_m').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
  });
  
  
</script>
