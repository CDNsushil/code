<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url_lang('/workprofile');

$profileVisaForm = array(
    'name'=>'profileVisaForm',
    'id'=>'profileVisaForm'
);

$visaTypeInput = array(
    'name'	=> 'visaType',
    'id'	=> 'visaType',
    'class'	=> 'font_wN required width_258 ml15',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('visaType'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('visaType')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('visaType')."','hide')" 
);

$visaIdInput = array(
    'name'	=> 'visaId',
    'id'	=> 'visaId',
    'value'	=> 0,
    'type'	=> 'hidden'
);
?>

<div class="wra_head clearb pb18 " >
    <h3 class="red mt30 pb10"><?php echo  $this->lang->line('workVisa');?></h3>
    <?php echo form_open($baseUrl.'/personaldetails',$profileVisaForm); ?>
    <ul class="billing_form form1 mt30 clearbox">
		
	
		  <li class=" width_258 fl select select_1">
			<?php
			$countryList = getCountryList();
			echo form_dropdown('countryId', $countryList, 0,'id="countryId" class=" main_SELECT selectBox width235imp  required"');?>
		</li>
		
		<li class=" width_258  fl ">
			 <?php echo form_input($visaTypeInput); ?>
		</li>
        </ul>	
        <div class="fr mt15">
            <input class="red p10 bdr_a0a0a0 fshel_bold min_width_79" value="Save" type="button" onclick = "$('#profileVisaForm').submit();" />
            <input id="visaCancelBtn" class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Cancel" type="button" onclick = "resetVisaForm();" />
        </div>
        <?php 
		echo form_input($visaIdInput);
    echo form_close();?>
    
    	<div class="mb10  pl50 clearbox">
		<span class=" width100_per lineH21">
			<span class="red fl pl15 width210 ">Country</span>
			<span class="red fl pl15 width210 ">Visa Type</span>
			<span class="red mr20 fr"> </span>
		</span>
	</div>
    <ul class=" list_box  liststyle_none clearb" id="visasData">
        <?php
        if( is_array($userProfileVisas) && count($userProfileVisas) > 0 ) {
            foreach($userProfileVisas as $profileVisa) { ?>
                <li id="profileVisa_<?php echo $profileVisa->visaId;?>" class="pl30 mb10"> 
                    <span class="gray_bg mb0"> 
                        <span class=" fl width210 pr20 pl23"><?php echo getCountry($profileVisa->countryId);?> </span> 
                        <?php echo $profileVisa->visaType;?>
                        <span class="red fs12 fr">
                            <a title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editvisas(this)" visaId="<?php echo $profileVisa->visaId;?>" countryId="<?php echo $profileVisa->countryId;?>" visaType="<?php echo $profileVisa->visaType;?>">Edit</a>
                            / 
                            <a href="javascript:void(0)" onclick="deleteVisa('<?php echo $profileVisa->visaId;?>');" >Delete </a>
                        </span> 
                    </span>
                </li>
        <?php } 
        } ?>
    </ul>
</div>

<script>
    $(document).ready(function() {
        // manage visa submit form 
        $("#profileVisaForm").validate({
            submitHandler: function() {
                var fromData=$("#profileVisaForm").serialize();
                var countryId = $('#countryId').val();
                if(countryId == 0 ) {
					alert('Please select country.');
					return false;
				}
				loader();
                $.post('<?php echo $baseUrl.'/addprofilevisas/';?>',fromData, function(data) {
                    if(data) {
						//parent show div
						$("#popup_box").parent().hide();
                        if(data.editId > 0) {
                            $('#profileVisa_'+data.editId).html(data.languageHtml);
                        } else {
                            $('#visasData').prepend(data.languageHtml);
                        }
                        // append form values as blank
                        resetVisaForm();
                    }
                },'json');
            }
        });
    });
    
    // visa manage workrprofile
    function editvisas(obj) {
        var visaId = $(obj).attr('visaId');
        var countryId = $(obj).attr('countryId');
        var visaType = $(obj).attr('visaType');
			
        // set form values in fields
        $('#visaId').val(visaId);     
        setSeletedValueOnDropDown( 'countryId',countryId );
        $('#visaType').val(visaType);   
     
        // manage buttons
        $('#visaCancelBtn').show();
    }
    
    // reset visa form values
    function resetVisaForm() {
        $('#visaId').val(0);
        setSeletedValueOnDropDown( 'countryId',0 );
        $('#visaType').val('');  
        $('#visaCancelBtn').hide();
    }
    
    // remove visa from workrprofile
    function deleteVisa(visaId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'visaId='+visaId;
             $.post('<?php echo $baseUrl.'/deleteprofilevisa/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    $("#profileVisa_"+visaId).fadeOut("normal", function() {
                        $(this).remove();
                    });
                }
            },'json');
        });
    }	

</script>
