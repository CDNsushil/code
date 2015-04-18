<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php 
		
$currentWorkDetail = array();

foreach ($work_array as $key =>$work_array_record) {

if($work_array_record->workId == $defaultWorkId) { 
$currentWorkDetail = $work_array_record;
}
}
if(count($currentWorkDetail)>0)	{
$this->load->view('common/strip',array('class'=>'cell shadow_wp strip_absolute_right left_801'));					
?>
 <!--Middle_column-->
        <div class="cell width_476 sub_col_1 pr10 pl10 bg_DarkGreen">
          <div class="seprator_10"></div>
			
					 <div class="Work_gredient_box pt13 pl20 pr11 pb20">
						<div class="font_opensansLight font_size26 lineH_32 width450px overflowHid"><?php echo @$currentWorkDetail->workTitle;?></div>
						<div class="seprator_20"></div>
						<?php if(@$currentWorkDetail->workCompany!='') { ?>
						<span class="cell width_100 clr_black font_size14"><b>Company</b></span><span class="cell font_size13"><?php echo @$currentWorkDetail->workCompany;?></span>
						<div class="clear seprator_20"></div>
						<?php } ?>
						<div class="text_alignC note font_size13"><?php echo @$currentWorkDetail->workShortDesc;?></div>
					  </div>
					 <div class="seprator_7"></div>
					  <!--box-->
					  <div class="Work_gredient_box pt13 pl20 pr11 pb20">
						<div class="clr_black font_size14"><b>Description</b></div>
						<div class="clear seprator_10"></div>
						<div class="font_size13">
						  <p><?php echo @$currentWorkDetail->workDesc;?></p>
						</div>
					  </div>
					  <div class="seprator_7"></div>
					   <!--box-->
					   <?php if( @$currentWorkDetail->workTypeDesc !='') { ?>				  
						  <div class="Work_gredient_box pt13 pl20 pr11 pb20">
							<div class="clr_black font_size14"><b>Job Requirements</b></div>
							<div class="clear seprator_10"></div>
							<div class="font_size13 NIC">
							  <p><?php echo @$currentWorkDetail->workTypeDesc;?></p>
							</div>
						  </div>
						  <!--box-->
					  <?php } ?>
					  
			<?php 
		   
			   //LOAD RELATED PROMO IMAGES
			   echo $this->load->view('promo_images');
		   
		   ?>

        
         <div class="seprator_18"></div>
          <div class="scroll_box darkGrey_bg pt7 pb7 bdr_d2d2d2">
            <div class="row pl20 pr20">
                    <div class="tds-button01 cell"> <a onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)"><span>
                <div class="btn_email_icon"></div>
                <div class="Fright">Email</div>
                </span></a> </div>
                    <div class="tds-button01 cell "> <a onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)"><span>
                <div class="btn_share_icon"></div>
                <div class="Fright">Share</div>
                </span></a> </div>
                <div class="tds-button01 cell "> <a onmousedown="mousedown_tds_button01(this)" onmouseup="mouseup_tds_button01(this)"><span>
                <div class="btn_link_icon"></div>
                <div class="Fright">Short Link</div>
                </span></a> </div>
                
                
                <?php $this->load->view('craves/craveView',array('elementId'=>$defaultWorkId,'entityId'=>$workEntityId));?>
                <div class="clear"></div>
                </div>     
          </div>
          <div class="clear seprator_18"></div>
        </div>
        <!--right_column-->
        <div class="cell width_284 pl10 pr10 sub_col_2 bg_DarkGreen">
          <div class="mt10"></div>
          <!--right btn-->
          <div class="scroll_box darkGrey_bg global_shadow pt15 pb15 bdr_d2d2d2">
            <?php 
            if(strcmp(@$currentWorkDetail->isUrgent,'t')==0){
			$divWidth = 'width_116';
            $imgWidth =" max_w114_h171";
			}
            else{
			$divWidth = 'width_242';
            $imgWidth =" max_w240_h158";
			}
            ?>
            <div class="Fleft ml20 <?php echo $divWidth;?>">
              <div class="AI_table">
                <div class="AI_cell">
					<?php $thumbImg = getImage(@$currentWorkDetail->filePath.'/'.@$currentWorkDetail->fileName,''); ?>
					<img border="0" src="<?php echo $thumbImg;?>" class="wp_topimg_thumb  <?php echo $imgWidth; ?> bdr_d2d2d2"></div>
              </div>
            </div>
            <?php 
            //IF THE CURRENT WORK IS URGENT THEN WILL SHOW THE RED BUTTON ELSE NOT
         
            if(strcmp(@$currentWorkDetail->isUrgent,'t')==0) { ?>
            <div class="Fright mr14"><img src="<?php echo base_url('images/frontend/urgent_tag.png');?>"></div>
            <? } ?>
            <div class="clear"></div>
            <div class="ml20 mr20 mt25">
              <div class="font_opensansSBold clr_white ">
                <div class="summery_posted_wrapper bdr_T666666"><span class="cell width_90 font_opensans pl16"><?php echo $this->lang->line('langauage');?></span> <span class="cell pl16"><?php echo getLanguage(@$currentWorkDetail->workLang1);?></span> </div>
                <div class="summery_posted_wrapper bdr_T666666"><span class="cell width_90 font_opensans pl16"><?php echo $this->lang->line('country');?></span> <span class="cell pl16"><?php echo getCountry(@$currentWorkDetail->workCountryId);?></span> </div>
                <!--summery_posted_date_wrapper--->
                <div class="summery_posted_wrapper bdr_T666666"><span class="cell width_90 font_opensans pl16"><?php echo $this->lang->line('workCity');?></span> <span class="cell pl16"><?php echo getSUbString(@$currentWorkDetail->workCity,20);?></span> </div>
                <div class="summery_posted_wrapper bdr_T666666"><span class="cell width_90 font_opensans pl16"><?php echo $this->lang->line('Date');?></span> <span class="cell pl16"><?php echo date("d F Y", strtotime(@$currentWorkDetail->workPublisheDate));?></span> </div>
                <?php if( @$currentWorkDetail->workExperiece=='t'){?>
                <div class="summery_posted_wrapper bdr_T666666 "><span class="cell width_90 font_opensans pl16"><?php echo $this->lang->line('workExperience');?></span></div>
                <?php } else {?>
                <div class="summery_posted_wrapper bdr_T666666 "><span class="cell width_90 font_opensans pl16"><?php echo $this->lang->line('workRemuneration');?></span> <span class="cell pl16"><?php echo @$currentWorkDetail->workRemuneration; echo  (@$currentWorkDetail->workRenumUnit != '')? '/'.@$currentWorkDetail->workRenumUnit:@$currentWorkDetail->workRenumUnit;?></span> </div>
                <?php } ?>
              </div>
              <div class="seprator_10 bdr_T666666 clear"></div>
              
<div class="EM_view_crave_box pl15">
	<?php
	$LogSummarywhere=array(
					'entityId'=>$workEntityId,
					'elementId'=>$defaultWorkId
			);
			$resLogSummary=getDataFromTabel('LogSummary', 'craveCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
			if($resLogSummary){
				$resLogSummary=$resLogSummary[0];
				$craveCount=($resLogSummary->craveCount);
			}else{
				$craveCount=0;
			}
			
			$cravedALL='';
			$loggedUserId=isloginUser();
			if($loggedUserId > 0){
				$where=array(
								'tdsUid'=>$loggedUserId,
								'entityId'=>$workEntityId,
								'elementId'=>$defaultWorkId
							);
				$countResult=countResult('LogCrave',$where);
				$cravedALL=($countResult>0)?'cravedALL':'';
			}else{
				$cravedALL='';
			}
	?>
	<div class="cell height_27 pl36 icon_crave4_blog crave craveDiv<?php echo $workEntityId.''.$defaultWorkId?> <?php echo $cravedALL;?>">Craves <span class="inline"><?php echo $craveCount;?></span></span></div>
	
	<?php $this->load->view('rating/ratingView',array('elementId'=>$defaultWorkId,'entityId'=>$workEntityId,'ratingClass'=>'cell pt5 width_auto pl25 mt5'));?>
	<div class="clear"></div>
	<div class="icon_view3_blog float_none height_27 pl36"> Views 17</div>
	</div>

	<div class="mt15 Fright"><a onmousedown="mousedown_apply_btn(this)" onmouseup="mouseup_apply_btn(this)" class="Apply_big_btn">Apply Now</a>
 
  </div>
	 <div class="clear"></div>
</div>
</div>
<!--Extract box-->
<div class="seprator_25"></div>
<?php 		   
   //LOAD RELATED WORK VIDEO
   echo $this->load->view('promo_video');
?>
<div class="seprator_25"></div>
<?php 		
   //LOAD ALL WORK DETAIL
   echo $this->load->view('all_works');		   
?>		
</div>

<div class="cell advert_column sub_col_3">
  <div class="seprator_5"></div>
	<div class="ad_box ml11 mt10 mb10"><img src="<?php echo base_url('images/advert_img.jpg');?>" class="max_w159_h593"></div>
</div>
<?php 
}
else {
echo '<div class=" pt13 pl20 pr11 pb20 orange width950px" align="center">'.$this->lang->line('noRecordFound').'</div>';
}
?>
        <!--cell_width_284-->
<script type="text/javascript">
/*tab function*/
	$(document).ready(function(){
			$('#slider1').tinycarousel({ axis: 'y', display: 4, groupStep:1});	
			$('#slider2').tinycarousel({ axis: 'y', display: 3});
			$('#slider3').tinycarousel({ axis: 'y', display: 3});
			$('#slider4').tinycarousel({ axis: 'y', display: 3});
			$('#slider5').tinycarousel({ axis: 'y', display: 3});
			function resetTabs(){
    $("#tab_content > div").hide(); //Hide all content
    $("#tabs_link li").attr("class",""); //Reset id's      
}

var myUrl = window.location.href; //get URL
var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // For mywebsite.com/tabs.html#tab2, myUrlTab = #tab2     
var myUrlTabName = myUrlTab.substring(0,4); // For the above example, myUrlTabName = #tab

(function(){
    $("#tab_content > div").hide(); // Initially hide all content
    $("#tabs_link li:first").attr("class","z_index_3"); // Activate first tab
    $("#tab_content > div:first").fadeIn(); // Show first tab content
    
    $("#tabs_link li").on("click",function(e) {
        e.preventDefault();
        if ($(this).attr("class") == "z_index_3"){ //detection for current tab
         return       
        }
        else{             
        resetTabs();
        $(this).attr("class","current"); // Activate this
        $($(this).attr('name')).fadeIn(); // Show content for current tab
			
			if ($(this).attr("id") == "tab01"){ //detection for current tab
				
				$("#tab01").attr("class","z_index_3");
				$("#tab02").attr("class","z_index_2");
				$("#tab03").attr("class","z_index_1");
         		       
        		}
			else if ($(this).attr("id") == "tab02"){ //detection for current tab
				
				$("#tab01").attr("class","z_index_1");
				$("#tab02").attr("class","z_index_3");
				$("#tab03").attr("class","z_index_2");
         		       
        		}
			else {
				$("#tab01").attr("class","z_index_1");
				$("#tab02").attr("class","z_index_2");
				$("#tab03").attr("class","z_index_3");
			
				}
        }
    });

   
})()

	for (i = 1; i <= 2; i++) {
		
		  if (myUrlTab == myUrlTabName + i) {
			// alert(myUrlTab);
			  resetTabs();
			  $("a[name='"+myUrlTab+"']").attr("class","current"); // Activate url tab
			  $(myUrlTab).fadeIn(); // Show url tab content  
			// alert(myUrlTabName +'0'+i);
			  $(myUrlTabName +'0'+i).attr("class","z_index_3");      
		  }	   
	}
});
			
</script>
