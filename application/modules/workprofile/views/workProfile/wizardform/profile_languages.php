<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url_lang('/workprofile');

$profileLangForm = array(
    'name'=>'profileLangForm',
    'id'=>'profileLangForm'
);

$profileLangId = array(
    'name'	=> 'profileLangId',
    'id'	=> 'profileLangId',
    'value'	=> 0,
    'type'	=> 'hidden'
);
?>

<div class="wra_head clearb  " >
    <h3 class="red mt30 pb10"><?php echo  $this->lang->line('languages');?></h3>
    <?php echo form_open($baseUrl.'/personaldetails',$profileLangForm); ?>
    <ul class="billing_form form1 clearbox mt30">
		  <li class=" width_258 fl select select_1">
			<?php
			$languagesList = getlanguageList();
			echo form_dropdown('langId', $languagesList, 0,'id="langId" class=" main_SELECT selectBox width235imp required"');?>
		</li>
		
		<li class=" width_258 fl ml15 select select_1">
			<?php
			$fluecyList = getFluencyTypeList();
			echo form_dropdown('fluencyType', $fluecyList, '','id="fluencyType" class=" main_SELECT selectBox width235imp required"');?>
		</li>
        </ul>	
        <div class="fr mt15">
            <input class="red p10 bdr_a0a0a0 fshel_bold min_width_79" value="Save" type="button" onclick = "$('#profileLangForm').submit();" />
            <input id="cancelBtn" class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Cancel" type="button" onclick = "resetCreativeForm();" />
        </div>
        <?php 
		echo form_input($profileLangId);
    echo form_close();?>
    
	<div class="mb10  pl50 clearbox">
		<span class=" width100_per lineH21">
			<span class="red fl pl15 width210 ">Language</span>
			<span class="red fl pl15 width210 ">Fluency</span>
			<span class="red mr20 fr"> </span>
		</span>
	</div>
    <ul class=" list_box  liststyle_none clearb" id="AssociativeData">
        <?php
        if( is_array($userProfileLanguages) && count($userProfileLanguages) > 0 ) {
            foreach($userProfileLanguages as $profileLanguage) { ?>
                <li id="creativeTeam_<?php echo $profileLanguage->profileLangId;?>" class="pl30 mb10">
                    <span class="gray_bg mb0"> 
                        <span class=" fl width210 pr20 pl23"><?php echo getLanguage($profileLanguage->langId);?> </span> 
                        <?php echo $profileLanguage->fluencyType;?>
                        <span class="red fs12 fr">
                            <a title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editAssociative(this)" profileLangId="<?php echo $profileLanguage->profileLangId;?>" langId="<?php echo $profileLanguage->langId;?>" fluencyType="<?php echo $profileLanguage->fluencyType;?>">Edit</a>
                            / 
                            <a href="javascript:void(0)" onclick="deleteCreativeMember('<?php echo $profileLanguage->profileLangId;?>');" >Delete </a>
                        </span> 
                    </span>
                </li>
        <?php } 
        } ?>
    </ul>
</div>

<script>
    $(document).ready(function() {
        // manage other creative member's data store
        $("#profileLangForm").validate({
            submitHandler: function() {
                var fromData=$("#profileLangForm").serialize();
                 var langId = $('#langId').val();
                if(langId == 0 ) {
					alert('Please select language.');
					return false;
				}
				loader();
                $.post('<?php echo $baseUrl.'/addprofilelanguage/';?>',fromData, function(data) {
                    if(data) {
						//parent show div
						$("#popup_box").parent().hide();
                        if(data.editId > 0) {
                            $('#creativeTeam_'+data.editId).html(data.languageHtml);
                        } else {
                            $('#AssociativeData').prepend(data.languageHtml);
                        }
                        // append form values as blank
                        resetCreativeForm();
                    }
                },'json');
            }
        });
    });
    
    // creative involved Associative Section
    function editAssociative(obj) {
        var profileLangId = $(obj).attr('profileLangId');
        var langId = $(obj).attr('langId');
        var fluencyType = $(obj).attr('fluencyType');
			
        // set form values in fields
        $('#profileLangId').val(profileLangId);     
        setSeletedValueOnDropDown( 'langId',langId );
        setSeletedValueOnDropDown( 'fluencyType',fluencyType );
     
        // manage buttons
        $('#cancelBtn').show();
    }
    
    // reset creative form values
    function resetCreativeForm() {
        $('#profileLangId').val(0);
        setSeletedValueOnDropDown( 'langId',0 );
        setSeletedValueOnDropDown( 'fluencyType','' );
        $('#cancelBtn').hide();
    }
    
    // remove project's creative team member
    function deleteCreativeMember(profileLangId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'profileLangId='+profileLangId;
             $.post('<?php echo $baseUrl.'/deleteprofilelanguage/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    $("#creativeTeam_"+profileLangId).fadeOut("normal", function() {
                        $(this).remove();
                    });
                }
            },'json');
        });
    }	

</script>
