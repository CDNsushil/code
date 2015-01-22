<?PHP if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="footer_main">
    
    <div class="footer_wrapper">
       <div class="footer_top_strip"> <img src="<?php echo $imgPath; ?>/footertop_strip.png" alt="topstrip"/> </div>
       <div class="footer_content">
          <!--Set social link box-->
          <div class="footer_left ml30 pr ">
             <a href="<?php echo base_url(); ?>"><img src="<?php echo $imgPath; ?>/logo_toad_grayscale.png" alt=""> </a>
             <div class="footer_search_box ">
                <div class="search_box_wrapper fl mt15">
               
                    <?php
                      $formAttributes = array(
                        'name'=>'SearchFooterForm',
                        'id'=>'SearchFooterForm',
                      );
                      echo form_open(base_url(lang().'/search/searchform'),$formAttributes);
                    ?>
                    <input name="keyWord" type="text" class="search_text_box" placeholder="<?php echo $this->lang->line('keywordSearchNew');?>" value="<?php //echo $this->lang->line('keywordSearchNew');?>"  onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('keywordSearchNew');?>','show')" />
                    <input name="sectionId" type="hidden" value="">
                    <div>
                      <input type="submit" name="searchCrave" value="" class="search_btn_glass">
                      <!--<input type="image" value="searchCrave" name="searchCrave" src="<?php echo base_url();?>images/btn_search_box.png" >-->
                    </div>
                  <?php echo form_close(); ?>
               
                </div>
                <!--<a class="noroton_logo  fl ml20 "> <img src="<?php //echo $imgPath; ?>/noroton_logo.png" alt="" /> </a> -->
                <?php  if(ENVIRONMENT=='production'){  ?>
                    <div class="pa bottom_0 l10px" id="SSLDiv">
                        <table width="135" border="0" cellpadding="2" cellspacing="0" title="Click to Verify - This site chose Symantec SSL for secure e-commerce and confidential communications.">
                            <tr>
                                <td width="135" align="center" valign="top"><script type="text/javascript" src="https://seal.verisign.com/getseal?host_name=www.toadsquare.com&amp;size=L&amp;use_flash=YES&amp;use_transparent=YES&amp;lang=en"></script><br /><a href="http://www.symantec.com/verisign/ssl-certificates" target="_blank"  style="color:#000000; text-decoration:none; font:bold 7px verdana,sans-serif; letter-spacing:.5px; text-align:center; margin:0px; padding:0px;"><!--ABOUT SSL CERTIFICATES--></a></td>
                            </tr>
                        </table>
                    </div>
                <?php  }  ?>
                
                <!--search_box_wrapper--> 
             </div>
             <!--footer_search_box--> 
          </div>
          <!--footer_left-->
          <?php 
            /* Set Follow us link*/
            $facebook_url   =   $this->config->item('facebook_follow_url');
            $linkedin_url   =   $this->config->item('linkedin_follow_url');
            $twitter_url    =   $this->config->item('twitter_follow_url');
            $google_url     =   $this->config->item('google_follow_url');
            $crave_url      =   $this->config->item('crave_us');
          ?>
          <div class="fr mr40">
             <div class=" fs14 clearb  clr_white">
                <div class="fl"> <span class="fl mt10">Crave us on</span> 
                    <a target="_blank" class="indexsocial toadsquare" href="<?php echo $crave_url;?>"></a> 
                </div>
                <div class="fr ">
                     <span class="fl mt10 mr15">Follow us on</span> 
                     <a target="_blank" class="indexsocial facebook_footer" href="<?php echo $facebook_url;?>"></a> 
                     <a target="_blank" class="indexsocial twitter_footer" href="<?php echo $twitter_url;?>"></a> 
                     <a target="_blank" class="indexsocial linkedin_footer" href="<?php echo $linkedin_url;?>"></a>
                     <a target="_blank" class="indexsocial googleplus_footer" href="<?php echo $google_url;?>"></a> 
                </div>
             </div>
             <div class="footer_right">
                <div class="footer_link1">
                   <div class="footer_block">
                      <a href="<?php echo base_url(lang().'/cms/termsncondition');?>"><?php echo $this->lang->line('termsNcond')?> </a><br>
                      <?php $this->load->view('common/suggestionView');?>
                      <div class="clear"></div>
                   </div>
                </div>
                <div class="footer_link2">
                   <div class="footer_block">
                        <a href="<?php echo base_url(lang().'/cms/descofservices');?>"><?php echo $this->lang->line('DescriptionofServices')?></a> <br />
                           <?php
                            $abusiveReportSelect=$this->load->view('common/abusiveReportSelect','',true);
                            $abusiveReportComplain=$this->load->view('common/abusiveReportComplain','',true);
                            $abusiveReportForm=$this->load->view('common/abusiveReportForm','',true);
                          ?>
                          <script>
                            var abusiveReportSelect=<?php echo json_encode($abusiveReportSelect);?>;
                            var abusiveReportComplain=<?php echo json_encode($abusiveReportComplain);?>;
                            var abusiveReportForm=<?php echo json_encode($abusiveReportForm);?>;
                          </script>
                         
                         <!--Manage link for Abuse report --> 
                         <?php $loggedUserId=isloginUser();
                          $beforeReportAProblem=$this->lang->line('beforeReportAProblemLoggedIn');
                          if($loggedUserId > 0){	?>								  							  
                            <a href="<?php echo base_url(lang().'/report_a_problem');?>"><?php echo $this->lang->line('problemReport');?></a><?php
                            }
                          else{	
                            $reportSendSuggest="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeReportAProblem."')";?>
                            <a href="javascript:void(0)" onclick="<?php echo $reportSendSuggest?>"><?php echo $this->lang->line('problemReport');?> </a><?php
                          }	
                          ?>
                   </div>
                </div>
                <div class="footer_link3">
                   <div class="footer_block"> 
                       <span class="cpyrt"><?php echo $this->lang->line('copyRight');?></span><br />
                      
                        <?php 
                            $legalsContactPopup=$this->load->view('common/legals_contact','',true);
                          ?>
                        <script>
                          var legalsContactPopup=<?php echo json_encode($legalsContactPopup);?>;
                        </script>
                      
                      <a href="javascript:void(0)" onclick="loadPopupData('popupBoxWp','popup_box',legalsContactPopup);"><?php echo $this->lang->line('legals&Contact');?></a>
 
                   </div>
                </div>
             </div>
             <!--foote_right-->
          </div>
          <div class="clear"></div>
       </div>
       <!--footer_content-->
       <div class="footer_bottom_strip"> <img src="<?php echo $imgPath; ?>/footer_bottom_strip.png" alt="" > </div>
    </div>

</div>  

<?php
  $InternetExplorerMsgClose=$this->session->userdata('InternetExplorerMsgClose');
  $isIE8=get_user_browser($checkI8=true);
  if($isIE8 && $InternetExplorerMsgClose != 1){?> 
    <div id="InternetExplorerMsg" class="InternetExplorerMsg">
      <?php echo $this->lang->line('InternetExplorerMsg');?>
      <div class="fr mr20">
        <div class="tds-button-top">
          <a onclick="InternetExplorerMsgClose();" href="javascript:void(0);" ><span><div class="projectDeleteIcon"></div></span></a>
        </div>
      </div>
    </div>
    <?php
  }

  //error and sucess message show helper
  echo get_global_messages();

  if($this->session->flashdata('verifiedEmailPopup')){
    ?>
    <script>
      customAlert('<?php echo $this->session->flashdata('verifiedEmailPopup'); ?>');
    </script>
    <?php 
  }elseif($loggedUserId && $this->session->userdata('showwelcomepopup')){
    $this->session->unset_userdata('showwelcomepopup');
    echo "<script>openLightBox('popupBoxWp','popup_box','/auth/selectPage');</script>";
  }elseif(!$loggedUserId && isset($loadLoinPopup) && $loadLoinPopup){
    $message=isset($message)?$message:'';
    ?>
    <script>
      openLightBox('popupBoxWp','popup_box','/auth/login','<?php echo $message;?>');
    </script>
    <?php
    }else{
        //$this->load->view('unreadTmailAlert'); 
  }
?>

