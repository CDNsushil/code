  <?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  $accessUserProfile = (isset($accessUserProfile) && ($accessUserProfile!='')) ? $accessUserProfile :''; ?>
  
    <div class="content_wrapper_front">
      <div class="seprator_9"></div>
      <table cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td valign="top" class="left_coloumn_profile">
			  
			  <?php 
			  $buttonArray['accessUserProfile'] = $accessUserProfile; 
			  $this->load->view('portfolio_common_button',$buttonArray); ?>
            <!--left_coloumn-->
          </td>
				  <td valign="top" class="right_coloumn_profile rc_black_profile" >	



<div class="position_relative">
              <div class="strip_absolute_right_profile">
                <!-- <img src="images/strip_blog.png"  border="0"/>-->
                <table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
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
                  <div class="font_size18 text_alignR pr32 pb18 mt_minus4"><?php echo $workDetail->profileFName .' '.$workDetail->profileLName;
                  
							$mediaDetail = getMediaDetail($workDetail->fileId);
							if(is_array($mediaDetail) && !empty($mediaDetail))
							{
								$profileImgPath = $mediaDetail[0]->filePath;
								$profileImgName = $mediaDetail[0]->fileName;
							}else
							{
								$profileImgPath = '';
								$profileImgName = '';
							}
							
							$workProfileThumbImage = addThumbFolder(@$profileImgPath.$profileImgName,'_s');	
							
							$workProfileSrc = '<img src="'.getImage($workProfileThumbImage,$this->config->item('defaultWorkWanted_s')).'" class="bdr_white max_h170_w172 left_colum_thumb" />'
					       
                  
                  
                   ?></div>
                  <div class="pr32 fRight">	<?php echo $workProfileSrc; ?></div>
                  <div class="seprator_20 clear"></div>
                  
                  <div class="seprator_40"></div>
                  <div class="pr32 clr_898989 text_alignR font_size13"><?php if (isset($workDetail->profileAdd)) echo $workDetail->profileAdd ?><br />
                   <?php if (isset($workDetail->profileStreet)) echo $workDetail->profileStreet ?><br />
                   <?php echo $workDetail->profileCity ?><br />
                    <?php echo getCountry($workDetail->profileCountry)?><bR />
                    <?php echo $workDetail->profileZip?>
                    <div class="seprator_25"></div>
                    + <?php echo $workDetail->profilePhone ?><br />
                    <?php echo $workDetail->profileEmail ?> </div>
                </div>
               
          <div class="cell">
				   
			 <?php  if( isset($empHistory) && !empty($empHistory) )
                    {				  
							 foreach($empHistory as $history){ ?>
							  <!--box01-->
									  <div class="width_506 pl25">
											  <div class="bdr_4b4b4b bg_373737 pl10 pr10 pt10 pb10">
											  <div class="bdr_B616161 font_size13"><b><?php if(isset($history->empDesignation)) echo $history->empDesignation ?></b></div>
											  <div class="pt10">
												  
												<div class="cell width320px"><div class="orange_clr_imp font_opensans font_size16"><?php if(isset($history->compName))echo $history->compName ?></div><div class="font_opensansSBold pt4"><?php
												if($history->empEndDate == '0'){ 
													$endDate = 'Present';
													}else{
													$endDate .= dateFormatView($history->empEndDate,'F Y');
												}
												 echo  dateFormatView($history->empStartDate,'F Y') .' - '.$endDate;?></div></div>
													<div class="Fright clr_888888 width158px font_opensansSBold text_alignR pt3">
														
														
															<?php
															
															if(!empty($history->compState) && (!empty($history->compCountry))) {													
															
																	echo $history->compState .' , '.getCountry($history->compCountry);
															 
															  } ?>
														
														</div>
												<div class="clear"></div>
											  </div>
											  </div>
											  <div class="seprator_20"></div>
											  <?php if(isset($history->empAchivments) && !empty($history->empAchivments) ) { ?>
											  
											  <div class="seprator_10"></div>
												  <div class="text_editorArea ml10 mr10 NIC">
													<p class="font_OpenSansBold font_size13"><?php if(isset($history->empAchivments)) echo $history->empAchivments?></p>
													

												   </div>
									         <?php } ?>
									
									  </div>
					<?php } } ?>        
              
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
    
