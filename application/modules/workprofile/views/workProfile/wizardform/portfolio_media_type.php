<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url_lang('/workprofile');

$mediaTypeForm = array(
    'name'=>'mediaTypeForm',
    'id'=>'mediaTypeForm'
);

$mediaIdInput = array(
    'name'	=> 'mediaId',
    'id'	=> 'mediaId',
    'value'	=> (isset($mediaId) && !empty($mediaId)) ? $mediaId : 0,
    'type'	=> 'hidden'
);
$mediaType = (isset($profileMediaData->mediaType) && !empty($profileMediaData->mediaType)) ? $profileMediaData->mediaType : 0; 
?>
<div class="content display_table  TabbedPanelsContent width635 m_auto">
	<div class="c_1 clearb">
		<h3 class="red fs18 pb10"><?php echo  $this->lang->line('typeOfVideo');?></h3>
		<?php echo form_open($baseUrl.'/setportfoliomediatype',$mediaTypeForm); ?>
			<div class="sap_30"></div>
			<ul class="defaultP listpb10">
				<?php if(!empty($mediaType)) { ?>
					<li>
						<input type="radio" checked="checked" value="<?php echo $mediaType;?>" name="mediaType">
						<?php echo $this->lang->line('mediaType'.$mediaType);?>
					</li>
				<?php 
				} else { ?>
					<li>
						<input type="radio" value="2" name="mediaType" checked='checked' >
						<?php echo $this->lang->line('mediaType2');?>                    
					</li>
					<li>
						<input type="radio" value="3" name="mediaType" >
						<?php echo $this->lang->line('mediaType3');?> 
					</li>
					<li>
						<input type="radio" value="4" name="mediaType" >
						<?php echo $this->lang->line('mediaType4');?>                  
					</li>
					<li>
						<input type="radio" value="1" name="mediaType" >
						<?php echo $this->lang->line('mediaType1');?>                  
					</li>
				<?php 
				}?>
			</ul>
		<!-- Form buttons -->
        <?php
			echo form_input($mediaIdInput);
		echo form_close();
		// set cancle url
		$data['cancleUrlType'] = 2;
        // set back url
        $data['backHistory'] = '1';
        // set next form name
        $data['formName'] = 'mediaTypeForm';
		$this->load->view('workProfile/wizardform/common_buttons',$data);
        ?>
	</div>
</div>

<script>
	
    /*$(document).ready(function() {
        // manage employment submit form
		$("#mediaTypeForm").validate({
            submitHandler: function() {
                var fromData=$("#mediaTypeForm").serialize();
                $.post('<?php echo $baseUrl.'/setreferences';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });*/
</script>
