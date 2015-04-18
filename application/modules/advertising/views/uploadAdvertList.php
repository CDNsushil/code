<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$advertUploadLimit = '5';
$browseId = '_cm';
$defCoverImage = $this->config->item('defaultMediaImg_s');
$mainCoverImage = '';
$coverImage = addThumbFolder($mainCoverImage,$suffix='_xxs',$thumbFolder ='thumb',$defCoverImage);	
$coverImage = getImage($coverImage,$defCoverImage);
$isBlockEdit=false;
$arraryDataNew='';	

if(!empty($advertListData)){
	foreach($advertListData as $advertList){
		$arraryDataNew[$advertList->advertorder] = $advertList;
	}
}


for($i=0;$i<$advertUploadLimit;$i++) { 			
	// advert lable	
	$row = $i+1;			
	$peaceString = 'Advert '.$row;
	
	if(isset($arraryDataNew[$row]) && $row==$arraryDataNew[$row]->advertorder) { 

		$data = $arraryDataNew[$row];
		
		//Set advert image
		$advertImg = getAdvertImage($data->fileinput);		
		$opacity_4 = '';
		$data->mediaFormAction = 'mediaEdit';
		$data->advertorder = $row;
		$jsonData=json_encode($data);
		$dimensions = $data->filewidth.'px X '.$data->fileheight.'px';
		$pathinfo = pathinfo($data->fileinput);
		$hrefUrl = 'javascript:void(0)';
		
		if($data->storagetype=="web"){
			if(isset($pathinfo['extension'])){
				$extension = strtolower($pathinfo['extension']);
				if($extension=="jpg" || $extension=="jpeg" || $extension=="gif" || $extension=="png"){
					$hrefUrl = "javascript:openLightBox('popupBoxWp','popup_box','/advertising/previewAdvert','".$data->bannerid."');";
				}
			}
		}else{
			$hrefUrl = "javascript:openLightBox('popupBoxWp','popup_box','/advertising/previewAdvert','".$data->bannerid."');";
		}
		
		?>
		<script>var dataCM<?php echo $i;?> = <?php echo $jsonData;?>;</script>
		<div class="row" id="CG<?php echo $i;?>">
			<div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $peaceString;?></span></div></div>								 
			<div id="CGData<?php echo $i;?>" class="cell frm_element_wrapper extract_content_bg">
				<!--extract_img_wp-->
				<a href="<?php echo $hrefUrl; ?>" >
					<div class="extract_img_wp height30 <?php echo $opacity_4;?>" > 
						<img class="formTip ptr maxWH30 ma" src="<?php echo $advertImg;?>"  title="<?php echo $data->title; ?>"  />
					</div>
				</a>
				<!--extract_heading_box-->
				<div class="extract_heading_box <?php echo $opacity_4;?>"> <?php  echo  getSubString($data->title,50).' ( '.$dimensions.' )'; ?> </div>
				<!--extract_button_box-->
				<div class="extract_button_box">
					<div  class="small_btn formTip" title="<?php echo $this->lang->line('delete');?>"><a href='javascript:advertDelete(<?php echo $data->bannerid;?>)' ><div class="cat_smll_plus_icon"></div></a></div>
					<?php //if($data->storagetype=="web") { ?>
						<div class="small_btn formTip" title="<?php echo $this->lang->line('edit');?>"><a id="advertForm<?php echo $data->bannerid;?>" href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#advertMediaFormDiv');" ><div class="cat_smll_edit_icon"></div></a></div>
					<?php  //} ?>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
	<?php  }else{ 
		
		if(!$isBlockEdit){
		// get media type details
		$arrayDataAdd['isMediaSet'] = false;
		$arrayDataAdd['title'] = 'Add '.$peaceString ;
		//$arrayDataAdd['title'] = 'Add Advert';
		
		switch($i)
		{
			case 0:
			$arrayDataAdd['filewidth'] = '250';
			$arrayDataAdd['fileheight'] = '250';
			$dimensions = '250px X 250px';
			break;
			
			case 1:
			$arrayDataAdd['filewidth'] = '160';
			$arrayDataAdd['fileheight'] = '600';
			$dimensions = '160px X 600px';
			break;
			
			case 2:
			$arrayDataAdd['filewidth'] = '468';
			$arrayDataAdd['fileheight'] = '60';
			$dimensions = '468px X 60px';
			break;
			
			case 3:
			$arrayDataAdd['filewidth'] = '170';
			$arrayDataAdd['fileheight'] = '170';
			$dimensions = '170 X 170px';
			break;
			
			case 4:
			$arrayDataAdd['filewidth'] = '728';
			$arrayDataAdd['fileheight'] = '90';
			$dimensions = '728 X 90px';
			break;
		}
		
		$arrayDataAdd['mediaFormAction'] = 'mediaAdd';
		$opacity_4='opacity_4';
		$arrayDataAdd['advertorder'] = $row;
		$jsonData=json_encode($arrayDataAdd);
		?>
	
		<script>var dataCM<?php echo $i;?> = <?php echo $jsonData;?>;</script>
		<div class="row" id="CG<?php echo $i;?>">
			<div class="label_wrapper cell"><div class="labeldiv"><span><?php echo $peaceString;?></span></div></div>									 
			<div id="CGData<?php echo $i;?>" class="cell frm_element_wrapper extract_content_bg">
				<!--extract_img_wp-->
				<div class="extract_img_wp <?php echo $opacity_4;?>"> 
					<img class="formTip ptr maxWH30 ma" src="<?php echo $coverImage;?>"  title="<?php echo$arrayDataAdd['title']; ?>"  />
				</div>
				<!--extract_heading_box-->
				<div class="extract_heading_box <?php echo $opacity_4;?>"> <?php  echo  getSubString($arrayDataAdd['title'],50).' ( '.$dimensions.' )'; ?> </div>
				
				<!--extract_button_box-->
				<div class="extract_button_box">
					 <div class="small_btn formTip" title="<?php echo $this->lang->line('add');?>"><a href="javascript:void(0)" onclick="fillFormValueCM(dataCM<?php echo $i;?>,'#advertMediaFormDiv');"><div class="cat_smll_add_icon"></div></a></div>
				</div>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php 
		}
	}	
}
?>
<script type="text/javascript">
	$(document).ready(function(){
		$(".advertstype").click(function(){
			// get current show div value
			var selectedVal= $(this).val();
			
			// show upload advert div
			if(selectedVal=='upload'){
				    $(".advert_upload_div").show();
				    $(".advert_create_div").hide();
				}
			
			// show create advert div
			if(selectedVal=='create'){
				
					//remove heading form field
					$(".heading_form").each(function(){
						$(this).remove();
					});
					
					//remove heading form field
					$(".img_filed").each(function(){
						$(this).remove();
					});
					
					//set default html
					$("#main_div_id").html('<span id="image_append_show"></span><p id="show_heading_0" class="show_heading_0 p_show" >Dummy Text </p>');
					$("#main_div_id").css("background-image","none");
					
					//create first heading field
					createHeadingField(0,'');
					$( ".show_heading_0").draggable({ distance: 10, cursor: "crosshair" });
					
					$(".show_heading_0").css({
						color:'#ffffff',
						height: '35px',
						'text-align': 'center',
						margin:'0px',
						padding:'0px',
						float:'left',
						'font-size':'30px',
						'line-height':'26px',
						'font-weight':'normal'
					});
					
					$(".advert_upload_div").hide();
				    $(".advert_create_div").show();
				}
		});
	});
	
	
	function fillFormValueCM(data,formId){
		//console.log(data);
		
		var browseId = '<?php echo $browseId;?>';
		$('label.error').remove();
		$('input.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
		});
		
		// set advert type in upload and create advert form	
		$('#uploadAdvertOrder').val(data.advertorder);
		$('#createAdvertOrder').val(data.advertorder);
	
		//set create addvert div size select by dimention
		$(".main_div").css("width",data.filewidth+"px");
		$(".main_div").css("height",data.fileheight+"px");
		
		// set width and height in hidden div
		$("#width").val(data.filewidth);
		$("#height").val(data.fileheight);
		
		//set width for create advert div	
		$("#createAdvertWidth").val(data.filewidth);
		$("#createAdvertHeight").val(data.fileheight);
		
		var getDivWidth = parseInt(data.filewidth);
		var getDivHeight = parseInt(data.fileheight);
		
		//set div position by diemention 250 X 250
		if(getDivWidth==250 && getDivHeight==250){
			$(".advert_show_parent_div").css({'margin-top':'-285px','margin-left':'350px'});
			$(".advert_create_div").removeClass('pt100').addClass('pt_280');
			$(".save_advert_div").css({'margin-top':'0px'});
			var restrictIndustryIds = new Array(26,29,30,31,32,33); //set array of industry ids 
				var displayIndustryIds  = new Array(1,2,3,4,8,9,10,11,12,13,16,17,18,19,28); //set array of display industry ids
			//hide industries which not have advert
			for(i=0;i<restrictIndustryIds.length;i++) {
				$('#industryUpload_'+restrictIndustryIds[i]).hide();
				$('#industryCreate_'+restrictIndustryIds[i]).hide();
			}
			//show industries which includes advert
			for(i=0;i<displayIndustryIds.length;i++) {
				$('#industryUpload_'+displayIndustryIds[i]).show();
				$('#industryCreate_'+displayIndustryIds[i]).show();
			}
		}
		
		//set div position by diemention 160 X 600
		if(getDivWidth==160 && getDivHeight==600){
			$(".advert_show_parent_div").css({'margin-top':'-58px','margin-left':'620px'});	
			$(".advert_create_div").removeClass('pt_280 pt100');	
			$(".save_advert_div").css({'margin-top':'255px'});
			var restrictIndustryIds = new Array(6,7,8,26,29,30,31,32,33); //set array of industry ids 
			var displayIndustryIds  = new Array(1,2,3,4,9,10,11,12,13,16,17,18,19,28); //set array of display industry ids
			//hide industries which not have advert
			for(i=0;i<restrictIndustryIds.length;i++) {
				$('#industryUpload_'+restrictIndustryIds[i]).hide();
				$('#industryCreate_'+restrictIndustryIds[i]).hide();
			}
			//show industries which includes advert
			for(i=0;i<displayIndustryIds.length;i++) {
				$('#industryUpload_'+displayIndustryIds[i]).show();
				$('#industryCreate_'+displayIndustryIds[i]).show();
			}	
		}
		
		//set div position by diemention 468 X 60
		if(getDivWidth==468 && getDivHeight==60){
			$(".advert_show_parent_div").css({'margin-top':'-105px','margin-left':'265px'});
			$(".advert_create_div").removeClass('pt_280').addClass('pt100');	
			$(".save_advert_div").css({'margin-top':'0px'});
			var restrictIndustryIds = new Array(6,7,8,26,29,30,31,32,33); //set array of industry ids 
			var displayIndustryIds  = new Array(1,2,3,4,8,9,10,11,12,13,16,17,18,19,28); //set array of display industry ids
			//hide industries which not have advert
			for(i=0;i<restrictIndustryIds.length;i++) {
				$('#industryUpload_'+restrictIndustryIds[i]).hide();
				$('#industryCreate_'+restrictIndustryIds[i]).hide();
			}
			//show industries which includes advert
			for(i=0;i<displayIndustryIds.length;i++) {
				$('#industryUpload_'+displayIndustryIds[i]).show();
				$('#industryCreate_'+displayIndustryIds[i]).show();
			}
		}
		
		//set div position by diemention 170 X 170
		if(getDivWidth==170 && getDivHeight==170){
			$(".advert_show_parent_div").css({'margin-top':'-255px','margin-left':'350px'});
			$(".advert_create_div").removeClass('pt100').addClass('pt_280');
			$(".save_advert_div").css({'margin-top':'0px'});	
			var restrictIndustryIds = new Array(28,29,30,31,32,33); //set array of hide industry ids 
			var displayIndustryIds  = new Array(1,2,3,4,6,7,8,9,10,11,12,13,16,17,18,19,27); //set array of display industry ids 
			//hide industries which not have advert
			for(i=0;i<restrictIndustryIds.length;i++) {
				$('#industryUpload_'+restrictIndustryIds[i]).hide();
				$('#industryCreate_'+restrictIndustryIds[i]).hide();
			}
			//show industries which includes advert
			for(i=0;i<displayIndustryIds.length;i++) {
				$('#industryUpload_'+displayIndustryIds[i]).show();
				$('#industryCreate_'+displayIndustryIds[i]).show();
			}
		}
		
		//set div position by diemention 728 X 90
		if(getDivWidth==728 && getDivHeight==90) {
			$(".advert_show_parent_div").css({'margin-top':'-115px','margin-left':'50px'});
			$(".advert_create_div").removeClass('pt_280').addClass('pt100');	
			$(".save_advert_div").css({'margin-top':'0px'});
			var restrictIndustryIds = new Array(1,2,3,4,6,7,8,9,10,11,12,13,16,17,18,19,27,28,29,30,31,32,33); //set array of industry ids
			var displayIndustryIds  = new Array('26'); //set array of display industry ids  
			//hide industries which not have advert
			for(i=0;i<restrictIndustryIds.length;i++) {
				$('#industryUpload_'+restrictIndustryIds[i]).hide();
				$('#industryCreate_'+restrictIndustryIds[i]).hide();
			}
			//show industries which includes advert
			for(i=0;i<displayIndustryIds.length;i++) {
				$('#industryUpload_'+displayIndustryIds[i]).show();
				$('#industryCreate_'+displayIndustryIds[i]).show();
			}
		}
	
		//advert add condition
		if(data.mediaFormAction == 'mediaAdd'){
			$(formId+' form')[0].reset();
			
			//create advert div button show
			$(".advert_upload_div").hide();
			$(".advert_create_div").hide();
			$("#CreateAdverts" ).show();
			$("#UploadAdverts").show();
			$("#advertsTypeUpload").attr('checked', false);
			$("#advertsTypeCreate").attr('checked', false);
			$(".ez-radio").removeClass("ez-selected");
			
			//div toggle for add case
			if(!$(formId).is(":visible")){
				$(formId).slideToggle('slow');
			}
			
			//set default value  for create advert
			$("#headingFieldRow").val('1');
			$("#imgFieldRow").val('0');
			
			//---------set deafult media type if set in criteria upload form----//
			if(!data.isMediaSet){
				
				$('#Uploadvideo<?php echo $browseId;?>').show();
				$('#FileUpload<?php echo $browseId;?>').show();
				$('#rawFileNameDiv<?php echo $browseId;?>').hide();
				$('#selectFileTypeDiv<?php echo $browseId;?>').show();
				$('#uploafFileButton<?php echo $browseId;?>').show();
				$('#embedButton<?php echo $browseId;?>').show();
				$('#EmbeddedURL<?php echo $browseId;?>').hide();
				//------show default lenght div-----//	
				$("#fileLengthDiv<?php echo $browseId;?>").show();
				//$("#dimensionsDiv<?php echo $browseId;?>").hide();
				$("#wordCountDiv<?php echo $browseId;?>").hide(); 
			} else {
				
				$('#Uploadvideo<?php echo $browseId;?>').show();
				$('#FileUpload<?php echo $browseId;?>').show();
				$('#rawFileNameDiv<?php echo $browseId;?>').hide();
				$('#selectFileTypeDiv<?php echo $browseId;?>').show();
				$('#uploafFileButton<?php echo $browseId;?>').show();
				$('#embedButton<?php echo $browseId;?>').show();
				$('#EmbeddedURL<?php echo $browseId;?>').hide();
				//------show default lenght div-----//	
				$("#fileLengthDiv<?php echo $browseId;?>").show();
				$("#dimensionsDiv<?php echo $browseId;?>").hide();
				$("#wordCountDiv<?php echo $browseId;?>").hide();
			}	
			
			//---------set deafult value in form----//
			$.each(data, function(key, value){
				if($(formId+' form [name=' + key + ']') !='undefind'){
					$(formId+' form [name=' + key + ']').val(value);
				} 
			});
			
            // set width and height of 		
			$('#fileHeight').val(data.fileHeight);
			$('#fileWidth').val(data.fileWidth);
			
			//set Advert Id
			$('#bannerid').val('');
			$('#createAdvertId').val('');
			$('#createAdvertTitle').val('');
			$('#advertUrl').val('');
			$('#submitAction').val('add');
			
			//manage advert display section fields as uncheck
			var sections = data.banner_sections;
			if(sections==undefined) {
				var sectionCheckIds = [];
				$(".CreateCheckBox:checked").each(function() {
					sectionCheckIds.push(this.value);
				});
				
				for(i=0;i<sectionCheckIds.length;i++) {
					if(sectionCheckIds[i]!='' && sectionCheckIds[i]!=undefined) {
						$('#createSection_'+sectionCheckIds[i]).attr('checked', false);
						$('#section_'+sectionCheckIds[i]).attr('checked', false);
					}
				}
				$('#advertcreatesectionInputContainer').val('');
				$('#createSectionIds').val('');
			}
		}else{
			
			//div toggle for edit case
			if(!$(formId).is(":visible")){
				$(formId).slideToggle('slow');
			}
			
			$.each(data, function(key, value){
			  if($(formId+' form [name=' + key + ']') !='undefind'){
				  $(formId+' form [name=' + key + ']').val(value);
			  }
			});
			
			//trigger fire by advert type
			if(data.storagetype=="web"){
				
				$( "#UploadAdverts" ).show();
				$( "#CreateAdverts" ).hide();
				$( ".advert_upload_div" ).show(); //show upload div
				$( ".advert_create_div" ).hide(); //hide create advert div
				$( "#advertsTypeUpload" ).trigger( "click" );
			}else{
				$( ".advert_create_div" ).show(); //show create advert div
				$( ".advert_upload_div" ).hide(); //hide upload div
				
				//remove all main div if exist
				$(".main_div").each(function(){
					$(this).remove();
				});
				$("#CreateAdverts").show();
				$("#UploadAdverts").hide();
				
				$("#advertsTypeCreate" ).trigger( "click" );
				var getHtmlData = data.htmltemplate;
				var replaceHtml = getHtmlData.replace(/{server_path}/g,baseUrl);
				$(".advert_show_parent_div").html(replaceHtml);
				$(".hidden_div_code").html('');
				$("#createAdvertTitle").val(data.title);
				$("#advertUrl").val(data.url);
				$("#submitAction").val('edit');
				$("#createAdvertId").val(data.bannerid);
				
				//remove default field in edit case
				$("#form_0").remove();
				
				//get create field data
				var getHtmlObj = $.parseJSON(data.htmltemplatefield)
				var getHeadingLastKey = 0;
				if(getHtmlObj[0]!=undefined){
					if(getHtmlObj[0].writeheading!=undefined){
						$.each(getHtmlObj[0].writeheading, function(key, value){
							//create heading form field 
							$("#form_"+key).remove();
							var getVal = (value=="")?"Dummy Text":value;
							createHeadingField(key,getVal);
							getHeadingLastKey = key;
						});
					}
				}
				
				//image field create
				var getImgLastKey = 0;
				if(getHtmlObj[1]!=undefined) {
					if(getHtmlObj[1].advertimgfield!=undefined){
						$.each(getHtmlObj[1].advertimgfield, function(key, value){
							//create image form field 
							$("#img_filed_"+key).remove();
							createImgField(key,value);
							getImgLastKey = key;
						});
					}
				}
				
				$("#headingFieldRow").val(parseInt(getHeadingLastKey)+1);
				$("#imgFieldRow").val(parseInt(getImgLastKey));
			}
			
			// set width and height of 		
			$('#fileHeight').val(data.fileheight);
			$('#fileWidth').val(data.filewidth);	
			// set file name
			$('#fileInput_cm').val(data.fileinput);
			//set Advert Id
			$('#bannerid').val(data.bannerid);
			//set Content type
			$('#contenttype').val(data.contenttype);
			//manage advert display section fields
			var sections = data.banner_sections;
			if(sections!=undefined) {
				manageAdvertSection(sections,data.storagetype);
			} 
		}
		$('#browseId').val(browseId);
	}

	//delete advert data 
	function advertDelete(advertId){
		var detStatus = confirm('Are you sure you want delete this advert?');
		if(detStatus){
			var deleteData = '&advertId='+advertId;
			var url = baseUrl+language+'/advertising/deleteAdvert';
			$.post(url,deleteData, function(data) {
			  if(data){
					refreshPge();
				}
			},"json");
		}
	}
	
	//Manage advert section listing
	function manageAdvertSection(sections,storagetype) {
		var sectionIds = sections.split(","); //make array of section ids
		var sectionName = new Array(); //set sections name array
		var sectionVal = new Array();  //set sections values array
		for(i=0;i<sectionIds.length;i++) {
			if(sectionIds[i]!='' && sectionIds[i]!=undefined) {
				if(storagetype=='html') {
					var sectionId = '#createSection_'+sectionIds[i];
				}else{
					var sectionId = '#section_'+sectionIds[i];
				}
				$(sectionId).attr('checked', true);
				$(sectionId).parent().addClass('ez-checked');
				sectionVal[i]  = sectionIds[i];  
				sectionName[i] = $(sectionId).attr('title');
			}
		}
		
		//append ids and names as per storage type
		if(storagetype=='html') {
			$('#advertcreatesectionInputContainer').val(sectionName);
			$('#createSectionIds').val(sectionVal);
		} else {
			$('#advertsectionInputContainer').val(sectionName);
			$('#sectionIds').val(sectionVal);
		}
	}
	
	//display advert form on edit from advert listing 
	<?php if(isset($advertId) && !empty($advertId)) {?>
		$("#advertForm<?php echo $advertId;?>").trigger('click');
	<?php }?>
</script>
