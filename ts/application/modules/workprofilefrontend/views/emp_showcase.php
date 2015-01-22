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
                  <div class="font_size18 text_alignR pr32 pb18 mt_minus4">
					  <?php 
					        if(isset($workDetail->profileFName) && !empty ($workDetail->profileFName))
					        
					        { echo $workDetail->profileFName .' '.$workDetail->profileLName; } 
					        
					        
					        
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
					        
					        ?>
					        
					        
					        
					  
				  </div>
                  <div class="pr32 fRight"><?php echo $workProfileSrc; ?> </div>
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
                
                  		
                  		<?php $this->load->view('emp_references');?>
                  							  
						<?php $this->load->view('emp_recommendation');?>							
							
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
   
  
