<?php 

$displayImageForm = array(
'name'=>'displayImageForm',
'id'=>'displayImageForm',
);

// set base url
$baseUrl = base_url(lang().'/showcase/');
$stockChecked = '';
$stockImageId = 0;

$browseId           =   '1';
$fileSize           =   0;   
$filePath           =   $dirUploadMedia;
$imgload            =   0;    
$fileName           =   ''; 
$allowedMediaType   =   str_replace(',',', ',$this->config->item('imageType'));
$mediaFileTypes     =   $this->config->item('imageAccept');
$fileNameInput = array(
    'name'	=> 'fileName'.$browseId,
    'value'	=> $fileName,
    'id'	=> 'fileName'.$browseId,
    'type'	=> 'hidden',
);

$fileSizeInput = array(
    'name'	=> 'fileSize'.$browseId,
    'value'	=> $fileSize,
    'id'	=> 'fileSize'.$browseId,
    'type'	=> 'hidden'
);

$typeOfFileInput = array(
    'name'	=> 'fileType'.$browseId,
    'value'	=> 1,
    'id'	=> 'fileType'.$browseId,
    'type'	=> 'hidden'
);

$inputArray = array(
    'name'	=> 'fileInput'.$browseId,
   // 'class'	=> 'fl width_280 p12 bdr_adadad pb11 ',
    'value'	=> '',
    'id'	=> 'fileInput'.$browseId,
    'type'	=> 'hidden',
    'readonly'	=> true
);

$fileUploadPathInput = array(
    'name'	=> 'fileUploadPath'.$browseId,
    'value'	=> $filePath,
    'id'	=> 'fileUploadPath'.$browseId,
    'type'	=> 'hidden'
);

$fileErrorInput = array(
    'name'	=> 'fileErrorInput'.$browseId,
    'value'	=> '0',
    'id'	=> 'fileErrorInput'.$browseId,
    'type'	=> 'hidden'
);

$browseIdField = array(
    'name'	=> 'browseId',
    'value'	=> $browseId,
    'id'	=> 'browseId',
    'type'	=> 'hidden'
);

//next page url 
$nextUrl  =  base_url(lang().'/showcase/showcasedetails');


?>

<?php echo form_open($baseUrl.'/uploadelementfilepost',$displayImageForm); ?>
 
<div class="newlanding_container">
  <div class="wizard_wrap fs14 ">
    <div id="TabbedPanels1" class="TabbedPanels edit_section"> 
    
     <!-- ================================main tab content  ======================= -->
    <div id="uploadFileByJquery<?php echo $browseId;?>"></div>
    <div id="FileContainer<?php echo $browseId;?>" class="fr">
        <div class="fileInfo" id="fileInfo<?php echo $browseId;?>">
            <div id="progressBar<?php echo $browseId;?>" class="plupload_progress">
                <div class="progressBar_msg fl"><?php echo $this->lang->line('fileUploading');?></div>
                <div class="plupload_progress_container fl">
                    <div id="plupload_progress_bar<?php echo $browseId;?>" class="plupload_progress_bar"></div>
                </div>
            </div>
            <span id="percentComplete<?php echo $browseId;?>" class="percentComplete fl"></span>
        </div>
        <div id="dropArea<?php echo $browseId;?>"></div>
    </div>
   
   
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
              <img id='preview_image' imgtype="" src='<?php echo $imgPath; ?>edit_fv.jpg'>
           </div>
        
       
         <div class="input_box ptr" id="uploadFileSection<?php echo $browseId;?>" >
            <div>
                <div class="<?php echo $VFS;?> <?php echo $UF;?><?php echo $imgLoadClass;?>" id="Uploadvideo<?php echo $browseId;?>">
                    <div id="FileUpload<?php echo $browseId;?>">
                        <?php echo form_input($inputArray); ?>
                        <div id="browsebtn<?php echo $browseId;?>" class="filecropbtn"> 
                            <div  id="uploadBtn"  class="upload_sec position_absolute fs20 "> 
                                <i class="edit_tab"></i> Upload your Display Image* 
                            </div>
                        </div>
                        <div id="fileError<?php echo $browseId;?>" class="validation_error position_absolute pt10"></div>
                    </div>
                    <div id="rawFileNameDiv<?php echo $browseId;?>"></div>
                </div>
            </div>  

            <div id="fileTypeRuntimeDiv<?php echo $browseId;?>">
                <input type="hidden" value="<?php echo $mediaFileTypes;?>" id="fileTypeRuntime<?php echo $browseId;?>" />
            </div>
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
          <button type="button" class="b_F1592A bdr_F1592A creaveimage"> Next </button>
        </div>
        <div class="sap_30"></div>
      </div>
    </div>
  </div>
</div>


<?php  
    echo form_input($fileNameInput);
    echo form_input($fileSizeInput);
    echo form_input($typeOfFileInput);
    echo form_input($fileUploadPathInput);
    echo form_input($fileErrorInput);
    echo form_input($browseIdField);
     
echo form_close(); ?>


<script type="text/javascript">
    //call new upload method for files uploading
    newuploadMediaFiles('<?php echo $filePath;?>','<?php echo $mediaFileTypes;?>','<?php echo $this->config->item('imageSize');?>','<?php echo $browseId;?>',1,1,0,'<?php echo $imgload;?>','','_xs','0');
</script>





<script type='text/javascript'>

$(document).ready(function() {
    
  var picture = $('#preview_image');
     picture.on('load', function(){  
        // Initialize plugin (with custom event)
        picture.guillotine({
            width: 1000,
            height: 562,
            eventOnChange: 'guillotinechange'
        });

        // Display inital data
        var data = picture.guillotine('getData');
        
        
        //for(var key in data) { $('#'+key).html(data[key]); }

        $('#fit').click(function(){ picture.guillotine('fit'); });
        $('#zoom_in').click(function(){ picture.guillotine('zoomIn'); });
        $('#zoom_out').click(function(){ picture.guillotine('zoomOut'); });


        //$(".guillotine-canvas").css("width","100%");
         
        // Update data on change
        //picture.on('guillotinechange', function(ev, data, action) {
            
          
        //});
     });
  
});


$(".creaveimage").click(function(){
    
  
    var fileName =  $("#fileName<?php echo $browseId?>").val();
    
    var left    =   $(".guillotine-canvas").position().left;
    var top     =   $(".guillotine-canvas").position().top;
    var width   =   $(".guillotine-canvas").width();
    var height  =   $(".guillotine-canvas").height();
    
    var canvas, canvasContext;
    
    canvas = $("<canvas />").attr({
                width: 1000,
                height: 562
            }).get(0);
     
    var    img      = document.getElementById("preview_image");
    var    imgtype  = $("#preview_image").attr("imgtype");
    
    
    canvasContext = canvas.getContext("2d");
   
    canvasContext.drawImage(img,left,top,width,height);
    
    var imageData =  canvas.toDataURL(imgtype, 1.0);
    
    if(imgtype==""){
        customAlert("Please select image.");
        return false;
    }
    
    var fromData = $("#displayImageForm").serialize();
    
    
    var fileName        =  $("#fileName<?php echo $browseId?>").val();
    var fileUploadPath  =  $("#fileUploadPath<?php echo $browseId?>").val();
     
    var formObj  =  {
            "fileName":fileName,
            "fileUploadPath":fileUploadPath,
            "imageData":imageData,
        }
    
    $.post( baseUrl+language+'/mediafrontend/cropupload', formObj, function( data ) {
        $("#uploadFileByJquery<?php echo $browseId;?>").click();
    });
    
});


</script>    
