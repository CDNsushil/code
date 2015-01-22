<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$uploadSetupForm = array(
    'name' => 'uploadSetupForm',
    'id'   => 'uploadSetupForm'
);
// set checked value
$checkedShipOption = '';
$checkedDownloadOption = '';
if($formOption == 2) {
    $checkedShipOption = 'checked';
} else {
    $checkedDownloadOption = 'checked';
}
// set base url
$baseUrl = formBaseUrl();
?>
	
<div class="TabbedPanels tab_setting second_inner"> 
    <!--========== Setup your Auction  =================-->
    <?php echo form_open($baseUrl.'/setuploadformoption/'.$projectId.'/'.$elementId,$uploadSetupForm); ?>
        <div class="c_1">
           <h3 class="red fs21   bb_aeaeae"> <?php echo $this->lang->line('whatFormThis')?> </h3>
            <div class="sap_35"></div>
            <ul class=" display_table clearb rate_wrap defaultP">
                <li >
                    <label>
                        <input  type="radio" name="formOption" value="1" <?php echo $checkedDownloadOption; ?> >
                        <?php 
                        $fileForDownload  = $this->lang->line('fileForDownload');
                        $search = array("{{var fileType}}");
                        $replace   = array($fileType);
                        echo str_replace($search,$replace,$fileForDownload);?>
                    </label>
                </li>
                <li class="or_text">OR </li>
                <li>
                    <label>
                        <input  type="radio" name="formOption" value="2" <?php echo $checkedShipOption; ?> >
                        <?php 
                        $fileForShipped  = $this->lang->line('fileForShipped');
                       
                        $searchShipped = array("{{var fileShipped}}");
                        $replaceShipped = array($fileShipped);
                        echo str_replace($searchShipped,$replaceShipped,$fileForShipped);?>
                    </label>
                </li>
            </ul>
            <?php 
            // set back page
            $data['backPage'] = '/sellersetting/'.$projectId;
            // set next form name
            $data['formName'] = 'uploadSetupForm';
            $data['isSkipstep'] = 1;
            
            $this->load->view('common_view/upload_buttons',$data);
            ?>
    <?php  echo form_close();?>
</div>
