<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = base_url(lang().'/media/');

$toadCreativeForm = array(
    'name'=>'toadCreativeForm',
    'id'=>'toadCreativeForm'
);

$crtDesignation = array(
    'name'  => 'crtDesignation',
    'id'    => 'tcrtDesignation',
    'class' => 'font_wN required',
    'value' => '',
    'placeholder' => $this->lang->line('enterDesignation'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterDesignation')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterDesignation')."','hide')" 
);
$crtName = array(
    'name'	=> 'crtName',
    'id'	=> 'tcrtName',
    'class'	=> 'font_wN required',
    'value'	=> '',
    //'readonly' => true,
    'placeholder'	=> $this->lang->line('enterFName'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterFName')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterFName')."','hide')" 
);
$crtLastName = array(
    'name'	=> 'crtLastName',
    'id'	=> 'tcrtLastName',
    'class'	=> 'font_wN',
    'value'	=> '',
    //'readonly' => true,
    'placeholder'	=> $this->lang->line('enterLName'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterLName')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterLName')."','hide')" 
);
$crtId = array(
    'name'	=> 'crtId',
    'id'	=> 'tcrtId',
    'value'	=> 0,
    'type'	=> 'hidden'
);

$elementIdInput = array(
    'name'	=> 'elementId',
    'id'	=> 'elementId',
    'value'	=> $projId,
    'type'	=> 'hidden'
);
$entityIdInput = array(
    'name'	=> 'entityId',
    'id'	=> 'entityId',
    'value'	=> $entityId,
    'type'	=> 'hidden'
); 
$tdsUidInput = array(
    'name'	=> 'tdsUid',
    'id'	=> 'tdsUid',
    'value'	=> 0,
    'type'	=> 'hidden'
);
?>

<div class="wra_head clearb  bb_aeaeae  pb18 " >
    <h4 class="red fs18 fnt_mouse pt13 pb10 ">Toadsquare Members in the Creative Team</h4>
    <?php echo form_open($baseUrl.'/addAssociative',$toadCreativeForm); ?>
        <ul class="Purchase_input">
            <li>
                 <?php echo form_input($crtDesignation); ?>
            </li>
            <li>
                <?php echo form_input($crtName); ?>
            </li>
            <li>
                <?php echo form_input($crtLastName); ?>
            </li>
        </ul>
        <div class="fr mt10">
            <input class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Save" id="toadMemSave" type="button" onclick = "$('#toadCreativeForm').submit();" />
            <input id="toadCrtCnlBtn" class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Cancel" type="button" onclick = "resetToadCreativeForm();" />
            <input class="red p10 bdr_a0a0a0 fshel_bold search_pop" value="Search  Members" type="button" />
        </div>
        <?php 
        echo form_input($crtId);
        echo form_input($tdsUidInput);
        echo form_input($elementIdInput);
        echo form_input($entityIdInput);
    echo form_close();?>
  
    <ul id="toadAssociativeData" class=" fs13 open_semibold pt15 review liststyle_none clearb">
        <?php
        if( is_array($toadCreativeInvolved) && count($toadCreativeInvolved) > 0 ) {
            foreach($toadCreativeInvolved as $toadCreative) { ?>
                <li id="toadcreativeTeam_<?php echo $toadCreative->crtId;?>">
                    <span class="bg_f9f9f9"> 
                        <span class=" fl width176 pl23"><?php echo $toadCreative->crtDesignation;?> </span> 
                        <?php echo $toadCreative->crtName.' '.$toadCreative->crtLastName;?>
                        <span class="red fs12 fr">
                            <a title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editToadAssociative(this)" crtId="<?php echo $toadCreative->crtId;?>" crtDesignation="<?php echo $toadCreative->crtDesignation;?>" crtName="<?php echo $toadCreative->crtName;?>" crtLastName="<?php echo $toadCreative->crtLastName;?>">Edit</a>
                            / 
                            <a href="javascript:void(0)" onclick="deleteToadCreativeMember('<?php echo $toadCreative->crtId;?>');" >Delete </a>
                        </span> 
                    </span>
                </li>
        <?php } 
        } ?>
       
       <li class="icon_2 mt25 fs14 fshel_midum"> These members will be asked if they want to add a link to this Collection on their Showcase.</li>
    </ul>
</div>

<script>
    // manage search popup 
    /*$('.search_pop').click(function() {
        var tcrtName = $('#tcrtName').val();
        var tcrtLastName = $('#tcrtLastName').val();
        openLightBox('popupBoxWp','popup_box','/media/searchtoadmember',tcrtName,tcrtLastName);
    });*/
    
     // manage search popup
    $('.search_pop').click(function() {
        var searchKeyword = $('#tcrtName').val()+' '+$('#tcrtLastName').val();
        lightBoxWithAjax('popupBoxWp','popup_box','/search/searchMediaRecords/',searchKeyword,'associatedMember','linkToSoundtrack');
        runTimeCheckBox();
    });
    
    $(document).ready(function() {
        // manage toadsquare creative member's data store
        $("#toadCreativeForm").validate({
            submitHandler: function() {
                var fromData = $("#toadCreativeForm").serialize();
                fromData = fromData+'&Membertype=1';
                $.post('<?php echo $baseUrl.'/addEditAssociative/';?>',fromData, function(data) {
                    if(data) {
                        if(data.editId > 0) {
                            $('#toadcreativeTeam_'+data.editId).html(data.creativeTeamHtml);
                        } else {
                            $('#toadAssociativeData').prepend(data.creativeTeamHtml);
                        }
                        // append form values as blank
                       resetToadCreativeForm();
                    }
                },'json');
            }
        });
    });
    
    // creative involved Associative Section
    function editToadAssociative(obj) {
        var crtId = $(obj).attr('crtId');
        var crtDesignation = $(obj).attr('crtDesignation');
        var crtName = $(obj).attr('crtName');
        var crtLastName = $(obj).attr('crtLastName');
        // set form values in fields
        $('#tcrtId').val(crtId);
        $('#tcrtDesignation').val(crtDesignation);
        $('#tcrtName').val(crtName);
        $('#tcrtLastName').val(crtLastName);
        // manage buttons
        $('#toadMemSave').show();
        $('#toadCrtCnlBtn').show();
        // set first and last name input as readonly
        $('#tcrtName').attr('readonly', true);
        $('#tcrtLastName').attr('readonly', true);
    }
    
    // reset creative form values
    function resetToadCreativeForm() {
        // set field values as blank
        $('#tcrtId').val(0);
        $('#tcrtDesignation').val('');
        $('#tcrtName').val('');
        $('#tcrtLastName').val('');
        // manage buttons
        $('#toadCrtCnlBtn').hide();
        $('#toadMemSave').hide();
        // set first and last name readonly input as false
        $('#tcrtName').attr('readonly', false);
        $('#tcrtLastName').attr('readonly', false);
    }
    
    // remove project's creative team member
    function deleteToadCreativeMember(crtId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'crtId='+crtId;
             $.post('<?php echo $baseUrl.'/deleteCreativeMember/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    $("#toadcreativeTeam_"+crtId).fadeOut("normal", function() {
                        $(this).remove();
                    });
                }
            },'json');
        });
    }

</script>
