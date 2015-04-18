<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$displayImageOptionForm = array(
    'name' => 'displayImageOptionForm',
    'id'   => 'displayImageOptionForm'
);
$projectIdField = array(
    'name'  => 'projectId',
    'value' => $projectId,
    'id'    => 'projectId',
    'type'  => 'hidden'
);

$elementIdField = array(
    'name'	=> 'elementId',
    'value'	=> $elementId,
    'id'	=> 'elementId',
    'type'	=> 'hidden'
);


$elementEntityIdField = array(
    'name'	=> 'entityId',
    'value'	=> $entityId,
    'id'	=> 'entityId',
    'type'	=> 'hidden'
);

// set base url
$baseUrl = formBaseUrl();
?>
<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
    <div class="TabbedPanelsContent width635 m_auto clearb TabbedPanelsContentVisible">
        <?php echo form_open($baseUrl.'/setdisplayimageoption',$displayImageOptionForm); ?>
            <div class="c_1">
               <h3 class="red fs21   bb_aeaeae"> Display Image options </h3>
                <div class="sap_35"></div>
                <ul class=" display_table clearb rate_wrap defaultP">
                    <li >
                        <label>
                            <input  type="radio" name="displayImageType" value="1" <?php if($displayImageType == 1 || $displayImageType == '') { echo 'checked'; }?> >
                            Upload Image File 
                        </label>
                    </li>
                    <?php if(isset($embeddImageOption)) { ?>
                        <li class="or_text">OR </li>
                        <li>     
                            <label>
                                <input  type="radio" name="displayImageType" value="2" <?php if($displayImageType == 2 ) { echo 'checked'; }?>>
                               Embed Image 
                            </label>
                        </li>
                    <?php } ?>
                    <li class="or_text">OR </li>
                    <li>     
                        <label>
                            <input  type="radio" name="displayImageType" value="3" <?php if($displayImageType == 3 ) { echo 'checked'; }?> >
                            Use <?php echo $this->lang->line('mediaSection');?>'s default image.
                        </label>
                    </li>
                    <?php if(isset($profileImageOption)) { ?>
                        <li class="or_text">OR </li>
                        <li>     
                            <label>
                                <input  type="radio" name="displayImageType" value="4" <?php if($displayImageType == 4 ) { echo 'checked'; }?> >
                                Use your Profile Image.
                            </label>
                        </li>
                    <?php } ?>
                </ul>
            </div>         
        <?php 
            echo form_input($projectIdField);
            echo form_input($elementIdField);
            echo form_input($elementEntityIdField);
        echo form_close();
        // set back page
        $data['backPage'] = '/uploadfile/'.$projectId.'/'.$elementId;
        // set next form name
        $data['formName'] = 'displayImageOptionForm';
        if($displayImageType > 0) {
            $data['skipPage'] = '/uploadtitle/'.$projectId.'/'.$elementId;
        } else {
            $data['isSkipstep'] = 1;
        }
        $this->load->view('common_view/upload_buttons',$data);
        ?>
    </div>
</div>
