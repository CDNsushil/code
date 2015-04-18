<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'skillForm',
    'id'=>'skillForm',
);

$skillsInput = array(
    'name'        =>  'skills',
    'id'          =>  'ckeditor',
    'class'       =>  'ckeditor required',
    'value'       =>  (isset($workProfileDetails->skills) && !empty($workProfileDetails->skills)) ? $workProfileDetails->skills : '',
    'tabindex'    =>  "1",
);

// set base url
$baseUrl = base_url(lang().'/workprofile/');
?>


<div class="content display_table  TabbedPanelsContent width635 m_auto">
    <?php   
    echo form_open($baseUrl.'/professionsummary/',$formAttributes); 
    ?>
        <div class="c_1 clearb">
           <ul class="form_img mt25">
               <li>
                <h4 class="red fs21 bb_aeaeae mb0"> <?php echo $this->lang->line('skillQualifications')?></h4>
                
                <span class="sap_30"></span>
                <div class="editor_wrap editor_showcase">
                    <?php echo form_textarea($skillsInput); ?>
                </div>
              </li>
           </ul>
        </div>
    <?php echo form_close();?>
        <!-- Form buttons -->
        <?php 
        // set back page
        $data['backPage'] = '/workprofile/professionsummary';
        // set next form name
        $data['formName'] = 'skillForm';
        
        $this->load->view('workProfile/wizardform/common_buttons',$data);
        ?>
</div>
<script type="text/javascript">
   /**
    * Set Editor's instance for data management
    */
    CKEDITOR.on('instanceReady', function(){
       $.each( CKEDITOR.instances, function(instance) {
        CKEDITOR.instances[instance].on("change", function(e) {
            for ( instance in CKEDITOR.instances )
            CKEDITOR.instances[instance].updateElement();
        });
       });
    });
    
    $(document).ready(function() {
        $("#skillForm").validate({
            submitHandler: function() {
                var fromData=$("#skillForm").serialize();
                //loader();
                $.post('<?php echo $baseUrl.'/setskills';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
</script>
