<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed');   ?>

    <div class="content_wrapper_front">
      <div class="seprator_9"></div>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td valign="top" class="left_coloumn_profile"><a class="circled_link_box" href="">
            <div class="seprator_18"></div>
            <div class="portfolio_icon"></div>
            <div class="font_opensansSBold font_size13 text_alignC pt2"><?php echo $this->lang->line('portfolio');?></div>
            </a>
            <!--left_coloumn-->
          </td>
				  <td valign="top" class="right_coloumn_profile rc_black_profile" >	


<div class="position_relative">
              <div class="strip_absolute_right_profile">
                <!-- <img src="images/strip_blog.png"  border="0"/>-->
                <table width="100%" height="534px" cellspacing="0" cellpadding="0" border="0">
                  <tbody>
                    <tr>
                      <td height="66px">&nbsp;</td>
                    </tr>
                    <tr>
                      <td class="dot_mid">&nbsp;</td>
                    </tr>
                    <tr>
                      <td height="30px">&nbsp;</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="orange_strip"></div>
              <div class="seprator_62"></div>
              <div class="row">
                <div class="cell width_243 font_opensans pb20 break_word">
                  <div class="font_size18 text_alignR pr32 pb18 mt_minus4">
					  <?php 
					        if(isset($workDetail->profileFName) && !empty ($workDetail->profileFName))
					        
					        { $workProfileUserName=$workDetail->profileFName .' '.$workDetail->profileLName; 
							  echo $workProfileUserName;
					        } 
					  	
							 $mediaDetail = getMediaDetail($workDetail->fileId);
							 if(is_array($mediaDetail) && !empty($mediaDetail))
							 {
								$profileImgPath = $mediaDetail[0]->filePath;
								$profileImgName = $mediaDetail[0]->fileName;
							 }
							 else
							 {
								$profileImgPath = '';
								$profileImgName = '';
							 }
								
							$workProfileThumbImage = addThumbFolder(@$profileImgPath.$profileImgName,'_s');														
							$workProfileSrc = '<img src="'.getImage($workProfileThumbImage,$this->config->item('defaultWorkWanted_s')).'" class="bdr_white max_h170_w172 left_colum_thumb" />';												   
					  ?>
					  
				  </div>
                  <div class="pr32 fRight"><?php echo $workProfileSrc; ?></div>
                  <div class="seprator_20 clear"></div>
                  
                  <div class="seprator_40"></div>
                 <?php 
                 /*
                  <div class="pr32 clr_898989 text_alignR font_size13"><?php if (isset($workDetail->profileAdd)) echo $workDetail->profileAdd ?><br />
                   <?php if (isset($workDetail->profileStreet)) echo $workDetail->profileStreet ?><br />
                   <?php echo $workDetail->profileCity ?><br />
                    <?php echo getCountry($workDetail->profileCountry)?><bR />
                    <?php echo $workDetail->profileZip?>
                    <div class="seprator_25"></div>
                    + <?php echo $workDetail->profilePhone ?><br />
                    <?php echo $workDetail->profileEmail ?> 
                   </div>
                  */ 
                 ?>
                </div>
               
                
    <?php
	$userImage = getImage($userInfo['userImage'],$this->config->item('defaultWorkWanted_s'));
	$beforeContactmeIn=$this->lang->line('beforeContactmeIn');
	$loggedUserId=isloginUser();	
							        
	$beforereqWorkProfile=$this->lang->line('beforereqWorkProfile');
	if($loggedUserId!=$userId) {
								   
	   $recipientsId=$userId ;								    
	}if($loggedUserId > 0){
	if($loggedUserId==$userId){
		$canNotReqOwn=$this->lang->line('canNotReqOwn');
		$functionRequestme="customAlert('".$canNotReqOwn."')";
	}else{
		$requestMe=$this->load->view('common/request_work_profile',array('userFullName'=>$workProfileUserName,'userImage'=>$userImage,'recipientsId'=>$recipientsId), true);
		echo "<script>var requestProfile=".json_encode($requestMe)."</script>";
		$functionRequestme="if(checkIsUserLogin('".$beforereqWorkProfile."')){loadPopupData('popupBoxWp','popup_box',requestProfile)}";
	}
	}else{

	$functionRequestme="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforereqWorkProfile."')";
	}

     $contactMe=$this->load->view('common/contactme',array('userId'=>$userId,'userFullName'=>$userInfo['userFullName'],'userImage'=>$userImage), true);
     echo "<script>var contactMe=".json_encode($contactMe)."</script>";
     $functionContactme="if(checkIsUserLogin('".$beforeContactmeIn."')){loadPopupData('popupBoxWp','popup_box',contactMe)}"; 

    ?>            
               
               <div class="cell">
                  <div class="width_506 pl10">
                    <!--box01-->
                    
                   <div class="search_result_list_wrapper bg_SRCreative width500px mb10 ml10 ">
					  <div class="search_result_list_gradient">
						<div class="search_result_img_box w26_h167 Fleft"> </div>
						<div class="Fleft width_458">
						  <div class="search_no_result_head">
							  <span class="underline inline"><span class="inline orange_clr_imp">This Link Has Expired</span></span>
						  </div>
						  <div class="search_no_result_note">Please contact <a class="dash_link_hover" style="color:black;text-decoration:underline" href="<?php echo base_url().'en/showcase/index/'.$userId?>"> <?php echo $userData['userFullName']?></a></h1></div>
						   <!--<div class="tds-button fr mt25">
                            <button onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" onclick="<?php //echo $functionRequestme;?>" style="background-position: 0px -38px;"><span class="pr5" style="background-position: right -38px;">
									 <div class="clr_E76D34 Fleft font_size12 ml5">Request Work Profile</div>
									 <div class="send_button"></div>
								 </span>
							 </button>
                          </div>-->
						  
						<div class="tds-button fr mt25"> 
							<a href="javascript::void(0)" onclick="<?php echo $functionRequestme;?>" onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" >
								<span class="font_size12 clr_E76D34 width135px gray_clr_hover"> 
									<div class="Fleft font_size12 ml-12 width_139">Request Work Profile</div>
									<div class="send_button mt-25 mr-3"></div>
								</span>
							</a>
						</div>
						  
						</div>
						<div class="clear"></div>
					  </div>
					  
					  
					  
				</div>	
         
                  
          </div> 
                  							  
													
							
                  <div class="seprator_30"></div>
                </div>
               
               
               
               
                <div class="clear"></div>
              </div>
              <div class="seprator_10"></div>
   
   
            </div>


</td>
        </tr>
      </table>
      <div class="seprator_5"></div>
    </div>
    <!--content_wrapper-->
   
  
