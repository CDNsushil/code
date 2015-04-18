/*
 * Create Date : 22-Oct-2013
 * Auther **Lokendra Meena**
 * Description: This libarary for making own advert
 * Add Image file and background image file no need to on sever
 * But if you want save file on server un-comment generate html section code 
 */ 
	
		
		// change background color flat or Gradient
		$(document).on('click','.bgtype', function(){	
			
				//default all hide onclick	
				$(".show_div_0").hide();
				$(".show_div_1").hide();
				$(".show_div_2").hide();
				
				var chkVal = $(this).val()
				$(".show_div_"+chkVal).show();
				
				if(chkVal==0 || chkVal==2){	
					var color_picker = $("#color_picker").val();
					$("#main_div_id").css("background-color","#"+color_picker);
					$("#main_div_id").css("background-image","none");
					$("#main_div_id").css("background-repeat","");
				}
				
				if(chkVal==1){	
					 gradX("#gradX", {
						direction: "top",
						targets: [".main_div"]
					});
					
					//create jquery select box
					selectBox();
				}
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
			'font-size':'30px',
			'font-weight':'normal'
		});
		
		//flat background date picker
		$(document).on('change','#color_picker', function(){
			var getBgColor = $(this).val();
			$("#main_div_id").css("background-color","#"+getBgColor);
			$("#main_div_id").css("background-image","none");
			$("#main_div_id").css("background-repeat","");
		});
	
		//heading text change
		$(document).on('keyup','.write_heading', function(){
			var rowid = $(this).attr('textrowid')
			if($(this).val()!=""){
				$(".show_heading_"+rowid).html($(this).val());
			}
		});
		
		// heading font-size change
		$(document).on('change','.font_size_heading', function(){
			var selectrowid = $(this).attr('selectrowid');
			var fontSize = $(this).val();
			$(".show_heading_"+selectrowid).css("font-size",fontSize+"px");
		});
		
		//heading set bold 
		$(document).on('click','.heading_bold', function(){
			var boldrowid = $(this).attr('boldrowid');
				if($("#heading_bold_"+boldrowid).is(':checked'))
					$(".show_heading_"+boldrowid).css("font-weight","bold");           
				else
					$(".show_heading_"+boldrowid).css("font-weight","normal");          
				
		});
		
		
		//heading color change color picker
		$(document).on('change','.color_heading', function(){
			var colorVal = $(this).val();
			var colorrowid = $(this).attr('colorrowid');
			$(".show_heading_"+colorrowid).css("color","#"+colorVal);  
		});
		
		
		// main div border change
		
		$(document).on('change','#select_border', function(){
			var brd = $(this).val();
			var getColor = $("#main_div_bord_clr").val();
			$("#main_div_id").css("border",brd+"px solid");
			$("#main_div_id").css("border-color","#"+getColor);
		});
		
		// main div border color manage css
		$(document).on('change','#main_div_bord_clr', function(){
			var getColor = $(this).val();
			$("#main_div_id").css("border-color","#"+getColor);
		});
		
		// onclick deimention change div size
		$(document).on('click','.div_size', function(){
			var sizeObj= $.parseJSON($(this).val());
			$(".main_div").css("width",sizeObj.width+"px");
			$(".main_div").css("height",sizeObj.height+"px");
		});	
		
		
		// draggable div 
		$(function() {
			$( ".show_heading_0").draggable({ distance: 10, cursor: "crosshair" });
			$( "#show_text").draggable({ distance: 10, cursor: "crosshair" });
		});
		
		//add daynamic heading box
		$(document).on("click",".add_heading_box",function(){
			
			var textRow=$("#headingFieldRow").val();
			// bind jscolor box
			var newColorBox = document.createElement('INPUT')
			newColorBox.type="text";
			newColorBox.id='color_heading_'+textRow;
			newColorBox.className='color width50px color_heading';
			newColorBox.setAttribute("colorrowid",textRow);
			
			// create colorbox object for daynamic create color box
			var col = new jscolor.color(newColorBox)
			
			var check_p_show_exist = 0;
			$( ".p_show").each(function(){
				check_p_show_exist++;
			});
		
			//add <p> in div of advert
			if(check_p_show_exist==0){
				$( "#main_div_id").append( '<p id="show_heading_'+textRow+'" class="show_heading_'+textRow+' p_show">Dummy Text </p>' );
			}else{
				$( ".p_show").last().after( '<p id="show_heading_'+textRow+'" class="show_heading_'+textRow+' p_show">Dummy Text </p>' );
			}
			
			
			// add field in form of create advert
			var addHeading = '<div class="row  heading_filed_'+textRow+' heading_form" id="form_'+textRow+'" ><div class="cell label_wrapper">&nbsp;</div>';
			
			addHeading += '<div class="cell frm_element_wrapper width160px"><input type="text" id="write_heading_'+textRow+'" name="write_heading['+textRow+']" class="write_heading width140px" textrowid='+textRow+'></div>';
			
			addHeading += '<div class="cell width_85 pr"> <select id="font_size_heading_'+textRow+'" class="font_size_heading mt_minus_2 width80px mr20 left0px" selectrowid="'+textRow+'">';
			
				for(var i=10;i<=100;i++){
					addHeading += '<option value="'+i+'">'+i+'</option>';
				}
				
			addHeading += '</select></div>';				
			
			addHeading += '<div class="cell defaultP pt11 ml5 width45px lh40 tal" id="head_bold_field_'+textRow+'"><input type="checkbox" id="heading_bold_'+textRow+'" class="heading_bold" boldrowid="'+textRow+'"></div>';				
								
			//addHeading +=	'<div class="tds-button Fleft pt5"><button type="button" id="'+textRow+'" class="cancel remove_heading_box dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" "><span><div class="Fleft">Remove</div></span></button></div>';
			addHeading +=	'<div class="extract_button_box remove_heading_box fl_imp mt-5 " id="'+textRow+'"><div class="small_btn formTip"><a href="javascript:void(0)"><div class="cat_smll_plus_icon"></div></a></div></div>';
			
			// end main div
			addHeading +=	'</div>';
			
			// append all create row div 
			if(check_p_show_exist==0){
				//$("#heading_div_show").after(addHeading);
				$(".sortable_heading_field").append(addHeading);
			}else{
				$(".heading_form").last().after(addHeading);
			}
			
			
			//create jquery check box
			runTimeCheckBox();
			
			//create jquery select box
			selectBox();
			
			// add color box section
			$('#head_bold_field_'+textRow).after('<div class="cell width70px pt5" id="head_color_field_'+textRow+'"><div>');	
			$('#head_color_field_'+textRow).append(newColorBox);	
			
			
			//add css heading <p> heading
			$(".show_heading_"+textRow).css({
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
			
			// load draggable function		
			$( ".show_heading_"+textRow).draggable({ distance: 10, cursor: "crosshair", containment: "#main_div_id" });	
		
			textRow++;	
			$("#headingFieldRow").val(textRow);		
						
	});  

	//remove daynamic heading box
	$(document).on("click",".remove_heading_box",function(){
		var delrowid = $(this).attr('id');
		$("#form_"+delrowid).remove();
		$("#show_heading_"+delrowid).remove();
		var headingFieldRow = $("#headingFieldRow").val();
	//	headingFieldRow = headingFieldRow - 1;
	//	$("#headingFieldRow").val(headingFieldRow)
	});	
	
	// image select in background image
	$(document).on("change",".bg_image",function(){
		
		//get div width and height
		var divWidth =  $("#createAdvertWidth").val();
		var divHeight =  $("#createAdvertHeight").val();
			
		//daynamic add image and manage it
		var addImg = new FileReader(); 
		var image  = new Image();
	
		var imgName = this.files[0].name;
		addImg.readAsDataURL(this.files[0]);
		
		addImg.onload = function(e) {
			var imgSrc  =  e.target.result;
			image.src    = e.target.result; 
		
			image.onload = function() {
				var w = this.width,
					h = this.height,
					t = e.type,                           // ext only: // file.type.split('/')[1],
					n = e.name,
					s = ~~(e.size/1024) +'KB';
					
					if(w==divWidth && h==divHeight){
						$("#bg_image_name").val(imgName); 
						$(".main_div").css("background-image", "");
						$(".main_div").css("background-color", "");
						$(".main_div").css('background','url("'+imgSrc+'") no-repeat');
					}else{
						alert("Image size should be "+divWidth+" X "+divHeight+".");
						return false;
					}
				};
				
				image.onerror= function() {
					alert('Invalid file type: '+ file.type);
				};  	
			};
	});
	
	/*
	//change background image change by css
	var reader = new FileReader(); 
	reader.onload = function(e) {
		$(".main_div").css("background-image", "");
		$(".main_div").css("background-color", "");
		$(".main_div").css('background','url("'+e.target.result+'") no-repeat');
		
	};
	// uploaded image preview show by this code
	function readURL(input){ 
	   if(input.files && input.files[0]){
		   // set bg image name in hidden filed
		   var imgName = input.files[0].name;
		  // console.log(imgName);
		   $("#bg_image_name").val(imgName); 
		   
		   reader.readAsDataURL(input.files[0]);
	   }
	   else {
			document.images[0].src = input.value || "No file selected";
	   }
	}*/

	
	
	//this sectoin add add image filed
	
	$(document).on("click",".add_img_field",function(){
		
		fieldCount=$("#imgFieldRow").val();
		
		//default blank temp div
		$("#show_generate_code").html('');
		$("#hidden_div_code").html('');
		
		var addSection = '<div class="row  img_filed"  id="img_filed_'+fieldCount+'"><div class="cell label_wrapper">&nbsp;</div>';
	
		var browseButton = '<div class="tds-button Fleft pt5 pa"><button type="button" class="ml12  mt-5 dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" "><span><div class="Fleft">Browse</div></span></button></div>';
		
		addSection += '<div class="cell width80px file_browse_wrapper ml_7"> '+browseButton+' <input type="file" name="add_img_'+fieldCount+'" id="add_img_'+fieldCount+'" fieldId="'+fieldCount+'" class="add_img file_browse" /></div>';
		
		/*addSection += '<div class="cell width100px pr "> <select id="add_img_width_'+fieldCount+'" class="add_img_width width100px mr20 left0px mt-8" selectimgwidth="'+fieldCount+'"><option value=" ">Width</option> ';
		for(var i=0;i<=600;i++){
			addSection += '<option value="'+i+'">'+i+'</option>';
		}
		addSection += '</select> </div>';
		
		addSection += '<div class="cell width100px pr "> <select id="add_img_height_'+fieldCount+'" class="add_img_height width100px mr20 left0px mt-8" selectimgheight="'+fieldCount+'"><option value=" ">Height</option>';
		for(var j=0;j<=250;j++){
			addSection += '<option value="'+j+'">'+j+'</option>';
		}
		addSection += '</select></div>'; */
		
		addSection += '<div class="cell width90px pr "> <input type="text" id="add_img_width_'+fieldCount+'" class="add_img_width width50px left0px"  placeholder="Width" selectimgwidth="'+fieldCount+'"/> PX</div> ';
		
		addSection += '<div class="cell width90px pr "> <input type="text" id="add_img_height_'+fieldCount+'" class="add_img_height width50px left0px"  placeholder="Height" selectimgheight="'+fieldCount+'" /> PX</div>';
		
		//addSection +=	'<div class="tds-button Fleft"><button type="button" id="'+fieldCount+'" class="cancel remove_img_field dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" "><span><div class="Fleft">Remove</div></span></button></div>';
		addSection +=	'<div class="extract_button_box remove_img_field fl_imp mt-5 " id="'+fieldCount+'"><div class="small_btn formTip"><a href="javascript:void(0)"><div class="cat_smll_plus_icon"></div></a></div></div>';
			
		
		addSection += '</div>';
		
		$("#addImgSection").append(addSection);
		
		//create jquery select box
		selectBox();
		
		fieldCount++;	
		$("#imgFieldRow").val(fieldCount);
	});	
	
	
	// image select in add image
	$(document).on("change",".add_img",function(){
		
		//get div width and height
		var divWidth =  $("#createAdvertWidth").val();
		var divHeight =  $("#createAdvertHeight").val();
			
		//daynamic add image and manage it
		var addImg = new FileReader(); 
		var image  = new Image();
	
		//default blank temp div
		$("#show_generate_code").html('');
		$("#hidden_div_code").html('');
		
		var fieldId = $(this).attr('fieldId');
		
		var imgName = this.files[0].name;
		addImg.readAsDataURL(this.files[0]);
		
		addImg.onload = function(e) {
			var imgSrc  =  e.target.result;
			 image.src    = e.target.result; 
			var getwidth = '';
			var getheight = '';
			
			image.onload = function() {
				var w = this.width,
					h = this.height,
					t = e.type,                           // ext only: // file.type.split('/')[1],
					n = e.name,
					s = ~~(e.size/1024) +'KB';
					
					if(w <= divWidth && h <= divHeight){
					
						//change url previous upload image
							var countImg= 0;
							$(".img_show_"+fieldId).each(function(){
								countImg++;
							});
							
							if(countImg > 0){
								//$("#img_show_"+fieldId).remove();
								$("#img_show_"+fieldId).attr('src',imgSrc)
							}else{
								//append image in main div
								$("#image_append_show").after( '<img src='+imgSrc+' id="img_show_'+fieldId+'" name="'+imgName+'" class="img_show_'+fieldId+' add_show_img" style="display:block;float:left"  />');
								$("#img_show_"+fieldId).css({top:"0px"});
							}
						//load draggable image in main div	
						$("#img_show_"+fieldId).draggable({ containment: 'parent',cursor: "crosshair", containment: "#main_div_id" });
					}else{
						alert("Image size should be less or equal to "+divWidth+" X "+divHeight+".");
						return false;
					}
				};
				
				image.onerror= function() {
					alert('Invalid file type: '+ file.type);
				}; 
			};
	});
	
	// change daynamic add image width 
	$(document).on('keyup','.add_img_width', function(){
		var selectWidth = $(this).attr('selectimgwidth');
		var size = $(this).val();
		$("#img_show_"+selectWidth).css("width",size+"px");
	});
	
	// change daynamic add image height 
	$(document).on('keyup','.add_img_height', function(){
		var selectHeight = $(this).attr('selectimgheight');
		var size = $(this).val();
		$("#img_show_"+selectHeight).css("height",size+"px");
	});
	
	
	// change bg position add image height 
	$(document).on('keyup','.bg_position_left', function(){
		var positionleft = $(this).val();
		var positiontop = $("#bg_position_top").val();
		$(".main_div").css("background-position-x",positionleft+"px");
		$(".main_div").css("background-position-y",positiontop+"px");
	});
	
	
	// change bg position add image height 
	$(document).on('keyup','.bg_position_top', function(){
		var positiontop = $(this).val();
		var positionleft = $("#bg_position_left").val();
		$(".main_div").css("background-position-x",positionleft+"px");
		$(".main_div").css("background-position-y",positiontop+"px");
	});
		
	//remove daynamic add image field
	$(document).on("click",".remove_img_field",function(){
		var delrowid = $(this).attr('id');
		$("#img_filed_"+delrowid).remove();
		$("#img_show_"+delrowid).remove();
		var imgFieldRow = $("#imgFieldRow").val();
		//imgFieldRow = imgFieldRow - 1;
		//$("#imgFieldRow").val(imgFieldRow)
	});	
	
	
	// generate create advert code	
	/*$(document).on("click",".generate_html",function(){
		
		//set default null div and textarea
		$("#show_generate_code").html('')
		$("#hidden_div_code").html('');
		
		// make clone for saving html
		$("#hidden_div_code").append($(".main_div").clone());
		
		//Want change path of file save file on sever then un-comment this code
		/*var tempPath = "{server_path}images/";
		$("#hidden_div_code > .main_div > img").each(function(){
			var getImgName = $(this).attr('name');
			getImgName = tempPath + getImgName;
			$(this).attr('src',getImgName)	
		});
		
		if($("#bg_imgage_name").val()!=""){
			var bgImgName = 'images/'+$("#bg_imgage_name").val();
			$("#hidden_div_code > .main_div").css("background-image", "");
			$("#hidden_div_code > .main_div").css("background-color", "");
			$("#hidden_div_code > .main_div").css('background','url("'+bgImgName+'") no-repeat');
		}
		
		//send html into textarea
		$("#show_generate_code").html($("#hidden_div_code").html());
	});	*/
	
	
	
	
	
	//-------------------create headding field section---------------//
	
	function createHeadingField(key,value){
		
			//add daynamic heading box
			//var textStr = key; 
			var textRow = key;  
		
			// bind jscolor box
			var newColorBox = document.createElement('INPUT')
			newColorBox.type="text";
			newColorBox.id='color_heading_'+textRow;
			newColorBox.className='color width50px color_heading';
			newColorBox.setAttribute("colorrowid",textRow);
			
			// create colorbox object for daynamic create color box
			var col = new jscolor.color(newColorBox)
			
			var check_p_show_exist = 0;
			$( ".heading_form").each(function(){
				check_p_show_exist++;
			});
		
			// add field in form of create advert
			var addHeading = '<div class="row  heading_filed_'+textRow+' heading_form" id="form_'+textRow+'" ><div class="cell label_wrapper">&nbsp;</div>';
			
			addHeading += '<div class="cell frm_element_wrapper width160px"><input type="text" id="write_heading_'+textRow+'" value="'+value+'" name="write_heading['+textRow+']" class="write_heading width140px" textrowid='+textRow+'></div>';
			
			addHeading += '<div class="cell width_85 pr"> <select id="font_size_heading_'+textRow+'" class="font_size_heading mt_minus_2 width80px mr20 left0px" selectrowid="'+textRow+'">';
			
				for(var i=10;i<=100;i++){
					addHeading += '<option value="'+i+'">'+i+'</option>';
				}
				
			addHeading += '</select></div>';				
			
			addHeading += '<div class="cell defaultP pt11 ml5 width45px lh40 tal" id="head_bold_field_'+textRow+'"><input type="checkbox" id="heading_bold_'+textRow+'" class="heading_bold" boldrowid="'+textRow+'"></div>';				
								
			//addHeading +=	'<div class="tds-button Fleft pt5"><button type="button" id="'+textRow+'" class="cancel remove_heading_box dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" "><span><div class="Fleft">Remove</div></span></button></div>';
			addHeading +=	'<div class="extract_button_box remove_heading_box fl_imp mt-5 " id="'+textRow+'"><div class="small_btn formTip"><a href="javascript:void(0)"><div class="cat_smll_plus_icon"></div></a></div></div>';
			
			// end main div
			addHeading +=	'</div>';
			
			// append all create row div 
			if(check_p_show_exist==0){
				//$("#heading_div_show").after(addHeading);
				$(".sortable_heading_field").append(addHeading);
			}else{
				$(".heading_form").last().after(addHeading);
			}
			
			//create jquery check box
			runTimeCheckBox();
			
			//create jquery select box
			selectBox();
			
			// add color box section
			$('#head_bold_field_'+textRow).after('<div class="cell width70px pt5" id="head_color_field_'+textRow+'"><div>');	
			$('#head_color_field_'+textRow).append(newColorBox);	
			
			// load draggable function		
			$( ".show_heading_"+textRow).draggable({ distance: 10, cursor: "crosshair", containment: "#main_div_id" });	
	
		}
		
		
	//--------------create image field------------//	
	
	
	function createImgField(key,value){
			//this sectoin add add image filed
			fieldCount=key;
		
			//default blank temp div
			$("#show_generate_code").html('');
			$("#hidden_div_code").html('');
			
			var addSection = '<div class="row  img_filed"  id="img_filed_'+fieldCount+'"><div class="cell label_wrapper">&nbsp;</div>';
		
			var browseButton = '<div class="tds-button Fleft pt5 pa"><button type="button" class="ml12  mt-5 dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" "><span><div class="Fleft">Browse</div></span></button></div>';
			
			addSection += '<div class="cell width80px file_browse_wrapper ml_7"> '+browseButton+' <input type="file" name="add_img_'+fieldCount+'" id="add_img_'+fieldCount+'" fieldId="'+fieldCount+'" class="add_img file_browse" /></div>';
			
			addSection += '<div class="cell width90px pr "> <input type="text" id="add_img_width_'+fieldCount+'" class="add_img_width width50px left0px"  placeholder="Width" selectimgwidth="'+fieldCount+'"/> PX</div> ';
			
			addSection += '<div class="cell width90px pr "> <input type="text" id="add_img_height_'+fieldCount+'" class="add_img_height width50px left0px"  placeholder="Height" selectimgheight="'+fieldCount+'" /> PX</div>';
			
			//addSection +=	'<div class="tds-button Fleft"><button type="button" id="'+fieldCount+'" class="cancel remove_img_field dash_link_hover" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)" "><span><div class="Fleft">Remove</div></span></button></div>';
			addSection +=	'<div class="extract_button_box remove_img_field fl_imp mt-5 " id="'+fieldCount+'"><div class="small_btn formTip"><a href="javascript:void(0)"><div class="cat_smll_plus_icon"></div></a></div></div>';
				
			
			addSection += '</div>';
			
			$("#addImgSection").append(addSection);
			
			selectBox();
			
			//load draggable image in main div	
			$("#img_show_"+fieldCount).draggable({ containment: 'parent',cursor: "crosshair", containment: "#main_div_id" });
	}
