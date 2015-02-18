<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
$formAttributes = array(
    'name'=>'addButtonForm',
    'id'=>'addButtonForm',
);
  
// set base url
$baseUrl = base_url(lang().'/showcase/');
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <div class="wra_head clearb">
       <h3 class="red   fs21 fnt_mouse bb_aeaeae"><?php echo $this->lang->line('communicationBtnHead');?> </h3>
        <?php echo form_open($baseUrl.'/setcommcontactoption',$formAttributes); ?>
            <div class="sap_50"></div>
            <ul class="clearb fl defaultP pr0">
                <li class="pb20 fl">
                    <input class="" type="checkbox" name="memberReviewMe" <?php if($showcaseRes->memberReviewMe=='t') { ?> checked="checked" <?php } ?> />
                    <span class="fl width600">
                        <?php echo $this->lang->line('addButtonTmail1');?>
                        <a href="<?php echo base_url(lang().'/tmail');?>"><?php echo $this->lang->line('addButtonTmail2');?></a> 
                        <?php echo $this->lang->line('addButtonTmail3');?>
                    </span>
                </li>
                <li class="pb20 fl">
                    <input class="" type="checkbox" name="recommendMe" <?php if($showcaseRes->recommendMe=='t') { ?> checked="checked" <?php } ?> />
                    <span class="fl width600">
                        <?php echo $this->lang->line('addButtonRecommandation1');?> 
                        <a href="<?php echo base_url(lang().'/showcase/managerecommendations');?>"><?php echo $this->lang->line('addButtonRecommandation2');?></a> 
                        <?php echo $this->lang->line('addButtonRecommandation3');?>   
                    </span>                              
                </li>
                <li class=" fl">
                    <input class="" type="checkbox" name="reviewMe" <?php if($showcaseRes->reviewMe=='t') { ?> checked="checked" <?php } ?> /> 
                    <span class="fl width600">
                        <?php echo $this->lang->line('addButtonReview');?>
                    </span>                                
                </li>
            </ul>
        <?php echo form_close(); ?>
        <!-- Form buttons -->
        <?php 
        // set back url
        $data['backPage'] = '/showcase/yourvideo/1';
        // set next form name
        $data['formName'] = 'addButtonForm';
        $this->load->view('wizardform/showcase_buttons',$data);
        ?>
    </div>
</div>
<!--  content wrap  end --> 
<script>
    radioCheckboxRender();
</script>
