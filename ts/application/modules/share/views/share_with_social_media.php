<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$MW_ShareHeading  =str_replace('{{var catType}}',$this->lang->line('catType'.$projCategory),$this->lang->line('MW_ShareHeading'));
$MW_ShareMsg  =str_replace('{{var catType}}',$this->lang->line('catType'.$projCategory),$this->lang->line('MW_ShareMsg'));
$projId = isset($projId)?$projId:0;
// set base url
$baseUrl = DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method();
?>
    
    <div class="c_1 clearb">
      <h3 class="bb_aeaeae "><?php echo $MW_ShareHeading;?></h3>
      <div class="sap_40"></div>
      <ul class="public ">
         <li>
            <span><a href="" class="share common_graphic">  </a></span>
            <span class=" ml5 mr20  email_link  text_alignR" >
                <div class="addthis_toolbox" addthis:url="<?php echo $shortLink ?>" addthis:title="<?php echo $MW_ShareHeading?>" addthis:description="<?php echo $MW_ShareMsg;?>">                                                                                                           
                    <a class="facebook_icon common_graphic addthis_button_facebook"></a>
                    <a class="twetter_icon common_graphic addthis_button_twitter"></a>
                    <a class="linkdein_icon common_graphic addthis_button_linkedin"></a>
                    <a class="reddit_icon common_graphic addthis_button_reddit"></a>
                    <a class="digg_icon common_graphic addthis_button_digg"></a>
                    <a class="Stumble_icon common_graphic addthis_button_stumbleupon"></a>
                    <a id="instagram" class="box_icon common_graphic"></a>
                    <a id="flickr" class="filcr_icon common_graphic"></a>
                    <a class="pin-interest_icon common_graphic addthis_button_pinterest"></a> 
                    <a class="google_icon common_graphic addthis_button_google_plusone_share"></a>
                </div>
           </span> 
         </li>
         <li class="mt18 pb10">
            <h4 class="fs21  short_link fl red"></h4>
            <div class="fl ml12">
               <span class="fl"> <input id="gsInput" type="text" readonly value="<?php echo $shortLink;?>" name="getShortLink" class="bdr_adadad  fs11 mr20 width_356 min-height28 bg_f5f5f5"></span>
               <span class="fr" id="projectCopy"> <input class="copylink red_btn projectCopy ptr fr width166 height40 bg_f5f5f5 bdr_a0a0a0 fshel_bold" data-copy-shorturl='<?php echo $shortLink?>' type="button" value="<?php echo $this->lang->line('copyShortLink');?>" /></span>
            </div>
         </li>
      </ul>
    </div>
    <?php if(!empty($elementShortLink)) { ?>
        <!------ Start Element share section ------>
        <div class="or_text text_alighC ml0">OR</div>
        <div class="c_1 clearb">
            <h3 class="bb_aeaeae width635 m_auto">Share a link to Images on your Social Media Sites. </h3>
            <div class="sap_20"></div>
            <button class="red width166 ml67 search_pop bg_f5f5f5 bdr_a0a0a0 " type="button" > Select Image</button></span>

            <div class="sap_40"></div>  
            <ul class="public  width635 m_auto">
                <li>
                    <span><a href="" class="share common_graphic">  </a></span>
                    <span class=" ml5 mr20  email_link  text_alignR" >
                       <div id="elementtoolbox" class="addthis_toolbox" addthis:url="<?php echo $elementShortLink?>" addthis:title="<?php echo $MW_ShareHeading?>" addthis:description="<?php echo $MW_ShareMsg;?>">                                                                                                           
                            <a class="facebook_icon common_graphic addthis_button_facebook"></a>
                            <a class="twetter_icon common_graphic addthis_button_twitter"></a>
                            <a class="linkdein_icon common_graphic addthis_button_linkedin"></a>
                            <a class="reddit_icon common_graphic addthis_button_reddit"></a>
                            <a class="digg_icon common_graphic addthis_button_digg"></a>
                            <a class="Stumble_icon common_graphic addthis_button_stumbleupon"></a>
                            <a id="instagram" class="box_icon common_graphic"></a>
                            <a id="flickr" class="filcr_icon common_graphic"></a>
                            <a class="pin-interest_icon common_graphic addthis_button_pinterest"></a> 
                            <a class="google_icon common_graphic addthis_button_google_plusone_share"></a>
                        </div>
                    </span> 
                </li>
                <li class="mt18">
                    <h4 class="fs21  short_link fl red"></h4>
                    <div class="fl ml12">
                        <span class="fl"> <input readonly class="bdr_adadad  fs11 mr20 width_356 min-height28 bg_f5f5f5" type="text" name="getElementShortLink" id="getElementShortLink" placeholder="http://www.toadsquare.com/en/?url=Je7d1Frosweradf//,,wdwd,.efe" value="<?php echo $elementShortLink?>" onclick="placeHoderHideShow(this,'http://www.toadsquare.com/en/?url=Je7d1Frosweradf//,,wdwd,.efe','hide')" onblur="placeHoderHideShow(this,'http://www.toadsquare.com/en/?url=Je7d1Frosweradf//,,wdwd,.efe','show')" /></span>
                        <span class="fr" id="elementCopy"> <button class="copylink red_btn elementCopy fr width166 bg_f5f5f5 bdr_a0a0a0 " data-copy-shorturl='<?php echo $elementShortLink?>' type="button" > <?php echo $this->lang->line('copyShortLink');?> </button></span>
                    </div>
                </li>
            </ul>
        </div>
    <?php } ?>

    <div class="fr btn_wrap display_block mt22 font_weight">
        <a href="<?php echo $projectIndexLink;?>">
            <button class="bg_ededed bdr_b1b1b1  mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('cancel');?></span></button>
        </a>
        <a href="<?php echo $backurl;?>">
            <button class="back bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('back');?></span></button>
        </a>
        <a href="<?php echo $nexturl;?>">
            <button class="back  bdr_b1b1b1 next_tab mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('skip');?></span></button>
        </a>
        <a href="<?php echo $nexturl;?>">
            <button class="b_F1592A bdr_F1592A  ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('next');?></span></button>
        </a>
    </div>
<script>
   
    $("#projectCopy").mouseover(function(){ //When the mouse enters
       $(".projectCopy").addClass('orange_btn_hov');
    });
    $("#projectCopy").mouseleave(function(){ //When the mouse enters
       $(".projectCopy").removeClass('orange_btn_hov');
    });
   
    $("#elementCopy").mouseover(function(){ //When the mouse enters
       $(".elementCopy").addClass('orange_btn_hov');
    });
    $("#elementCopy").mouseleave(function(){ //When the mouse enters
       $(".elementCopy").removeClass('orange_btn_hov');
    });
    
    //copyClip.init('.copylink');

    // manage search popup
    $('.search_pop').click(function() {
        var projId = '<?php echo $projId;?>';
        var industry = '<?php echo $industry;?>';
        var isShareMenu = '<?php echo $isShareMenu;?>';
        lightBoxWithAjax('popupBoxWp','popup_box','<?php echo $baseUrl;?>'+'/searchshareelements/'+projId+'/'+isShareMenu,projId,industry,'linkToSoundtrack');
        runTimeCheckBox();
    });
    
    // manage copy functionality    
    window.onload = loaded();
    function loaded()
    {
        $('.copylink').zclip({
            path: baseUrl+'/swf/zeroClipboard.swf',
            copy: function(){ return $(this).attr('data-copy-shorturl'); },
            afterCopy: function()
            {
                console.log($(this).attr('data-copy-shorturl') + " was copied to clipboard");
            }
        });
    }
    
   
</script>
