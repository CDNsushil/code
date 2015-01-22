<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

$titleInput = array(
	'name'	=> 'createAdvertTitle',
	'id'	=> 'createAdvertTitle',
	'class'	=> 'required width300px',
	'value'	=> '',	
);

$advertUrl = array(
	'name'	=> 'advertUrl',
	'id'	=> 'advertUrl',
	'class'	=> 'width300px',
	'value'	=> '',	
);

$sectionIdInput = array(
	'name'	=> 'sectionIds'.$browseId,
	'value'	=> '',
	'id'	=> 'createSectionIds',
	'type'	=> 'hidden'
);


//Get industry listing 
$advertCreateSectionInput = array(
	'name'	=> 'advertcreatesectionInputContainer',
	'id'	=> 'advertcreatesectionInputContainer',
	'class'	=> 'textarea_small_bg clr_darkgrey required',
	'value'	=> '',
	'cols'	=> 40,
	'rows'	=> 3,
	'readonly' => true
);

$intrestedCountriesID = array();
if(!empty($countriesInterestWorking)){
	$intrestedCountriesID = explode('|',$countriesInterestWorking);
}else{
	$intrestedCountriesID[]=0;
}

?>

<div class="row form_wrapper">
	
	<div class="row position_relative">	
			
			<div  class="advert_show_parent_div tac pt20 pb20 pa" >
					<div class="main_div" id="main_div_id">
						<span id="image_append_show"></span>
						<p id="show_heading_0" class="show_heading_0 p_show" >Dummy Text </p>
					</div>
			</div>
			
			<form id="create_advert_form" name="create_advert_form" action="<?php echo base_url('en/advertising/saveCreateAdvert'); ?>" method="post" enctype="multipart/form-data">
			
			 <div class="row" >
				<div class="cell label_wrapper"><label >Add</label></div>
				<div class="cell frm_element_wrapper width320px" >
					<div class="tds-button Fleft mr10"><button  class="add_heading_box" id="cancelButton" type="button" class="cancel dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" ><span><div class="Fleft width50px">Add Text</div></span></button></div>
					<div class="tds-button Fleft"><button  class="add_img_field" id="cancelButton" type="button" class="cancel dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" ><span><div class="Fleft width70px">Add Image</div></span></button></div>
				</div>
			 </div>
			
			<!--- 
			 <div class="row" id="heading_div_show">
				<div class="cell label_wrapper">&nbsp;</div>
				<div class="cell width160px f14 tal ml23">
						<label class="lh40">Heading</label>
				</div>
				<div class="cell width_85 f14 tal">
						<label class="lh40">Font Size</label>
				</div>
				
				<div class="cell width45px f14 tal">
						<label class="lh40">Bold</label>
				</div>
					
				<div class="cell width70px f14 pl5">
						<label class="lh40">Color</label>
				</div>	
			 </div> --->
			 
			 <div class="clear"></div>
			
			<div id="sortable_heading_field" class="sortable_heading_field" > 
			 
				<div class="row heading_filed_0 heading_form daynamic_field"  id="form_0">
					<div class="cell label_wrapper">&nbsp;</div>
						<div class="cell width160px frm_element_wrapper width320px">
							  <input type="text" id="write_heading_0" name="write_heading[0]" class="write_heading width140px" textrowid='0'>
						</div>
						<div class="cell width_85 pr">
							  
							<select id="font_size_heading_0" class="font_size_heading mt_minus_2 width80px mr20 left0px" selectrowid='0'>
									<?php for($i=10;$i<=100;$i++){  ?>
										<option value="<?php echo $i; ?>" <?php echo ($i=="30")?'selected="selected"':''; ?> ><?php echo $i; ?></option>
									<?php } ?>
							</select>
						</div>	
						<div class="cell width45px tal lh40 defaultP pt11 ml5">
							<input type="checkbox" id='heading_bold_0'  class="heading_bold "  boldrowid='0'>
						</div>
						<div class="cell width70px pt5">
								<input type="text" id="color_heading_0" class="color width50px color_heading"  colorrowid='0' >
						</div>	
						<div class="extract_button_box remove_heading_box fl_imp mt-5 " id="0"><div class="small_btn formTip"><a href="javascript:void(0)"><div class="cat_smll_plus_icon"></div></a></div></div>
					</div>
				</div>
			
			<div id="addImgSection" class="addImgSection"> </div>
			
			
			 <div class="row">
					<div class="cell label_wrapper"><label >Advert Border</label></div>
					
					<div class="cell width70px pr frm_element_wrapper ml20">
						<select id="select_border" class="width68px width80px left0px">
							<?php for($i=0;$i<=50;$i++){  ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>	
						</select>
					</div>	
					<div class="cell width70px f16 frm_element_wrapper">
						<input type="text" id="main_div_bord_clr" class="color width50px main_div_bord_clr color_box" value="000000" >
					</div>	
			 </div>
			 
			<div class="row">
				<div class="cell label_wrapper"><label >Background</label></div>
				<div class="cell frm_element_wrapper width320px">
					<div class="row pt5">
							
						<div class="cell defaultP">
						 <input type="radio" name="bgtype" id="bg_flat" class="bgtype" value="0" checked > 
						</div>
						
						<div class="cell mr20">
						  <label class="lH25">Flat</label>
						</div>
						
						<div class="cell defaultP">
							<input type="radio" name="bgtype" id="bg_gradient" class="bgtype" value="1" > 
						</div>
						
						<div class="cell mr20">
						  <label class="lH25">Gradient</label>
						</div>
						
						<div class="cell defaultP">
							<input type="radio" name="bgtype" id="bg_img" class="bgtype" value="2" >
						</div>
						
						<div class="cell mr20">
						  <label class="lH25">Image</label>
						</div>
							
					</div>
				</div>
			</div> 
			
			<div id="div_color"  class="row show_div_0" >
				<div class="cell label_wrapper"><label >Color Picker</label></div>
				<div class="cell frm_element_wrapper width320px" >
					<input type="text" id="color_picker" class="color" value="F15C34" >
				</div>
			</div>  
			
			
			
			<div id="upload_img"  class="row show_div_2 dn" >
				<div class="cell label_wrapper"><label >Select Image</label></div>
				<div class="cell file_browse_wrapper ml_7 mt5" >
					<div class="tds-button Fleft pt5 pa"><button type="button" class="ml12  mt-5 dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" "><span><div class="Fleft">Browse</div></span></button></div>
					<input type='file' id="bg_image" class="file_browse bg_image"  name="bg_image" />
				</div>
				<div class="cell width70px pr "> <input type="text" id="bg_position_left" class="bg_position_left mt5 width50px mr20 left0px" value="0"  placeholder="Left" /></div>
				<div class="cell width70px pr "> <input type="text" id="bg_position_top" class="bg_position_top mt5 width50px mr20 left0px"  value="0" placeholder="Top" /></div>
			</div>  
			
			<div id="div_color"  class="row show_div_1 dn" >
				<div class="cell label_wrapper"><label >Gradient</label></div>
				<div id="gradX"  class="cell frm_element_wrapper ml_7" >
					
				</div>
			</div> 
			
			<div class="row">
				<div class="cell label_wrapper"><label class="select_field"><?php echo $this->lang->line('title');?></label></div>
				<div class="cell frm_element_wrapper width320px" >
					<?php echo form_input($titleInput); ?>
				</div>
			</div>
			
<!-- Div start here for advert sections -->
<div class="row">
	<div class="label_wrapper cell">
		<label><?php echo $this->lang->line('sections');?></label>
	</div>
	<div class="cell frm_element_wrapper"> 
		<?php
		//echo "<pre>";
		//print_r($industrySections);
		//echo "------------------";
		
		//echo "<pre>";
		//print_r($continentWiseCountry);
		
		if(isset($industrySections) && is_array($industrySections) && count($industrySections) > 0){ ?>
		<div class="row">
			<div class="cell">
				<div class="row">
					<div class="cell">
						<div class="countryListing" id="countryListing">
							<div class="shiping_select_box02 width220px height155px">	
								<div class="mr10 ml15 mt10" >
									<?php
									foreach($industrySections as $section){
										$checked=in_array($section->IndustryId, $intrestedCountriesID)?'checked':''; 
										?>
										<div id="industryCreate_<?php echo $section->IndustryId;?>">
											<div class="defaultP">
												<input type="checkbox" class="CreateCheckBox" name="sectionCheckBox[]" id="createSection_<?php echo $section->IndustryId;?>" value="<?php echo $section->IndustryId; ?>" title="<?php echo $section->IndustryName; ?>" <?php echo $checked;?>  />
											</div>
											<div class="cell ml10 width135px"><?php echo $section->IndustryName;?></div>
											<div class="bdr_below_checkbox clear"></div>
										</div>
										 <?php
									}
									?>
									<div class="clear seprator_9"> </div>
								</div>
							</div>	
						</div>
					</div>
					<div class="clear seprator_9"></div>
				</div>
			</div>
			</div>
			<div class="row">
				<div class="cell ">
					<div class=" width200px">
						<?php echo form_textarea($advertCreateSectionInput); ?>
					</div>
					<div class="seprator_5 clear"></div>
					<div class="note_belw_textarea"> <?php echo $this->lang->line('competitionCountriesMsg');?></div>
				</div>
			</div>
		<?php } ?>
	</div> 
</div>
<!-- Div end here for advert sections -->
			
			
			<div class="row">
				<div class="cell label_wrapper"><label >Url</label></div>
				<div class="cell frm_element_wrapper width320px" >
					<?php echo form_input($advertUrl); ?>
				</div>
			</div>
			
			
			
			<!---vis_hid--->
			<div class="save_advert_div">
				<input type="hidden"  id="show_generate_code" name="show_generate_code" value="" />
				<input type="hidden"  id="campaign_id" name="campaign_id" value="<?php echo $campaignId ?>"/>
				<input type="hidden"  id="width" name="width" value=""/>
				<input type="hidden"  id="height" name="height" value=""/>
				<input type="hidden"  id="bg_image_name" name="bg_image_name" value=""/>
				<input type="hidden"  id="createAdvertOrder" name="createAdvertOrder" value=""/>
				<input type="hidden"  id="createAdvertId" name="createAdvertId" value=""/>
				<input type="hidden"  id="advertHeadingField" name="advertHeadingField" value=""/>
				<input type="hidden"  id="advertImgField" name="advertImgField" value=""/>
				<input type="hidden"  id="submitAction" name="submitAction" value="add"/>
				<input type="hidden"  id="headingFieldRow" name="headingFieldRow" value="1"/>
				<input type="hidden"  id="imgFieldRow" name="imgFieldRow" value="0"/>
				<input type="hidden"  id="createAdvertWidth" name="createAdvertWidth" value=""/>
				<input type="hidden"  id="createAdvertHeight" name="createAdvertHeight" value=""/>
				<input type="hidden"  id="createAdvertHeight" name="createAdvertHeight" value=""/>
				<?php echo form_input($sectionIdInput);?>
				
				<div class="tds-button Fright mr20"><button  class="generate_html save_html dash_link_hover" name="saveButton" id="saveButton" type="submit" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" ><span><div class="Fleft">Save</div><div class="icon-publish-btn"></div></span></button></div>
				<div class="tds-button Fright mr5"><button id="CAcancelButton" class="font_arial" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" type="button"><span><div class="Fleft"><?php echo $this->lang->line('cancel'); ?></div> <div class="icon-cancel-btn-new"></div> </span> </button> </div>
						
			</div>
			
			</form>
			<div id="hidden_div_code" class="hidden_div_code dn"> </div> 
			
		<div class="seprator_25 clear row"></div>
	</div>
</div>

<script>
	//Manage create adverts sections listing 
	$(document).ready(function(){	
		$(".CreateCheckBox").click(function() {
			var sectionName = new Array();
			var sectionVal = new Array();
		
			$('.CreateCheckBox:checkbox:checked').each(function(i){
				  sectionVal[i] = $(this).val();  
				  sectionName[i]= $(this).attr('title');
			});	
			//Set name and ids of sections
			$('#advertcreatesectionInputContainer').val(sectionName);
			$('#createSectionIds').val(sectionVal);
		});
	});	
	
		  $(function() {
			//$( "#sortable_heading_field" ).sortable();
			// $( "#sortable" ).disableSelection();
		  });
		
		
	
		//add css style onload 
		$(".main_div").css({
			border: '1px solid',
			width: '250px',
			height: '250px',
			overflow: 'hidden',
			display: 'inline-block',
			background: '#f15c34',
		});
		
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

		$(document).on("click",".save_html",function(){
			
					//-----------prepare html for inserting data----------//	
					
					//set default null div and textarea
					$("#show_generate_code").val('')
					$("#hidden_div_code").html('');
					
					// make clone for saving html
					$("#hidden_div_code").append($(".main_div").clone());
					
					//change path of file 
					var tempPath = "{server_path}openx/www/images/";
					$("#hidden_div_code > .main_div > img").each(function(){
						
						var getImgid = $(this).attr('id');
						var getImgName = $(this).attr('name');
						//getImgName = tempPath + getImgName;
						var replaceAttrId = getImgid.replace(/img_show_/g,'');
						getImgName = tempPath + "{"+getImgid+"}";
						if($("#add_img_"+replaceAttrId).val()!=""){
							$(this).attr('src',getImgName)	
						}
					});
					
					if($("#bg_image_name").val()!=""){
						var bgImgName = baseUrl+'openx/www/images/'+$("#bg_image_name").val();
						$("#hidden_div_code > .main_div").css("background-image", "");
						$("#hidden_div_code > .main_div").css("background-color", "");
						$("#hidden_div_code > .main_div").css('background','url("'+bgImgName+'") no-repeat');
					}
					
					//send html into hidden field
					$("#show_generate_code").val(base64_encode($("#hidden_div_code").html()));	
					
					//daynamic create filed data
					var advertField =  new Array();
					count=0;
					$(".add_img").each(function(){
						
						advertField[count] = $(this).attr("fieldid");
						count++;
					});
					
					$("#advertImgField").val(advertField);
					
					// prepare array for heading field
					var advertHeadingField =  new Array();
					count=0;
					$(".write_heading").each(function(){
						
						advertHeadingField[count] = $(this).attr("textrowid");
						count++;
					});
					
					$("#advertHeadingField").val(advertHeadingField);
					
					
					
						
				//-----------prepare html for inserting data end----------//
			});

		$(document).ready(function(){
			
			$("#create_advert_form").validate();
			
			/*$("#create_advert_form").validate({
			submitHandler: function() {
				
					//-----------prepare html for inserting data----------//	
					
					//set default null div and textarea
					$("#show_generate_code").val('')
					$("#hidden_div_code").html('');
					
					// make clone for saving html
					$("#hidden_div_code").append($(".main_div").clone());
					
					//change path of file 
					var tempPath = "{server_path}openx/www/images/";
					$("#hidden_div_code > .main_div > img").each(function(){
						var getImgName = $(this).attr('name');
						getImgName = tempPath + getImgName;
						$(this).attr('src',getImgName)	
					});
					
					if($("#bg_imgage_name").val()!=""){
						var bgImgName = baseUrl+'openx/www/images/'+$("#bg_imgage_name").val();
						$("#hidden_div_code > .main_div").css("background-image", "");
						$("#hidden_div_code > .main_div").css("background-color", "");
						$("#hidden_div_code > .main_div").css('background','url("'+bgImgName+'") no-repeat');
					}
					
					//send html into hidden field
					$("#show_generate_code").val($("#hidden_div_code").html());	
						
				//	$("#create_advert_form").submit();	
				//-----------prepare html for inserting data end----------//
				
					var width = '';
					var height = '';
					$('.div_size').each(function(){
						if($(this).is(':checked')){
							var obj =  $.parseJSON($(this).val());
							width = obj.width;
							height = obj.height;
						}
					});
					
					var fromData=$("#create_advert_form").serialize();
					fromData +='&width='+width+'&height='+height; 
					var url = baseUrl+language+'/advertising/saveCreateAdvert';
					$.post(url,fromData, function(data) {
					  if(data){
							refreshPge();
						}
					},"json"); 
			}
		});*/

		});
		
	//--------this function is used to convert create advert into base64_encod string--------//	
		
	function base64_encode(data) {
		  // http://kevin.vanzonneveld.net
		  // +   original by: Tyler Akins (http://rumkin.com)
		  // +   improved by: Bayron Guevara
		  // +   improved by: Thunder.m
		  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		  // +   bugfixed by: Pellentesque Malesuada
		  // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
		  // +   improved by: Rafał Kukawski (http://kukawski.pl)
		  // *     example 1: base64_encode('Kevin van Zonneveld');
		  // *     returns 1: 'S2V2aW4gdmFuIFpvbm5ldmVsZA=='
		  // mozilla has this native
		  // - but breaks in 2.0.0.12!
		  //if (typeof this.window['btoa'] == 'function') {
		  //    return btoa(data);
		  //}
		  var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
		  var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
			ac = 0,
			enc = "",
			tmp_arr = [];

		  if (!data) {
			return data;
		  }

		  do { // pack three octets into four hexets
			o1 = data.charCodeAt(i++);
			o2 = data.charCodeAt(i++);
			o3 = data.charCodeAt(i++);

			bits = o1 << 16 | o2 << 8 | o3;

			h1 = bits >> 18 & 0x3f;
			h2 = bits >> 12 & 0x3f;
			h3 = bits >> 6 & 0x3f;
			h4 = bits & 0x3f;

			// use hexets to index into b64, and append result to encoded string
			tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
		  } while (i < data.length);

		  enc = tmp_arr.join('');

		  var r = data.length % 3;

		  return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);

	}
	
	$("#CAcancelButton").click(function(){
			var browseId = '<?php echo $browseId;?>';
			$('#advertMediaForm')[0].reset();
			$('#advertMediaForm form input[type=hidden]').val('');
			$('#browseId').val('<?php echo $browseId;?>');
			$("#advertMediaFormDiv").slideToggle('slow');
			$('.CheckBox').parent().removeClass('ez-checked'); //remove checked checkbox class
		});
	
	
	
</script>

