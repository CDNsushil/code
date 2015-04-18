<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row content_wrap blog_wrap" >
   <div class="bg_f3f3f3 fl width100_per  title_head">
      <h1 class="fs34 letrP-1 opens_light mb0  fl  textin30">Sales</h1>
        <?php 
        
        //-------shopping cart menu navigation start----------//
            echo modules::run('cart/shoppingcartdata');
        //-------shopping cart menu navigation start----------//
         ?>  
   </div>
    <form action="<?php base_url('cart/sales_information')?>" method="get" name="search_sales_info" id="search_sales_info"> 
        <div class="m_auto display_table width875">
          <div class="sap_30"></div>
          <ul class="dis_nav sale_nav fs16 mt5 fl  ">
             <li > <a href="<?php echo base_url('cart/mysales')?>">Sales</a> </li>
             <li class="active">
                <a href="<?php echo  base_url('cart/salesinformation')?>">Sales Information</a>
                <ul class="fs14 sub_sale subClearBorderLeft ">
                   <li class="active"><a href="<?php echo  base_url('cart/salesinformation')?>">Sales Information</a></li>
                   <li><a href="javascript:void(0)" class="comming_soon">Items Views</a></li>
                </ul>
             </li>
          </ul>
          <div class="fr calnder_sale">
             <div class="row">
                <div class="to_wrap  fl">
                   <label for="from" class=" fl pt5 pr10">Show by</label>
                   <div class="fl position_relative sale_selct width82">
                        <?php
                            $showArray  = array(
                            'day'       => 'Day',
                            'month'     => 'Month',
                            'year'      => 'Year',
                            'project'   => 'Project'); 
                            $js  = 'id="show_by" class="selectBox height25 width82"';	  
                            echo form_dropdown('show_by', $showArray, $show_by, $js);
                        ?>
                   </div>
                </div>
                
                <?php
                    $cls             =  ($show_by=='day' || $show_by=='month' || $show_by=='project')?" ":"dn";
                    $cls_disable     =  ($show_by=='day' || $show_by=='month')?" ":"disabled";
                    $cls_new         =  ($show_by=='year')?"":"dn";
                    $cls_new_disable =  ($show_by=='year')?"":"disabled";

                    $cls_show        =  ($show_by=='project')?"bc_grey":"";
                    $cls_disable     =  ($show_by=='project')?"disabled":"";
                    $img_cls_show    =  ($show_by=='project')?"":"dn";
                    $img_cls_hide    =  ($show_by=='project')?"dn":"";
                ?>
                
                <!---day wise calendar start--->
                    <div class="day_wise_calendar fl <?php echo $cls; ?>">
                        <div class="to_wrap fl">
                           <label for="from" class="pl10 pr12">From</label>
                             <input  <?php echo $cls_disable ?> type="text" name="from_date" id="from_date" value="<?php echo $from_date ?>" placeholder="DD  MM  YY" class="calendar_picker unselcted_cal <?php echo $cls_show ?>"  readonly>
                        </div>
                        <div class="to_wrap fl">
                           <label for="to" class="pl15 pr12">To</label>
                            <input <?php echo $cls_disable ?> type="text"  dateGreaterThan="#from_date" value="<?php echo $to_date ?>" title="Enter correct date." name="to_date" id="to_date" placeholder="DD  MM  YY" class="calendar_picker unselcted_cal <?php echo $cls_show ?>" readonly>
                        </div>
                    </div>
                <!---day wise calendar end--->
                
                
                <!---month wise calendar start--->
                    <div class="month_wise_calendar fl <?php echo $cls_new; ?>">
                        <div class="to_wrap fl">
                           <label for="from" class="pl10 pr12">From</label>
                           <input <?php echo $cls_new_disable ?>  type="text" name="from_date" id="from_date_m" value="<?php echo $from_date_1 ?>" class="unselcted_cal"  placeholder="MM  YY"  readonly>
                        </div>
                        <div class="to_wrap fl">
                           <label for="to" class="pl15 pr12">To</label>
                            <input  <?php echo $cls_new_disable ?> type="text"  monthYearGreaterThan="#from_date_m"  value="<?php echo $to_date_1 ?>" title="Enter correct date." name="to_date" id="to_date_m" placeholder="MM  YY" class="unselcted_cal "  readonly>
                        </div>
                    </div>
                <!---month wise calendar end--->
               
                
                <button class="height32 white_button ml15 fl lh_5">Refresh</button>
             </div>
          </div>
          <div class="sap_35"></div>
          
            <div id="showInbox"> 
                <?php 
                    if($show_by!="project"){
                        $this->load->view("sales_info_without_pro_new");
                    }else{
                        $this->load->view("sales_info_with_pro_new");
                    }
                ?>
            </div>
        </div>
        
    </form>
</div>

<script type="text/javascript">
    
    $(document).ready(function(){
        
        $("#search_sales_info").validate({});

        $("#show_by").change(function() { 
         
            if($(this).val()=="month" || $(this).val()=="day")
            {
                //input box hide and show
                $(".day_wise_calendar").show();
                $(".month_wise_calendar").hide();
                $("#from_date_m").attr("disabled", "disabled"); 
                $("#to_date_m").attr("disabled", "disabled"); 
                $("#from_date").removeAttr("disabled"); 
                $("#to_date").removeAttr("disabled"); 
                $("#from_date").removeClass('bc_grey selcted_cal').addClass('unselcted_cal');
                $("#to_date").removeClass('bc_grey selcted_cal').addClass('unselcted_cal'); 
                
            }
            
            
            if($(this).val()=="year")
            {
                $(".day_wise_calendar").hide();
                $(".month_wise_calendar").show();
                $("#from_date").attr("disabled", "disabled"); 
                $("#to_date").attr("disabled", "disabled"); 
                $("#from_date_m").removeAttr("disabled"); 
                $("#to_date_m").removeAttr("disabled"); 
                $("#from_date_m").removeClass('bc_grey selcted_cal').addClass('unselcted_cal');
                $("#to_date_m").removeClass('bc_grey selcted_cal').addClass('unselcted_cal')
            }
            
            
            if($(this).val()=="project")
            {
                //input box hide and show
                $("#img_from_date").show();
                $("#img_to_date").show();
                $("#from_date_m").attr("disabled", "disabled"); 
                $("#to_date_m").attr("disabled", "disabled"); 
                $("#from_date").attr("disabled", "disabled"); 
                $("#to_date").attr("disabled", "disabled"); 
                $("#from_date_m").addClass('bc_grey selcted_cal').removeClass('unselcted_cal');
                $("#to_date_m").addClass('bc_grey selcted_cal').removeClass('unselcted_cal'); 
                $("#from_date").addClass("bc_grey selcted_cal").removeClass('unselcted_cal');
                $("#to_date").addClass("bc_grey selcted_cal").removeClass('unselcted_cal'); 
            }
        });
    });
</script> 
 

<script type="text/javascript">
    $(function () {
        $('#to_date_m').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
    });

    $(function () {
        $('#from_date_m').monthpicker({selectedYear: <?php echo date('Y')?>, startYear: 1925, finalYear: <?php echo date('Y')?>});
    });
</script>
