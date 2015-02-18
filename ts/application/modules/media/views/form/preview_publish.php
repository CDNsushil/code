<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    $MW_PreviewPublishHeading  =str_replace('{{var category}}',$category,$this->lang->line('MW_PreviewPublishHeading'));
    $MW_PPmsg  =str_replace('{{var catType}}',$this->lang->line('catType'.$projCategory),$this->lang->line('MW_PPmsg'));
    $MW_PPhideMsg  =str_replace('{{var catType}}',$this->lang->line('catType'.$projCategory),$this->lang->line('MW_PPhideMsg'));

    $findString=array('{{var catType}}','{{var mediaEditUrl}}');
    $replaceWithString=array($this->lang->line('catType'.$projCategory),'#');
    $MW_PPeditMsg  =str_replace($findString,$replaceWithString,$this->lang->line('MW_PPeditMsg'));
     
    $isPublished = (isset($isPublished) && ($isPublished=='t'))?'t':'f';
    // set base url
    $baseUrl = formBaseUrl();
    // set method name
    $methodName = $this->config->item($this->router->fetch_method().'_frntmathod');
    // set publish url for news n review 
    $publishUrl = $baseUrl.DIRECTORY_SEPARATOR.'publicise'.DIRECTORY_SEPARATOR.$projId;
    if(isset($isNewsReview)) {
        $methodName = $industry;
        // set publish url for news n review 
        $publishUrl = $baseUrl.DIRECTORY_SEPARATOR.'publicisecollection'.DIRECTORY_SEPARATOR.$projId.DIRECTORY_SEPARATOR.$elementId ;
    }
    // set preview url
    if($isPublished == 't'){
        $previewLink=base_url(lang().'/mediafrontend/'.$methodName.'/'.$userId.'/'.$projId);
    } else {
        $previewLink=base_url(lang().'/mediafrontend/preview/'.$userId.'/'.$projId.'/'.$methodName);
    }
    // set element id
    $elementId = (isset($elementId))?$elementId:'';
    ?>

    <div class="c_1">
        <h3 class=" fs21 red  fnt_mouse bb_aeaeae"><?php echo $MW_PreviewPublishHeading;?></h3>
        <h4 class="fs16 fl  lineH24"><?php echo $MW_PPmsg;?></h4>
        <div class="sap_30"></div>
        <div class="clearb finsh_button fl fs16 "> 
            <a class="ml40 mr15" target="_blank" href="<?php echo $previewLink;?>">  
                <button type="button" class="red bdr_a0a0a0 fshel_bold">
                    <?php echo $this->lang->line('preview')." ".$this->lang->line('catType'.$projCategory);?>
                </button>
            </a>
            <a class="ml80" href="<?php echo $publishUrl;?>">
                <button type="button" class="red bdr_a0a0a0 fshel_bold" >
                    <?php echo $this->lang->line('Publish')." ".$this->lang->line('catType'.$projCategory);?>
                </button>
            </a>
        </div>
        <div class="sap_25"></div> 
        <ul class="clearb org_list">
            <li class="icon_2"><?php echo $MW_PPeditMsg; ?></li>
            <li><?php echo $MW_PPhideMsg;?></li>
        </ul>
        <?php  if(!isset($isNewsReview)) { ?>
            <div class=" fs14 fr display_block btn_wrap mt20 mb20 font_weight">
                <!--<a href="P&amp;A Wizard Create new Album STAGE 1.html"><button onclick="change()" class="bg_ededed bdr_b5b5b5 fr ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false"><span class="ui-button-text">Cancel</span></button></a>-->
                <a href="<?php echo $publishUrl;?>">
                    <button class="back back_click4 bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('skip');?></button>
                </a>
            </div>
        <?php } ?>
    </div>
