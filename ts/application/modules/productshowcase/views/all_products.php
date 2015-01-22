<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 

//THREE TYPE OF PRODUCTS
if(!empty($product_array)){
$freesale_array = array();
$wanted_array = array();
$free_array = array();

$userId = @$this->uri->segment(4)>0?$this->uri->segment(4):isLoginUser();

$freesale = '1';
$wanted = '2';
$free = '3';

$free_count =0;
$freesale_count =0;
$wanted_count =0;


//SEPEARTED WORK ON THE BASIS OF TIS TYPE
//echo '<pre />';print_r($product_array);
foreach ($product_array as $key =>$product_array_record) {
	
	if($product_array_record->catId == $freesale) 
	{ 
		$freesale_array[$freesale_count]=$product_array_record;
		$freesale_count++;
	}
	else if($product_array_record->catId == $wanted)
	{
		$wanted_array[$wanted_count]=$product_array_record;	
		$wanted_count++;
	}
	else
	{
		$free_array[$free_count]=$product_array_record;
		$free_count++;
	}
}
/*
echo '<pre />';
print_r($freesale_array);
print_r($wanted_array);
print_r($free_array);
*/
$openLi = '<li>';  // Only assign once
$closeLi = '</li>';  // Only assign once

if((!isset($defaultproductId) || $defaultproductId =='') && $count_freesale_array==0) $defaultClass=' highlight';
$freesaleClass = '';	
$wantedClass = '';	
$freeClass = '';	

$myUrlTab='#tab4';

$currentClass=$this->router->class;
$currentMethod=$this->router->method;
?>
 <div class="row summery_right_archive_wrapper width_auto position_relative">
            <!--tabs start-->
            <div class="tabs_RShowcase showcase_link_hover">
              <ul id="tabs_link_1">
               <?php
                echo '<li class="z_index_3" name="#tab4" id="tab04"><a><span><span>'.$this->lang->line('sell').'</span></span></a></li>';
                echo '<li class="z_index_2" name="#tab5" id="tab05"><a><span><span>'.$this->lang->line('wanted').'</span></span></a></li>';
                echo '<li class="z_index_1" name="#tab6" id="tab06"><a><span><span>'.$this->lang->line('freeStuff').'</span></span></a></li>';
               ?>
                </ul>
              <div class="clear"></div>
            </div>
            <!--tabs ends-->
            <!-- tabbox1 start-->
            <div class="global_shadow bdr_non" id="tab_content_1">
              <!--content box-->
              
              <div id="tab4" class="scroll_box innershadw darkGrey_bg bdr_d2d2d2" style="display: block;">
                <div class="slider mt3 scroll_light_btn" id="sliderforsale"> <a href="#" class="buttons prev disable"></a>
                  <div class="viewport scroll_container02">
                    <ul class="overview height480 top0px min_w270">
                      <?php
						
						$currentTab1 = '#tab4#top';
						
						$slider2StartFrom = 1;
						if(!empty($freesale_array)){ 
						
						foreach($freesale_array as $count_freesale_array => $freesaleDetail){ 						
						
						$class = '';					
						$defaultClass = '';
						
						$freesaleDetailUrl=($currentMethod=='preview')?'/productshowcase/preview/'.$userId.'/'.$freesaleDetail->productId.'/works/':'/'.$currentClass.'/'.$currentMethod.'/'.$userId.'/'.$freesaleDetail->productId;
						$freesaleDetailUrl=base_url(lang().$freesaleDetailUrl);
							
						if($freesaleDetail->productId == $defaultproductId) 
						{
							$freesaleDetailUrl = 'javascript:void(0);';
							$freesaleClass = 'highlight';
							$slider2StartFrom = ceil(($count_freesale_array+1)/3);
							$myUrlTab='#tab4';
						}
						else $freesaleClass = '';
						
						$thumbImage = addThumbFolder(@$freesaleDetail->filePath.@$freesaleDetail->fileName,'_xs');				
						$freesaleThumbImg = getImage(@$thumbImage,$this->config->item('defaultProductForSale_xs'));
						
						//$freesaleThumbImg = getImage(@$freesaleDetail->filePath.@$freesaleDetail->fileName,$this->config->item('defaultProductForSale_s'));
						$borderClass="";
						//if($freesaleDetail->productExperiece=='t') $borderClass="borderOrange";
						//else $borderClass="";
						
						/*if(strcmp($freesaleClass,'hightlight')==0) echo '<script>$("#tab01").attr("class","z_index_3");$("#tab02").attr("class","z_index_2");
				$("#tab03").attr("class","z_index_1");</script>';*/	
						
						echo $openLi;				
						
					?>                   
                        <div class="row recent_box_wrapper01">
                          <div class="row">
                            <div class="cell recent_thumb01 thumb_absolute01"> <img border="0" class="minMax_w44_h60" src="<?php echo $freesaleThumbImg;?>" > </div>
                            <div class="cell ml55">
                              <div class="cell recent_two_line02 padding_left10 pt4 ptr" onclick="window.location.href='<?php echo $freesaleDetailUrl;?>'"> <span class="recent_short_title Fleft  <?php echo $freesaleClass;?> dash_link_hover"><?php echo getSubString($freesaleDetail->productTitle,22);?></span>
                              <span class="recent_short_txt clear"><?php  echo getSubString($freesaleDetail->productOneLineDesc,50); ?></span></div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="clear"></div>
                        </div>
                     
                     <?
						echo $closeLi;
					}//End Foreach
					}//If no free sale products
					else{
						echo $openLi;
						?>
						<div class="width260px height236px">
								<div class="AI_table">
									<div class="AI_cell"><img src="<?php echo base_url();?>images/toadsquare_gray_logo.png" ></div>
								</div>
						</div>
						<?php	
						echo $closeLi;
					}
				                       
					?>  
                    </ul>
                  </div>
                  <a href="#" class="buttons next"></a> </div>
              </div>
            	
              <div id="tab5" class="scroll_box innershadw darkGrey_bg" style="display: none;">
                <div class="slider mt3" id="sliderwanted"> <a href="#" class="buttons prev disable"></a>
                  <div class="viewport scroll_container02">
                    <ul class="overview height480 top0px min_w270">
                     <?php
						
						$currentTab2 = '#tab5#top';
						$slider3StartFrom = 1;
						if(!empty($wanted_array)){ 
						foreach($wanted_array as $count_wanted_array => $wantedDetail)
						{ 						
							
							$wantedDetailUrl=($currentMethod=='preview')?'/productshowcase/preview/'.$userId.'/'.$wantedDetail->productId.'/works/':'/'.$currentClass.'/'.$currentMethod.'/'.$userId.'/'.$wantedDetail->productId;
							$wantedDetailUrl=base_url(lang().$wantedDetailUrl);
						
							
							$thumbImage = addThumbFolder(@$wantedDetail->filePath.@$wantedDetail->fileName,'_xs');				
							$wantedThumbImg = getImage(@$thumbImage,$this->config->item('defaultProductWanted_xs'));
							
							//$wantedThumbImg = getImage(@$wantedDetail->filePath.@$wantedDetail->fileName,$this->config->item('defaultProductWanted'));
							
							$borderClass = "";
							if($wantedDetail->productId == $defaultproductId) 
							{
								$wantedDetailUrl = 'javascript:void(0);';
								$wantedClass = 'highlight';
								$slider3StartFrom=ceil(($count_wanted_array+1)/3);
								$myUrlTab='#tab5';
							}
							else $wantedClass = '';
							
							echo $openLi;
							
							/*if(strcmp($wantedClass,'hightlight')==0) echo '<script>$("#tab02").attr("class","z_index_3");$("#tab03").attr("class","z_index_2");
					$("#tab03").attr("class","z_index_1");</script>';*/
						?> 
					  
							<div class="row recent_box_wrapper01">
							  <div class="row">
								<div class="cell recent_thumb01 thumb_absolute01 "> <img border="0" class="minMax_w44_h60" src="<?php echo $wantedThumbImg;?>" > </div>
								<div class="cell ml55">
								  <div class="cell recent_two_line02 padding_left10 pt4 ptr" onclick="window.location.href='<?php echo $wantedDetailUrl;?>'"> <span class="recent_short_title Fleft <?php echo $wantedClass;?> dash_link_hover"><?php echo getSubString($wantedDetail->productTitle,22);?></span>
								  <span class="recent_short_txt clear"><?php  echo getSubString($wantedDetail->productOneLineDesc,50); ?></span></div>
								</div>
								<div class="clear"></div>
							  </div>
							  <div class="clear"></div>
							</div>
						 
						 <?
							echo $closeLi;
					}//End Foreach
				    }//If no wanted products
					else{
						echo $openLi;
						?>
						<div class="width260px height236px">
								<div class="AI_table">
									<div class="AI_cell"><img src="<?php echo base_url();?>images/toadsquare_gray_logo.png" ></div>
								</div>
						</div>
						<?php	
						echo $closeLi;
					}//else no wanted products
					?> 
                    </ul>
                  </div>
                  <a href="#" class="buttons next"></a> </div>
              </div>
          	
              <div id="tab6" class="scroll_box innershadw darkGrey_bg" style="display: none;">
                <div class="slider mt3" id="sliderfree"> <a href="#" class="buttons prev disable"></a>
                  <div class="viewport scroll_container02">
                    <ul class="overview height480 top0px min_w270">
                     <?php
						
						$currentTab3 = '#tab6#top';
						$slider4StartFrom = 1;
						if(!empty($free_array)){ 
						foreach($free_array as $count_free_array => $freeDetail)
						{ 				
							$thumbImage = addThumbFolder(@$freeDetail->filePath.@$freeDetail->fileName,'_xs');				
							$freeThumbImg = getImage(@$thumbImage,$this->config->item('defaultProductFree'));
							//$freeThumbImg = getImage(@$freeDetail->filePath.@$freeDetail->fileName,$this->config->item('defaultProductForSale'));
							
							$borderClass = "";
							if($freeDetail->productId == $defaultproductId) 
							{
								$freeDetailUrl = 'javascript:void(0);';
								$freeClass = 'highlight';
								$slider4StartFrom=ceil(($count_free_array+1)/3);
								$myUrlTab='#tab6';
							}
							else {
								$freeClass = '';
								
								$freeDetailUrl=($currentMethod=='preview')?'/productshowcase/preview/'.$userId.'/'.$freeDetail->productId.'/works/':'/'.$currentClass.'/'.$currentMethod.'/'.$userId.'/'.$freeDetail->productId;
								$freeDetailUrl=base_url(lang().$freeDetailUrl);
							
							}
							
							echo $openLi;
							
							/*if(strcmp($freeClass,'hightlight')==0) echo '<script>$("#tab03").attr("class","z_index_3");$("#tab02").attr("class","z_index_2");
					$("#tab01").attr("class","z_index_1");</script>';*/
						?> 
					   
							<div class="row recent_box_wrapper01">
							  <div class="row">
								<div class="cell recent_thumb01 thumb_absolute01"> <img border="0" class="minMax_w44_h60" src="<?php echo $freeThumbImg;?>" > </div>
								<div class="cell ml55">
								  <div class="cell recent_two_line02 padding_left10 pt4 ptr" onclick="window.location.href='<?php echo $freeDetailUrl;?>'"> <span class="recent_short_title Fleft  <?php echo $freeClass;?> dash_link_hover"><?php echo getSubString($freeDetail->productTitle,22);?></span>
								  <span class="recent_short_txt clear"><?php  echo getSubString($freeDetail->productOneLineDesc,50); ?></span></div>
								</div>
								<div class="clear"></div>
							  </div>
							  <div class="clear"></div>
							</div>
						 
						 <?
							echo $closeLi;
						}//End Foreach	
				    }//If no free products
					else
					{
						echo $openLi;
						?>
						<div class="width260px height236px">
								<div class="AI_table">
									<div class="AI_cell"><img src="<?php echo base_url();?>images/toadsquare_gray_logo.png" ></div>
								</div>
						</div>
						<?php	
						echo $closeLi;
					}                  
                ?> 
                    </ul>
                  </div>
                  <a href="#" class="buttons next"></a> </div>
              </div>
          
              <!--content box-->
              </div>
            <!-- tabbox3 end-->
        
          </div>
         
<?php } ?>

<script>
$(document).ready(function(){

	$('#sliderforsale').tinycarousel({ axis: 'y', display: 3, start:<?php echo $slider2StartFrom; ?>});	
	$('#sliderwanted').tinycarousel({ axis: 'y', display: 3, start:<?php echo $slider3StartFrom; ?>});	
	$('#sliderfree').tinycarousel({ axis: 'y', display: 3, start:<?php echo $slider4StartFrom; ?>});
		
	function resetTabs(){
		$("#tab_content_1 > div").hide(); //Hide all content
		$("#tabs_link_1 li").attr("class",""); //Reset id's      
	}
	
	var myUrl = window.location.href; //get URL
	var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // For mywebsite.com/tabs.html#tab2, myUrlTab = #tab2     
	var myUrlTab = '<?php echo $myUrlTab;?>';	
	//alert(myUrlTab);
	var myUrlTabName = myUrlTab.substring(0,4); // For the above example, myUrlTabName = #tab	

	(function(){
		
		$("#tab_content_1 > div").hide(); // Initially hide all content
		$("#tabs_link_1 li:first").attr("class","z_index_3"); // Activate first tab
		$("#tab_content_1 > div:first").show(); // Show first tab content
		
		$("#tabs_link_1 li").on("click",function(e) {
			e.preventDefault();
			if ($(this).attr("class") == "z_index_3"){ //detection for current tab
			 return       
			}
			else{             
			resetTabs();
			$(this).attr("class","current"); // Activate this
			$($(this).attr('name')).show(); // Show content for current tab
				
				if ($(this).attr("id") == "tab04") {//detection for current tab				
					$("#tab04").attr("class","z_index_3");
					$("#tab05").attr("class","z_index_2");
					$("#tab06").attr("class","z_index_1");         		       
				}
				else if ($(this).attr("id") == "tab05") {//detection for current tab				
					$("#tab04").attr("class","z_index_1");
					$("#tab05").attr("class","z_index_3");
					$("#tab06").attr("class","z_index_2");         		       
				}
				else {//detection for current tab
					$("#tab04").attr("class","z_index_1");
					$("#tab05").attr("class","z_index_2");
					$("#tab06").attr("class","z_index_3");			
				}
			}
		});	  
	})()
	
	for (i = 4; i <= 6; i++) {
		
		$(myUrlTabName +i).hide(); // Show url tab content
	
		if (myUrlTab == myUrlTabName + i) {
		
		resetTabs();
		 
		  $("a[name='"+myUrlTab+"']").attr("class","current"); // Activate url tab
		  $(myUrlTab).show(); // Show url tab content  
		  	//alert(i);
			if(i==4){
			 $("#tab04").attr("class","z_index_3");
			 $("#tab05").attr("class","z_index_2");
			 $("#tab06").attr("class","z_index_1");    
			}  
			  
			if(i==5){
			$("#tab04").attr("class","z_index_1");
			$("#tab05").attr("class","z_index_3");
			$("#tab06").attr("class","z_index_2");      
			}   
			 
			if(i==6){
			$("#tab04").attr("class","z_index_1");
			$("#tab05").attr("class","z_index_2");
			$("#tab06").attr("class","z_index_3");   
			}    
		}
	}
	 //Jump to top
	 $('html').animate({scrollTop:0}, 'slow');
	});


</script>
