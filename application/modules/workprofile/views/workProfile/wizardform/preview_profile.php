<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
// set base url
$baseUrl = base_url(lang().'/workprofile/');
?>

<div class="content display_table  TabbedPanelsContent width635 m_auto">
	<div class="c_1">
		<h3 class=" fs21 red  fnt_mouse bb_aeaeae"><?php echo $this->lang->line('previewWorkProfile');?></h3>
        <h4 class="fs16 fl  lineH24"><?php echo $this->lang->line('previewWorkProfileNote');?></h4>
        <ul class="clearb">
			<li><?php echo $this->lang->line('previewWorkProfileNote1')?></li>
			<li><?php echo $this->lang->line('previewWorkProfileNote2')?></li>
			<li><?php echo $this->lang->line('previewWorkProfileNote3')?></li>
        </ul>
        <div class="sap_30"></div>
        <div class="clearb finsh_button fl fs16 "> 
			<a class="ml40 mr15" target="_blank" href="<?php echo $previewLink;?>">  
                <button type="button" class="red bdr_a0a0a0 fshel_bold">
                    <?php echo $this->lang->line('previewWorkProfileBtn');?>
                </button>
            </a>
        </div>
        <div class="sap_25"></div> 
        <ul class="clearb org_list">
            <li class="icon_2"><?php echo $this->lang->line('previewWorkProfileFooterNote'); ?></li>
        </ul>
    </div>
	<!-- Form buttons -->
	<?php 
	// set back page
	$data['backHistory'] = '1';
	// set next form 
	$data['isNextstep'] = '1';
	$data['nextPage'] = '/workprofile/emaillink';
	
	$this->load->view('workProfile/wizardform/common_buttons',$data);
	?>
</div>
