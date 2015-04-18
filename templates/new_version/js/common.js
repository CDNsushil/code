$(document).ready(function() {
  
  // error and sucesss notification div in bottom
  if($('#messageSuccessError')){
     timeout = setTimeout(hideDiv, 5000);
  }

});  

//---------------------------------------------------------------------------

/**
 * @Description: sucess/error div show/hide method 
 */ 
function hideDiv(){
  if($('.successMsg')){
    $('.successMsg').remove();
  }
  if($('.errorMsg')){
    $('.errorMsg').remove();
  }
}

//---------------------------------------------------------------------------

/**
 * @Description: open light box on click 
 */ 

function openLightBox(BoxWp,Container,URL,val1,val2,val3,val4,val5){	
    
     
    /* Only for login case ( When user login on another tab ) */
     if(URL=="/auth/login"){
        var url = baseUrl+language+'/common/checkIsUserLogin'
        var returnData = AJAX_json(url,'','');
        if(returnData.userId > 0){
            loader();
            window.top.window.location=baseUrl;
        }
     }
     
  
    
  $('#'+Container).html('');
  $.ajax({
        type:'GET',
        data:{
        ajaxHit:1,
        val1:val1,
        val2:val2,
        val3:val3,
        val4:val4,
        val5:val5
        },
        url: baseUrl+language+URL,
        cache: false,
        beforeSend: function( ) {
        $('#'+Container).html(loader());
        },
        success: function(html){	
         $('#'+Container).show();
         $('#'+Container).html(html);
         $('#'+BoxWp).lightbox_me({
          centered: true,
          closeEsc:false,
          closeClick:false,
          onLoad: function() {
            copyClip.init('.copylink');	
           // $("#"+Container).parent().removeClass('load_popup');
          }	
        });		
        if(val1){
          if($('#email')){
            $('#email').val(val1);
          }
        }
        $(this).parent
        
        }
      });
//destroyOnClose:true, 		
}

//---------------------------------------------------------------------------

/**
 * @Description: open loader for ajax request
 */ 

function loader(){
  
  var Container  = "popup_box";
   
  //parent show div
  $("#"+Container).parent().show();
  
  //div blank for loader
  $("#popup_box").html('');
    
  //prepare loader showing html
  var loaderImage = baseUrl+"templates/new_version/images/loading_wbg.gif";
  var loaderHtml = '<div class="f_popup loader_show position_absolute top0 left0 width100_per new_verion_loader">';
  loaderHtml  += '<div class=" display_table text_alighC width100_per height100per">';
  loaderHtml  += '<div class="table_cell"> ';
  loaderHtml  += '<img src="'+loaderImage+'" alt="" class=" m_auto table_cell"  alt="Loading..." title="Loading..." /> ';
  loaderHtml  += '</div> ';
  loaderHtml  += '</div>';
  loaderHtml  += '</div> ';
  var img_url = $(loaderHtml);
  img_url.appendTo('#'+Container);
  
   /* 
   $('#popupBoxWp').lightbox_me({
      centered: true,
      closeEsc:false,
      closeClick:false,
   });	
   */
}

//---------------------------------------------------------------------------

/**
 * @Description: user do login popup
 */ 

function doLogin(url,login,password,remember,captcha) {
  var returnFlag= false;
  $.ajax({
    type: 'POST',
    url : url,
    dataType :'json',
    data : {
      login:login,
      password:password,
      remember:remember,
      captcha:captcha,
      ajaxHit:1
    },
    beforeSend:function(){
      $("#successMsg").html('<img  class="ma ajax_loader" align="absmiddle"src="'+baseUrl+'images/loading_wbg.gif" />');
    },
    complete:function(){
      
    },
    success:function(data){
      $("#successMsg").html('');
      $("#passwordMsg").html('');
      $("#emailMsg").html('');
      $("#captchaMsg").html('');
      if(data.success){
        returnFlag= true;				
        if(data.last_visit==false){
          openLightBox('popupBoxWp','popup_box','/auth/selectPage',data.email);
        }else{
          window.location.href=window.location.href;
        }
        
      }
      else{
        if(data.errors.password){
          $("#passwordMsg").html(data.errors.password);
          /****hide when re-type**/
          $("#passwordMsg").show();
        }
        if(data.errors.login){
          $("#emailMsg").html(data.errors.login);
        }
        if(data.errors.captcha){
          $("#captchaMsg").html(data.errors.captcha);
        }
        if(data.banned){
          
          $("#successMsg").html('<div class="red">'+data.banned+'</div>');
        }
      }
    },
    async:false,
        error: function (xhr, ajaxOptions, thrownError) {
      $("#successMsg").html('');
      //alert(xhr.status);
      //alert(thrownError);
    }
  });
  return returnFlag;
}

//---------------------

/**
 * @Description: open new window
 */ 
 
  function open_window(url)
  {
    NewWindow = window.open(url,"_blank","toolbar=0,menubar=0,status=0,copyhistory=0,scrollbars=1,resizable=1,location=0,Width=600,Height=400,top=250,left=300") ;
    if (window.focus) {NewWindow.focus()}
    return false;
  }

//-------------forgotPasswordPopup-------------------------

/**
 * @Description: open forgot password window
 */ 
 
function forgotPasswordPopup(){
  openLightBox('popupBoxWp','popup_box','/auth/forgot_password/');
}
  
//-----------------forgot password-------------------------

function forgotPassword(url,login) {
	
	$.ajax({
		type: 'POST',
		url : url,
		dataType :'json',
		data : {
			login:login,
			ajaxHit:1
		},
		beforeSend:function(){
			$("#emailMsg").show();
			$("#emailMsg").html('<img  class="ma ajax_loader" align="absmiddle"src="'+baseUrl+'images/loading_wbg.gif" />');
		},
		complete:function(){
			
		},
		success:function(data){
			
			$("#successMsg").html('');
			$("#emailMsg").html('');
			if(data.success){
				$("#successMsg").html(data.success);
				$("#dataStorage").html('');
				customAlert(sucess_show_msg);
			}
			else{
				if(data.errors.login){
					$("#emailMsg").show();
					$("#emailMsg").html(data.errors.login);
				}
			}
		},
        error: function (xhr, ajaxOptions, thrownError) {
			$("#successMsg").html('');
			//alert(xhr.status);
			//alert(thrownError);
		}
	});
}
 
//--------------------------customAlert--------------------------------  

function customAlert(msg,title){
    var msgTitle = (title==undefined)?'Note':title;
   
	//msg='<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger(\'close\');"></div><div class="customAlert">'+msg+'</div>';
  var msgHtml = '<div class="poup_bx width329 shadow fshel_midum">';
  msgHtml += '<div class="close_btn position_absolute " onclick="$(this).parent().trigger(\'close\');"></div>';
  msgHtml += '<h3 class="">'+msgTitle+'</h3> ';
  msgHtml += '<P class="text_alighC mt20 fs14" > '+msg+'</P>';
  msgHtml += '</div>';

	$("#popup_box").show();
	$("#popup_box").html(msgHtml);
	$('#popupBoxWp').lightbox_me({
		centered: true, 
		closeEsc:false,
		closeClick:false,
		onLoad: function() {}	
	});
	return false;			
}

//----------------------------loadPopupData-----------------------------

function loadPopupData(BoxWp,Container,data){
  openLightBoxWithoutAjax(BoxWp,Container);
  $('#'+Container).html(data);
} 

//----------------------openLightBoxWithoutAjax-------------------------

function openLightBoxWithoutAjax(BoxWp,Container){
  $('#'+Container).show();
  $('#'+Container).html(loader(Container));
    $('#'+BoxWp).lightbox_me({
    centered: true,
    closeEsc:false,
    closeClick:false,
    onLoad: function() {
      if($('#defaultLoader')){
        //$('#defaultLoader').remove();
        }
      
    }	
  });			
  //destroyOnClose:true,
}

//----------------------checkIsUserLogin--------------------------------

function checkIsUserLogin(msg){
    var url = baseUrl+language+'/common/checkIsUserLogin'
    var returnData = AJAX_json(url,'','');
    if((returnData.userId>0)){
      return true;
    }else{
      openLightBox('popupBoxWp','popup_box','/auth/login',msg)
      return false;
    }
}

//----------------------AJAX_json---------------------------------------

function AJAX_json(url,DivID,val1,val2,val3,val4,val5,val6,val7,val8) {
  var returnFlag= false;
  var res =new Array();
  if (val1.constructor == Array){
     val1 = val1.toString();
  }
  
  $.ajax({
    type: 'POST',
    url : url,		
    dataType :'json',
    data : {
      val1:val1,
      val2:val2,
      val3:val3,
      val4:val4,
      val5:val5,
      val6:val6,
      val7:val7,
      val8:val8,
      ajaxHit:1
    },
    beforeSend:function(){
    
    },
    complete:function(){
      
    },
    success:function(res){
      returnFlag= res;
      if(res !=null && res.crtId != undefined &&  res.crtId > 0){
        if(val1>0){
          var str ='<div class="cell pro_title">'+val2+'&nbsp;</div><div class="cell pro_name">'+val3+'&nbsp;</div><div class="cell pro_name">'+val4+'&nbsp;</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteAssociative(this)" EEID="'+val7+'" crtId="'+val1+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editAssociative(this)" EEID="'+val7+'" crtId="'+val1+'" crtDesignation="'+val2+'" crtName="'+val3+'" crtEmail="'+val4+'"><div class="cat_smll_edit_icon"></div></a></div></div>';
          $("#"+DivID).html(str);
        }else{
          var str ='<li id="row'+res.crtId+'"><div id="rowData'+res.crtId+'" class="pro_li_content_wp"><div class="cell pro_title">'+val2+'&nbsp;</div><div class="cell pro_name">'+val3+'&nbsp;</div><div class="cell pro_name">'+val4+'&nbsp;</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteAssociative(this)" EEID="'+val7+'" crtId="'+res.crtId+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editAssociative(this)" EEID="'+val7+'" crtId="'+res.crtId+'" crtDesignation="'+val2+'" crtName="'+val3+'" crtEmail="'+val4+'"><div class="cat_smll_edit_icon"></div></a></div></div></div></li>';
          $("#"+DivID).prepend(str);
        }
      }
      if(res !=null && res.crtId != undefined &&res.SpId > 0){
        if(res.editFlg > 0){
          DivID='rowData'+res.SpId;
          var str ='<div class="cell pro_title">'+res.countryNmame+'</div><div class="cell pro_title">'+val6+val3+'</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteShippingCharges(this)" EEID="'+val7+'" SpId="'+res.SpId+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editShippingCharges(this)" EEID="'+val7+'" SpId="'+res.SpId+'" SpCountry="'+val2+'" SpAmount="'+val3+'" ><div class="cat_smll_edit_icon"></div></a></div></div>';
          $("#"+DivID).html(str);
        }else{
          var str ='<li id="row'+res.SpId+'"><div id="rowData'+res.SpId+'" class="pro_li_content_wp"><div class="cell pro_title">'+res.countryNmame+'</div><div class="cell pro_title">'+val6+val3+'</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteShippingCharges(this)" EEID="'+val7+'" SpId="'+res.SpId+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editShippingCharges(this)" EEID="'+val7+'" SpId="'+res.SpId+'" SpCountry="'+val2+'" SpAmount="'+val3+'" ><div class="cat_smll_edit_icon"></div></a></div></div></div></li>';
          $("#"+DivID).prepend(str);
        }
      }
    },
    async:false,
    error: function (xhr, ajaxOptions, thrownError) {
      //alert(xhr.status);
      //alert(thrownError);
      /*********exception handling code start*******/
      try
        { 
          var getErrorString = thrownError.indexOf("exception 101");
          if(getErrorString>-1) throw "no";
          if(getErrorString==-1) throw "yes";
        }
      catch(err)
        {
        if(err=="yes")
        {
          alert(thrownError);
        }
        }
       /*********exception handling code end*******/ 
    }
  });
  return returnFlag;
}

//--------------------------confirm box--------------------------------  

function confirmBox(text,yesFunc) {
    
    var msgHtml = '<div class="poup_bx width329 shadow fshel_midum">';
    msgHtml += '<div class="close_btn position_absolute "  onclick="$(this).parent().trigger(\'close\');"></div>';
    msgHtml += '<h3 class="">Confirmation </h3>';
    msgHtml += '';
    msgHtml += '<P class="text_alighC mt20 fs14" > '+text+'</P>';
    msgHtml += '<div class="fr mb10">';
   // msgHtml += '<button type="button" class="bg_ededed bdr_b1b1b1 bdr_bbb confirmno" onClick="$(this).parent().trigger(\'close\');" >Cancel</button>';
    msgHtml += '<button type="button" class="bdr_bbb confirmyes" onClick="$(this).parent().trigger(\'close\');">Ok</button>';
    msgHtml += '</div>';
    msgHtml += '</div>';

    $("#popup_box").show();
    $("#popup_box").html(msgHtml);
    $('#popupBoxWp').lightbox_me({
      centered: true, 
      closeEsc:false,
      closeClick:false,
      onLoad: function() {}	
    });
    
    $('.confirmyes').click(function () {
         yesFunc();
         yesFunc = function () {};
    });    
    $('.confirmno').click(function () {
         yesFunc = function () {};
    });
}

//----------------------------refreshPge-------------------------------------

function refreshPge()
{ 
    window.location.href=window.location.href;
}

//-----------------------------------------------------------------------------

function getDisplayPrice(obj, currency, totalCommisionDiv, displayPriceDiv) { 
 setTimeout(function(){	
	if(isNaN(obj)){
		var price = $(obj).val();
	}else{
		var price = obj;
	}
	if(!price){price=0;}
	var url=baseUrl+language+'/common/getDisplayPrice'
	var data = AJAX_json(url,'',price,currency);
	if(data){
		if($(totalCommisionDiv)){
			$(totalCommisionDiv).html(data.currencySign+' '+data.totalCommision);
		}
		if($(displayPriceDiv)){
			$(displayPriceDiv).html(data.currencySign+' '+data.displayPrice);
		}
	}
	
 }, 1200);	
	
}

function endDateCalculation(startDate, days, endDateDiv) { 
    
	var startDate = $(startDate).val();
    var date = new Date(startDate),
    days = parseInt($(days).val());
    if(!(days > 0)){
      days = 0;  
    }
    
    if(!isNaN(date.getTime())){


date.setDate(date.getDate() + days);
        dformat = [ (date.getMonth()+1),
                    date.getDate(),
                    date.getFullYear()].join('/');
		var endDate = dformat.split("/");
        //date.setDate(date.getDate() + days);
        //var endDate = date.toLocaleDateString().split("/");
        
        var month = parseInt(endDate[0])-1;
        var monthA = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		$(endDateDiv).html(endDate[1]+' '+monthA[month]+' '+endDate[2]);
    }
}


		/* Upload heavy files Added by gurutva July 16 2012 */
function uploadMediaFiles(fileUploadPath,fileTypes,fileMaxSize,uniId,isMultipleForm,isReloadPage,norefresh,imgload,checksection,imgext,isRedirect,redirectUrl,isProfileImage,cropSection)
    { 
        if(typeof(uniId)         == undefined){uniId='';}
        if(typeof(isReloadPage)  == undefined || isNaN(isReloadPage)){isReloadPage=1;}
        if(typeof(norefresh)     == undefined || isNaN(norefresh)){norefresh=0;}
        if(typeof(isRedirect)    == undefined){isRedirect=0;}
        if(typeof(redirectUrl)   == undefined){redirectUrl=0;}
        if(typeof(isProfileImage)   == undefined){isProfileImage=0;}
        
        
        var relocate = false;
        var fileSrc='';
        var files_remaining=1;
        var org_filepath=fileUploadPath;
        
        var saveButton='#uploadFileByJquery'+uniId; 
        var flash_url=baseUrl+"templates/system/javascript/jquery-upload/plupload.flash.swf"; 
        fileUploadPath = fileUploadPath.replace(/\//g, "+");
        fileTypes = fileTypes.replace(/\|/g, ",");
        var fileExtension ='';
        var uploadedFileName = '';
        
        var URL = baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath;
        if(uniId=='_posterImage'){
            var URL = baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath+'/1';
        }else{
            var URL = baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath;
        }
        
        var uploaderId = new plupload.Uploader({                    
            runtimes: 'html5,flash,gears,browserplus,silverlight,html4',  
            url:URL,
            flash_swf_url:baseUrl+"templates/system/javascript/jquery-upload/plupload.flash.swf",
            max_file_count: 1,
            browse_button : "browsebtn"+uniId,
            button_browse_hover : true,
            drop_element : "dropArea"+uniId,
            autostart : true,
            max_file_size: fileMaxSize,
            container: "FileContainer"+uniId,
            chunk_size: '1mb',
            unique_names: true,
            multi_selection:false           
         });                

            var fileTypesFilter = 'notallow';
            var $body = $("body");
            var $dropArea = $("#dropArea"+uniId);

            uploaderId.init();
            uploaderId.bind('FilesAdded', function(up, files) {
                if (uploaderId.files.length > 1) {
                    for(var j=0; j<(uploaderId.files.length-1); j++){
                        uploaderId.removeFile(uploaderId.files[j]);
                    }
                }
                    
                $dropArea.removeClass();
                
                $.each(files, function(i, file) {
                    //Checks a comma delimted list for allowable file types set file types to allow for all
                    fileExtension = file.name.substring(file.name.lastIndexOf(".")+1, file.name.length).toLowerCase();
                    var fileOriginalExtension = file.name.substring(file.name.lastIndexOf(".")+1, file.name.length);
                    var fileTypeRuntime = $('#fileTypeRuntimeDiv'+uniId).is(":visible");
                    if(fileTypeRuntime == true) {
                        fileTypes = $('#fileTypeRuntime'+uniId).val();
                    }
                    fileTypes = fileTypes.replace(/\|/g, ",");
                    var supportedExtensions = fileTypes.split(",");
                    var supportedFileExtension = ($.inArray(fileExtension.toLowerCase(),supportedExtensions) >= 0);
                    if(fileTypesFilter == "allow")
                    {
                        supportedFileExtension = !supportedFileExtension
                    }
                    filename = file.name;
                    if((fileTypes == "all") || supportedFileExtension)
                    {
                        $('#fileError'+uniId).html('');
                        $('#fileErrorInput'+uniId).val('0');
                        filename = file.name;
                        fileSrc = baseUrl+"/"+org_filepath+file.id+'.'+fileOriginalExtension;
                        uploadedFileName=file.id+'.'+fileOriginalExtension;		  
                        if('#fileName'+uniId)
                            $('#fileName'+uniId).val(file.id+'.'+fileOriginalExtension);
                        if('#fileInput'+uniId)
                            $('#fileInput'+uniId).val(filename);
                        if('#FileField'+uniId)
                            $('#FileField'+uniId).val(filename);
                        if('#fileSize'+uniId){
                            $('#fileSize'+uniId).val(file.size);
                        }
                        
                        var totalFileSize=file.size;
                        var upload2ndFileDiv = $('#upload2ndFileDiv').is(":visible");
                        
                        if(upload2ndFileDiv){
                            var browseId1st =$('#browseId1st').val();
                            var browseId2nd =$('#browseId2nd').val();
                            var fileSize1st =$('#fileSize'+browseId1st).val();
                            var fileSize2nd =$('#fileSize'+browseId2nd).val();
                            fileSize1st=parseInt(fileSize1st);
                            fileSize2nd=parseInt(fileSize2nd);
                            var totalFileSize=(fileSize1st + fileSize2nd);
                        }
                        
                        if(totalFileSize > fileMaxSize){
                              uploaderId.trigger("Error", {
                                  code : "-600",
                                  message : fileSizeErrorMasg,
                                  file : file
                              });
                        }
                        
                        up.refresh();
                        $(saveButton).click(function(){
                            
                            var errorlength = 0;
                            $('input.error').each(function(index){
                                    errorlength=(errorlength+1);
                            });
                            var inputFilename=$('#fileInput'+uniId).val();
                            var inputFileExtension='';
                            
                            if(inputFilename.length > 4 ){
                                inputFileExtension = inputFilename.substring(inputFilename.lastIndexOf(".")+1, inputFilename.length).toLowerCase();
                            }							
                            
                            if(($('#Uploadvideo'+uniId).is(":visible")) && (errorlength==0) && (inputFileExtension!=''))
                            {										
                                uploaderId.start();
                                openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
                            }					
                        });
                    }
                    else
                    {
                        $('#fileInput'+uniId).val(filename);
                        $('#fileErrorInput'+uniId).val('1');
                        $('#fileError'+uniId).html(fileNotSupportedMasg);
                        uploaderId.stop();
                        uploaderId.refresh(); 
                    }
                });
            });
            
            uploaderId.bind('BeforeUpload', function(up, file) {
                var uploadPath =  $('#fileUploadPath'+uniId).val();
                if(uploadPath){
                        fileUploadPath = uploadPath.replace(/\//g, "+");
                        up.settings.url=baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath;
                }
            });

            uploaderId.bind('UploadProgress', function(up, file) {
                isuploading=true;
                $("#progressBar"+uniId).show();
                $("#plupload_progress_bar"+uniId).attr("style", "width:"+ file.percent + "%");
                $("#percentComplete"+uniId).html(file.percent+"%");
                window.onbeforeunload = function() {
                  if(isuploading){
                      return leavePageMasg;
                  }
                }
            });
            
            
            uploaderId.bind('FileUploaded', function(up, file, response) {
                $('#progressBar'+uniId).hide() ;						 
                $('#percentComplete'+uniId).html('');		
                
                var serverData = $.parseJSON(response.response);
                if(serverData.error == undefined || serverData.error ==''){
                    
                    if(uniId=='_posterImage'){
                        isReloadPage =0;
                        $("#form"+uniId).submit();
                        $("#image"+uniId+' img').attr('src',fileSrc);
                    }
                    
                    var totalFileToupload =  $('#totalFileToupload').val();
                    if(totalFileToupload){
                        files_remaining=parseInt(totalFileToupload);
                    }
                    files_remaining--;
                    
                    
                    if(totalFileToupload){
                        $('#totalFileToupload').val(files_remaining);
                    }
                    
                    var imgFile = ["gif","jpeg","jpg","png","exif","tiff","tif","raw","bmp","ppm","pgm","pmb","pnm","tga"];
                    if(checkValueInArray(imgFile,fileExtension)){
                        var createWaterMarkFlag = $('#createWaterMarkFlag').val();
                        if(createWaterMarkFlag && (createWaterMarkFlag == 1 || createWaterMarkFlag == '1')){}
                        else{createWaterMarkFlag=0;}
                        returnFlag= AJAX( baseUrl+language+'/common/createthumbimages','',fileUploadPath,uploadedFileName,createWaterMarkFlag);
                    }
                
                    if (files_remaining <= 0){
                        returnFlag =  AJAX(baseUrl+language+'/common/updateMediaFileJobStsatus','','','','' ); // change mediaFile status uploading to new
                        if(returnFlag){
                            isuploading=false;	
                            var returnform =  $('#relocateId').val();
                            if(returnform && returnform.length >= 5 && isReloadPage==1) { 
                                window.location.href = returnform;
                                relocate = true;
                            }else if(isReloadPage==1 && norefresh != 1){
                                timeout = setTimeout(refreshPge, 1000);
                            }else{
                                $('#popupBoxWp').trigger('close');
                                $('#popup_box').hide();
                                $('#defaultLoader').remove();
                            }
                            
                            //redirect to next page file uploaded successfully
                            if((isRedirect==1 || isRedirect=='1') && redirectUrl!=""){
                                window.location.href = redirectUrl;
                            }
                            
                            //check is profile image image crop popup show
                            if( (isProfileImage==1 || isProfileImage=='1')){
                                openLightBox('popupBoxWp','popup_box','/showcase/profileimagecrop',cropSection);
                            }
                        }
                    }

                }else{
                    
                    isuploading=false;
                    if('#fileName'+uniId)
                        $('#fileName'+uniId).val('');
                    if('#fileInput'+uniId)
                        $('#fileInput'+uniId).val('');
                        
                    $('#fileInput'+uniId).val('');
                    $('#fileError'+uniId).html(serverData.error.message);
                    
                    
                    
                    $('#popupBoxWp').trigger('close');
                    $('#popup_box').hide();
                    $('#defaultLoader').remove();
                    
                    uploaderId.trigger("Error", {
                      code : serverData.error.code,
                      message : serverData.error.message,
                      file : file
                    });
                    customAlert(serverData.error.message);
                    
                }
                
                
            });

           
           uploaderId.bind('Error', function(up, err) {			
                
                var userContainerId = $('#userContainerId').val();			
                
                $errorPanel = $("div.error:first");
                //-600 means the file is larger than the max allowable file size on the uploader thats set in the options above.
                if(err.code == "-600")
                {
                    $('#fileInput'+uniId).val('');
                    $('#fileError'+uniId).html(fileSizeErrorMasg);
                    $('#fileErrorInput'+uniId).val('1');
                    $("#redirectUrl").attr("href",baseUrl+language+"/membershipcart/addspace/"+userContainerId);
                    lightBoxWithAjax('popupBoxWp','popup_box','/package/notEnoughSpace/',userContainerId,'');
                }
                else if(err.code == "-100")
                {
                    $('#fileInput'+uniId).val('');
                    $('#fileError'+uniId).html(err.message);
                    $('#fileErrorInput'+uniId).val('1');
                    
                }
                else
                {
                    $('#fileInput'+uniId).val('');
                    $('#fileError'+uniId).html(fileErrorMasg+ err.file.name);
                    $('#fileErrorInput'+uniId).val('1');
                }
                uploaderId.stop();
                uploaderId.refresh(); // Reposition Flash/Silverlight
                
            });
		
	}
    
    
    
    
    		/* Upload heavy files Added by gurutva July 16 2012 */
function newuploadMediaFiles(fileUploadPath,fileTypes,fileMaxSize,uniId,isMultipleForm,isReloadPage,norefresh,imgload,checksection,imgext,isRedirect,redirectUrl,isProfileImage)
    { 
        if(typeof(uniId)         == undefined){uniId='';}
        if(typeof(isReloadPage)  == undefined || isNaN(isReloadPage)){isReloadPage=1;}
        if(typeof(norefresh)     == undefined || isNaN(norefresh)){norefresh=0;}
        if(typeof(isRedirect)    == undefined){isRedirect=0;}
        if(typeof(redirectUrl)   == undefined){redirectUrl=0;}
        if(typeof(isProfileImage)   == undefined){isProfileImage=0;}
        
        
        var relocate = false;
        var fileSrc='';
        var files_remaining=1;
        var org_filepath=fileUploadPath;
        
        var saveButton='#uploadFileByJquery'+uniId; 
        var flash_url=baseUrl+"templates/system/javascript/jquery-upload/plupload.flash.swf"; 
        fileUploadPath = fileUploadPath.replace(/\//g, "+");
        fileTypes = fileTypes.replace(/\|/g, ",");
        var fileExtension ='';
        var uploadedFileName = '';
        
        var URL = baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath;
        if(uniId=='_posterImage'){
            var URL = baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath+'/1';
        }else{
            var URL = baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath;
        }
        
        var uploaderId = new plupload.Uploader({                    
            runtimes: 'html5,flash,gears,browserplus,silverlight,html4',  
            url:URL,
            flash_swf_url:baseUrl+"templates/system/javascript/new-jquery-upload/Moxie.swf",
            max_file_count: 1,
            browse_button : "browsebtn"+uniId,
            button_browse_hover : true,
            drop_element : "dropArea"+uniId,
            autostart : true,
            max_file_size: fileMaxSize,
            container: "FileContainer"+uniId,
            chunk_size: '1mb',
            unique_names: true,
            multi_selection:false           
         });                

            var fileTypesFilter = 'notallow';
            var $body = $("body");
            var $dropArea = $("#dropArea"+uniId);

            uploaderId.init();
            uploaderId.bind('FilesAdded', function(up, files) {
                if (uploaderId.files.length > 1) {
                    for(var j=0; j<(uploaderId.files.length-1); j++){
                        uploaderId.removeFile(uploaderId.files[j]);
                    }
                }
                    
                $dropArea.removeClass();
                
                $.each(files, function(i, file) {
                    
                    
                    showImagePreview(file);
                    
                    //Checks a comma delimted list for allowable file types set file types to allow for all
                    fileExtension = file.name.substring(file.name.lastIndexOf(".")+1, file.name.length).toLowerCase();
                    var fileOriginalExtension = file.name.substring(file.name.lastIndexOf(".")+1, file.name.length);
                    var fileTypeRuntime = $('#fileTypeRuntimeDiv'+uniId).is(":visible");
                    if(fileTypeRuntime == true) {
                        fileTypes = $('#fileTypeRuntime'+uniId).val();
                    }
                    fileTypes = fileTypes.replace(/\|/g, ",");
                    var supportedExtensions = fileTypes.split(",");
                    var supportedFileExtension = ($.inArray(fileExtension.toLowerCase(),supportedExtensions) >= 0);
                    if(fileTypesFilter == "allow")
                    {
                        supportedFileExtension = !supportedFileExtension
                    }
                    filename = file.name;
                    if((fileTypes == "all") || supportedFileExtension)
                    {
                        $('#fileError'+uniId).html('');
                        $('#fileErrorInput'+uniId).val('0');
                        filename = file.name;
                        fileSrc = baseUrl+"/"+org_filepath+file.id+'.'+fileOriginalExtension;
                        uploadedFileName=file.id+'_crop'+'.'+fileOriginalExtension;		  
                        if('#fileName'+uniId)
                            $('#fileName'+uniId).val(file.id+'.'+fileOriginalExtension);
                        if('#fileInput'+uniId)
                            $('#fileInput'+uniId).val(filename);
                        if('#FileField'+uniId)
                            $('#FileField'+uniId).val(filename);
                        if('#fileSize'+uniId){
                            $('#fileSize'+uniId).val(file.size);
                        }
                        
                        var totalFileSize=file.size;
                        var upload2ndFileDiv = $('#upload2ndFileDiv').is(":visible");
                        
                        if(upload2ndFileDiv){
                            var browseId1st =$('#browseId1st').val();
                            var browseId2nd =$('#browseId2nd').val();
                            var fileSize1st =$('#fileSize'+browseId1st).val();
                            var fileSize2nd =$('#fileSize'+browseId2nd).val();
                            fileSize1st=parseInt(fileSize1st);
                            fileSize2nd=parseInt(fileSize2nd);
                            var totalFileSize=(fileSize1st + fileSize2nd);
                        }
                        
                        if(totalFileSize > fileMaxSize){
                              uploaderId.trigger("Error", {
                                  code : "-600",
                                  message : fileSizeErrorMasg,
                                  file : file
                              });
                        }
                        
                        up.refresh();
                        $(saveButton).click(function(){
                            
                            var errorlength = 0;
                            $('input.error').each(function(index){
                                    errorlength=(errorlength+1);
                            });
                            var inputFilename=$('#fileInput'+uniId).val();
                            var inputFileExtension='';
                            
                            if(inputFilename.length > 4 ){
                                inputFileExtension = inputFilename.substring(inputFilename.lastIndexOf(".")+1, inputFilename.length).toLowerCase();
                            }							
                            
                            if(($('#Uploadvideo'+uniId).is(":visible")) && (errorlength==0) && (inputFileExtension!=''))
                            {										
                                uploaderId.start();
                                openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
                            }					
                        });
                    }
                    else
                    {
                        $('#fileInput'+uniId).val(filename);
                        $('#fileErrorInput'+uniId).val('1');
                        $('#fileError'+uniId).html(fileNotSupportedMasg);
                        uploaderId.stop();
                        uploaderId.refresh(); 
                    }
                });
            });
            
            uploaderId.bind('BeforeUpload', function(up, file) {
                var uploadPath =  $('#fileUploadPath'+uniId).val();
                if(uploadPath){
                        fileUploadPath = uploadPath.replace(/\//g, "+");
                        up.settings.url=baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath;
                }
            });

            uploaderId.bind('UploadProgress', function(up, file) {
                isuploading=true;
                $("#progressBar"+uniId).show();
                $("#plupload_progress_bar"+uniId).attr("style", "width:"+ file.percent + "%");
                $("#percentComplete"+uniId).html(file.percent+"%");
                window.onbeforeunload = function() {
                  if(isuploading){
                      return leavePageMasg;
                  }
                }
            });
            
            
            uploaderId.bind('FileUploaded', function(up, file, response) {
                $('#progressBar'+uniId).hide() ;						 
                $('#percentComplete'+uniId).html('');		
                
                var serverData = $.parseJSON(response.response);
                if(serverData.error == undefined || serverData.error ==''){
                    
                    if(uniId=='_posterImage'){
                        isReloadPage =0;
                        $("#form"+uniId).submit();
                        $("#image"+uniId+' img').attr('src',fileSrc);
                    }
                    
                    var totalFileToupload =  $('#totalFileToupload').val();
                    if(totalFileToupload){
                        files_remaining=parseInt(totalFileToupload);
                    }
                    files_remaining--;
                    
                    
                    if(totalFileToupload){
                        $('#totalFileToupload').val(files_remaining);
                    }
                    
                    var imgFile = ["gif","jpeg","jpg","png","exif","tiff","tif","raw","bmp","ppm","pgm","pmb","pnm","tga"];
                    if(checkValueInArray(imgFile,fileExtension)){
                        var createWaterMarkFlag = $('#createWaterMarkFlag').val();
                        if(createWaterMarkFlag && (createWaterMarkFlag == 1 || createWaterMarkFlag == '1')){}
                        else{createWaterMarkFlag=0;}
                        returnFlag= AJAX( baseUrl+language+'/common/createthumbimages','',fileUploadPath,uploadedFileName,createWaterMarkFlag);
                    }
                
                    if (files_remaining <= 0){
                        returnFlag =  AJAX(baseUrl+language+'/common/updateMediaFileJobStsatus','','','','' ); // change mediaFile status uploading to new
                        if(returnFlag){
                            isuploading=false;	
                            var returnform =  $('#relocateId').val();
                            if(returnform && returnform.length >= 5 && isReloadPage==1) { 
                                window.location.href = returnform;
                                relocate = true;
                            }else if(isReloadPage==1 && norefresh != 1){
                                timeout = setTimeout(refreshPge, 1000);
                            }else{
                                $('#popupBoxWp').trigger('close');
                                $('#popup_box').hide();
                                $('#defaultLoader').remove();
                            }
                            
                            //redirect to next page file uploaded successfully
                            if((isRedirect==1 || isRedirect=='1') && redirectUrl!=""){
                                window.location.href = redirectUrl;
                            }
                            
                            //check is profile image image crop popup show
                            if( (isProfileImage==1 || isProfileImage=='1')){
                                openLightBox('popupBoxWp','popup_box','/showcase/profileimagecrop');
                            }
                        }
                    }

                }else{
                    
                    isuploading=false;
                    if('#fileName'+uniId)
                        $('#fileName'+uniId).val('');
                    if('#fileInput'+uniId)
                        $('#fileInput'+uniId).val('');
                        
                    $('#fileInput'+uniId).val('');
                    $('#fileError'+uniId).html(serverData.error.message);
                    
                    
                    
                    $('#popupBoxWp').trigger('close');
                    $('#popup_box').hide();
                    $('#defaultLoader').remove();
                    
                    uploaderId.trigger("Error", {
                      code : serverData.error.code,
                      message : serverData.error.message,
                      file : file
                    });
                    customAlert(serverData.error.message);
                    
                }
                
                
            });

           
           uploaderId.bind('Error', function(up, err) {			
                
                var userContainerId = $('#userContainerId').val();			
                
                $errorPanel = $("div.error:first");
                //-600 means the file is larger than the max allowable file size on the uploader thats set in the options above.
                if(err.code == "-600")
                {
                    $('#fileInput'+uniId).val('');
                    $('#fileError'+uniId).html(fileSizeErrorMasg);
                    $('#fileErrorInput'+uniId).val('1');
                    $("#redirectUrl").attr("href",baseUrl+language+"/membershipcart/addspace/"+userContainerId);
                    lightBoxWithAjax('popupBoxWp','popup_box','/package/notEnoughSpace/',userContainerId,'');
                }
                else if(err.code == "-100")
                {
                    $('#fileInput'+uniId).val('');
                    $('#fileError'+uniId).html(err.message);
                    $('#fileErrorInput'+uniId).val('1');
                    
                }
                else
                {
                    $('#fileInput'+uniId).val('');
                    $('#fileError'+uniId).html(fileErrorMasg+ err.file.name);
                    $('#fileErrorInput'+uniId).val('1');
                }
                uploaderId.stop();
                uploaderId.refresh(); // Reposition Flash/Silverlight
                
            });
		
	}
    
    
    /*
     * plupload image preview section 
     */ 

    function showImagePreview( file ) {

        var preloader = new mOxie.Image();
       
        // command as load() does not execute async.
        preloader.onload = function() {
            
            if(preloader.width < 1000 || preloader.height < 562){
                customAlert("Image dimensions should be Minimum 1000 pixels wide and Maximum 562 pixels high.");
                return false;
            }
            
            $("#preview_image").attr("imgtype",preloader.type);
            $("#preview_image").attr("src",preloader.getAsDataURL());
            $('#fit').trigger("click");
        };
        preloader.load( file.getSource() );
    }

    
    //-------------------------------------------------------------------------
  
    function checkValueInArray(array,val){
	
        if($.inArray(val.toLowerCase(),array) > 0){
            return true;
        }else{
            return false;
        }
    }

  
//---------------------

/**
 * @Description: This function is use for word counting
 */ 
function checkWordLen(obj,wordLen,divid){
    if(!wordLen){
        var wordLen = 100; // Maximum word length
    }
    if(!divid){
        var divid = 'remainingLimit'; 
    }
    var value = obj.value.replace(/^\s+|\s+$/g,"");
    var len =value.split(/[\s]+/);
    var limit = len.length;
    var limitError1 = 'There is a limit of ';
    var limitError2 = ' words';
    if(value.length==0){
        limit = 0;
    }
    if(limit > wordLen){
        alert(limitError1+wordLen+limitError2);
        s = value.substring(0, wordLen);
        t = WordLengthCheck( value ,wordLen );
        t = t.replace(/^\s+|\s+$/g, "");
        obj.value = t;
        $('#'+divid).html(wordLen);
       return false;
    }
    else{
        $('#'+divid).html(limit);
        return true;
    }

}

//---------------------

/**
 * @Description: This function returns the string with defined word length only removing extra stuff from the string
 */ 

function WordLengthCheck(s,l) {
    WordsMonitor = 0;
    var f = false;
    var ts = new String();
    for(var vi = 0; vi < s.length; vi++) {
    vs = s.substr(vi,1);
    if((vs >= 'A' && vs <= 'Z') || (vs >= 'a' && vs <= 'z') || (vs >= '0' && vs <= '9')) {
        if(f == false)	{
            f = true;
            WordsMonitor++;
            if((l > 0) && (WordsMonitor > l)) {
                s = s.substring(0,ts.length);
                vi = s.length;
                WordsMonitor--;
                }
            }
        } else { 
            f = false; 
        }
        ts += vs;
    }
    return s;
}

//---------------------------------

/**
 * @Description: This method is use to lightbox with ajax popup
 */ 

function lightBoxWithAjax(BoxWp,Container,URL,val1,val2,val3,val4){	

	if (val1.constructor == Array){
	   val1 = val1.toString();
	}

	$.ajax({
		  type:'POST',
		  data:{
			ajaxHit:1,
			val1:val1,
			val2:val2,
			val3:val3,
			val4:val4
		  },
		  url: baseUrl+language+URL,
		  cache: false,
		  beforeSend: function( ) {
			  $('#'+Container).html(loader(Container));
		  },
		  success: function(html){	
			$('#'+Container).show();
			$('#'+Container).html(html);
			$('#'+BoxWp).lightbox_me({
				centered: true,
				closeEsc:false,
				closeClick:false,
				onLoad: function(){}	
			});		
			$(this).parent;
		  }
	});
}

//---------------------------------------------------------------------------

/**
 * @Description: This method is use to creave user 
 */ 

function postCrave(divId,data,entityId,elementId,msg){
	
	var postCraveFlag=checkIsUserLogin(msg);
	if(postCraveFlag){
		var returnData=AJAX_json(baseUrl+language+"/craves/postCrave",divId,data);
		if(returnData.craveDone){
			var msg = '';
			var craveCount=returnData.craveCount;
			var craveContainer="craveDiv"+entityId+''+elementId;
			var craveClass='';
			
			if(returnData.cravedStatus==1){
				$("."+craveContainer).each(function(index){
						//craveClass =$(this).attr('class').replace('cravedALL', '');
						//craveClass = craveClass+' cravedALL';
						$(this).addClass("cravedALL");
						
				});
				$("#"+craveContainer).addClass("cravedALL");
				
			}else{
				$("."+craveContainer).each(function(index){
						//craveClass =$(this).attr('class').replace('cravedALL', '');
						$(this).removeClass("cravedALL");;
				});
				$("#"+craveContainer).removeClass("cravedALL");
				
			}
			$("."+craveContainer).html(craveCount);
			
		}else if(returnData.craveDone==0){
			customAlert(returnData.msg);
		}
	}else{
			return false;
	}
}

//-------------------------------------------------------------------------


/**
* @Add by lokendra for copy functionality to clipboard script
*/
var copyClip = {
	init: function(controlId) {
		$(controlId).zclip({
			//path: "http://www.steamdev.com/zclip/js/ZeroClipboard.swf",
			path:baseUrl+'swf/zeroClipboard.swf',
			copy: function() {
					return $('#gsInput').val();
			}
		});
	}
}

//-------------------------------------------------------------------------

/**
* @description: This method is use to open user lightbox 
*/

function openUserLightBox(BoxWp,Container,URL,UrlToShare){
	//alert(postId);
	//$('body').addClass('overflowHid');
	$('#'+Container).html('');
	
	$.ajax({
			  type:'GET',
			   data:{
			  ajaxHit:1,
			  UrlToShare:UrlToShare
			  },			 
			  url: baseUrl+language+URL,
			  cache: false,
			  beforeSend: function( ) {
				//$('#'+Container).html(loader());
			  },
			  success: function(html){
				$('#'+Container).show();
				$('#'+Container).html(html);
				 $('#'+BoxWp).lightbox_me({
					centered: true,
					closeEsc:false,
					closeClick:false,
					onLoad: function() {
						
					}	
				});	
			  }
	});
  
}

//-------------------------------------------------------------------------

/**
 * @description: This methos is use for postRating
 */ 

function postRating(divId,entityId,elementId,alreadyRate,msg){
    var postRateFlag=checkIsUserLogin(msg);
    if(postRateFlag){
        var ratingValue=getRatingValue();
        var rateData={"elementId":elementId,"entityId":entityId,"ratingValue":ratingValue};
            
        var returnData=AJAX_json(baseUrl+language+"/rating/postRating",divId,rateData);
        if(returnData.ratingDone){
            var msg =returnData.msg;
            var ratingAvg=roundRatingValue(returnData.ratingAvg);
            var rateContainer=".rateDiv"+entityId+''+elementId;
            var rateBtn = ".rateBtn"+entityId+''+elementId;
            var ratingImg=baseUrl+'templates/new_version/images/rating/rating_0'+ratingAvg+'.png';
            var img='<img  src="'+ratingImg+'" />';
            $("#"+divId).html(msg);
            timeOutDiv('popup_box');
            $(rateBtn).addClass('rateALL');
            $(rateContainer).html(img);
            $(rateBtn).attr("onclick","customAlert('"+alreadyRate+"')");
        }
    }else{
            return false;
    }
}

//--------------------------------------------------------------------------

/**
 * @description: This method is use for roundRatingValue
 */ 
 
    function roundRatingValue(value){
        var decimal = (value - Math.floor(value));
        var addvalue = 0;

        if(decimal > 0) {
            if(decimal >= 0.3 && decimal < 0.8){
                addvalue = 0.5;	
            }
            if(decimal > 0.7){
                addvalue = 1;	
            }
        }
        var roundValue = (Math.floor(value) + addvalue);
        return roundValue;
    }


//-------------------------------------------------------------------------

/**
 * @description: This method is use for timeOutDiv
 */ 

function timeOutDiv(divId) {
    
    setTimeout(function(){
      $("."+divId).fadeOut("slow", function () {
      $('.'+divId).trigger('close');
          });

    }, 1700);

}

//--------------------------------------------------------------------------

/**
*  @description: This method  is use  generateStateList
*/ 

function generateStateList(divId1,val1,val2,val3){
	// alert(divId1+'---'+val1);return false;
		var url = baseUrl+language+'/common/getCountryStateList'		
		AJAX(url,divId1,val1,val2,val3);
}


//---------------------------------------------------------------------------

function AJAX(url,DivID,val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,val11,val12,val13,val14) {
	
	var returnFlag= false;
	var res;
	
	if (val1.constructor == Array){
	   val1 = val1.toString();
	}
	$.ajax({
		type: 'POST',
		url : url,
		dataType :'html',
		data : {
			val1:val1,
			val2:val2,
			val3:val3,
			val4:val4,
			val5:val5,
			val6:val6,
			val7:val7,
			val8:val8,
			val9:val9,
			val10:val10,
			val11:val11,
			val12:val12,
			val13:val13,
			val14:val14,
			ajaxHit:1
		},		
		beforeSend:function(){
			//alert(val4);
			//alert('AJAX-OUT-PUT-Inside:'+val6);
			if(DivID != '' && (DivID =='catInfo'|| DivID =='educationInfo'|| DivID =='visaTypeInfo'|| DivID =='contentBox'|| DivID =='contentBoxIntro')){
			
				if(DivID != '' && val4!='loadImg' && val4!='loadVideo'){
					$("#"+DivID).html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
				}
			}
			else
			{
				if(DivID != ''){
					if(val11){
						$("#"+DivID).prepend('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
					}else{
						$("#"+DivID).html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
					}					
				}
			}
		},
		complete:function(){
			
		},
		success:function(HTML){
			returnFlag= true;
			
			if('#loadImg'){
				$("#loadImg").remove();
			}
			if(DivID=='educationInfo' ||  DivID =='visaTypeInfo'){
				if(val1==0) 
				{					
					$("#"+DivID).prepend(HTML);
				}
				else
				{	
					if(DivID =='visaTypeInfo')
						$("#removeVisaID_"+val7).html(HTML);
					if(DivID =='educationInfo')
						$("#removeID_"+val7).html(HTML);
				}				
				}
			else if(val4=='loadImg'){
				if(DivID != '' && val4=='loadImg' && val3==0)
				{	
					
					$("#"+DivID).prepend(HTML);				
					$("#"+val5).val('');
					$("#"+val6).val(0);
				}
				else
				{					
					res = HTML;
					if(val7)
						$("#removeID_"+val7).html(HTML);
					$('#addCatButton').removeClass('cat_edit_icon');
					$('#addCatButton').addClass('cat_plus_icon');
					$('#catCancel').hide();	
					$("#"+val5).val('');
					$("#"+val6).val(0);
					return res;				
				}
			}
			else{
			
				if(DivID != '')
				{
					if(val11){
						$("#"+DivID).prepend(HTML);
					}else{
						$("#"+DivID).html(HTML);
					}
				}
				else
				{
					res = HTML;
					return res;
				}
			}	
								
		},
		async:false,
        error: function (xhr, ajaxOptions, thrownError) {
			//alert(xhr.status);
			alert(thrownError);
		}
	});
	return returnFlag;
}

//---------------------------------------------------------------------------

/**
 * @Description: This method is use to remove table row 
 */ 

function deleteTabelRow(tbl,field,id,divId,checkbox,removeRow,fileId,filePath,isLogSummery,deleteCache,reloadPage,customMsg){
    if(deleteCache == undefined){
        deleteCache='';
    }
    if(removeRow == undefined || removeRow == ''){
            removeRow ='#row';
    }
    if(checkbox == undefined || checkbox == ''){
            checkbox ='.CheckBox';
    }
    if(fileId == undefined){
            fileId =0;
    }
    if(filePath == undefined){
            filePath ='';
    }
    if(isLogSummery == undefined){
            isLogSummery =0;
    }
    if(customMsg  != undefined){
        areYouSure=customMsg;		
    }	
    
    var url = baseUrl+language+'/common/deleteTabelRow';
    var ID = new Array();
    if(id>0)
    {
        ID[0] = id;
    }
    else
    {
        ID = checkCheckbox(checkbox);
    }
    if(ID){
        if(confirm(areYouSure)){
            
            //console.log(url+"=="+divId+"=="+ID+"=="+tbl+"=="+field+"=="+fileId+"=="+filePath+"=="+isLogSummery+"=="+deleteCache);
            
            var returnFlag=AJAX(url,divId,ID,tbl,field,fileId,filePath,isLogSummery,deleteCache);
            
            if(returnFlag){
                
                
                if($('#uploadElementForm')){
                    if($('#uploadElementForm').is(":visible")){
                        $("#uploadElementForm").slideToggle('slow');
                    }
                }
                
                if(reloadPage==1){
                    setTimeout(refreshPge, 500);
                }else{
                    $.each(ID, function(key, value) { 
                      $(removeRow+value).remove();
                    });
                }
            }
            return 1;
        }else{
                return 0;
        }
        
    }else{
        alert(atleastSelect);
    }
}

function viewGalleryFullScreen(){
	
	var slider = $(".royalSlider").data('royalSlider');
      	var ua = navigator.userAgent.toLowerCase();      
		var isAndroid = ua.indexOf("android") > -1; //&& ua.indexOf("mobile");
		var isOpera = $.browser.opera;
		
		$("#fullScreenButton,#myToogleSlideshowButton").click(function(){ 
			     	
		var imageSlideNumber = $('#fullScreenCurrentImage').val();	
		
		if(isAndroid || isOpera) {
			$('#slider-toolkit').removeClass('dn');
		}	
      	slider.enterFullscreen(); 
      
      	slider.ev.on('rsEnterFullscreen', function() {
			$('#slider-toolkit').removeClass('dn');
			
			$(".royalSlider").royalSlider('goTo', imageSlideNumber);
				
		});
 });
}

//---------------------

/**
 * @Description: open new url
 */ 
 
function gotoUrl(url) {
    
    window.open(url); 
    
}


/*-------------------------------------*/

////for next and previous on popup box////
function next_prevoius(Container,URL,val1,val2,val3)
{
	//alert(baseUrl+language+URL);
	 $.ajax({
			  type:'GET',
			  data:{
				ajaxHit:1,
				val1:val1,
				val2:val2,
				val3:val3
			  },
			  url: baseUrl+language+URL,
			  
			  cache: false,
			  //beforeSend: function( ) {
			//	$('#'+Container).html(loader(Container));
			 // },
			  success: function(html)
			  {				  
				$('#'+Container).html(html);
			
				if(val1){
					if($('#email')){
						$('#email').val(val1);
					}
				}							
			}			
		});
	}
	
	
	
	function placeHoderHideShow(obj,placeHoder,action){
	var input = $(obj);
	if(!action){ action = 'hide'; }
 	
 	if(action=='hide'){
		if (input.attr('value') == placeHoder || input.attr('value') == '') {
			input.attr("placeholder","");
			input.attr('value','');
		}
	}
	
	else if(action=='show'){
		if (input.attr('value') == '' || input.attr('value') == placeHoder) {
			input.attr("placeholder",placeHoder );
			input.attr('value',placeHoder);
		}
	}
}
	
