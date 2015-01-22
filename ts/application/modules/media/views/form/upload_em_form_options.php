<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$uploadSetupForm = array(
    'name' => 'uploadSetupForm',
    'id'   => 'uploadSetupForm'
);
// set checked value
$checkedOption = '';
if($mediaFileType != 0 ) {
    $checkedOption = 'checked';
}

// set base url
$baseUrl = formBaseUrl();
?>
	
<div class="TabbedPanels tab_setting second_inner"> 
    <!--========== Setup your Auction  =================-->
    <?php echo form_open($baseUrl.'/setuploadformoption/'.$projectId.'/'.$elementId,$uploadSetupForm); ?>
        <div class="c_1">
            <h3 class="red fs21 bb_aeaeae" id="headTitle"> <?php echo $this->lang->line('whatDigitalFormThis');?> </h3>
            <div class="sap_35"></div>
            <!------------ Media file type options   ------------->
            <ul class="clearb rate_wrap defaultP" id="fileTypeOptionsUl">
                <li >
                    <label>
                        <input  type="radio" name="emFileType" value="2" <?php if($mediaFileType == 2) { ?> checked="checked" <?php } ?> >
                        <?php echo $typePrefix.$this->lang->line('videoFile');?>
                    </label>
                </li>
                <li class="or_text">OR </li>
                <li>
                    <label>
                        <input  type="radio" name="emFileType" value="3" <?php if($mediaFileType == 3) { ?> checked="checked" <?php } ?> >
                        <?php echo $typePrefix.$this->lang->line('audioFile');?>
                    </label>
                </li>
                <li class="or_text">OR </li>
                <li>
                    <label>
                        <input  type="radio" name="emFileType" value="4" <?php if($mediaFileType == 4) { ?> checked="checked" <?php } ?> >
                        <?php echo $typePrefix.$this->lang->line('textFile');?>
                    </label>
                </li>
            </ul>
            
            <?php if( $emFileTypes == 1 ) { ?>
                <!------------ Video file form type options   ------------->
                <ul id="mediaFileUl2" class=" clearb rate_wrap defaultP dn">
                    <li >
                        <label>
                            <input  type="radio" name="formOption2" value="1" checked="checked">
                            <?php echo $this->lang->line('videoFileForDownload');?>
                        </label>
                    </li>
                    <?php if($elementType != 1) { ?>
                        <li class="or_text">OR </li>
                        <li>
                            <label>
                                <input  type="radio" name="formOption2" value="2" >
                                <?php echo $this->lang->line('dvdShipped');?>
                            </label>
                        </li>
                    <?php } ?>
                </ul>
                
                <!------------ Audio file form type options   ------------->
                <ul id="mediaFileUl3" class=" clearb rate_wrap defaultP dn">
                    <li >
                        <label>
                            <input  type="radio" name="formOption3" value="1" checked="checked">
                            <?php echo $this->lang->line('audioFileForDownload');?>
                        </label>
                    </li>
                    <?php if($elementType != 1) { ?>
                        <li class="or_text">OR </li>
                        <li>
                            <label>
                                <input  type="radio" name="formOption3" value="2" >
                                <?php echo $this->lang->line('cdShipped');?>
                            </label>
                        </li>
                    <?php } ?>
                </ul>
                
               <!------------ Text file form type options   ------------->
                <ul id="mediaFileUl4" class=" clearb rate_wrap defaultP dn">
                    <li >
                        <label>
                            <input  type="radio" name="formOption4" value="1" checked="checked">
                            <?php echo $this->lang->line('textFileForDownload');?>
                        </label>
                    </li>
                    <?php if($elementType != 1) { ?>
                        <li class="or_text">OR </li>
                        <li>
                            <label>
                                <input  type="radio" name="formOption4" value="2" >
                                <?php echo $this->lang->line('textShipped');?>
                            </label>
                        </li>
                    <?php } ?>
                </ul>
            <?php }
            // set back page
            $data['backPage'] = '/sellersetting/'.$projectId;
            // set next form name
            $data['formName'] = 'uploadSetupForm';
            $data['isSkipstep'] = 1;
            if($emFileTypes == 1) {
                $data['isNextstep'] = 1;
            }
            $this->load->view('common_view/upload_buttons',$data);
            ?>
    <?php  echo form_close();?>
</div>

<script>
    // manage next options
    $('#nextAjaxButton').click(function() {
        
        var emFileType = $('input:radio[name=emFileType]:checked').val();
        if(emFileType != '' && emFileType != undefined)  {
            $('#fileTypeOptionsUl').hide();
            $('#nextAjaxButton').hide();
            $('#nextButton').show();
            $('#mediaFileUl'+emFileType).show();
            $('#backAjaxButton').show();
            $('#backButton').hide();
            $('#headTitle').html('<?php echo $this->lang->line('whatFormThis');?>');
        }
    });
    
    // manage back steps 
    $('#backAjaxButton').click(function() {
        
        var emFileType = $('input:radio[name=emFileType]:checked').val();
        if(emFileType != '' && emFileType != undefined)  {
            $('#nextAjaxButton').show();
            $('#nextButton').hide();
            $('#fileTypeOptionsUl').show();
            $('#mediaFileUl'+emFileType).hide();
            $('#backAjaxButton').hide();
            $('#backButton').show();
            $('#headTitle').html('<?php echo $this->lang->line('whatDigitalFormThis');?>');
        }
    });
</script>
