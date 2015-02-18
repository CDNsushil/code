<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
    
$lang           =   lang(); // get current selected language
$mediaFileForm  =   array(
    'name'      =>  'mediaFileForm',
    'id'        =>  'mediaFileForm'
);?>

<div class="TabbedPanelsContentGroup design_wrap width_665 m_auto ">
    <div class="TabbedPanelsContent width635 m_auto clearb TabbedPanelsContentVisible">
        <?php echo form_open($this->uri->uri_string(),$mediaFileForm); ?>
            <div class="c_1 clearb">
                <?php 
                //load file upload form
                $this->load->view("form/upload_file_form");
                ?>
           </div>
        <?php  echo form_close(); ?>
        <!-- Form buttons -->
        <?php 
        if($projData->projSellstatus == 't' && $projData->hasDownloadableFileOnly != 0 && $projRes->sellPriceType != 3 && $indusrtyName != 'educationMaterial') {
            // set back page
            $data['backPage'] = '/sellersetting/'.$projectId;
        } elseif(($projData->hasDownloadableFileOnly == 0 && $projData->elementType == 0) || $indusrtyName == 'educationMaterial') {
            // set back page
            $data['backPage'] = '/uploadform/'.$projectId.'/'.$elementId;
        }
        // set next form name
        $data['formName'] = 'mediaFileForm'.$projectId.'/'.$elementId;
        if($fileId > 1) {
            //set skip page
            $skipPage = '/setdisplayimage/'.$projectId.'/'.$elementId;
            if($indusrtyName == 'photographyNart') {
                $skipPage = '/uploadtitle/'.$projectId.'/'.$elementId;
            }
            $data['skipPage'] = $skipPage;
        } else {
            $data['isSkipstep'] = 1;
        }
        
        
        $this->load->view('common_view/upload_buttons',$data);
        ?>
        
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#mediaFileForm").validate({
            submitHandler: function() {
                var fromData=$("#mediaFileForm").serialize();
                var fileVal = $('#fileName1').val();
                var embeddVal = $('#embbededURL1').val();
                if(fileVal == '' && embeddVal == '') {
                    alert('Please upload file.');
                    return false;
                }
            }
        });
    });
</script>
