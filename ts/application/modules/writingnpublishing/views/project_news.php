<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php //$this->load->view('top_banner');?>
<?php

//$news_array = search_nested_arrays($news, "elements");
$reviews_array = search_nested_arrays($reviews, "elements");
		
?>
<div class="row">
	<div class="cell bdr_brown10 global_shadow bg_white ml40 width_420">
	 <ul id="tabs_link" class="wp_news_tab">
		<li id="tab01" class="wp_tab width_80 wp_tab_selected "> News </li>
		<!--news_box_tab-->
		<li id="tab02" class="wp_tab width_100 "> Reviews </li>
		<!--review_box_tab-->
      </ul>
      
       <div class="news_content_wp" id="tab_content">
              <!--news_content_box-->
              <div class="pl10 pr10 pb10 pt5" id="tab1" >
                  <div id="slider2" class="slider wp_news_scroll_btn_box"> 
                  <a class="buttons next" href="#"></a><a class="buttons prev mr3" href="#"></a>
                    <div class="viewport wp_news_scroll_container">
                      <ul class="overview">
						
						<?php
						//print_r($news_array);die;
						$newsCounter =0;
						$openLi ='<li>';
						$closeLi ='</li>';
						foreach($news_array as $countNews => $newsDetail){ 
							$userInfo = showCaseUserDetails($newsDetail->projuserid);
							$imgDetail = getMediaDetail(@$newsDetail->fileId);				
				
							if(is_array($imgDetail) && !empty($imgDetail))
							{
								$thumbImgPath = $imgDetail[0]->filePath;
								$thumbImgName = $imgDetail[0]->fileName;
							}else
							{
								$thumbImgPath = '';
								$thumbImgName = '';
							}							
							$thumbFinalImg = getImage(@$thumbImgPath.'/'.@$thumbImgName,$this->config->item('defaultNewsImg'));
							
						$newsCounter++;
						if($newsCounter ==1) echo $openLi;
						switch ($newsCounter)
						{
						  case 1:
						  ?>
							  <div class="wp_news_top_box">
							  <div class="wp_news_heading_first"><?php echo getSubString($newsDetail->title,30);?></div>
							  <div class="wp_news_thumb Fleft"><div class="AI_table">
								  <div class="AI_cell"><img class="max_w138_h96" src="<?php echo $thumbFinalImg;?>" /></div></div></div>
							  <div class="width_252 Fleft ml8">
								<div class="wp_news_postedby mt_minus_2"><?php echo $userInfo['userFullName'];?></div>
								<div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->createdDate));?></div>
								<div class="clr_555"><?php echo getSubString($newsDetail->title,100);?></div>
							  </div>
							  
							  </div>
							   <div class="clear seprator_13"></div>
						  <?php
						  break;
						  case 2:
						  ?>
						  <div class="cell bdr_Rgrey20per pr10">
                            	<div class="wp_news_left_box bdr_Bgrey20per">
                                <div class="wp_news_heading_second"><?php echo getSubString($newsDetail->title,30);?></div>
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="clr_555 pt15"><?php echo getSubString($newsDetail->title,100);?></div></div>
                                <div class="seprator_10"></div>
                            
						  <?php
						  break;
						  case 3:
						  ?>
						   <div class="wp_news_left_box">
                                <div class="wp_news_heading_second"><?php echo getSubString($newsDetail->title,30);?></div>
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="clr_555 pt15"><?php echo getSubString($newsDetail->title,100);?></div></div>
                            </div>
						  <?php
						break;
						case 4:
						?>
						<div class="cell pl13">
                            	<div class="wp_news_right_box ">
                                <div class="wp_news_heading_second"><?php echo getSubString($newsDetail->title,30);?></div>
 
                                <div class="wp_news_postedby"><?php echo $userInfo['userFullName'];?></div> 
                                <div class="wp_news_date pb18"><?php echo date("d F Y", strtotime($newsDetail->modifyDate));?></div>
                                <div class="wp_news_thumb_right"><div class="AI_table">
                              <div class="AI_cell"><img class="max_w171_h107" src="<?php echo $thumbFinalImg;?>" /></div></div></div>
                                <div class="clr_555 pt15"><?php echo getSubString($newsDetail->title,100);?></div></div>
                                <div class="seprator_10"></div>
                                
                            </div>                     
                         <div class="clear"></div>
						<?php
						break;
						
						}
						if($newsCounter>4) {$newsCounter=0;echo $closeLi;}		
					}
					?>
						
					
					  </ul>
					</div><!-- End viewport wp_news_scroll_container-->
				</div><!-- End slider2 -->
			 </div><!-- End tab1 -->
		</div><!-- End news_content_wp -->
		<div class="pl10 pr10 pb10 pt5" id="tab2" style="display:none;">
                  <div id="slider1" class="slider wp_news_scroll_btn_box"> <a class="buttons next" href="#"></a><a class="buttons prev mr3" href="#"></a>
                    <div class="viewport wp_news_scroll_container">
                      <ul class="overview">
						  <li>
						 <?php 
						 foreach($reviews_array as $countReviews => $ReviewsDetail) 
								echo '<pre />REVIEWS';		
						?>
						 
						</li>
					</ul>
					</div><!-- End viewport wp_news_scroll_container-->
				</div><!-- End slider2 -->
			 </div><!-- End tab1 -->
	
	</div><!-- End cell bdr_brown10 global_shadow bg_white ml40 width_420 -->
	 <div class="cell">
         <div class="bdr_brown10 global_shadow bg_white ml20 width_420">
			 <li>
			 <?php
				echo '<pre />Latest';
				
			 ?>
			 </li>
		</div><!-- End bdr_brown10 global_shadow bg_white ml20 width_420 -->
	
	 <div class="seprator_7"></div>
     <div class="bdr_brown10 global_shadow bg_white ml20 width_420">
		 <?php
			echo '<pre />Latest';				
		?>
	 </div><!-- End bdr_brown10 global_shadow bg_white ml20 width_420 -->  	
	 </div><!-- End cell -->		  
</div><!-- End row -->
<div class="row seprator_40"></div>
<div class="clear"></div> 
<?php
// recursive search for key in nested array, also search in objects!!
	// returns: array with "values" for the searched "key"
	function search_nested_arrays($array, $key){
		if(is_object($array))
			$array = (array)$array;
	   
		// search for the key
		$result = array();
		foreach ($array as $k => $value) {
			if(is_array($value) || is_object($value)){
				$r = search_nested_arrays($value, $key);
				if(!is_null($r))
					array_push($result,$r);
			}
		}
	   
		if(array_key_exists($key, $array))
			array_push($result,$array[$key]);
	   
	   
		if(count($result) > 0){
			// resolve nested arrays
			$result_plain = array();
			foreach ($result as $k => $value) {
				if(is_array($value))
					$result_plain = array_merge($result_plain,$value);
				else
					array_push($result_plain,$value);
			}
			return $result_plain;
		}
		return NULL;
	}
	
?>
<script type="text/javascript">

/**/

$('#tab01').click(function(){
										   
		$(this).addClass('wp_tab_selected ');	
		$(this).siblings().removeClass('wp_tab_selected');
		$('#tab1').css('display','block');
		$('#tab2').css('display','none');
	
		
		 })


$('#tab02').click(function(){
										   
		$(this).addClass('wp_tab_selected ');	
		$(this).siblings().removeClass('wp_tab_selected');
		$('#tab1').css('display','none');
		$('#tab2').css('display','block');
	
		
		 })
</script>
<script type="text/javascript">
/*tab function*/
	$(document).ready(function(){
			$('#slider1').tinycarousel();	
			$('#slider2').tinycarousel();
			//$('#slider3').tinycarousel();
			//$('#slider4').tinycarousel();
			//$('#slider5').tinycarousel();
			
		});
</script>

