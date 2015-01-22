<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="TabbedPanels tab_setting" id="TabbedPanels2"> 
    <ul class="TabbedPanelsTabGroup second_ul pt20 pb20">
        <li class="TabbedPanelsTab <?php echo isset($PRnewsMenu)?$PRnewsMenu:'';?>"><a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'prnews'.DIRECTORY_SEPARATOR.$projId);?>"><span>Step 1 <b>Add Links to News Articles </b></span></a> </li>
        <li class="TabbedPanelsTab <?php echo isset($PRreviewsMenu)?$PRreviewsMenu:'';?>"><a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'prreviews'.DIRECTORY_SEPARATOR.$projId);?>"><span>Step 2 <b>Add Links to Reviews</b></span></a></li>
        <li class="TabbedPanelsTab <?php echo isset($PRinterviewsMenu)?$PRinterviewsMenu:'';?>"><a href="<?php echo base_url(lang().DIRECTORY_SEPARATOR.$this->router->fetch_class().DIRECTORY_SEPARATOR.$this->router->fetch_method().DIRECTORY_SEPARATOR.'prreinterviews'.DIRECTORY_SEPARATOR.$projId);?>"><span>Step 3 <b>Add Links to Interviews </b></span></a></li>
    </ul>
    <div class="TabbedPanelsContentGroup public_2 width_665 m_auto"> 
        <div class="TabbedPanelsContent m_auto clearb TabbedPanelsContentVisible">
                <?php echo  Modules::run("additionalInfo/prmaterial", array('table'=>$table,'tdsUid'=>$userId,'entityId'=>$entityId,'elementId'=>$projId,'projId'=>$projId,'PRview'=>'additionalInfo/pr_form')); ?>
                <div class="fr btn_wrap display_block mt22 font_weight">
                    <a href="<?php echo $projectIndexLink ;?>">
                        <button class="bg_ededed bdr_b1b1b1  mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('cancel');?></span></button>
                    </a>
                    <a href="<?php echo $backurl ;?>">
                        <button class="back bdr_b1b1b1 mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('back');?></span></button>
                    </a>
                    <a href="<?php echo $nexturl ;?>">
                        <button class="back  bdr_b1b1b1 next_tab mr5 ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="button" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('skip');?></span></button>
                    </a>
                    <a href="<?php echo $nexturl ;?>">
                        <button class="b_F1592A bdr_F1592A  ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only" type="submit" role="button" aria-disabled="false"><span class="ui-button-text"><?php echo $this->lang->line('next');?></span></button>
                    </a>
                </div>
               
        </div>
    </div>
</div>
