<td class="rc_purple" valign="top">
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
$currentMethod = $this->router->method;
?>
<?php if(count($upcomingRecord)>0) { 
	
	if(!isset($userInfo)){
		$userInfo =showCaseUserDetails($upcomingRecord['tdsUid']);
	}
	$seller_currency=$userInfo['seller_currency'];
	$seller_currency=($seller_currency>0)?$seller_currency:0;
	$currencySign=$this->config->item('currency'.$seller_currency);
	$sectionId=$this->config->item('upcomingSectionId');
	
	$viewCount=0;
	$craveCount=0;
	$ratingAvg=0;
		$LogSummarywhere=array(
					'entityId'=>$entityId,
					'elementId'=>$upcomingRecord['projId']
		);
		$resLogSummary=getDataFromTabel('LogSummary', 'craveCount,ratingAvg,viewCount',  $LogSummarywhere, '', $orderBy='', '', 1 );
		if($resLogSummary)
		{
			$resLogSummary = $resLogSummary[0];
			$viewCount = $resLogSummary->viewCount;
			$craveCount = $resLogSummary->craveCount;
			$ratingAvg = $resLogSummary->ratingAvg;
		}else
		{
			$viewCount=0;
			$craveCount=0;
			$ratingAvg=0;
		}
		$ratingAvg=roundRatingValue($ratingAvg);
		$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';			
		$cravedALL='';
		$loggedUserId=isloginUser();
		if($loggedUserId > 0){
			$where = array(
						'tdsUid'=>$loggedUserId,
						'entityId'=>$entityId,
						'elementId'=>$upcomingRecord['projId']
					);
			$countResult = countResult('LogCrave',$where);
			$cravedALL = ($countResult>0)?'cravedALL':'';
		}else $cravedALL='';
      //echo '<pre />promoImages:';print_r($promoImages);
      if(!empty($promoImages))
	  {
		echo '<div id="popupImages" class="dn">';
		echo '<div class="popup_box">';
		echo '<div class="popup_close_btn" id="close-popup" onclick="$(this).parent().trigger(\'close\');"></div>';
			echo '<div id="popupImagesContainer" class="" >';				
			echo '</div>';
		echo '</div>';
		echo '</div>';
	  }//End If Empty 
	  ?>
        <div class="row mt14">
          <div class="upcoming_center_title ml24 "><?php echo $upcomingRecord['projTitle'];?></div>
          <div class="clear"></div>
        </div>
        <div class="seprator_14"></div>
        <!--gallery box-->
        <?php        
		if(!empty($promoImages))
		{
		?>
        <div class="up_grey_box ml12 mr12 pl13 pt5 pb4">
			 <div class="slider" id="slider1"> 
			 <a href="#" class="buttons prev disable"></a>
			<?php echo Modules::run("upcomingfrontend/getPromoImages", $promoImages);?>
			 <a href="#" class="buttons next"></a> 
			</div>
        </div>
        <div class="seprator_16"></div>
        
        <?php }//End If Empty ?>
		<div class="position_relative">
		  <div class="cell shadow_wp strip_absolute_right">
            <!-- <img src="images/strip_blog.png"  border="0"/>-->
            <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody><tr>
                <td height="271"><img src="<?php echo base_url();?>images/shadow-top.png"></td>
              </tr>
              <tr>
                <td class="shadow_mid">&nbsp;</td>
              </tr>
              <tr>
                <td height="271"><img src="<?php echo base_url();?>images/shadow-bottom.png"></td>
              </tr>
            </tbody></table>
            <div class="clear"></div>
          </div>
          <div class="row">
            <div class="cell width_476 mr8 ml12">
				<?php 
				  echo $this->load->view('further_desc',array('ratingAvg'=>@$ratingAvg,'viewCount'=>@$viewCount,'craveCount'=>@$craveCount)); 
				  ?>
				<!-- ADS FOR CONTENT -->
		
			<!-- Div for 468x60 advert display -->
			<div class="row width470px ma mt14" id="advert468_60"><?php 
				if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)) {
					//Manage left side content bottom advert
					$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'3'));
					if(!empty($bannerRhsData)) {
						$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'3','sectionId'=>$advertSectionId));
					} else {
						$this->load->view('common/adv_content_bot'); 
					} 
				} else {
					$this->load->view('common/adv_content_bot');  
				}?>
			</div>  
			
			<div class="clear"></div>  
			<div class="seprator_20"></div>
				  				 
				<?php  if(!empty($promoMedias))	echo $this->load->view('promo_media'); 		   
			   ?>
			
  			</div><!-- End width_476 -->  
<div class="cell width_284 pl10 pr10 mb25">  
<div class="seprator_14"></div>
<div class="row recent_box_wrapper01 mr24 p10">	
	 <div class="cell pt2 icon_crave4_blog crave craveDiv<?php echo $entityId.''.$upcomingRecord['projId']?> <?php echo $cravedALL;?>"><?php echo $this->lang->line('craves'); ?> <span class="inline"><?php echo $craveCount;?></span></span></div>	
	 <div class=" cell padding_left16 pt8 rateDiv<?php echo $entityId.''.$upcomingRecord['projId']?>">			 
			<img  src="<?php echo base_url($ratingImg);?>" />
	 </div>	 
	<div class="clear"></div>
	<div class="icon_view5_blog mt4"><?php echo $this->lang->line('project_views').' '.@$viewCount;?></div>
</div>
<div class="seprator_14"></div>
	<?php 
		$tableInfo=array(
		'entityId'=>$entityId,
		'elementId'=>$upcomingRecord['projId'],
		'tableName'=>array('AddInfoNews','AddInfoInterview'),
		'sections'=>array($this->lang->line('NEWS'),$this->lang->line('INTERVIEWS')),
		'orderBy'=>array('news','interv'),
		'sectionBgcolor'=>'rightBoxBG',
		'largeTab'=>1
		);
		echo Modules::run("additionalInfo/additionalInfoList", $tableInfo);
	?>
             <div class="row summery_right_archive_wrapper showcase_link_hover">
                <h1 class="sumRtnew_strip01" style="color:#FFFFFF;"><?php echo $this->lang->line('upcomingandevent');?></h1>
                <ul class="sraw_new">
				<?php 
				 
				 $URLuserId=$this->uri->segment(4);				 
				 if(!isset($URLuserId) || $URLuserId=='') $URLuserId = isLoginUser();				 
				 $currentUpcomingId = end($this->uri->segments);				 
				$i=0;
				foreach($upcomingListing as $up=>$upcomingListRecord)
				{
					$i++;
					if(!$upcomingprojId > 0 && ($i==1)){
						$upcomingprojId = $upcomingListRecord['projId'];
					}
						
						$href=($currentMethod=='preview')?'/upcomingfrontend/preview/'.$URLuserId.'/'.$upcomingListRecord['projId'].'/upcoming/':'/upcomingfrontend/upcoming/'.$URLuserId.'/'.$upcomingListRecord['projId'];
						$href=base_url(lang().$href);
						$class = ' white ';
						$defaultClass = '';
						
						if((!isset($currentUpcomingId) || $currentUpcomingId =='') && $up==0) $defaultClass=' highlight';
						if($upcomingListRecord['projId'] == $upcomingprojId) 
						{
							$href = 'javascript:void(0);';
							$class = 'highlight';
						}
				?>
                <li class="sraw_new"><a href="<?php echo $href;?>" class=" <?php echo $class.$defaultClass;?>"><?php echo getSubString($upcomingListRecord['projTitle'],30);?></a></li>
				<?php } //foreach End ?>
                </ul>
              </div>
             <?php
             if(isset($upcomingRecord['askForDonation']) && $upcomingRecord['askForDonation']=='t'){
				?>
				  <div class="ml34 mr39">
					  <div class="line5"></div>
					  <div class="seprator_10"></div>
					  <div class="Fright">
						  <?php 
							  $donorDetail=array('entityId'=>$entityId,'elementId'=>$upcomingRecord['projId'],'projId'=>$upcomingRecord['projId'],'sectionId'=>$sectionId,'ownerId'=>$upcomingRecord['tdsUid'],'seller_currency'=>$seller_currency);
							  $this->load->view("shipping/donate_frontend_view",$donorDetail);  
						  ?>
					 </div>
				</div>
				<?php
			}?>
		
		<div class="clear seprator_20"></div>			  
		
		<!-- Div for 250x250 advert display-->
		 <div class="ad_box_shadow width250px mb20" id="advert250_250"><?php 
			if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
				//Manage right side forum advert
				$bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'1'));
				if(!empty($bannerRhsData)) {
					$this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'1','sectionId'=>$advertSectionId));
				} else {
					$this->load->view('common/adv_rhs_forum');
				}
			} else {
				$this->load->view('common/adv_rhs_forum');
			}?>
		</div>
		
       	</div>

 			</div><!-- row end -->   
 			  
<div class="clear"></div>  
      
<div class="seprator_10"></div>

</div><!-- End position_relative -->

<?php } else { 
	echo '<div class="sub_col_middle ml12 mr12 mt14 pl13 pt5 pb4 orange_color" align="center">No Records Found!</div>';
	} 

	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//manage auto advert params and js methods
		echo $advertChangeView;
	}
?>

<script type="text/javascript">
/*tab function*/
	$(document).ready(function(){
			$('#slider1').tinycarousel({ axis: 'y', display: 2});	
			$('#slider2').tinycarousel({ axis: 'y', display: 3});
			$('#slider3').tinycarousel({ axis: 'y', display: 3});
	});
</script>
</td>
