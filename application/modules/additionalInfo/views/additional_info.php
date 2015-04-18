<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row form_wrapper">
	<div class="row">
		<div class="cell frm_heading">
			<h1><?php  echo (isset($sectionheading) && @$sectionheading!='')?$sectionheading:$this->lang->line('aditionalInformation'); ?></h1>
		</div>
		<?php echo @$header; ?>
	</div>
	
	<div class="row tab_wp pt2" id="additionalInfoBox">
		
		<?php 
			
			if(is_array($additionalInfoSection) && count($additionalInfoSection)>0){
				$ownerId=isset($ownerId)?$ownerId:isLoginUser();
				$returnUrl=$this->uri->uri_string();
				
				$data['entityId'] = $tableId;
				$data['elementId'] = $recordId;
				$data['returnUrl'] = $returnUrl;	
				$data['ownerId'] = $ownerId;	
				$data['userId'] = isLoginUser();
				
				foreach($additionalInfoSection as $Section){
					if($Section == 'addInfoNewsPanel'){
						$this->load->view('additionalInfo/add_info_news_panel',$data);
					}elseif($Section == 'addInfoReviewsPanel'){
						$this->load->view('additionalInfo/add_info_reviews_panel',$data);
					}
					elseif($Section == 'addInfoInterviewsPanel'){
						$this->load->view('additionalInfo/add_info_interviews_panel',$data);
					}
					else{
						echo Modules::run("additionalInfo/".$Section,$tableId,$recordId,$returnUrl, array('ownerId'=>$ownerId));
					}
				}
				?>
					<div class="row"><div class="tab_shadow"></div></div>
				<?php
			}
		
		?>
	</div>
	
	<div class="clear"></div>
</div>


<script language="javascript" type="text/javascript">
	$(document).ready(function(){
		$(".ajaxCancelButton").click(function(){
			var toggleDivForm = $(this).closest("form").attr('toggleDivForm');
			var toggleDivFormID = $(this).closest("form").attr('id');
			var section =$(this).closest("form").attr('section');
			
			if($('#newsSearchResult'))$('#newsSearchResult').hide();
			if($('#displaySearchInputDiv'))$('#displaySearchInputDiv').show();
			
			
			if(section+'Heading')
				$(section+'Heading').html('<?php echo $label['add'];?>');
			if(section+'Id')
				$(section+'Id').val(0);
			if(section+'title')
				$(section+'title').val('');
			if(section+'writerName')
				$(section+'writerName').val('');
			if(section+'Description')
				$(section+'Description').val('');
			if(section+'externalUrl')
				$(section+'externalUrl').val('');
			if(section+'EmbbededVideo')
				$(section+'EmbbededVideo').val('');
			if(section+'Language'){
				$(section+'Language').val('');
				setSeletedValueOnDropDown(section+'Language', '');
			}
			if(section+'publishDate')
				$(section+'publishDate').val('');
			
			$('#'+toggleDivFormID+' label.error').remove();
			
			$('#'+toggleDivFormID+' input.error').each(function(index){
					var inputClass =$(this).attr('class').replace('error', '');
					$(this).attr('class',inputClass);
			});
			$('#'+toggleDivFormID+' textarea.error').each(function(index){
					var inputClass =$(this).attr('class').replace('error', '');
					$(this).attr('class',inputClass);
			});
			
			selectSearchType(section,section+'ExternalURLDiv');
			
			$('.'+section+'SelectSearchType').each(function(index){
					$(this).attr("checked", false);
			});
			
			$(section+'URLExternal').attr("checked", true);
			
			runTimeCheckBox();
			
			if($("#"+toggleDivForm).is(":visible")){
				$("#"+toggleDivForm).slideToggle('slow');
			}
		});

		$('.editAdditionalInfo').click(function(){
			var toggleDivForm = $(this).attr('toggleDivForm');
			var section = $(this).attr('section');
			var id = $(this).attr('id');
			var title = $(this).attr('titlehere');
			var writer = $(this).attr('writer');
			var description = $(this).attr('description');
			var descLen = description.replace(/^\s+|\s+$/g,"").split(/[\s]+/).length;
			var embed = $(this).attr('embed');
			var externalUrl = $(this).attr('externalUrl');
			var languageId = $(this).attr('languageId');
			var urlType = $(this).attr('urlType');
			var publishDate = $(this).attr('publishDate');
			var projId = $(this).attr('projId');
			$("#"+toggleDivForm).show();
			$(section+'Heading').html('<?php echo $label['edit'];?>');
			$(section+'Id').val(id);
			$(section+'title').val(title);
			$(section+'writerName').val(writer);
			$(section+'Description').val(description);
			$(section+'DescLimit').html(descLen);
			$(section+'externalUrl').val(externalUrl);
			
			$(section+'EmbbededVideo').val(embed);
			$(section+'Language').val(languageId);
			setSeletedValueOnDropDown(section+'Language', languageId);
			$(section+'publishDate').val(publishDate);
			if($(section+'Searchprojectid'))$(section+'Searchprojectid').val(projId);
			
			if($('#newsSearchResult'))$('#newsSearchResult').show();
			if($(this).attr('ElementTitle')){
				var ElementTitle = $(this).attr('ElementTitle');
				if(ElementTitle !=''){
					
					if($('#displaySearchInputDiv'))$('#displaySearchInputDiv').hide();
					if($('#newsSearchDiv'))$('#newsSearchDiv').show();
					if($('#newsSearchRow'))$('#newsSearchRow').show();
					
					
					
					$(section+'Searchelementid_from').val($(this).attr('associatedElementId'));
					$(section+'SearchDiv').html(ElementTitle);
					$(section+'SearchRow').show();
				}else{
					$(section+'SearchDiv').html('');
					$(section+'SearchRow').hide();
				}
			}
			
			if(urlType==1){
					var urlDiv='SearchOnToadsquareDiv';
					var urlCheckBox='URLts';
			}else if(urlType==3){
				var urlDiv='EmbedURLDiv';
				var urlCheckBox='URLEmbed';
			}else{
				var urlDiv='ExternalURLDiv';
				var urlCheckBox='URLExternal';
			}
			selectSearchType(section,section+urlDiv);
			
			$('.'+section+'SelectSearchType').each(function(index){
					$(this).attr("checked", false);
			});
			
			$(section+urlCheckBox).attr("checked", true);
		
			
			runTimeCheckBox();
		});
		
		$('.deleteAdditionalInfoRow').click(function(){
			var section = $(this).attr('section');
			var id = $(this).attr('id');
			var tbl = $(this).attr('tbl');
			var field = $(this).attr('field');
			var checkbox = $(this).attr('checkbox');
			var rowData = $(this).attr('rowData');
			deleteTabelRow(tbl,field,id,'',checkbox,rowData,'','','','',1,'Are you sure you wish to delete this item?');
			var lenth = $(section+"Data").length;
			if(lenth < 1){
				$(section+'DataHeading').hide();
				$(section+'NoRecords').show();
			}
		});
		
	});
	
	function editSocialMedia(obj){
		var toggleDivForm = $(obj).attr('toggleDivForm');
		var section = $(obj).attr('section');
		var id = $(obj).attr('id');
		var elementId = $(obj).attr('elementId');
		var socialLink = $(obj).attr('socialLink');
		var socialLinkType = $(obj).attr('socialLinkType');
		var socialLinkTypeValue = $(obj).attr('socialLinkType');
		
		$("#"+toggleDivForm).show();
		//$('#Heading').html('<?php echo $label['edit'];?>');
		$('#profileSocialLinkId').val(id);
		$('#elementId').val(elementId);
		$('#socialLink').val(socialLink);
		$('#socialLinkType').val(socialLinkType);
		setSeletedValueOnDropDown('socialLinkType',socialLinkType);
	}
		
	function delePRSocialMedia(obj){
		var section = $(obj).attr('section');
		var id = $(obj).attr('id');
		var tbl = $(obj).attr('tbl');
		var field = $(obj).attr('field');
		var checkbox = $(obj).attr('checkbox');
		var rowData = $(obj).attr('rowData');
		deleteTabelRow(tbl,field,id,'',checkbox,rowData,'','','','',1);
		var rowlength = $(".rowCount").length;
		
		if(rowlength < 1){
			$(section+'DataHeading').hide();
			$(section+'NoRecords').removeClass("dn");
		}
	}

	function selectSearchType(SS,searchDiv){
		$(SS+'SearchOnToadsquareDiv').hide();
		$(SS+'ExternalURLDiv').hide();
		$(SS+'EmbedURLDiv').hide();
		$(searchDiv).show();
		
	}
	function changeSCFileFormValue(data,section){ 
		//alert(section);
		$('#uploadElementForm'+section+' label.error').remove();
		$('#uploadElementForm'+section+' input.error').each(function(index){
				var inputClass =$(this).attr('class').replace('error', '');
				$(this).attr('class',inputClass);
		});
		
		if(!$('#uploadElementForm'+section).is(":visible")){
			$("#uploadElementForm"+section).slideToggle('slow');
		}
		
		if($('#interviewTitle'+section) )
			$('#interviewTitle'+section).val(data.interviewTitle);
			
		if($('#interviewDescription'+section))
			$('#interviewDescription'+section).val(data.interviewDescription);
		
		if($('#introductoryTitle'+section) )
			$('#introductoryTitle'+section).val(data.introductoryTitle);
			
		if($('#introductoryDescription'+section))
			$('#introductoryDescription'+section).val(data.introductoryDescription);
			
		if($('#fileId'+section))
			$('#fileId'+section).val(data.fileId);
			
		if($('#fileInput'+section))
			$('#fileInput'+section).val('');
			
		if($('#fileName'+section))
			$('#fileName'+section).val(data.fileName);
		
		if($('#rawFileName'+section)){
			$('#rawFileName'+section).val(data.rawFileName);
			if(data.rawFileName!='' && data.rawFileName != null){
				if('#uploadFileSection'+section)
				$('#uploadFileSection'+section).html('<div class="cell frm_element_wrapper">'+data.rawFileName+'</div>');
				
			}
		}
		
		if($('#fileSize'+section))
			$('#fileSize'+section).val(data.fileSize);
		
		if($('#isExternal'+section)){
			$('#isExternal'+section).val(data.isExternal);
			if(data.isExternal=='t'){
					if($('#uploafFileButton'+section)){
						$('#uploafFileButton'+section).remove();
					}
					if($('#Uploadvideo'+section)){
						$('#Uploadvideo'+section).remove();
					}
					if($('#EmbeddedURL'+section)){
						$('#EmbeddedURL'+section).show();
					}
			}
		}
		
		if($('#embedCode'+section))
			$('#embedCode'+section).val(data.embedCode);
	}

	function isEmbed(value,section){
		$("#EmbeddedURL"+section).hide();
		$("#Uploadvideo"+section).hide();
		if(value==1){
			$("#EmbeddedURL"+section).show();
			$("#fileInput"+section).val('');
			$('#isExternal'+section).val('t');
			$('#fileMenu'+section).attr('class','');
			$('#embedMenu'+section).attr('class','active');
		}else{
			$("#Uploadvideo"+section).show();
			$("#embedCode"+section).val('');
			$('#isExternal'+section).val('f');
			$('#fileMenu'+section).attr('class','active');
			$('#embedMenu'+section).attr('class','');
		}
	}
	
	function deleteAssociatedNews(){
		if(confirm(areYouSure)){
			var newsId =$('#newsId').val();
			var editdata = {"associatedNewsElementId":0}; 
			var where = {"newsId":newsId}; 
			var del=AJAX('<?php echo base_url(lang()."/common/editDataFromTabel");?>','',editdata,'AddInfoNews',where,'');	
			if(del){
				$('#newsSearchelementid_from').val(0);
				$('#newsSearchDiv').html('');
				$('#displaySearchInputDiv').show();
				$('#newsSearchRow').hide();
			}
		}
	}
	
	
</script>
