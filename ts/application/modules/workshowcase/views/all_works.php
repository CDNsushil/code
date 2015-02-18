<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php 
$myUrlTab = '#tab1';
$offered_array = array();
$wanted_array = array();

$userId = @$this->uri->segment(4)>0?$this->uri->segment(4):isLoginUser();

$search = 'wanted';

$wanted_count =0;
$offered_count =0;

$currentClass=$this->router->class;
$currentMethod=$this->router->method;

//SEPEARTED WORK ON THE BASIS OF TIS TYPE


foreach ($work_array as $key =>$work_array_record) {
	
	if(strcmp($work_array_record['workType'],$search)==0) { 
		$wanted_array[$wanted_count]=$work_array_record;
		$wanted_count++;
	}else{		
		$offered_array[$offered_count]=$work_array_record;
		$offered_count++;
	}
}

$openLi = '<li>';  // Only assign once
$closeLi = '</li>';  // Only assign once
if((!isset($defaultWorkId) || $defaultWorkId =='') && $count_offered_array==0) $defaultClass=' highlight';
?>
 <div class="row summery_right_archive_wrapper width_auto position_relative">
            <!--tabs start-->
            <div class="tabs_RShowcase">
              <ul id="tabs_link">
                <li class="z_index_2" name="#tab1" id="tab01"><a><span><span class="dash_link_hover">Offered</span></span></a></li>
                <li class="z_index_1" name="#tab2" id="tab02"><a><span><span class="dash_link_hover">Wanted</span></span></a></li>
                </ul>
              <div class="clear"></div>
            </div>
            <!--tabs ends-->
            <!-- tabbox1 start-->
            <div class="global_shadow bdr_non" id="tab_content">
              <!--content box-->
              <div id="tab1" class="scroll_box innershadw darkGrey_bg bdr_d2d2d2" style="display: block;">
                <div class="slider mt3 scroll_light_btn" id="slider2"> <a href="#" class="buttons prev disable"></a>
                  <div class="viewport scroll_container02">
                    <ul class="overview height480 top0px">
                      <?php
                 	
						$currentTab1 = '#tab1#top';
						$slider2StartFrom = 1;
						if(!empty($offered_array)){ 
							foreach($offered_array as $count_offered_array => $offeredDetail){ 	
							
							$class = '';					
							$defaultClass = '';
							
							$workDetailUrl=($currentMethod=='preview')?'/workshowcase/preview/'.$offeredDetail['tdsUid'].'/'.$offeredDetail['workId'].'/works/':'/'.$currentClass.'/'.$currentMethod.'/'.$offeredDetail['tdsUid'].'/'.$offeredDetail['workId'];
							$workDetailUrl=base_url(lang().$workDetailUrl);
							
							if($offeredDetail['workId'] == $defaultWorkId) 
							{
								$workDetailUrl = 'javascript:void(0);';
								$offerdClass = 'highlight';
								$slider2StartFrom = ceil(($count_offered_array+1)/3);
								$myUrlTab = '#tab1';
							}
							else
							$offerdClass='';
							
							$thumbImage = addThumbFolder(@$offeredDetail['filePath'].@$offeredDetail['fileName'],'_xs');				
							$offeredThumbImg = getImage(@$thumbImage,$this->config->item('defaultWorkOffered_xs'));	
							//$offeredThumbImg = getImage(@$offeredDetail['filePath'].@$offeredDetail['fileName'],$this->config->item('defaultWorkOffered_s'));
							
							/*if($offeredDetail['workExperiece']=='t') $backgroundClass="backgroundOrange";
							else $backgroundClass=""; */
							$backgroundClass="";
							
							echo $openLi;						
							
						?>                   
							<div class="row recent_box_wrapper01">
							  <div class="row">
								<div class="cell recent_thumb01 thumb_absolute01 <?php echo $offerdClass.$backgroundClass;?>"> <img border="0" class="minMax_w44_h60" src="<?php echo $offeredThumbImg;?>" > </div>
								<div class="cell ml55">
								  <div class="cell recent_two_line02 padding_left10 pt4 ptr" onclick="window.location.href='<?php echo $workDetailUrl;?>'"> <span class="recent_short_title Fleft dash_link_hover <?php  echo $offerdClass.$defaultClass;?>"><?php echo getSubString($offeredDetail['workTitle'],20);?></span>
								  <span class="recent_short_txt clear"><?php  echo getSubString($offeredDetail['workShortDesc'],50); ?></span></div>
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
              <!--content box-->
              <div id="tab2" class="scroll_box innershadw darkGrey_bg" style="display: none;">
                <div class="slider mt3" id="slider3"> <a href="#" class="buttons prev disable"></a>
                  <div class="viewport scroll_container02">
                    <ul class="overview height480 top0px">
                     <?php
                 	
						$currentTab2 = '#tab2#top';
						$slider3StartFrom = 1;
					
						if(!empty($wanted_array)){ 
						foreach($wanted_array as $count_wanted_array => $wantedDetail){ 						
						
						$wantedDetailUrl=($currentMethod=='preview')?'/workshowcase/preview/'.$wantedDetail['tdsUid'].'/'.$wantedDetail['workId'].'/works/':'/'.$currentClass.'/'.$currentMethod.'/'.$wantedDetail['tdsUid'].'/'.$wantedDetail['workId'];
						$wantedDetailUrl=base_url(lang().$wantedDetailUrl);
						
						$thumbImageWantedDetail = addThumbFolder(@$wantedDetail['filePath'].@$wantedDetail['fileName'],'_xs');				
						
						$wantedThumbImg = getImage(@$thumbImageWantedDetail,$this->config->item('defaultWorkWanted_xs'));
						
						//$wantedThumbImg = getImage(@$wantedDetail['filePath'].@$wantedDetail['fileName'],$this->config->item('defaultWorkWanted_s'));
						/* if($wantedDetail['workExperiece']=='t') $backgroundClass="backgroundOrange";
						else $backgroundClass=""; */
						$backgroundClass="";
						
						
						if($wantedDetail['workId'] == $defaultWorkId) 
						{
							$wantedDetailUrl = 'javascript:void(0);';
							$wantedClass = 'highlight';
							$slider3StartFrom=ceil(($count_wanted_array+1)/3);
							$myUrlTab = '#tab2';
						}else $wantedClass='';
						echo $openLi;
					?>                  
                        <div class="row recent_box_wrapper01">
                          <div class="row">
                            <div class="cell recent_thumb01 thumb_absolute01 <?php echo $wantedClass.$backgroundClass;?>"> <img border="0" class="minMax_w44_h60" src="<?php echo $wantedThumbImg;?>" > </div>
                            <div class="cell ml55">
                              <div class="cell recent_two_line02 padding_left10 pt4 ptr" onclick="window.location.href='<?php echo $wantedDetailUrl;?>'"> <span class="recent_short_title Fleft dash_link_hover <?php echo $wantedClass;?>"><?php echo getSubString($wantedDetail['workTitle'],20);?></span>
                              <span class="recent_short_txt clear"><?php  echo getSubString($wantedDetail['workShortDesc'],50); ?></span></div>
                            </div>
                            <div class="clear"></div>
                          </div>
                          <div class="clear"></div>
                        </div>                     
                     <?
						echo $closeLi;
					}//End Foreach
				}//If	
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
              <!--content box-->
              </div>
            <!-- tabbox1 end-->
         
          </div>
       
<script>
$(document).ready(function(){
	
$('#slider2').tinycarousel({ axis: 'y', display: 3, start:<?php echo $slider2StartFrom; ?>});	
$('#slider3').tinycarousel({ axis: 'y', display: 3, start:<?php echo $slider3StartFrom; ?>});			
	
var myUrl = window.location.href; //get URL
var myUrlTab = myUrl.substring(myUrl.indexOf("#")); // For mywebsite.com/tabs.html#tab2, myUrlTab = #tab2     
var myUrlTab = '<?php echo $myUrlTab;?>';	
var myUrlTabName = myUrlTab.substring(0,4); // For the above example, myUrlTabName = #tab

function resetTabs()
{
    $("#tab_content > div").hide(); //Hide all content
    $("#tabs_link li").attr("class",""); //Reset id's      
}		
	
(function(){
    $("#tab_content > div").hide(); // Initially hide all content
    $("#tabs_link li:first").attr("class","z_index_3"); // Activate first tab
    $("#tab_content > div:first").fadeIn(); // Show first tab content
    
    $("#tabs_link li").on("click",function(e) {
        e.preventDefault();
        if ($(this).attr("class") == "z_index_2"){ //detection for current tab
         return       
        }
        else{             
        resetTabs();
        $(this).attr("class","current"); // Activate this
       
        $($(this).attr('name')).show(); // Show content for current tab
			
			if ($(this).attr("id") == "tab01") { //detection for current tab					
					$("#tab01").attr("class","z_index_2");
					$("#tab02").attr("class","z_index_1");	         		       
        		}
			else if ($(this).attr("id") == "tab02") { //detection for current tab				
					$("#tab01").attr("class","z_index_1");
					$("#tab02").attr("class","z_index_2");			
        		}
			else {				
					$("#tab01").attr("class","z_index_1");
					$("#tab02").attr("class","z_index_2");			
				}
        }
    });

   
})()		
		
				
	for (i = 1; i <= 2; i++) {
	$(myUrlTabName +i).hide();// Show url tab content
	//alert(myUrlTab);
		if (myUrlTab == myUrlTabName + i) {
		  resetTabs();				 
		  $("a[name='"+myUrlTab+"']").attr("class","current"); // Activate url tab
		  $(myUrlTab).show(); // Show url tab content  
				
			if(i==1){
			 $("#tab01").attr("class","z_index_2");
			 $("#tab02").attr("class","z_index_1");			  
			}  			  
			if(i==2){
			 $("#tab01").attr("class","z_index_1");
			 $("#tab02").attr("class","z_index_2");			 
			}   		
		}
	}
	 //Jump to top
	  $('html').animate({scrollTop:0}, 'slow');
});

</script>
