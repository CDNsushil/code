<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$baseUrl = formBaseUrl();  
?>
<!--========================== stage 1 :- second tab  ==============================-->

<div class="TabbedPanels tab_setting" id="TabbedPanels2"> 
    <ul class="TabbedPanelsTabGroup scond_li shipless">
        <?php if(!isset($isStage2)) { ?>
            <li class="TabbedPanelsTab <?php echo isset($addNewsReviewS1Menu)?$addNewsReviewS1Menu:'';?>" ><span><?php echo $this->lang->line('step1AddNewsReview');?></span></li>
            <li class="TabbedPanelsTab <?php echo isset($addNewsReviewS2Menu)?$addNewsReviewS2Menu:'';?>" ><span><?php echo $this->lang->line('step2AddNewsReview');?></span></li>
            <li class="TabbedPanelsTab <?php echo isset($addNewsReviewS3Menu)?$addNewsReviewS3Menu:'';?>" ><span><?php echo $this->lang->line('step3AddNewsReview');?></span> </li>
        <?php } else {?>
            <li class="TabbedPanelsTab <?php echo isset($addCoverPageS1Menu)?$addCoverPageS1Menu:'';?>" ><span><?php echo $this->lang->line('step1CollectionPage');?></span></li>
            <li class="TabbedPanelsTab <?php echo isset($addCoverPageS2Menu)?$addCoverPageS2Menu:'';?>" ><span><?php echo $this->lang->line('step2CollectionPage');?></span></li>
            <li class="TabbedPanelsTab <?php echo isset($addCoverPageS3Menu)?$addCoverPageS3Menu:'';?>" ><span><?php echo $this->lang->line('step3CollectionPage');?></span> </li>
        <?php } ?>
    </ul>
    <div class="TabbedPanelsContentGroup   clearb shipgroup"> 
        <div class="TabbedPanelsContent TabbedPanelsContentVisible"> 
            <div id="TabbedPanels8" class="TabbedPanels tab_setting second_inner"> 
                <!--========== Setup your Auction  =================-->
                <div class="TabbedPanelsContentGroup width635  m_auto ">
                    <div class="TabbedPanelsContent  TabbedPanelsContentVisible tab_setting">    
                        <?php $this->load->view($subInnerPage); ?>
                    </div>
                </div>
            
            </div>
        </div>
    </div>
</div>             
