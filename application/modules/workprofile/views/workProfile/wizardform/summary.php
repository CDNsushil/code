<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$formAttributes = array(
    'name'=>'summaryForm',
    'id'=>'summaryForm',
);

$synopsisInput = array(
    'name'        =>  'synopsis',
    'id'          =>  'ckeditor',
    'class'       =>  'ckeditor required',
    'value'       =>  (isset($workProfileDetails->synopsis) && !empty($workProfileDetails->synopsis)) ? $workProfileDetails->synopsis : '',
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
                <h4 class="red fs21 bb_aeaeae mb0"> <?php echo $this->lang->line('professionalSummary')?></h4>
                
                <span class="sap_30"></span>
                <div class="editor_wrap editor_showcase">
                    <?php echo form_textarea($synopsisInput); ?>
                </div>
              </li>
           </ul>
        </div>
    <?php echo form_close();?>
        <!-- Form buttons -->
        <?php 
        // set back page
        $data['backPage'] = '/workprofile/socialmedialinks';
        // set next form name
        $data['formName'] = 'summaryForm';
        
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
        $("#summaryForm").validate({
            submitHandler: function() {
                var fromData=$("#summaryForm").serialize();
                //loader();
                $.post('<?php echo $baseUrl.'/setprofessionsummary';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
</script>
