<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = formBaseUrl();  

$otherCreativeForm = array(
    'name'=>'otherCreativeForm',
    'id'=>'otherCreativeForm'
);

$crtDesignation = array(
    'name'  => 'crtDesignation',
    'id'    => 'crtDesignation',
    'class' => 'font_wN required',
    'value' => '',
    'placeholder' => $this->lang->line('enterDesignation'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterDesignation')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterDesignation')."','hide')" 
);
$crtName = array(
    'name'	=> 'crtName',
    'id'	=> 'crtName',
    'class'	=> 'font_wN required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('enterFName'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterFName')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterFName')."','hide')" 
);
$crtLastName = array(
    'name'	=> 'crtLastName',
    'id'	=> 'crtLastName',
    'class'	=> 'font_wN required',
    'value'	=> '',
    'placeholder'	=> $this->lang->line('enterLName'),
    'onblur'=>"placeHoderHideShow(this,'".$this->lang->line('enterLName')."','show')",
    'onclick'=>"placeHoderHideShow(this,'".$this->lang->line('enterLName')."','hide')" 
);
$crtId = array(
    'name'	=> 'crtId',
    'id'	=> 'crtId',
    'value'	=> 0,
    'type'	=> 'hidden'
);
// set back url
$backPage = '/selectcollectioninfo/'.$elementId;
// set next url
$nextPage = '/selectassociatedmedia/'.$elementId;

if(isset($projectElementId) && !empty($projectElementId)) {
    // set back url
    $backPage = '/uploadimageinfo/'.$elementId.'/'.$projectElementId;
    // set next url
    $nextPage = '/nextmediaoptions/'.$elementId.'/'.$projectElementId;
    // set element id if project element id exists
    $elementId = $projectElementId;
    $data['isPausestep'] = 1;
}

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
);?>

<div class="c_1 clearb  bb_aeaeae  pb18 mb10">
    <h4 class="red fs18 pb10">Other people in the Creative Team</h4>
    <?php echo form_open($baseUrl.'/addAssociative',$otherCreativeForm); ?>
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
            <input class="red p10 bdr_a0a0a0 fshel_bold min_width_79" value="Save" type="button" onclick = "$('#otherCreativeForm').submit();" />
            <input id="cancelBtn" class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn" value="Cancel" type="button" onclick = "resetCreativeForm();" />
        </div>
        <?php 
        echo form_input($crtId);
        echo form_input($elementIdInput);
        echo form_input($entityIdInput);
    echo form_close();?>
    <ul class="fs12 open_semibold review liststyle_none clearb" id="AssociativeData">
        <?php
        if( is_array($creativeInvolved) && count($creativeInvolved) > 0 ) {
            foreach($creativeInvolved as $creatives) { ?>
                <li id="creativeTeam_<?php echo $creatives->crtId;?>">
                    <span class="bg_f9f9f9 "> 
                        <span class=" fl width176 pl23"><?php echo $creatives->crtDesignation;?> </span> 
                        <?php echo $creatives->crtName.' '.$creatives->crtLastName;?>
                        <span class="red fs12 fr">
                            <a title="<?php echo $this->lang->line('edit')?>" href="javascript:void(0)" onclick="editAssociative(this)" crtId="<?php echo $creatives->crtId;?>" crtDesignation="<?php echo $creatives->crtDesignation;?>" crtName="<?php echo $creatives->crtName;?>" crtLastName="<?php echo $creatives->crtLastName;?>">Edit</a>
                            / 
                            <a href="javascript:void(0)" onclick="deleteCreativeMember('<?php echo $creatives->crtId;?>');" >Delete </a>
                        </span> 
                    </span>
                </li>
        <?php } 
        } ?>
        <li class="icon_2 fl mt42 fs14 fshel_midum pl41"> If someone is not a member of Toadsquare, invite them to join.</li>
        <?php
         $shareLink = base_url('home');
        $onclickFunction = "getShortLink('".$shareLink."','email');" ;?>
        <li class="fr bg-non mt30">
            <a onclick="<?php echo $onclickFunction ?>" >
                <button class="red pt5 pb5 bdr_a0a0a0 fshel_bold min_width_79 joinToadBtn">Invite a friend<br /> to join</button>
            </a>
        </li>
    </ul>
</div>
<!-- Form buttons -->
<?php 
// set back url
$data['backPage'] = $backPage;
// set next url
$data['nextPage'] = $nextPage;
// set next step val
$data['isNextstep'] = 1;
$data['isSkipstep'] = 1;
$this->load->view('common_view/cover_buttons',$data);
?>

<script>
    $(document).ready(function() {
        // manage other creative member's data store
        $("#otherCreativeForm").validate({
            submitHandler: function() {
                var fromData=$("#otherCreativeForm").serialize();
                fromData = fromData+'&Membertype=0';
                $.post('<?php echo $baseUrl.'/addEditAssociative/';?>',fromData, function(data) {
                    if(data) {
                        if(data.editId > 0) {
                            $('#creativeTeam_'+data.editId).html(data.creativeTeamHtml);
                        } else {
                            $('#AssociativeData').prepend(data.creativeTeamHtml);
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
        var crtId = $(obj).attr('crtId');
        var crtDesignation = $(obj).attr('crtDesignation');
        var crtName = $(obj).attr('crtName');
        var crtLastName = $(obj).attr('crtLastName');
        // set form values in fields
        $('#crtId').val(crtId);
        $('#crtDesignation').val(crtDesignation);
        $('#crtName').val(crtName);
        $('#crtLastName').val(crtLastName);
        // manage buttons
        $('#cancelBtn').show();
        // set first and last name input as readonly
        $('#tcrtName').attr('readonly', true);
        $('#tcrtLastName').attr('readonly', true);
    }
    
    // reset creative form values
    function resetCreativeForm() {
        $('#crtId').val(0);
        $('#crtDesignation').val('');
        $('#crtName').val('');
        $('#crtLastName').val('');
        $('#cancelBtn').hide();
    }
    
    // remove project's creative team member
    function deleteCreativeMember(crtId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'crtId='+crtId;
             $.post('<?php echo $baseUrl.'/deleteCreativeMember/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    $("#creativeTeam_"+crtId).fadeOut("normal", function() {
                        $(this).remove();
                    });
                }
            },'json');
        });
    }
        
    function getShortLink (url,viewType) {	
    // alert(divId+'TBX'+textBoxId+'URL'+url);
        $.ajax
        ({   
            type: "POST",
            dataType: 'json',
            data:{url:url},
            url: "<?php echo base_url(lang().'/shortlink/addShortLink') ?>",
                success: function(msg){  
                                
                     if(viewType=='share') {
                        openLightBox('popupBoxWp','popup_box','/share/socialShare',msg.shortlink);
                     }
                       else if(viewType=='email') {
                              openLightBox('popupBoxWp','popup_box','/share/shareEmail',msg.shortlink);
                    }      
                }
        });
    }	

</script>
