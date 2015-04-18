<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

    $isPublished = (isset($upcomingRes['isPublished']) && ($upcomingRes['isPublished']=='t'))?'t':'f';
    // set base url
    $baseUrl = base_url(lang().'/upcomingprojects');
    // set method name
    $methodName = $this->config->item($this->router->fetch_method().'_frntmathod');
    // set publish url
    $publishUrl = $baseUrl.'/managepublishstatus/'.$projId;
    // set preview url
    if($isPublished == 't') {
        $previewLink = base_url(lang().'/media/preview');
    } else {
        $previewLink = base_url(lang().'/media/preview');
    }
	// set publish button text
    $publishBtnTxt = $this->lang->line('publishUpcoming');
    if($isPublished == 't') {
		$publishBtnTxt = $this->lang->line('unpublishUpcoming');
	}
   
    ?>
<div class="content display_table TabbedPanelsContent width635 m_auto">
    <div class="c_1">
        <h3 class=" fs21 red  fnt_mouse bb_aeaeae"><?php echo $this->lang->line('previewNPublish');?></h3>
        <h4 class="fs16 fl  lineH24"><?php echo $this->lang->line('previewNPublishNote1');?></h4>
        <div class="sap_30"></div>
        <div class="clearb finsh_button fl fs16 "> 
            <a class="ml40 mr15" target="_blank" href="<?php echo $previewLink;?>">  
                <button type="button" class="red bdr_a0a0a0 ">
                    <?php echo $this->lang->line('previewUpcoming');?>
                </button>
            </a>
			<a class="ml15" href="<?php echo $publishUrl;?>">
                <button type="button" class="red bdr_a0a0a0 " >
                    <?php echo $publishBtnTxt;?>
                </button>
            </a>
        </div>
        
        <ul class="clearb org_list">
            <li class="icon_2"><?php echo $this->lang->line('previewNPublishNote2');?></li>
        </ul>
        <!-- Form buttons -->
		<div class=" fs14 fr display_block btn_wrap mt20 mb20 font_weight">
			<a onclick="window.history.back();">
				<button class="back back_click4 bdr_b1b1b1 mr5" type="button"><?php echo $this->lang->line('back');?></button>
			</a>
		</div>
    </div> 
  </div>     
