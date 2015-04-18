<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set links count
$supportLinkCount = 0;
if(!empty($suportLinks)) {
    $supportLinkCount = count($suportLinks);
}
$baseUrl = formBaseUrl();  

$supportingMediaForm = array(
    'name'=>'supportingMediaForm',
    'id'=>'supportingMediaForm'
);

$supportLinkIdInput = array(
    'name'  => 'id',
    'id'    => 'id',
    'value' => 0,
    'type'  => 'hidden'
);
$entityIdFromInput = array(
    'name'	=> 'entityid_from',
    'id'	=> 'entityid_from',
    'value'	=> '',
    'type'	=> 'hidden'
);
$elementIdFromInput = array(
    'name'	=> 'elementid_from',
    'id'	=> 'elementid_from',
    'value'	=> '',
    'type'	=> 'hidden'
); 
$entityIdToInput = array(
    'name'	=> 'entityid_to',
    'id'	=> 'entityid_to',
    'value'	=> $entityId,
    'type'	=> 'hidden'
);
$elementIdToInput = array(
    'name'	=> 'elementid_to',
    'id'	=> 'elementid_to',
    'value'	=> $elementId,
    'type'	=> 'hidden'
);
$projNameInput = array(
    'name'	=> 'projName',
    'id'	=> 'projName',
    'value'	=> '',
    'type'	=> 'hidden'
);
$supportedMediaCountInput = array(
    'name'  => 'supportedMediaCount',
    'id'    => 'supportedMediaCount',
    'value' => $supportLinkCount,
    'type'  => 'hidden'
);
$searchdn = 'dn';
if( $supportLinkCount < 3 ) { 
    $searchdn = '';
}
?>

<!--========================== Associated Media==============================-->
<div class="TabbedPanelsContent Associated_wrap width635 m_auto clearb">
    <h3 class=" bb_aeaeae red ">Associated Media and Performances </h3>
    <h4 class="fs17"> Search Toadsquare for Media and Performaces associated with this Album.
    Links to three items can be added to your Showcase. </h4>
    <div class="sap_25"></div>
    <div class="wra_head clearb lineH40  bb_aeaeae pb28 mb2 " >
        <div id="searchBoxDiv" class="<?php echo $searchdn;?>">
            <ul class="Purchase_input display_block pb8 fl ">
                <li class="fl position_relative">
                    <input class="font_wN" type="text" name="keyWords" id="keywords" placeholder="Keywords" value="" onclick="placeHoderHideShow(this,'Keywords','hide')" onblur="placeHoderHideShow(this,'Keywords','show')">
                    <input name="Submit" type="submit" class="searchbtbbg search_pop" value="Submit" onclick="$('#associMediaHidden').val('');"  />
                </li>
                <li class="fl">
                    <input class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn width0 mr5" value="Save" id="supportLinkSave" type="button" onclick = "$('#supportingMediaForm').submit();" />
                    <input class="red p10 bdr_a0a0a0 fshel_bold min_width_79 dn width0 mr5" value="Cancel" id="supportLinkCancel" type="button" onclick = "cancelFormData()" />
                   <input class="red p10 bdr_a0a0a0 fshel_bold search_pop min_width_79 width0 mr5" value="Search" onclick="$('#associMediaHidden').val('');" type="button" />
                </li>
                <li id="searchedResult">
                </li>
            </ul>
            <?php echo form_open($baseUrl.'/addSupportingLink',$supportingMediaForm); ?>
                <?php 
                echo form_input($supportLinkIdInput);
                echo form_input($entityIdFromInput);
                echo form_input($elementIdFromInput);
                echo form_input($entityIdToInput);
                echo form_input($elementIdToInput);
                echo form_input($projNameInput);
                echo form_input($supportedMediaCountInput);
            echo form_close();?>
        </div>
        <ul class="fs12 img_text open_semibold pt30 review liststyle_none clearb" id="supportLinkUl">
            <?php
            $element_idChk = '';
            if( is_array($suportLinks) && count($suportLinks) > 0 ) {
                
                foreach( $suportLinks as $suportLinks ) {
					$element_idChk	.=	$suportLinks['elementid_from'].",";
                    // get industry name
                    $industryName = getIndustryName($suportLinks['section']);
                    // get Project Image
                    $projectImagePath = getProjectImage($suportLinks['entityid_from'],$suportLinks['elementid_from'],$suportLinks['projId'],$industryName);
                    ?>
                    <li id="supportingLi_<?php echo $suportLinks['id'];?>">
                        <span class="pl77"> 
                            <img src="<?php echo $projectImagePath;?>" alt="" class="short max_w_31 max_h_31" /> 
                            <?php echo getSubString($suportLinks['title'],80); ?> 
                            <span class="red fs12 fr">
                                <a href="javascript:void(0)" onclick="editSupportedMedia('<?php echo $suportLinks['id'];?>','<?php echo $suportLinks['title']; ?>','<?php echo $suportLinks['projId']; ?>','<?php echo $suportLinks['elementid_from']; ?>')"> Edit</a> / 
                                <a href="javascript:void(0)" onclick="deleteSupportedMedia('<?php echo $suportLinks['id'];?>')">Delete </a>
                            </span>
                        </span> 
                    </li>
                <?php 
                } 
                
            } 
            if($supportLinkCount < 3 ) {
                $remainLinkCount = 3-$supportLinkCount;
                for($i=0;$i<$remainLinkCount;$i++) { ?>
                <li id="remainSupportLink<?php echo $i;?>"><span class="pl77"><img class="short" alt="" src="<?php echo site_url();?>/images/short_2.jpg"> <span class="colr_999899">Add Media or Performance</span> </span> </li>   
            <?php } } ?>
        </ul>
    </div>
    
    <!-- Hidden Filed For Radio Button -->
    <?php 
    
    $projNameInput = array(
    'name'	=> 'associMediaHidden',
    'id'	=> 'associMediaHidden',
    'value'	=> '',
    'type'	=> 'hidden'
    );
   echo form_input($projNameInput);
    ?>
    
    
    <!-- Form buttons -->
    <?php 
    // set back url
    $data['backPage'] = '/selectcreativeteam/'.$elementId;
    // get session value of edit media mode
	$isEditMedia = $this->session->userdata('isEditMedia');
	$nextStepUrl = '/previewpublish/'.$elementId;
	if(!empty($isEditMedia)) {
		$nextStepUrl = '/editproject/'.$elementId;
	}
    // set next url
    $data['nextPage'] = $nextStepUrl;
    // set skip url
    $data['skipPage'] = $nextStepUrl;
    // set next step val
    $data['isNextstep'] = 1;
    $data['isPausestep'] = 1;
    $this->load->view('common_view/cover_buttons',$data);
    ?>
</div>
<script>
    // manage search popup
    $('.search_pop').click(function() {
        var keywords = $('#keywords').val();
        lightBoxWithAjax('popupBoxWp','popup_box','/search/searchMediaRecords/',$('#keywords').val(),'media','linkToSoundtrack');
        //radioCheckboxRender();
         runTimeCheckBox();
    });
    
    // remove supporting media of project
    function deleteSupportedMedia(supportLinkId) {
        confirmBox("If you delete this, it will be deleted immediately.", function () {
             var fromData = 'supportLinkId='+supportLinkId;
             $.post('<?php echo $baseUrl.'/deleteSupportedMedia/';?>',fromData, function(data) {
                if(data.deleted == 1 && data.countResult == 0) {
                    window.location.href =  window.location.href ;
                }
            },'json');
        });
    }
    
    // update projects supporting media
    function editSupportedMedia(supportLinkId,title,projId,elementId) {
        $('#id').val(supportLinkId);
        $('#keywords').val(title);
        $('#associMediaHidden').val('associatedPE_'+projId+'_'+elementId);
        lightBoxWithAjax('popupBoxWp','popup_box','/search/searchMediaRecords/',$('#keywords').val(),'media','linkToSoundtrack');
        
        
         $('#searchBoxDiv').show();
    }
    
    // manage suppoting media result data store
    $("#supportingMediaForm").validate({
        submitHandler: function() {
			
			/* check SupportLink */
			var supLnkChk = '<?php echo rtrim($element_idChk,","); ?>';
			var supLnkChkA = supLnkChk.split(',');
			var elementid_from = $('#elementid_from').val();
			var spCheck = supLnkChkA.indexOf(elementid_from);
			if(spCheck < 0)
			{
				var fromData = $("#supportingMediaForm").serialize();
				loader();
				$.post('<?php echo $baseUrl.'/addSupportingLink/';?>',fromData, function(data) {
					if(data) {
						refreshPge();
					}
				},'json');
			}else
			{
			alert('You have alredy associated with this media');	
			}
        }
    });
    
    // reset all the form fields
    function cancelFormData() {
        // set field values as blank
        $('#id').val(0);
        $('#keywords').val('');
        $('#entityid_from').val('');
        $('#elementid_from').val('');
        $('#searchedResult').html('');
        $('#projName').val('');
        var supportedMediaCount = $('#supportedMediaCount').val();
        if(supportedMediaCount == 3) {
            $('#searchBoxDiv').fadeOut( "slow" );
        } else {
            $('#supportLinkSave').fadeOut( "slow" );
            $('#supportLinkCancel').fadeOut( "slow" );
        }
    }
    
</script>
