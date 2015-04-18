
<div class="newlanding_container">
  <div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels edit_section"> 
      <!-- ================================main tab content  ======================= -->
      <div class="width635 m_auto">
        <h3>Select your Cover Image* </h3>
        <h4> The full size image will appear in your ShowcaseThis image will be used
          throughout Toadsquare: on landing pages, search results,and craves etc.
          It will also  appear on social media sites if your work is shared. </h4>
      </div>
      <div class="sap_20"></div>
      <div class="edit_fvv  bc2c2c2 position_relative"> 
          <!--       <img src="images/edit_fv.jpg" alt="" /> -->
           <div class='frame'>
              <img id='sample_picture' src='<?php echo $imgPath; ?>edit_fv.jpg'>
           </div>
        
        <div class="upload_sec position_absolute fs20 "> <i class="edit_tab"></i> Upload your Display Image* 
        
        <input type="file" name="filUpload" id="filUpload" class="filuploadselect" onchange="showimagepreview(this)" />
        </div>
        <div class="drag_zoom text_alighC position_absolute"> <span class=" clr_fff">Drag image to reposition </span>
          <div class="sap_20"></div>
          <i id='fit'  class="direction_icon edit_i noselect"></i>
          <div class="sap_10"></div>
          <i  id='zoom_in'  class="zoom_plus edit_i fl noselect"></i> 
          <i  id='zoom_out' class="zoom_minus edit_i fr noselect"></i> 
        </div>
      </div>
      <div class="sap_25"></div>
      <div class="width635 m_auto">
        <div class="fl width382"> <span class="red font_bold"> Recommended dimensions: </span>
          <div class="sap_15"></div>
          <p>Minimum 1000 pixels wide. </p>
          <p>Maximum 562 pixels high</p>
          <div class="sap_15"></div>
          <p>If your image is larger you can drag it into position </p>
          <div class="sap_15"></div>
          <p>For Films & Videos, images in portrait orientation should not
            be used. </p>
        </div>
        <div class="fr"> <span class="red font_bold"> Accepted File Types: </span>
          <div class="sap_15"></div>
          <p>gif, jpeg, jpg, png, tiff, tif, raw,<br />
            bmp, ppm, pgm, pmb, pnm, tga. </p>
        </div>
        <div class="pt45 pb10 fs20  clearbox">OR</div>
        <h3 class="mt0">Embed Image</h3>
        <div class="sap_30"></div>
        <textarea class="font_wN width_615 red_bdr_2  height38"  type="text" ></textarea>
        <div class="sap_30"></div>
        <ul class="listpb15">
          <li class="icon_2"> If you have photos on a photo sharing site, you can use the embed code from the image
            on that site here. </li>
          <li class="icon_2">If you do not add an image, the above default image will appear on your Showcase. </li>
        </ul>
        <div class="fr btn_wrap display_block ">
          <button class=" bg_ededed bdr_b1b1b1 mr5">Cancel</button>
          <button class=" back bdr_b1b1b1 mr5">Pause </button>
          <button class=" back bdr_b1b1b1 mr5">Back </button>
          <button class="b_F1592A bdr_F1592A"> Next </button>
        </div>
        <div class="sap_30"></div>
      </div>
    </div>
  </div>
</div>


<a href="javascript:void(0)" id="creaveimage">upload file</a>

<script type='text/javascript'>
var imgType = "";
function showimagepreview(input) {
    if (input.files && input.files[0]) {
    var filerdr = new FileReader();
    
    
    filerdr.onload = function(e) {
        
        var image = new Image();
        image.src = filerdr.result;
        
        if(image.width < 1000 || image.height > 562){
            customAlert("Image dimensions should be Minimum 1000 pixels wide and Maximum 562 pixels high.");
            return false;
        }
        
        $('#sample_picture').attr('src', e.target.result);
        $('#fit').trigger("click");
    }
    
    imgType = input.files[0].type;
    
    filerdr.readAsDataURL(input.files[0]);
    }
}    
    
jQuery(function() {
  var picture = $('#sample_picture');
      
        // Initialize plugin (with custom event)
        picture.guillotine({
            width: 1000,
            height: 562,
            eventOnChange: 'guillotinechange'
        });

        // Display inital data
        var data = picture.guillotine('getData');
        
        
        for(var key in data) { $('#'+key).html(data[key]); }

        $('#fit').click(function(){ picture.guillotine('fit'); });
        $('#zoom_in').click(function(){ picture.guillotine('zoomIn'); });
        $('#zoom_out').click(function(){ picture.guillotine('zoomOut'); });

        // Update data on change
        picture.on('guillotinechange', function(ev, data, action) {
            
           
        });
  
});


$("#creaveimage").click(function(){
    
    var left = $(".guillotine-canvas").position().left;
    var top = $(".guillotine-canvas").position().top;
    var width = $(".guillotine-canvas").width();
    var height = $(".guillotine-canvas").height();
    
    var canvas, canvasContext;
    
    canvas = $("<canvas />").attr({
                width: 1000,
                height: 562
            }).get(0);
     
    var img = document.getElementById("sample_picture");
    
    canvasContext = canvas.getContext("2d");
   
    canvasContext.drawImage(img,left,top,width,height);
    
    var imageData =  canvas.toDataURL(imgType, 1.0);
    
    $.post( baseUrl+language+'/mediafrontend/cropupload', { "imageData": imageData }, function( data ) {
        //console.log( data.name ); // John
        //console.log( data.time ); // 2pm
    });
    
});


</script>    
