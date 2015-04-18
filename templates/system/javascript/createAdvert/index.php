<html>
    <head>
        <title>create Advert</title>
	
	   
	    <link type="text/css" rel="stylesheet" href="js/gradX.css" />
        <link type="text/css" rel="stylesheet" href="colorpicker/css/colorpicker.css" />
		<link type="text/css" rel="stylesheet" href="js/advert.css" />

        <script src="js/jquery-1.9.1.js"></script>
		
		<script src="js/jquery-ui.js"></script>
        <script src="colorpicker/js/colorpicker.js"></script>
        <script src="js/dom-drag.js"></script>
        <script type="text/javascript" src="jscolor/jscolor.js"></script>
		<script src="js/gradX.js"></script>
		<script src="js/advert.js"></script>
	</head>

	<body>
		<div>
			<div class="fl width_height_700" >
		
				
					<div class="main_div" id="main_div_id">
						<p id="show_heading_0" class="show_heading_0 p_show" >Dummy Text </p>
					</div>
			
			</div>
				
				<div class="fl width_height_700">
					<p style="text-align:right;padding-right:15px"><button class="generate_html">Generate Html</button></p>
					  <div class="form">
						 <br> 
						250px X 250px <input type="radio" name="div_size"  class="div_size" value='{"width":"250","height":"250"}' checked > 
						160px X 600px <input type="radio" name="div_size"  class="div_size" value='{"width":"160","height":"600"}' > 
						468px X 60px <input type="radio" name="div_size"  class="div_size" value='{"width":"468","height":"60"}'  >  
						  
						<br><br>
						 <button class="add_heading_box">Add Heading</button>	
						<p class="form_filed heading_filed_0 heading_form" id="form_0" >
							Heading <input type="text" id="write_heading_0" class="write_heading" textrowid='0'>
						Font Size   
							<select id="font_size_heading_0" class="font_size_heading" selectrowid='0'>
									<?php for($i=10;$i<=100;$i++){  ?>
										<option value="<?php echo $i; ?>" <?php echo ($i=="30")?'selected="selected"':''; ?> ><?php echo $i; ?></option>
									<?php } ?>
							</select>
						Bold
						<input type="checkbox" id='heading_bold_0'  class="heading_bold"  boldrowid='0'>
						Color
						<input type="text" id="color_heading_0" class="color color_heading"  colorrowid='0' >
						</p> 	
						<p class="form_filed">Add Image
						
						<button id="add_img_field" class="add_img_field" >Add</button> 
						
						<div id="addImgSection"> </div>
						
						
						</p>
						<p class="form_filed">Border 
							<select id="select_border">
							<?php for($i=0;$i<=50;$i++){  ?>
								<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
							<?php } ?>	
							</select>
							
							Border Color
							<input type="text" id="main_div_bord_clr" class="color main_div_bord_clr color_box" >
						</p> 
						
						Background <br>
						
						Flat <input type="radio" name="bgtype" id="bg_flat" class="bgtype" value="0" checked > 
						Gradient <input type="radio" name="bgtype" id="bg_gradient" class="bgtype" value="1" > 
						Image <input type="radio" name="bgtype" id="bg_img" class="bgtype" value="2" > 
						
						</div> 
						<br>
						
						<div id="div_color"  class="show_div_0 dn">
							Color Picker <input type="text" id="color_picker" class="color" >
						</div>
						
						<div id="gradX" class="show_div_1 dn"></div>
					 
						<div id="upload_img" class="show_div_2 dn">  
								   <input type='file' id="bg_image" "bg_image"  onchange="readURL(this);"  />
						</div>
						
						
				</div>
				
				<form id="code_form" name="code_form" action="" method="post">
				<textarea id="show_generate_code" name="show_generate_code" rows="10" cols="80"></textarea>
				<input type="hidden" id="bg_imgage_name"  class="bg_imgage_name" value="" />
				<input type="button" value="Submit" name="submit" id="name" class="generate_html" onclick="return insert();">
				</form>
		</div>	
        
        <div id="hidden_div_code" class="hidden_div_code dn"> </div> 
        

        <script>
			
				
			function insert(){
				
				//*******prepare html for inserting data*************/
					
				//set default null div and textarea
				$("#show_generate_code").html('')
				$("#hidden_div_code").html('');
					
				// make clone for saving html
				$("#hidden_div_code").append($(".main_div").clone());
				
				//send html into textarea
				$("#show_generate_code").html($("#hidden_div_code").html());	
						
				var fromData=$("#code_form").serialize();
				baseUrl = "http://localhost/gradx/";
				var url = baseUrl+'submit.php';
				$.post(url,fromData, function(data) {
				  if(data){
					
				  }
				},"json");
				return false;
			}	
		
		</script>
	
    </body>
	

</html>
