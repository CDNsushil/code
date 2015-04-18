<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url_lang('/workprofile');

$refrenesForm = array(
    'name'=>'refrenesForm',
    'id'=>'refrenesForm'
);

$refrenesDetailsForm = array(
    'name'=>'refrenesDetailsForm',
    'id'=>'refrenesDetailsForm'
);

$refFNameInput = array(
    'name'	=> 'refFName',
    'id'	=> 'refFName',
    'class'	=> 'font_wN required width233imp',
    'value'	=> '',
    'placeholder' => $this->lang->line('profileFName'),
    'onblur' => "placeHoderHideShow(this,'".$this->lang->line('profileFName')."','show')",
    'onclick' => "placeHoderHideShow(this,'".$this->lang->line('profileFName')."','hide')" 
);

$refLNameInput = array(
    'name'	=> 'refLName',
    'id'	=> 'refLName',
    'class'	=> 'font_wN required width233imp',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('profileLName'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('profileLName')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('profileLName')."','hide')" 
);

$refCompNameInput = array(
    'name'	=> 'refCompName',
    'id'	=> 'refCompName',
    'class'	=> 'font_wN required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('company'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('company')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('company')."','hide')" 
);

$refEmailInput = array(
    'name'	=> 'refEmail',
    'id'	=> 'refEmail',
    'class'	=> 'font_wN required email',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('profileEmail'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('profileEmail')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('profileEmail')."','hide')" 
);

$refContactInput = array(
    'name'	=> 'refContact',
    'id'	=> 'refContact',
    'class'	=> 'font_wN number width233imp',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('profilePhone'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('profilePhone')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('profilePhone')."','hide')" 
);

$refIdInput = array(
    'name'	=> 'refId',
    'id'	=> 'refId',
    'value'	=> 0,
    'type'	=> 'hidden'
);
$referencePrintType   = (isset($workProfileDetails->referencePrintType) && !empty($workProfileDetails->referencePrintType)) ? $workProfileDetails->referencePrintType : 0;
?>
 <div class="content display_table  TabbedPanelsContent width742 m_auto">
     <div class=" clearb">
		<h3 class="width635 fr"><?php echo  $this->lang->line('refrences');?></h3>
		<?php echo form_open($baseUrl.'/refrences',$refrenesForm); ?>
			<div class="sap_30"></div>
			 <ul class=" billing_form form1">
				<li>
					<span class="fr width635 lineH22 defaultP">
						<input type="radio" value="1" name="referencePrintType" <?php if($referencePrintType == 1) { ?> checked='checked'<?php }?> >
						<?php echo $this->lang->line('refrenceCheckNote1');?>                    
					</span>
				</li>
				<li> <span class="fr width635 textin30 open_sans fs16">OR </span> </li>
				<li>
					<span class="fr width635 lineH22 defaultP">
						<input type="radio" value="2" name="referencePrintType" <?php if($referencePrintType == 2) { ?> checked='checked'<?php }?>>
						<?php echo $this->lang->line('refrenceCheckNote2');?>                  
					</span>
				</li>
			</ul>
		<?php echo form_close();?>
			<div class="sap_35"></div>
			<?php echo form_open($baseUrl.'/refrences',$refrenesDetailsForm); ?>
				<ul class=" billing_form form1">
					<li class="">
						<span class="fl">
							<label class="employe_label">First Name</label>
							<?php echo form_input($refFNameInput); ?>
						</span>
						<span class="fl">
							<label class="employe_label ">Last Name</label>
							<?php echo form_input($refLNameInput); ?>
						</span>
					</li>
					
					<li class="">
						<label class="employe_label">Company</label>
						<?php echo form_input($refCompNameInput); ?>
					</li>
					
					<li class="">
						<label class="employe_label">Email Address</label>
						<?php echo form_input($refEmailInput); ?>
					</li>
					
					<li class="">
						<label class="employe_label">First name*</label>
						<?php echo form_input($refContactInput); ?>
					</li>
		
				</ul>	
				<div class=" pt30 mr5  fr">
					<input class="red p10  fr  min_width_79" value="Save" type="button" onclick = "$('#refrenesDetailsForm').submit();" />
					<input id="cancelBtn" class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Cancel" type="button" onclick = "resetForm();" />
				</div>
				<?php 
				echo form_input($refIdInput);
			echo form_close();?>
		<span class="sap_30"></span>
		<div class="width_635 fr">
		<div class="mb10 pl30"> 
			<span class=" width100_per lineH21">
				<span class="red fl pl15 width_130 ">Name</span> 
				<span class="red fl pl15 width210 ">Company</span>
				<span class="red mr20 fr"> </span> 
			</span> 
		</div>
        
		<ul class="list_box  clearb" id="employmentData">
			<?php
			if( is_array($refrenceRes) && count($refrenceRes) > 0 ) {
				foreach($refrenceRes as $refrence) { ?>
					<li id="profileRefrences_<?php echo $refrence['refId'];?>" class="mb10 pl30">
						<span class="bg_f9f9f9 width605 lineH21">
							<span class=" fl pl15 width_130 ">
								<?php echo $refrence['refFName'].' '.$refrence['refLName'];?>
							</span> 
							<span class=" fl pl15 width210 ">
								<?php echo $refrence['refCompName'];?>
							</span> 
							<span class=" mr10 fr ">
								<span class="fl red mr10">
									<a title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editRefrence(this)" refId="<?php echo $refrence['refId'];?>" refFName="<?php echo $refrence['refFName'];?>" compName="<?php echo $refrence['compName'];?>" refLName="<?php echo $refrence['refLName'];?>" refCompName="<?php echo $refrence['refCompName'];?>" refEmail="<?php echo $refrence['refEmail'];?>" refContact="<?php echo $refrence['refContact'];?>">Edit</a>
									/ 
									<a href="javascript:void(0)" onclick="deleteRefrence('<?php echo $refrence['refId'];?>');" >Delete </a>
								</span> 
							</span> 
						</span>
					</li>
				<?php 	
				} 
			} ?>
		</ul>
		 <!-- Form buttons -->
        <?php
       
        // set back url
        $data['backPage'] = '/workprofile/employment';
        // set next form name
        $data['formName'] = 'refrenesForm';
		$this->load->view('workProfile/wizardform/common_buttons',$data);
        ?>
	</div>
</div></div>

<script>
	
    $(document).ready(function() {
        // manage employment submit form 
        $("#refrenesDetailsForm").validate({
            submitHandler: function() {
                var fromData=$("#refrenesDetailsForm").serialize();
				loader();
                $.post('<?php echo $baseUrl.'/addprofilerefrences/';?>',fromData, function(data) {
                    if(data) {
						//refreshPge();
						//parent show div
						$("#popup_box").parent().hide();
                        if(data.editId > 0) {
                            $('#profileRefrences_'+data.editId).html(data.refrenceHtml);
                        } else {
                            $('#employmentData').prepend(data.refrenceHtml);
                        }
                        // append form values as blank
                        resetForm();
                    }
                },'json');
            }
        });
        
		$("#refrenesForm").validate({
            submitHandler: function() {
                var fromData=$("#refrenesForm").serialize();
                $.post('<?php echo $baseUrl.'/setreferences';?>',fromData, function(data) {
                    if(data){
                        window.location.href = data.nextStep; 
                    }
                }, "json");
            }
        });
    });
    
    // employment manage workrprofile
    function editRefrence(obj) {
        var refId = $(obj).attr('refId');
        var refFName = $(obj).attr('refFName');
        var refLName = $(obj).attr('refLName');
        var refCompName = $(obj).attr('refCompName');
		var refEmail = $(obj).attr('refEmail');
		var refContact = $(obj).attr('refContact');
			
        // set form values in fields
        $('#refId').val(refId);     
		$('#refFName').val(refFName);  
		$('#refLName').val(refLName);  
        $('#refCompName').val(refCompName);  
		$('#refEmail').val(refEmail);  
		$('#refContact').val(refContact);
     
        // manage buttons
        $('#cancelBtn').show();
    }
    
    // reset employment form values
    function resetForm() {
        $('#refId').val(0);
       	$('#refFName').val('');  
		$('#refLName').val('');  
        $('#refCompName').val('');  
		$('#refEmail').val('');  
		$('#refContact').val('');   
        $('#cancelBtn').hide();
    }
    
    // remove employment entry from workrprofile
    function deleteRefrence(refId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'refId='+refId;
             $.post('<?php echo $baseUrl.'/deleteprofilerefrences/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    $("#profileRefrences_"+refId).fadeOut("normal", function() {
                        $(this).remove();
                    });
                }
            },'json');
        });
    }	
    
</script>
