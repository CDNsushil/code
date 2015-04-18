<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = formBaseUrl();  

$creativeForm = array(
    'name'=>'creativeForm'.$CMID,
    'id'=>'creativeForm'.$CMID
);

$crtDesignation = array(
    'name'  => 'crtDesignation',
    'id'    => 'crtDesignation'.$CMID,
    'class' => 'font_wN required',
    'value' => '',
    'placeholder' => $this->lang->line('enterDesignation'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterDesignation')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterDesignation')."','hide')" 
);
$crtName = array(
    'name'	=> 'crtName',
    'id'	=> 'crtName'.$CMID,
    'class'	=> 'font_wN required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('enterFName'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterFName')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterFName')."','hide')" 
);
$crtLastName = array(
    'name'	=> 'crtLastName',
    'id'	=> 'crtLastName'.$CMID,
    'class'	=> 'font_wN required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('enterLName'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterLName')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterLName')."','hide')" 
);
$crtId = array(
    'name'	=> 'crtId',
    'id'	=> 'crtId'.$CMID,
    'value'	=> 0,
    'type'	=> 'hidden'
);
$elementIdInput = array(
    'name'	=> 'elementId',
    'id'	=> 'elementId',
    'value'	=> $elementId,
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

<div class="c_1 clearb  bb_aeaeae  pb18 mb10">
    <h4 class="red fs18 pb10">Other people in the Creative Team</h4>
    <?php echo form_open($baseUrl.'/addAssociative',$creativeForm); ?>
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
        <div class="fr mt15">
            <input class="red p10 bdr_a0a0a0 fshel_bold min_width_79" value="Save" type="button" onclick = "$('#creativeForm<?php echo $CMID?>').submit();" />
            <input id="cancelBtn<?php echo $CMID;?>" class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Cancel" type="button" onclick = "resetCreativeForm();" />
        </div>
        <?php 
        echo form_input($crtId);
        echo form_input($tdsUidInput);
        echo form_input($elementIdInput);
        echo form_input($entityIdInput);
    echo form_close();?>
    <ul class="fs12 open_semibold review liststyle_none clearb" id="AssociativeData<?php echo $CMID;?>">
        <?php
        if( is_array($creativeInvolved) && count($creativeInvolved) > 0 ) {
            foreach($creativeInvolved as $creatives) { ?>
                <li id="creativeTeam_<?php echo $CMID.$creatives->crtId;?>">
                    <span class="bg_f9f9f9 "> 
                        <span class=" fl width176 pl23"><?php echo $creatives->crtDesignation;?> </span> 
                        <?php echo $creatives->crtName.' '.$creatives->crtLastName;?>
                        <span class="red fs12 fr">
                            <a title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editAssociative(this)" EEID="<?php echo $EEID;?>" crtId="<?php echo $creatives->crtId;?>" crtDesignation="<?php echo $creatives->crtDesignation;?>" crtName="<?php echo $creatives->crtName;?>" crtLastName="<?php echo $creatives->crtLastName;?>">Edit</a>
                            / 
                            <a href="javascript:void(0)" onclick="deleteCreativeMember('<?php echo $creatives->crtId;?>');" >Delete </a>
                        </span> 
                    </span>
                </li>
        <?php } 
        } ?>
        <li class="icon_2 fl mt42 fs14 fshel_midum pl41"> If someone is not a member of Toadsquare, invite them to join.</li>
        <li class="fr bg-non mt30">
            <button class="red pt5 pb5 bdr_a0a0a0 fshel_bold min_width_79">Invite a friend<br /> to join</button>
        </li>
    </ul>
</div>
<div class="fr btn_wrap display_block font_weight">
    <button class=" bg_ededed bdr_b1b1b1 mr5">Cancel</button>
    <button class=" back  bdr_b1b1b1 mr5" >Pause</button>
    <button class=" back back_click3 prev bdr_b1b1b1 mr5" >Back </button>
    <button class="b_F1592A next_click3 next bdr_F1592A"> Next </button>
</div>

<script>
    var CMID = '<?php echo $CMID;?>';
    $(document).ready(function() {
        $("#creativeForm"+CMID).validate({
            submitHandler: function() {
                var fromData=$("#creativeForm"+CMID).serialize();
                fromData = fromData+'&Membertype='+CMID;
                $.post('<?php echo $baseUrl.'/addEditAssociative/';?>',fromData, function(data) {
                    if(data) {
                        if(data.editId > 0) {
                            $('#creativeTeam_'+CMID+data.editId).html(data.creativeTeamHtml);
                        } else {
                            $('#AssociativeData'+CMID).prepend(data.creativeTeamHtml);
                        }
                        // append form values as blank
                        resetCreativeForm();
                    }
                },'json');
            }
        });
    });
    
    // creative involved Associative Section
    function editAssociative(obj){
        var EEID = $(obj).attr('EEID');
        var crtId = $(obj).attr('crtId');
        var crtDesignation = $(obj).attr('crtDesignation');
        var crtName = $(obj).attr('crtName');
        var crtLastName = $(obj).attr('crtLastName');
        // set form values in fields
        $('#crtId'+CMID).val(crtId);
        $('#crtDesignation'+CMID).val(crtDesignation);
        $('#crtName'+CMID).val(crtName);
        $('#crtLastName'+CMID).val(crtLastName);
        // manage buttons
        $('#cancelBtn'+CMID).show();
        // set first and last name input as readonly
        $('#tcrtName'+CMID).attr('readonly', true);
        $('#tcrtLastName'+CMID).attr('readonly', true);
    }
    
    // reset creative form values
    function resetCreativeForm() {
        $('#crtId'+CMID).val(0);
        $('#crtDesignation'+CMID).val('');
        $('#crtName'+CMID).val('');
        $('#crtLastName'+CMID).val('');
        $('#cancelBtn'+CMID).hide();
    }
    
    // remove project's creative team member
    function deleteCreativeMember(crtId) {
            confirmBox("If you delete this, it will be deleted immediately.", function () {
                 var fromData = 'crtId='+crtId;
                 $.post('<?php echo $baseUrl.'/deleteCreativeMember/';?>',fromData, function(data) {
                    if(data.deleted == 1 && data.countResult == 0) {
                        $("#creativeTeam_"+CMID+crtId).fadeOut("normal", function() {
                            $(this).remove();
                        });
                    }
                },'json');
            });
        }

</script>
