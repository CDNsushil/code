/*---------------------------*/	
var isuploading=false;		
var insertme='';		
var altforinsertme='';		
var fileMaxSize='';		
var fileTypes='';
var mediaFileTypes='';
var filePath='';
var imagefileTypes='';
var thumbImgPath='';
function customAlert(msg){
	//msg='<div id="popup_close_btn" class="popup_close_btn" onclick="$(this).parent().trigger(\'close\');"></div><div class="customAlert">'+msg+'</div>';
	
  var msgHtml = '<div class="poup_bx width329 shadow fshel_midum">';
  msgHtml += '<div class="close_btn position_absolute " onclick="$(this).parent().trigger(\'close\');"></div>';
  msgHtml += '<h3 class="red fs21 fnt_mouse text_alighC pb10">Note</h3> <div class="bdrb_afafaf"></div>';
  msgHtml += '<P class="text_alighC mt20 f14" > '+msg+'</P>';
  msgHtml += '</div>';

  $("#popup_box").show();
  $("#popup_box").html(msgHtml);

  //add class for new version popup box border remove
  if($("#popup_box").find('.poup_bx').length > 0 || $("#popup_box").find('.f_popup').length > 0){
  //console.log(typeof($('#'+Container).find('.poup_bx').length));
    $("#popup_box").addClass('popup_bg_none');
  }else{
    $("#popup_box").removeClass('popup_bg_none');
  }
  
	$('#popupBoxWp').lightbox_me({
		centered: true, 
		closeEsc:false,
		closeClick:false,
		onLoad: function() {}	
	});
	return false;			
}
/*---------------------------*/		
/*---------------------------*/		
//ajay//
function loader(Container){
  
   $("#"+Container).parent().show();
	var loaderImage = baseUrl+"images/loading_wbg.gif";
	var img_url = $("<div id='defaultLoader'><img class='ajax_loader' src='" + loaderImage + "' style=\"margin-left: auto; margin-right: auto;\" alt=\"Loading...\" title=\"Loading...\"/></div>");
	return img_url.appendTo('#'+Container);
}
/*---------------------------*/	

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

/*---------------------------*/		
function openLightBox(BoxWp,Container,URL,val1,val2,val3,val4,val5){	
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
				$('#'+Container).html(loader(Container));
			  },
			  success: function(html){				  
				 $('#'+Container).show();
         $('#'+Container).html(html);
         
         //add class for new version popup box border remove
         if($('#'+Container).find('.poup_bx').length > 0 || $("#popup_box").find('.f_popup').length > 0){
            //console.log(typeof($('#'+Container).find('.poup_bx').length));
            $('#'+Container).addClass('popup_bg_none');
         }else{
           $('#'+Container).removeClass('popup_bg_none');
         }
          
         $('#'+BoxWp).lightbox_me({
					centered: true,
					closeEsc:false,
					closeClick:false,
					onLoad: function() {
					copyClip.init('.copylink');	
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

/*-----------This lightbox for player----------------*/		
function openPlayerLightBox(BoxWp,Container,URL,val1,val2,val3,val4,val5){	
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
				$('#'+Container).html(loader(Container));
			  },
			  success: function(html){				  
				$('#'+Container).show();
				$('#'+Container).html(html);
				 $('#'+BoxWp).clone().lightbox_me({
					centered: true,
					closeEsc:false,
					destroyOnClose: true,
					closeClick:false,
					onLoad: function() {
						
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
	

/*---------------------------*/		
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
/*---------------------------*/		
function viewgallery(){
	$("#postGalleryBoxWp #postGalleryFormContainer").html('');
			  
	  $.ajax({
				  type:'GET',
				  data:'ajaxHit=1',
				  url: baseUrl+language+"/"+"blog/viewGallery",
				  cache: false,
				  beforeSend: function( ) {
					
				  },
				  success: function(html){
					$("#postGalleryBoxWp #postGalleryFormContainer").html(html);
					   $('#postGalleryBoxWp').lightbox_me({
						centered: true, 
						closeEsc:false,
						closeClick:false,						
						onLoad: function() {
							
						}	
					});	
				  }
		});
}
/*---------------------------*/		
function viewnicgallery(DivID){
	$("#postGalleryBoxWp #postGalleryFormContainer").html('');
			  
	  $.ajax({
				  type:'GET',
				  data:'ajaxHit=1',
				  url: baseUrl+language+"/"+"blog/viewGallery",
				  cache: false,
				  beforeSend: function( ) {
					
				  },
				  success: function(html){
					
					  $("#"+DivID).html(html);
				  }
		});
}
/*---------------------------*/	

/*---------------------------*/		
function workreview(){
	$("#reviewBoxWp #reviewFormContainer").html('');
	
	$.ajax({
	  type:'GET',
	  data:'ajaxHit=1',
	  url: baseUrl+language+"/"+"work/reviews",
	  cache: false,
	  beforeSend: function( ) {
	  },
	  success: function(html){
		$("#reviewBoxWp #reviewFormContainer").html(html);
		 $('#reviewBoxWp').lightbox_me({
			centered: true, 
			closeEsc:false,
			closeClick:false,
			onLoad: function() {
				
			}	
		});	
	  }
	});
	  		
}
/*---------------------------*/	

/*---------------------------*/		
function addCompanyHistory(Id,EmpHistoryId,Action){
	$("#companyHistoryBoxWp #companyHistoryFormContainer").html('');
	
	$.ajax({
		  type:'POST',
		  data:{
			  ajaxHit:1,
			  WorkProfileId:Id,
			  EmpHistoryId:EmpHistoryId,
			  Action:Action
			  },
		  url: baseUrl+language+"/"+"EmploymentHistory",
		  cache: false,
		  beforeSend: function( ) {
		  },
		  success: function(html){
			$("#companyHistoryBoxWp #companyHistoryFormContainer").html(html);
			 $('#companyHistoryBoxWp').lightbox_me({
					centered: true, 
					closeEsc:false,
					closeClick:false,
					onLoad: function() {
						
					}	
				});	
		  }
		});			  		
}

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


function prepareUserListForMail(obj, id, name){
	if(obj.checked){
		$('#userListForMail').append('<div id="user'+id+'" class="fl width125px mt10 ml10"><div class="fl widthAuto ptr" onclick="prepareUserListForMail(this,'+id+')" ><img class="mt3" align="absmiddle" width="12" src="'+baseUrl+'images/icons/delete_grey.png" /></div><div class="fl widthAuto">&nbsp;'+name+'</div></div>');
	}else{
		$('#user'+id).remove();
		$('#'+id).attr('checked', false);
	}
	var count1 = $(".CheckBox").size();
	var ID = new Array();
	ID = checkCheckbox();
	var count2 = ID.length;
	if(count1 == count2){
		$('#selectAllCheckBox').attr('checked', true);
	}else{
		$('#selectAllCheckBox').attr('checked', false);
	}
}

function checkUncheckParent(checkbox,parentcheckbox){
	var checkboxLength= $(checkbox).length;
	var checkedCheckboxLength =0;
	$(checkbox).each(function(index){
		if(this.checked){
			checkedCheckboxLength++;
		}
	});
	if(checkboxLength==checkedCheckboxLength){
		$(parentcheckbox).attr("checked", true);
	}else{
		$(parentcheckbox).attr("checked", false);
	}
	runTimeCheckBox();
}

function checkUncheck(obj, id, checkbox){
	if(!checkbox){
		checkbox ='.CheckBox';
	}
	$(checkbox).attr("checked", obj.checked);
	
	if(id>0){
		$("#"+id).html("");
		if(obj.checked){
			$(checkbox).each(function(index){
					prepareUserListForMail(this, this.id, this.alt);
			});
		}
	}
	runTimeCheckBox();
}

function checkCheckbox(checkbox){		
		if(!checkbox){
			checkbox ='.CheckBox';
		}
		var flag = 0;
		var ID = new Array();
		var i =0;
		$(checkbox).each(function(index){
			if(this.checked){
				flag=1;
				ID[i]=this.value;
				i++;
			}
		});
		if(flag){
			return ID;
		}else{
			return false;
		}
}
//Added by Sapna on 5'th June
// To count the checkboxes inside a Div
//divId id Id of that Div

function checkCheckboxDiv(divId){
		var flag = 0;
		var ID = new Array();
		var i =0;
		$('#'+divId+' input:checkbox:checked').each(function() {
			if(this.checked){
				flag=1;
				ID[i]=this.value;
				i++;
			}
		});
		if(flag){
			return ID;
		}else{
			return false;
		}
}

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

function deleteTabelRowAdmin(tbl,field,id,divId,checkbox,removeRow,fileId,reloadPage,customMsg){
	
	if(!removeRow || removeRow == ''){
			removeRow ='#row';
	}
	if(!checkbox || checkbox == ''){
			checkbox ='.CheckBox';
	}
	if(!fileId){
			fileId =0;
	}
	if(customMsg){
		areYouSure=customMsg;		
	}	
	
	var url = baseUrl+language+'/common/deleteTabelRowAdmin';
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
			var returnFlag=AJAX(url,divId,ID,tbl,field,fileId);
			if(returnFlag){
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

function moveMediaProjectInTrash(projectId,elemetTable,sectionId,section,customMsg){
	if(customMsg){
		areYouSure=customMsg;		
	}	
	var url = baseUrl+language+'/media/moveMediaProjectInTrash';
	if(projectId > 0 && elemetTable.length > 2){
		if(confirm(areYouSure)){
			var returnFlag=AJAX(url,'',projectId,elemetTable,sectionId,section);
			if(returnFlag){
				window.location.href=baseUrl+language+'/media/'+section+'/deletedItems';
			}
		}
	}
}
function moveMediaElementInTrash(projectId,elemetTable,elementId,sectionId,customMsg){
	if(customMsg){
		areYouSure=customMsg;		
	}	
	var url = baseUrl+language+'/media/moveMediaElementInTrash';
	if(projectId > 0 && elemetTable.length > 2){
		if(confirm(areYouSure)){
			var returnFlag=AJAX(url,'',projectId,elemetTable,elementId,sectionId);
			if(returnFlag){
				refreshPge();
			}
		}
	}
}

function changeStatusAsDeleted(table,field,id,section,customMsg){
	if(customMsg){
		areYouSure=customMsg;		
	}	
	var url = baseUrl+language+'/common/changeStatusAsDeleted/';
	if(id > 0 && table.length > 2 && field.length > 2){
		if(confirm(areYouSure)){
			var returnFlag=AJAX(url,'',id,table,field,section);
			if(returnFlag){
				refreshPge();
			}
		}
	}
}


// Added By sapna for Category Dropdown
function getCategoryList(divId1,divId2,divId3,val1,val2,val3,val4){
		var url = baseUrl+language+'/common/getCategoryList'
		$('#'+divId2+' option').each(function(i, option){ $(option).remove(); });
		$('#'+divId2).append( new Option(val3,'') );
		$('#'+divId3+' option').each(function(i, option){ $(option).remove(); });
		$('#'+divId3).append( new Option(val4,'') );
		AJAX(url,divId1,val1,val2);
}

function getGenerList(divId,val1,val2,val3,val4,setvalue){
	
	//alert(val1+'---'+val2);
	var url = baseUrl+language+'/common/getGenerList'
	AJAX(url,divId,val1,val2,val3,val4,setvalue);
}

function getTypeList(divId1,divId2,val1,val2,val3){
	  //alert(val1+'-'+val2+'-'+val3);
		var url = baseUrl+language+'/common/getTypeList'
		$('#'+divId2+' option').each(function(i, option){ $(option).remove(); });
		$('#'+divId2).append( new Option(val3,'') );
		AJAX(url,divId1,val1,val2);
}

function getTypeListGenre(divId1,divId2,val1,val2,val3){
	 //alert(val1+'---'+val2);
		var url = baseUrl+language+'/common/getTypeListGenre'
		
		AJAX(url,divId1,val1,val2);
}



function getStateList(divId1,val1,val2,val3){
	// alert(divId1+'---'+val1);return false;
		var url = baseUrl+language+'/common/getStateList'		
		AJAX(url,divId1,val1,val2,val3);
}


function getIndustryList(divId1,val1,val2,val3){
	  //alert(divId1+'='+val1+'-'+val2+'-'+val3);
		var url = baseUrl+language+'/common/getIndustryList'		
		AJAX(url,divId1,val1,val2);
		setSeletedValueOnDropDown('IndustryList',val1);
}



// function WordLengthCheck
function checkWordLen(obj,wordLen,divid){
//alert(obj+","+wordLen+","+divid);
	if(!wordLen){
	 var wordLen = 100; // Maximum word length
	}
	if(!divid){
	 var divid = 'remainingLimit'; 
	}
	var value = obj.value.replace(/^\s+|\s+$/g,"");
	var len =value.split(/[\s]+/);
	var limit = len.length;
	if(value.length==0){
		limit = 0;
	}
	if(limit > wordLen){
		alert(limitError1+wordLen+limitError2);
		//obj.oldValue = obj.value!=obj.oldValue?obj.value:obj.oldValue;
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

// function WordLengthCheck
function getRemainingLen(obj,wordLen,divid){
//alert(obj+","+wordLen+","+divid);
	if(!wordLen){
	 var wordLen = 100; // Maximum word length
	}
	if(!divid){
	 var divid = 'remainingLimit'; 
	}
	var len = obj.value.split(/[\s]+/);
	var limit = len.length;
	if(obj.value.length==0){
		limit = 0;
	}
	//alert(limit);
	if(limit > wordLen){
		alert(limitError1+wordLen+limitError2);
		//obj.oldValue = obj.value!=obj.oldValue?obj.value:obj.oldValue;
		s = obj.value.substring(0, wordLen);
		t = WordLengthCheck( obj.value ,wordLen );
		t = t.replace(/^\s+|\s+$/g, "");
		obj.value = t;
		//$('#'+divid).html(wordLen);
	   return false;
	}
	else{
		var remianingValue = wordLen-limit;
		$('#'+divid).html(remianingValue);
		return true;
	}

}

function doRegister(url,email,password,confirm_password,firstName,lastName,countryId,cityName) {
	$.ajax({
		type: 'POST',
		url : url,
		dataType :'json',
		data : {
			email:email,
			password:password,
			confirm_password:confirm_password,
			firstName:firstName,
			lastName:lastName,
			countryId:countryId,
			cityName:cityName,
			ajaxHit:1
		},
		beforeSend:function(){
			$("#successMsg").html('<img  class="ma ajax_loader" align="absmiddle"src="'+baseUrl+'images/loading_wbg.gif" />');
		},
		complete:function(){
			
		},
		success:function(data){
			$("#successMsg").html('');
			$("#emailMsg").html('');
			if(data.success){
				//$("#dataStorage").html("<div class='p15'>"+data.success+"</div>"); 
				//$("#dataStorage").hide();
				$('#popupBoxWp').trigger('close');
				$('#popup_box').hide();
				$('#defaultLoader').remove();
				openLightBox('popupBoxWp','popup_box','/auth/registersuccessmsgpopup');
			}
			else{
				if(data.errors.username){
					$("#emailMsg").html(data.errors.username);
				}
				if(data.errors.email){
					$("#emailMsg").html(data.errors.email);
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

function isEmailExist(url,email){
	if(email && email!=''){
		$.ajax({
			type: 'POST',
			url : baseUrl+language+url,
			dataType :'json',
			data : {
				email:email,
				ajaxHit:1
			},
			beforeSend:function(){
				$("#successMsg").html('<img  class="ma ajax_loader" align="absmiddle"src="'+baseUrl+'images/loading_wbg.gif" />');
			},
			complete:function(){
				
			},
			success:function(data){
				$("#successMsg").html('');
				
			 openLightBox('popupBoxWp','popup_box','/auth/register');
			/*	if(data.emaiExist){
					openLightBox('popupBoxWp','popup_box','/auth/emailAlreadyExist',email);
				}
				else{
					openLightBox('popupBoxWp','popup_box','/auth/register',email);
				} */
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$("#successMsg").html('');
				//alert(xhr.status);
				alert(thrownError);
			}
		});
	}else{
		openLightBox('popupBoxWp','popup_box','/auth/register',email);	
	}

}

function forgotPasswordPopup(){
	openLightBox('popupBoxWp','popup_box','/auth/forgot_password/');
}

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

function getTypeListNew(url,divId,val,val2,divId2,inputId,ajaxHit,removeDivId,divId3,inputId2){
	$('#'+divId).show();
	
	if(val=='other'){
		if(divId2 && inputId){
			$('#'+divId2).show();
			$('#'+divId2).html('<input name="'+inputId+'" id="'+inputId+'" type="text" class="Bdr4 required error"  value="" placeholder="Other"/>');
		}
		if(removeDivId){
			$('#'+removeDivId).html('');
		}
		if(divId3 && inputId2){
			$('#'+divId3).show();
			$('#'+divId3).html('<input name="'+inputId2+'" id="'+inputId2+'" type="text" class="Bdr4 required error"  value="" placeholder="Other"/>');
		}
	}else{
		if(divId2){
			$('#'+divId2).show();
			$('#'+divId2).html('');
		}
		if(divId3){
			$('#'+divId3).show();
			$('#'+divId3).html('');
		}
		if(ajaxHit==1){
			AJAX(url,divId,val,val2);
		}
	}

}
function getGenerListNew(url,divId,val,val2,divId2,inputId,ajaxHit,removeDivId,divId3,inputId2){
	//alert(url+','+divId+','+val+','+val2+','+divId2+','+inputId+','+ajaxHit+','+removeDivId+','+divId3+','+inputId2);
	$('#'+divId).show();
	
	if(val=='other'){
		if(divId2 && inputId){
			$('#'+divId2).show();
			$('#'+divId2).html('<input name="'+inputId+'" id="'+inputId+'" type="text" class="Bdr4 required error"  value="" placeholder="Other"/>');
		}
		if(removeDivId){
			$('#'+removeDivId).html('');
		}
		if(divId3 && inputId2){
			$('#'+divId3).show();
			$('#'+divId3).html('<input name="'+inputId2+'" id="'+inputId2+'" type="text" class="Bdr4 required error"  value="" placeholder="Other"/>');
		}
	}else{
		if(divId2){
			$('#'+divId2).show();
			$('#'+divId2).html('');
		}
		if(divId3){
			$('#'+divId3).show();
			$('#'+divId3).html('');
		}
		if(ajaxHit==1){
			AJAX(url,divId,val,val2);
		}
	}

}

function hideShow(id1,id2,id3,id4,id5,value)
{ 
	if(id1){
		$('#'+id1).hide(); 
	}
	
	if(id3){
		$('#'+id3).attr('class','');
	}
	
	if(id2){
		$('#'+id2).show();
	}
	
	if(id4){
		$('#'+id4).attr('class','active');
	}
	
	if(id5){
		$('#'+id5).val(value);
	}
}

function changeUploadMediyaFormValue(data)
{ 
	
	var isCheckbox=false;
	$('label.error').remove();
			
	$('input.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
	});
	$('textarea.error').each(function(index){
			var inputClass =$(this).attr('class').replace('error', '');
			$(this).attr('class',inputClass);
	});
	
	$('#fileError').html('');
	
	if(!$('#uploadElementForm').is(":visible")){
		$("#uploadElementForm").slideToggle('slow');
	}
	
	if(data.elementId > 0){
		if($('#selectFileTypeDiv')){
			$('#selectFileTypeDiv').hide();
		}
	}else{
		if($('#fileTypeFlag')){
			if($('#fileTypeFlag').val()==1){
				$('#selectFileTypeDiv').show();
			}else{
				$('#selectFileTypeDiv').hide();
			}
		}
	}
	if($('#projGenre') && data.industryId){
		getGenerList('GenreList','',data.industryId,'genreId','',data.genreId);
	}
	
	
	
	if($('#imgSrc') )
		$('#imgSrc').val(data.imgSrc);
	if($('#fileTitle'))
		$('#fileTitle').val(data.fileTitle);
	if($('#article') && data.article){
		$('#article').val(data.article);
		if($('.nicEdit-main'))
		$('.nicEdit-main').html(data.article);
		
	}
	if($('#articleSubject') && data.articleSubject)
		$('#articleSubject').val(data.articleSubject);
	if($('#industryId') && data.industryId){
		$('#industryId').val(data.industryId);
		setSeletedValueOnDropDown('industryId',data.industryId);
	}
	
	if($('#freeGenre') && data.freeGenre)
		$('#freeGenre').val(data.freeGenre);
	if($('#languageId') && data.languageId){
		$('#languageId').val(data.languageId);
		setSeletedValueOnDropDown('languageId',data.languageId);
	}
	
	if($('#wordCount') && data.wordCount >= 0){
		if(!data.wordCount || data.wordCount == 0){ data.wordCount =''} 
		$('#wordCount').val(data.wordCount);
	}
	
	
	
	if('#uploadFileSection')
		$('#uploadFileSection').show();
	if('#embedButton')
		$('#embedButton').show();
	if('#EmbeddedURL')
		$('#EmbeddedURL').show();
	if('#uploafFileButton')
		$('#uploafFileButton').show();
	if('#Uploadvideo')
		$('#Uploadvideo').show();
		
	if('#showInUploadCase')
		$('#showInUploadCase').show();
	
	if($('#isExternal')){
		//$('#isExternal').val(data.isExternal);
		if(data.elementId > 0){
			if(data.isDefaultElement=='t'){
				if('#showInUploadCase')
					$('#showInUploadCase').hide();
			}
			
			if(data.isExternal=='f'){
				if('#uploadFileSection')
				$('#uploadFileSection').hide();
			}else{
				
				if('#uploafFileButton')
					$('#uploafFileButton').hide();
				if('#Uploadvideo')
					$('#Uploadvideo').hide();
				
				if('#showInUploadCase')
					$('#showInUploadCase').hide();
			}
			
		}else{
			if('#EmbeddedURL')
				$('#EmbeddedURL').hide();
			
			if(data.isDefaultElement=='t'){
				if('#showInUploadCase')
					$('#showInUploadCase').hide();
			}
		}
	}
	
	if($('#isWrittenFileExternal') && data.isWrittenFileExternal){
		$('#isWrittenFileExternal').val(data.isWrittenFileExternal);
		$('#uploadNewsReviewsSection').show();
		$('#writeButton').show();
		$('#writeArticle').show();
			
		if(data.isWrittenFileExternal==2 ){
			//showSpecificSection('#embedArticleMenu',2);
			$('#uploafFileButton').hide();
			$('#Uploadvideo').hide();
			$('#writeButton').hide();
			$('#writeArticle').hide();
		}
		else if(data.isWrittenFileExternal==1){
			//showSpecificSection('#uploadArticleMenu',1);
			$('#uploadNewsReviewsSection').hide();
			
		}else{
			showSpecificSection('#writeArticleMenu',0);
			$('#uploafFileButton').hide();
			$('#Uploadvideo').hide();
			
			$('#embedButton').hide();
			$('#EmbeddedURL').hide();
			
			
		}
	}
	
	if($('#fileType') && (data.fileType)){
		$('#fileType').val(data.fileType);
		if(data.fileType=='text' || data.fileType==4){
			$('#fileLengthDiv').hide();
			$('#wordCountDiv').show();
			
			if($('#selectFileTypeDiv').is(":visible")){
				$('#selectFileType3').attr('checked',true);
			}
		}else{
			$('#fileLengthDiv').show();
			$('#wordCountDiv').hide();
			if(data.fileType=='audio' || data.fileType==3){
				$('#fileLengthLabel	').html('Length');
			}else{
				$('#fileLengthLabel	').html('Duration');
			}
		}
		
	}
	
	
	if($('#fileInput'))	$('#fileInput').val('');
	if(data.rawFileName !=null && data.rawFileName.length>4 && (data.isWrittenFileExternal==1 || data.isExternal=='f') && (data.isWrittenFileExternal !=0 && data.isWrittenFileExternal !=2 && data.isExternal  != 't')){
		if($('#rawFileName'))
			$('#rawFileName').val(data.rawFileName);
		
		if($('#rawFileNameContainerDiv'))
			$('#rawFileNameContainerDiv').show()
		
		if($('#rawFileNameDiv'))
			$('#rawFileNameDiv').html(data.rawFileName);
	}else{
		if($('#rawFileNameContainerDiv'))
			$('#rawFileNameContainerDiv').hide()
		
		if($('#rawFileNameDiv'))
			$('#rawFileNameDiv').html('');
	}		
	
	if($('#fileName'))
		$('#fileName').val(data.fileName);
	if($('#fileSize'))
		$('#fileSize').val(data.fileSize);
		
	
	if($('#fileHeight') && data.fileHeight){
		$('#fileHeight').val(data.fileHeight);
	}else{
		$('#fileHeight').val('');
	}
		
	if($('#fileWidth') && data.fileWidth){
		$('#fileWidth').val(data.fileWidth);
	}else{
		$('#fileWidth').val('');
	}
		
	if($('#fileUnit') && data.fileUnit) {		
	   setSeletedValueOnDropDown('fileUnit',data.fileUnit);	   
	} else if  (!data.fileUnit) {		  		  
		    setSeletedValueOnDropDown('fileUnit','');		  
	}		
	
	
	
	if($('#embbededURL')){
		var embbededURL  = data.embbededURL;
		embbededURL  = embbededURL.replace(/\&lt;/g, "<");
		embbededURL  = embbededURL.replace(/\&gt;/g, ">");
		$('#embbededURL').val(embbededURL);
	}
	
	if($('#fileLength')){
		if(data.hh && data.mm && data.ss){
			$('#fileLength').val(data.fileLength);
			data.hh=(data.hh.length==1)?'0'+data.hh:data.hh;
			$('#hh').val(data.hh);
			$('#hh').selectBoxJquery('value', data.hh);
			data.mm=(data.mm.length==1)?'0'+data.mm:data.mm;
			$('#mm').val(data.mm);
			$('#mm').selectBoxJquery('value', data.mm);
			data.ss=(data.ss.length==1)?'0'+data.ss:data.ss;
			$('#ss').val(data.ss);
			$('#ss').selectBoxJquery('value', data.ss);
		}
	}
	
	var piiceDivVisible = $('#showInUploadCase').is(":visible");
	if(piiceDivVisible){
		if($('#downloadPrice')){
			$('#downloadPrice').val(data.downloadPrice);
			$('#isDownloadPrice').attr('price',data.downloadPrice);
			if(data.isDownloadPrice=='t'){
				$('#downloadPrice').attr("class",'fl price_input NumGrtrZero required');
				$('#isDownloadPrice').attr("checked", true);
				$('#downloadPrice').removeAttr("readonly");
			}else{
				$('#downloadPrice').attr("class",'fl price_input_disable');
				$('#isDownloadPrice').attr("checked", false);
				$('#downloadPrice').attr("readonly",true);
			}
			getDisplayPrice('#downloadPrice',data.seller_currency,'#totalCommisionEDownLoad','#displayPriceEDownLoad');
		}
		if($('#perViewPrice')){
			$('#perViewPrice').val(data.perViewPrice);
			$('#isPerViewPrice').attr('price',data.perViewPrice);
			if(data.isPerViewPrice=='t'){
				
				$('#perViewPrice').attr("class",'fl price_input NumGrtrZero required');
				$('#isPerViewPrice').attr("checked", true);
				$('#perViewPrice').removeAttr("readonly");
			}else{
				
				$('#perViewPrice').attr("class",'fl price_input_disable');
				$('#isPerViewPrice').attr("checked", false);
				$('#perViewPrice').attr("readonly",true);
			}
			getDisplayPrice('#perViewPrice',data.seller_currency,'#totalCommisionEPPV','#displayPriceEPPV');
		}
		if($('#price')){
			$('#price').val(data.price);
			$('#isPrice').attr('price',data.price);
			if(data.isPrice=='t'){				
				$('#price').attr("class",'fl price_input NumGrtrZero required');
				$('#isPrice').attr("checked", true);
				$('#price').removeAttr("readonly");
			}else{
				$('#price').attr("class",'fl price_input_disable');
				$('#isPrice').attr("checked", false);
				$('#price').attr("readonly",true);
			}
			getDisplayPrice('#price',data.seller_currency,'#totalCommisionEProduct','#displayPriceEProduct');
		}
	}
	
	if($('#quantity')){
		$('#quantity').val(data.quantity);
	}
	
	if($('#elementId')){
		$('#elementId').val(data.elementId);
		
		if(data.elementId > 0){
			
			$('#fileInput').attr('class','width480px ');
		}else{
			$('#fileInput').attr('class','width480px required');
		}
	}
	
	if($('#mediaTypeId')){
		$('#mediaTypeId').val(data.mediaTypeId);
	}
	if($('#fileId'))
		$('#fileId').val(data.fileId);
	if($('#isDefaultElement') && data.isDefaultElement)
		$('#isDefaultElement').val(data.isDefaultElement);
	runTimeCheckBox();
	
	
}

function setSeletedValueOnDropDown(selectBoxid, value){
		if(!(selectBoxid.indexOf("#") >= 0)){
			selectBoxid="#"+selectBoxid;
		}
		$(selectBoxid).selectBoxJquery('value', value);
}

function hideDiv(){
	if($('.successMsg')){
		$('.successMsg').remove();
	}
	if($('.errorMsg')){
		$('.errorMsg').remove();
	}
}

function InternetExplorerMsgClose(){
	$('#InternetExplorerMsg').remove();
	var url = baseUrl+language+'/common/set_userdata'; 
	var val1='InternetExplorerMsgClose';
	var val2=1;
	AJAX(url,'',val1,val2);
}

/*---------------------------*/	



$(document).ready(function() {
	/********HEADER SEARCH BOX********/
	$("#show_searchbox").click(function () {
		$("#search_div").fadeToggle("slow");
	});
	/********************************************************************************************************************
	SIMPLE ACCORDIAN STYLE MENU FUNCTION
	********************************************************************************************************************/	
	$('div.accordionButton').click(function() {
		$('div.accordionContent').slideUp('normal');	
		$(this).next().slideDown('normal');
	});	
	/********************************************************************************************************************
	CLOSES ALL DIVS ON PAGE LOAD
	********************************************************************************************************************/	
	$("div.accordionContent").hide();
	selectBox();
	runTimeCheckBox();
	if($('#messageSuccessError')){
		 timeout = setTimeout(hideDiv, 5000);
	}

	
	
	$('.Check_box').click(function(){	
			$(this).parent().find('.chk_wp').toggle();
	});

	
	/*$('.Left_side_menu ul li a').click(function(){
			$(this).parent().addClass('LSM_select ');
			$(this).parent().siblings().removeClass('LSM_select ');
			
	})
	*/
	
	$('.Main_btn_right a').click(function(){
		$(this).parent().parent().parent().addClass('Main_select ');
		$(this).parent().parent().parent().siblings().removeClass('Main_select ');
	 })
	 
	
	/*
		move bulk mail in trashed click on remove icon(id=removeRecord)
		page: tmail/view/tmail_inbox.php
		written by sushil mishra date:24-03-2012 
	*/
	$('#removeRecord').click(function(){
		var ID = new Array();
		var flag;
		ID = checkCheckbox();
		if(ID){
			if(confirm(areYouSure)){
				var url = baseUrl+language+'/tmail/trash';
				var returnFlag=AJAX(url,'',ID);
				if(returnFlag){
					$('form .CheckBox').each(function(index){
						if(this.checked){
							 $(this).parents("tr:first").remove();
						}
					});
					var count = $(".CheckBox").size();
					if(!count){
						$('#removeRecord').remove();
						$('#Messages').html(noMessagae);
					}
				}
			}
			return false;
		}else{
			customAlert(atleastSelect);
			return false;
		}
	});
	
	$('a[href=#top]').click(function(){
        $('html').animate({scrollTop:0}, 'slow');
        return false;
    });
    
    
   //TOGGLE INFO USING THIS CLASS AND ATTRIBUTE
   $(".toggle_btn").click(function(){									
    $(this).parent().find('.blog_box').slideToggle("slow");
	if($(this).css("background-position")=='0% 0%'){
		$(this).css("background-position","0 -13px")
		
	}else{
		$(this).css("background-position","0% 0%");
		
	}
	});
	//END TOGGLE
	
	//TOGGLE INFO USING THIS CLASS AND ATTRIBUTE
   $("#flipUsingMe").click(function(){	
	   								
		var yearTogDivId = $(this).attr('yearToggleDivId');	
				
		if($("#flipUsingMe").attr('class')=='slide_up minMax16px') 
			$("#flipUsingMe").attr('class','slide_down minMax16px');
		else 
			$("#flipUsingMe").attr('class','slide_up minMax16px');		
	
	$('#'+yearTogDivId).slideToggle("slow");
	});
	//END TOGGLE
	
	$('.formToggleIcon').click(function(){
		
		var toggleDivIcon = $(this).attr('toggleDivIcon');
		var toggleDivForm = $(this).attr('toggleDivForm');
		var toggleDivFormIsVisible = $('#'+toggleDivForm).is(":visible");
		var togDivId = $(this).attr('toggleDivId');
		var toggleDivVisible = $('#'+togDivId).is(":visible");
		var cancelId = $(this).attr('cancelId');
		if(toggleDivVisible == true){
			
			if(!(toggleDivForm=='uploadElementForm' || toggleDivForm=='updateFurtherDescriptionForm'|| toggleDivForm=='FDS')){
				$('#'+toggleDivForm).slideToggle("slow");
		    }
			
			
			if(cancelId) $('#'+cancelId).click();
			
		}else{
			$('#'+toggleDivForm).show();
			
			if($('#'+toggleDivIcon).css("background-position")=='-1px -121px'){
				$('#'+toggleDivIcon).css("background-position","-1px -144px")
				
			}else{
				$('#'+toggleDivIcon).css("background-position","-1px -121px");
			}
			$('#'+togDivId).slideToggle("slow");
		}
	}); 
	$('.projectToggleIcon').click(function(){
		var togDivId = $(this).attr('toggleDivId');
		if($(this).css("background-position")=='-1px -121px'){
			$(this).css("background-position","-1px -144px")
			
		}else{
			$(this).css("background-position","-1px -121px");
		}
		$('#'+togDivId).slideToggle("slow");
	});
});

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


//dynamically render page-height, select-input, checkbox-input and raido input
	function renderMaxHeight(){
	/* for the left and right, sub leff and sub right */	

		  sub_col_1=$('.sub_col_1').height();
		  sub_col_2=$('.sub_col_2').height();
		  if($('.sub_col_3')){
		  sub_col_3=$('.sub_col_3').height(); 
			}else{
				sub_col_3=0;
			}
		  left_coloumn=$('.left_coloumn').height();
		  right_coloumn =$('.right_coloumn ').height();
		 
		  var largestHeight = Math.max(sub_col_1,sub_col_2,sub_col_3,left_coloumn,right_coloumn); 
		  
		  /*$('.right_coloumn').css('min-height',largestHeight)
		  $('.left_coloumn').css('min-height',largestHeight)
		  
		  $('.sub_col_1').css('min-height',largestHeight)
		  $('.sub_col_2').css('min-height',largestHeight)
		  $('.sub_col_3').css('min-height',largestHeight)
		  
		  $('.sub_col_tbl').css('height',largestHeight)*/
		  
		/* for the left and right, sub leff and sub right */	
	}

	function selectBox(){
		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {			
			$("SELECT").css("visibility", "visible");
			$("SELECT").addClass("pt3");
		}
		else{
			$("SELECT").selectBoxJquery();			
		}
	}

	function runTimeCheckBox(){
		$('.defaultP input').ezMark();
		$('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'})	
	}
//dynamically render page-height, select-input, checkbox-input and raido input


// buttons proptirty in event like mouseup, mousedown mouseover and mouseout
	function mousedown_tds_button_jludark(obj){
		obj.style.backgroundPosition ='0px -43px';
		obj.firstChild.style.backgroundPosition ='right -43px';
	}
	function mouseup_tds_button_jludark(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.firstChild.style.backgroundPosition ='right 0px';
	}
	function mouseup_fbloginB(obj){
		obj.className ='fbbutton_toad_login_down';
	}
	function mouseup_fblogin(obj){
		obj.className ='fbbutton_toad_login';
	}
	
	function mousedown_big_button(obj){
		obj.style.backgroundPosition ='-0px -96px';
		obj.firstChild.style.backgroundPosition ='right -96px';
	}

	function mouseout_big_button(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}

	function mouseup_big_button(obj){
		obj.style.backgroundPosition ='0px -0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}
	function mousedown_tds_button(obj){
		obj.style.backgroundPosition ='0px -76px';
		obj.children[0].style.backgroundPosition ='right -76px';
	}
	function mouseup_tds_button(obj){
		obj.style.backgroundPosition ='0px -38px';
		obj.children[0].style.backgroundPosition ='right -38px';
	}

	function mousedown_blog_button(obj){
	obj.style.backgroundPosition ='0px -26px';
	obj.firstChild.style.backgroundPosition ='right -26px';
	}
	function mouseup_blog_button(obj){
		obj.style.backgroundPosition ='0px -0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}


	function mousedown_cat_button(obj){
	obj.style.backgroundPosition ='0px -35px';
	obj.firstChild.style.backgroundPosition ='right -35px';
	}

	function mouseup_cat_button(obj){
		obj.style.backgroundPosition ='0px -0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}

	// for the small buttons 
	
	function mousedown_huge_button(obj){
		$(obj).attr('class','huge_btn_down Price_btn_style ptr');
	}
	
	function mouseup_huge_button(obj){
		$(obj).attr('class','huge_btn Price_btn_style ptr');
	}
	
	/*new button function*/
	function mousedown_apply_btn(obj){
		idobj = document.getElementById("sessionTicketButton");
		idobj.className ='Apply_big_btn_down_new ml30 mr30';
	}
	function mouseup_apply_btn(obj){
		idobj = document.getElementById("sessionTicketButton");
		idobj.className ='Apply_big_btn_new ml30 mr30';
	}


	function mousedown_small_button(obj){
	obj.style.backgroundPosition ='-0px -39px';
	obj.firstChild.style.backgroundPosition ='right -39px';
	}

	function mouseover_small_button(obj){
	obj.style.backgroundPosition ='-0px -20px';
	obj.firstChild.style.backgroundPosition ='right -20px';
	}


	function mouseout_small_button(obj){
        obj.style.backgroundPosition ='0px 0px';
        obj.firstChild.style.backgroundPosition ='right -0px';
	}

	function mouseup_small_button(obj){
		obj.style.backgroundPosition ='0px -0px';
		obj.firstChild.style.backgroundPosition ='right -0px';
	}
	
		
	/* Front End button function start */
	function mousedown_tds_button_front(obj){
        obj.className ='tds-button_new_down';
	}
	
	function mouseup_tds_button_front(obj){
        obj.className ='tds-button_new';
	}


	function mousedown_tds_button01(obj){
		//alert(obj.children[0]);
		obj.style.backgroundPosition ='0px -40px';
		obj.children[0].style.backgroundPosition ='right -40px';
	}
	
	function mouseup_tds_button01(obj){
		obj.style.backgroundPosition ='0px 0px';
		obj.children[0].style.backgroundPosition ='right 0px';
	}
	
	function mousedown_plus_icon(obj){
		obj.style.backgroundPosition ='0px -50px';
	}
	function mouseup_plus_icon(obj){
		obj.style.backgroundPosition ='0px 0px';
	}
	
	function mousedown_tds_download(obj){
		
		$(obj).css("background-position","0px -36px");
		$(obj).children(":first").css("background-position","right -36px");
	}
	function mouseup_tds_download(obj){
		$(obj).css("background-position","0px 0px");
		$(obj).children(":first").css("background-position","right 0px");
	}
	 
	// buttons proptirty in event like mouseup, mousedown mouseover and mouseout
	/* Front End button function end */

//for div row,cell effect in IE browser Add bu Gurutva
	var ua = $.browser;
	if(ua.msie){
		$(function() {
			$($("div.table").get().reverse()).each(function() { 
				$($(this).find("div.row").get().reverse()).each(function() { 
					$($(this).find("div.cell").get().reverse()).each(function() { 
						$(this).replaceWith( "<td "+getAttributes(this)+">" + $(this).html() + "</td>" );
					});
					$(this).replaceWith( "<tr "+getAttributes(this)+">" + $(this).html() + "</tr>" );
				});
				$(this).replaceWith( "<table "+getAttributes(this)+">" + $(this).html() + "</table>" );
			});
		});
		
		function getAttributes(element){
			var arr =  $(element)[0].attributes, attributes = "";
			for(var i = 0; i < arr.length; i++) {
			  attributeName = arr[i].name;
			  attributeValue = $(element).attr(arr[i].name);
			  if(attributeValue != null && attributeValue != "" && attributeValue != undefined){
				  attributes += attributeName+"=\""+attributeValue+"\" "
				 }
			}
			return attributes;
		}
	}

//for div row,cell effect in IE browser Add bu Gurutva


//for share, email, show, and getLink Add bu Gurutva
	function showShortLinkDiv(showDivId)
	{
		$(".getshortlinkPage").hide();
			$(".shareLinkEmail").hide();
		$('#'+showDivId).slideToggle("slow");		
	}

	function showEmailDiv(showDivId)
	{
		$(".shareLinkEmail").hide();
		$(".getshortlinkPage").hide();
		$('#'+showDivId).slideToggle("slow");		
	}

	function hideRelationDiv(showDivId,obj,relativeDivClass)
	{
		var visibleStatus= $('#'+showDivId).is(":visible");
		if(relativeDivClass){
			$("."+relativeDivClass).each(function(index){
				if($(this).is(":visible") && (showDivId != this.id)){
					$(this).slideToggle("slow");
				}
			});
			$(".projectToggleIcon").each(function(index){
				if(obj.id != this.id){
					$(this).css("background-position","-1px -144px")
				}
			});
		}
		$('#'+showDivId).slideToggle("slow");
	}
	
	function togRelDiv(showDivId,obj,relativeDivClass)
	{
		//alert(showDivId+relativeDivClass);
		//alert(obj.id+':'+this.id);
		var visibleStatus= $('#'+showDivId).is(":visible");
		var objId = "#"+obj;
		if(relativeDivClass){
			$("."+relativeDivClass).each(function(index){
				if($(this).is(":visible") && (showDivId != this.id)){
					$(this).slideToggle("slow");
				}
			});
			$(".projectToggleIcon").each(function(index){
				if(obj != this.id){					
					$(this).css({ 'background-position' : ''});
					$(this).css({ 'background-position' : '-1px -144px'});
				}				
			});
			$(objId).css({ 'background-position' : ''});
			$(objId).css({ 'background-position' : '-1px -122px'});
		}
		$('#'+showDivId).slideToggle("slow");
	}

	function hideAllRelationDiv(div1, div2)
	{
		if(!div1){
			div1 = ".shareLinkEmail";
		}
		if(!div2){
			div2 = ".getshortlinkPage";
		}
		
		if($(div1)){
			$(div1).hide();
		}	
		if($(div2)){
			$(div2).hide();
		}
		
	}
//for share, email, show, and getLink Add bu Gurutva

// creative involved Associative Section
	function editAssociative(obj){
		var EEID = $(obj).attr('EEID');
		var crtId = $(obj).attr('crtId');
		var crtDesignation = $(obj).attr('crtDesignation');
		var crtName = $(obj).attr('crtName');
		var crtEmail = $(obj).attr('crtEmail');
		$('#crtId'+EEID).val(crtId);
		$('#crtDesignation'+EEID).val(crtDesignation);
		$('#crtName'+EEID).val(crtName);
		$('#crtEmail'+EEID).val(crtEmail);
		$('#addEditIcon'+EEID).attr('class','cat_smll_save_icon');
		$('#cancelIcon'+EEID).show();
	}

	function cancelIcon(obj){
		var EEID = $(obj).attr('EEID');
		$('#crtId'+EEID).val(0);
		$('#crtDesignation'+EEID).val('');
		$('#crtName'+EEID).val('');
		$('#crtEmail'+EEID).val('');
		$('#addEditIcon'+EEID).attr('class','cat_smll_save_icon');
		$(obj).hide();
	}

	function deleteAssociative(obj){
		var crtId = $(obj).attr('crtId');
		var EEID = $(obj).attr('EEID');
		deleteTabelRow('AssociativeCreatives','crtId',crtId,'');
		var lenth = $(".liData"+EEID).length;
		if(lenth < 1){
			$('#noRecord'+EEID).show();
		}
	}
	
//To show  meeting point pop-up on the basis of publish/unpublish
function mettingPoint(obj,tbl,pulishField,field,fieldValue,currentStatus,changeStatus,isFARF,deleteCache,checkSession,isSession,sessionMsg,popupData)
{	
	var status = '';	
	var publishUnpublishInfo = {"tabelName":tbl,"pulishField":pulishField,"field":field,"fieldValue":fieldValue,"elementTable":"","elementField":"","isElement":0,"deleteCache":deleteCache};	
	status = publishUnpulish(obj,publishUnpublishInfo,currentStatus,changeStatus,isFARF,checkSession,isSession,sessionMsg,'mettingPoint');
	if(status=='t') {
		loadPopupData('popupBoxWp','popup_box',popupData);		
	}
}


function sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function publishUnpulish(obj,publishUnpublishInfo,currentStatus,changeStatus,isFARF,checkSession,isSession,sessionMsg,section,pagingData){
	if(!sessionMsg){sessionMsg= '';}
	if(!section){section= '';}
	var id=publishUnpublishInfo.fieldValue;
	var isPublished =publishUnpublishInfo.isPublished;
	if(checkSession==1 && isSession==0 && currentStatus=='Hide'){
		customAlert(sessionMsg);	
	}
	else
	{
		if(publishUnpublishInfo.projectId && publishUnpublishInfo.projectId > 0 && publishUnpublishInfo.isElement && publishUnpublishInfo.isElement == 1){
			var projectId =publishUnpublishInfo.projectId; 
			if($('#isProjectPublished'+projectId)){
				var isProjectPublished=$('#isProjectPublished'+projectId).val();
				if(isProjectPublished=='f'){
					isFARF=0;
					notPublishMsg=notPublishElementMsg;
				}
			}
		}
		
		if(isFARF==0 && isPublished=='f'){
				if(sessionMsg.length > 5){
					notPublishMsg = sessionMsg;
				}
				customAlert(notPublishMsg);
		}else
		{
			var msg=''
			var htmlCurrent = $(obj).html();
			if(htmlCurrent == currentStatus){
				htmlChange = changeStatus;
			}else{
				htmlChange = currentStatus;
			}
			if(htmlChange==publish){
				msg = hideMsg;
			}else{
				msg = publishMsg;
			}
			if(confirm(msg)){
				
				openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
				
				var url = baseUrl+language+'/common/publishUnpulish/';
				var returnFlag = AJAX_json(url,'',publishUnpublishInfo);
				
				if(returnFlag){
					if(!returnFlag.isElement || returnFlag.isElement ==0){
						if($('#isProjectPublished'+id)){
							$('#isProjectPublished'+id).val(returnFlag.ispublished);
						}
					}
					
					if(section=='showcase' && returnFlag.ispublished=='t') { 
						$('#publishUnpublishMsg').addClass('dn');
					}
					
					$('#popupBoxWp').trigger('close');
					$('#popup_box').hide();
					$('#defaultLoader').remove();
				}
				
				makePublishUnpulishProject(returnFlag);
				if(section=='mettingPoint'){
					return returnFlag.ispublished;
				}
			}
		}
	}
}

function makePublishUnpulishProject(data){
	if(data != undefined  && data != null){
		if(data.ispublished == 't'){
			makePublishProject(data);
			
		}else{
			makeUnPublishProject(data);
		}
	}
}

function makePublishProject(data){
	if(data != undefined  && data != null){
		if(data.isElement == 0){
			var rtsp='#relationToSharePublishproject'+data.elementId;
			var rtsup='#relationToShareUnPublishproject'+data.elementId;
			var pb='#PublishButtonproject'+data.elementId;
			var upb='#UnPublishButtonproject'+data.elementId;
		
			var vi='#viewIconproject'+data.elementId;
			var pi='#previewIconproject'+data.elementId;
			
			
			if(data.elementsToBePublishedId != 0){
				
				$.each(data.elementsToBePublishedId, function(key, value) {
					var rtspe='#relationToSharePublishelement'+value;
					var rtsupe='#relationToShareUnPublishelement'+value;
					var pbe='#PublishButtonelement'+value;
					var upbe='#UnPublishButtonelement'+value;
					var vie='#viewIconelement'+value;
					var pie='#previewIconelement'+value;
					$(rtspe).show();
					$(rtsupe).hide();
					$(pbe).show();
					$(upbe).hide();
					$(vie).show();
					$(pie).hide();
				});
				
				
			}
		}else{
			var rtsp='#relationToSharePublishelement'+data.elementId;
			var rtsup='#relationToShareUnPublishelement'+data.elementId;
			var pb='#PublishButtonelement'+data.elementId;
			var upb='#UnPublishButtonelement'+data.elementId;
			var vi='#viewIconelement'+data.elementId;
			var pi='#previewIconelement'+data.elementId;			

		}
		$(rtsp).show();
		$(rtsup).hide();
		$(pb).show();
		$(upb).hide();
		$(vi).show();
		$(pi).hide();
	}
}

function makeUnPublishProject(data){
	if(data != undefined  && data != null){
		if(data.isElement == 0){
		
			if(data.elementsToBePublishedId == 0){
				var rtsp='#relationToSharePublishproject'+data.elementId;
				var rtsup='#relationToShareUnPublishproject'+data.elementId;
				var pb='#PublishButtonproject'+data.elementId;
				var upb='#UnPublishButtonproject'+data.elementId;
			
				var vi='#viewIconproject'+data.elementId;
				var pi='#previewIconproject'+data.elementId;
			
			}else{
			
				$('.rtsp').each(function(index){
					$(this).hide();
				});	
				
				$('.rtsup').each(function(index){
					$(this).show();
				});
					
				$('.PublishButton').each(function(index){
					$(this).hide();
				});	
				
				$('.UnPublishButton').each(function(index){
					$(this).show();
				});
				
				$('.viewIcon').each(function(index){
					$(this).hide();
				});	
				
				$('.previewIcon').each(function(index){
					$(this).show();
				});
			}
		}else{
			var rtsp='#relationToSharePublishelement'+data.elementId;
			var rtsup='#relationToShareUnPublishelement'+data.elementId;
			var pb='#PublishButtonelement'+data.elementId;
			var upb='#UnPublishButtonelement'+data.elementId;
			
			var vi='#viewIconelement'+data.elementId;
			var pi='#previewIconelement'+data.elementId;
			
			
		}
		$(rtsp).hide();
		$(rtsup).show();
		$(pb).hide();
		$(upb).show();
		
		$(vi).hide();
		$(pi).show();
	}
}




/*
 *  Function to load element listing after publish/unpublish
 */
function manageElements(pagingData){
	var elementData = 'page='+pagingData.currentPage+'&ipp='+pagingData.currentIpp+'&ajaxRequest=1';
					
	$('#'+pagingData.containerDiv).html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
	$.post(pagingData.pageUrl,elementData, function(data) {
		if(data){
			$('#'+pagingData.containerDiv).html(data);
		}
	});
}

/* key personal type btn */

/* view_gallary button function */
function mousedown_viewG_btn(obj){
	obj.className ='veiw_gallary_btn_down';
}
function mouseup_viewG_btn(obj){
	obj.className ='veiw_gallary_btn';
}

function mousedown_big_button(obj){
obj.style.backgroundPosition ='-0px -96px';
obj.firstChild.style.backgroundPosition ='right -96px';
}

function mouseover_big_button(obj){
obj.style.backgroundPosition ='-0px -48px';
obj.firstChild.style.backgroundPosition ='right -48px';
}


function mouseout_big_button(obj){
obj.style.backgroundPosition ='0px 0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_big_button(obj){
obj.style.backgroundPosition ='0px -0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}


function mousedown_login_go_btn(obj){
obj.className ='login_go_btn_down';
}
function mouseup_login_go_btn(obj){
	obj.className ='login_go_btn';
}
function mousedown_tds_button_new(obj){
obj.className ='tds-button_new_down';
}
function mouseup_tds_button_new(obj){
	obj.className ='tds-button_new';
}


/*ticket button function*/
function mousedown_Dgrey_btn(obj){
obj.className ='Dgrey_btn_active';
}
function mouseup_Dgrey_btn(obj){
	obj.className ='Dgrey_btn';
}

/*red_btn button function*/
function mousedown_red_btn(obj){
obj.className ='red_btn_active';
}
function mouseup_red_btn(obj){
	obj.className ='red_btn';
}
function mousedown_login_go_btn(obj){
obj.className ='login_go_btn_down';
}
function mouseup_login_go_btn(obj){
	obj.className ='login_go_btn';
}

function mousedown_joinbtn_new(obj){
obj.className ='joinbtn_new_down';
}
function mouseup_joinbtn_new(obj){
	obj.className ='joinbtn_new';
}

function mousedown_promote_btn(obj){
obj.className ='promote_btn_down';
}
function mouseup_promote_btn(obj){
obj.className ='promote_btn';
}

function mousedown_tds_button_pur(obj){
	obj.style.backgroundPosition ='0px -42px';
	obj.firstChild.style.backgroundPosition ='right -42px';
}
function mouseup_tds_button_pur(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

/* functions for orange publish button*/
function mousedown_tds_button_orange(obj){
	obj.style.backgroundPosition ='0px -76px';
	obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button_orange(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

function mousedown_tds_button_red(obj){
	obj.style.backgroundPosition ='0px -50px';
	obj.firstChild.style.backgroundPosition ='right -50px';
}
function mouseup_tds_button_red(obj){
	obj.style.backgroundPosition ='0px 0px';
	obj.firstChild.style.backgroundPosition ='right 0px';
}

var urlExists = function(url, callback){

    if (typeof callback !== 'function') {
       throw 'Not a valid callback';
    }   

    $.ajax({
        type: 'HEAD',
        url: url,
        success: function() {
            callback(true);
        },
        error: function() {
            callback(false);
        }            
    });

}

	
	function refreshPge()
	{ 
		window.location.href=window.location.href;
	}
	
	function copyStr(id,str)
	{ 
		
		$('#'+id).zclip({
			path:baseUrl+'swf/zeroClipboard.swf',
			copy:str
		});
	}
	
	
	
	function deleteTabelRowMedia(mediaData,removeRow){
		
	var tbl=mediaData.tableName;
	var field=mediaData.elementFieldId;
	var id=mediaData.mediaId;
	var divId=mediaData.divId;
	var checkbox=mediaData.checkbox;
	if(removeRow)
	removeRow=removeRow;
	else 
	removeRow='#imgRow';
	var fileId=mediaData.fileId;
	var isLogSummery=mediaData.isLogSummery;
	var deleteCache=mediaData.deleteCache;
	var promoFieldId=mediaData.fieldName;
	var tableName=mediaData.tableName;
	var promoFieldVal=mediaData.fieldValue;
	var filePath=mediaData.filePathImage;
	var delBrowseId=mediaData.delBrowseId;
	var reloadPage=mediaData.reloadPage;
	reloadPage=1;
	//alert('reloadPage:'+reloadPage);
	
	if(!deleteCache){
		deleteCache='';
	}
	
	
	
	var isMain = $('#imgIsMain'+id).val();
	
	if(!isMain){
		isMain='';
	}
	if(!removeRow || removeRow == ''){
			removeRow ='#row';
	}
	if(!checkbox || checkbox == ''){
			checkbox ='.CheckBox';
	}
	if(!fileId){
			fileId =0;
	}
	if(!filePath){
			filePath ='';
	}
	if(!isLogSummery){
			isLogSummery =0;
	}
	var url =baseUrl+language+'/common/deleteTabelRowMedia';
	var ID = new Array();
	if(id>0){
		ID[0] = id;
		ID[1] = promoFieldVal;
	}else{
		ID = checkCheckbox(checkbox);
	}
	
	if(ID){
	
		if(confirm(areYouSure)){
			if(reloadPage==1) openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
			var returnFlag=AJAX(url,divId,ID,tbl,field,fileId,filePath,isLogSummery,deleteCache,isMain,promoFieldId,tableName,promoFieldVal,delBrowseId);
			if(returnFlag){	
				$.each(ID, function(key, value) { 					
				  $(removeRow+fileId).remove();				  
				});
				
				if($('#uploadElementForm')){
					if($('#uploadElementForm').is(":visible")){
						$("#uploadElementForm").slideToggle('slow');
					}
				}
				
				if(reloadPage==1){
					setTimeout(refreshPge, 500);
				}
			}
		}
		
	}else{
		alert(atleastSelect);
	}
}
/* showCurrentHideEach developed by  sushil 11-09-2012 */
function showCurrentHideEach(currentDiv,eachDiv){
	
	if(eachDiv && eachDiv != ''){
		eachDiv = eachDiv.replace(" ",""); 
		$(eachDiv).each(function(index){
			$(this).hide();
		});
	}
	if(currentDiv && currentDiv != ''){
		currentDiv = currentDiv.replace(" ",""); 
		$(currentDiv).each(function(index){
			$(this).show();
		});
	}
	//$(currentDiv).show();
}
/* loadPopupData developed by  sushil 11-09-2012 */
function loadPopupData(BoxWp,Container,data){
	openLightBoxWithoutAjax(BoxWp,Container);
	$('#'+Container).html(data);
  //add class for new version popup box border remove
   if($('#'+Container).find('.poup_bx').length > 0 || $("#popup_box").find('.f_popup').length > 0){
      //console.log(typeof($('#'+Container).find('.poup_bx').length));
      $('#'+Container).addClass('popup_bg_none');
   }else{
     $('#'+Container).removeClass('popup_bg_none');
   }
         
	runTimeCheckBox();
}

/* submit forn on enter  sushil 22-09-2012 */
function submitFormOnEnter(formId, checkfieldIdArray){
	var submitFlag=true;
	for(i=0; i < checkfieldIdArray.length; i++){
		var value =$(checkfieldIdArray[i]).val();
		if(!(value.length > 0)){
			var submitFlag=false;
		}
	}
	if(submitFlag){
		$(formId).submit();
	}
}
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
function checkValueInArray(array,val){
	
	if($.inArray(val.toLowerCase(),array) > 0){
		return true;
	}else{
		return false;
	}
}

function goTolink(obj,link){
	
	if(obj.value && obj.value!=undefined && obj.value != ''){
			var value=obj.value;
			link = link+'/'+value;
	}
	
	window.location.href=link;
}

function gotourl(thisUrl,addsiteurl)
{
	if(addsiteurl==1){
		if(!/^(https?|ftp|http):\/\//i.test(thisUrl)) var gotothisurl = 'http://'+thisUrl; // set both the value
		else var gotothisurl = thisUrl;
	}
	else
		var gotothisurl = baseUrl+language+thisUrl;
		
	window.open(
	  gotothisurl,
	  '_blank' // <- This is what makes it open in a new window.
	);
}

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
						craveClass =$(this).attr('class').replace('cravedALL', '');
						craveClass = craveClass+' cravedALL';
						$(this).attr('class',craveClass);
						
				});
				$("#"+craveContainer).attr("class","");
				
			}else{
				$("."+craveContainer).each(function(index){
						craveClass =$(this).attr('class').replace('cravedALL', '');
						$(this).attr('class',craveClass);
				});
				$("#"+craveContainer).attr("class","craved");
				
			}
			$("."+craveContainer+' span').html(craveCount);
			
		}else if(returnData.craveDone==0){
			customAlert(returnData.msg);
		}
	}else{
			return false;
	}
}

function postRating(divId,entityId,elementId,alreadyRate,msg){
		var postRateFlag=checkIsUserLogin(msg);
		if(postRateFlag){
			var ratingValue=getRatingValue();
			var rateData={"elementId":elementId,"entityId":entityId,"ratingValue":ratingValue};
			
			var returnData=AJAX_json(baseUrl+language+"/rating/postRating",divId,rateData);
			if(returnData.ratingDone){
				var msg =returnData.msg;
				var ratingAvg=roundRatingValue(returnData.ratingAvg);
				var rateContainerId="#rateDiv"+entityId+''+elementId;
				var rateContainer=".rateDiv"+entityId+''+elementId;
				var rateBtn = ".rateBtn"+entityId+''+elementId;
				var ratingImg=baseUrl+'images/rating/rating_0'+ratingAvg+'.png';
				var img='<img  src="'+ratingImg+'" />';
				$("#"+divId).html(msg);
				timeOutDiv('popup_box');
				var rateClass =$(rateContainerId).attr('class').replace('rateAll', '');
				rateClass = rateClass+' rateAll';
				$(rateContainerId).attr('class',rateClass);
				$(rateContainer).html(img);
				$(rateBtn).attr("onclick","customAlert("+alreadyRate+")");
			}
		}else{
				return false;
		}
    }
    
    //Toggle Meeting point users
	function toggleWithDelay(sliderId)
	{
		setTimeout(function(){	
			$(sliderId).slideToggle("slow");
		 }, 2000);
	}
    
    //Toggle Meeting point users
	function toggleuserlist(sliderId)
	{
		$('#'+sliderId).slideToggle("slow");
	}
	
	function meetingpoint(val,msg)
	{
		if(val>0)
			$('#eMeetingPointForm').submit();
		else
			alert(msg);
	}
	
	function HideShowAddOption(section,countAddInfo,addInfoLimitation){
		if(countAddInfo)countAddInfo=parseInt(countAddInfo);
		if(addInfoLimitation)addInfoLimitation=parseInt(addInfoLimitation);
		if(countAddInfo >= addInfoLimitation){
			$('#AddIcon'+section).removeClass('projectAddIcon');
			$('#AddLink'+section).hide();
		}else{
			$('#AddIcon'+section).addClass('projectAddIcon');
			$('#AddLink'+section).show();
		}
	}
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
	
		
	function getUserContainers(sectionId,url){
		if(sectionId && checkIsUserLogin('')){
			lightBoxWithAjax('popupBoxWp','popup_box','/package/getAvailableUserContainer/',sectionId,url);
		}
	}

	
	function removeThisID(remiveMeId){
		//alert(remiveMeId);
		 $("'#"+remiveMeId+"'").remove();
	}
	
	function isThereAnyProjectType(formNameId,projectTypeSelect){
		var selectProjectType = $('#selectProjectType'+formNameId).val();
		selectProjectType = parseInt(selectProjectType);
		if(selectProjectType==0){
			$('#selectContainerFrom'+formNameId).submit();
		}else{
			loadPopupData('popupBoxWp','popup_box',projectTypeSelect);
		}
	}



		/* Upload heavy files Added by gurutva July 16 2012 */
function uploadMediaFiles(fileUploadPath,fileTypes,fileMaxSize,uniId,isMultipleForm,isReloadPage,norefresh,imgload,checksection,imgext)
{ 
	if(typeof(uniId)  == undefined){uniId='';}
	if(typeof(isReloadPage)  == undefined || isNaN(isReloadPage)){isReloadPage=1;}
	if(typeof(norefresh)  == undefined || isNaN(norefresh)){norefresh=0;}
	
	
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
					if(createWaterMarkFlag && createWaterMarkFlag == 1){}
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
				$("#redirectUrl").attr("href",baseUrl+language+"/membershipcart/addspace/"+userContainerId);
				lightBoxWithAjax('popupBoxWp','popup_box','/package/notEnoughSpace/',userContainerId,'');
			}
			else if(err.code == "-100")
			{
				$('#fileInput'+uniId).val('');
				$('#fileError'+uniId).html(err.message);
				
			}
			else
			{
				$('#fileInput'+uniId).val('');
				$('#fileError'+uniId).html(fileErrorMasg+ err.file.name);
			}
			uploaderId.stop();
			uploaderId.refresh(); // Reposition Flash/Silverlight
			
		});
		
	}
		
//Used in nic editro insert image function
function selectImage(thisImg,thisAlt)
{
	insertme = thisImg;
	altforinsertme = thisAlt;	
}

function form2form(aF1, aF2, prefix1,prefix2) { 
 var selection = "#" + aF1 + " .copy";
 var inputType= 'text';
 var tagName= 'input';
 $(selection).each(function() {
	 var billingInput = "#" + this.name.replace(prefix1, prefix2);
	 if($(billingInput)){
	  inputType=$(billingInput).attr('type');
	  tagName=$(billingInput).prop("tagName");
	  if(inputType != 'hidden'){
		$(billingInput).val($(this).val());
		if(tagName=='SELECT'){
			$(billingInput).selectBoxJquery('value', $(this).val());
		}
	  }
	 }
 });
}
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

function sendNotification(notificationArray) {
	//setTimeout(function(){	 

	var notification_url = baseUrl+language+'/notifications/send_notification_on_publish/';
		$.ajax({
		  type:'POST',
		  data:{
			ajaxHit:1,
			notificationArray:notificationArray
		  },
		  url: notification_url,
		  success: ''
	});	
	//}, 10000);
}

/*Function for test notifications*/
function test_notification()
{	
	
var notification_url = 'http://localhost/toadsquare_branch_webservices/webservices/index.php?action=server&actionMethod=send_notification';

		$.ajax({
		  type:'POST',
		  data:{
			ajaxHit:1,
			test:'18'
		  },
		  url: notification_url,
		  success: ''
	});		
}


function sendMyNotification(notificationArray) {
	setTimeout(function(){	 
		var notification_url = baseUrl+language+'/notifications/notification_when_section_craved/';
		$.ajax({
		  type:'POST',
		  data:{
			ajaxHit:1,
			notificationArray:notificationArray
		  },
		  url: notification_url,
		  success:function(html){
		  }
	});

	}, 170);

}

/* 
 * Function for time out as per client requirement
 * Dissapear Popup after success message
*/

function timeOutDiv (divId) {
	
	setTimeout(function(){
	  $("."+divId).fadeOut("slow", function () {
	  $('.'+divId).trigger('close');
		  });

	}, 1700);

}

function selectMediaFileType(obj,browseId,allowedMediaType){
	var showAllowedMediaType = allowedMediaType;
	var showAllowedMediaType = showAllowedMediaType.replace(/\|/g, ",");
	var showAllowedMediaType = showAllowedMediaType.replace(/\,/g, ", ");
	$('#fileError'+browseId).html('');
	$('label.error').hide();
	var typeValue=$(obj).val();
	var typeValueCurrent=$('#fileType'+browseId).val();
	if(typeValueCurrent != typeValue){
		$('#fileName'+browseId).val('');
		$('#fileInput'+browseId).val('');
		$('#fileSize'+browseId).val('');
		$('#fileType'+browseId).val(typeValue);
		$('#allowedMediaType'+browseId).html(showAllowedMediaType);
		$('#fileTypeRuntime'+browseId).val(allowedMediaType);
	}
}
function moveInArchive(divId,tbl,primeryField,primeryVal,archiveField,publishField,returnUrl,deleteCache,elementTable,elementField,elementArchiveField,elementPublishField){
	if(!deleteCache){deleteCache='';}
	if(!elementTable){elementTable='';}
	if(!elementField){elementField='';}
	if(!elementArchiveField){elementArchiveField='';}
	if(!elementPublishField){elementPublishField='';}
	if(tbl && primeryField && primeryVal && archiveField && publishField){
		if(confirm(moveInArchiveMsg)){
			var  url= baseUrl+language+"/common/moveInArchive/";
			var res = AJAX(url,'',tbl,primeryField,primeryVal,archiveField,publishField,deleteCache,elementTable,elementField,elementArchiveField,elementPublishField);
			if(res){
				if(divId && divId !=''){
					$('#'+divId).remove();
				}
				else if(returnUrl){
					window.location.href=baseUrl+language+returnUrl;
				}
				else{
					refreshPge();
				}
			}else{
				alert('This project could not move in archive. please check!!');
			}
		}
	}else{
		alert('please check parameters');
	}
	
}
function moveFromArchive(divId,tbl,primeryField,primeryVal,archiveField,returnUrl,deleteCache,elementTable,elementField,elementArchiveField){
	if(!deleteCache){deleteCache='';}
	if(!elementTable){elementTable='';}
	if(!elementField){elementField='';}
	if(!elementArchiveField){elementArchiveField='';}
	if(tbl && primeryField && primeryVal && archiveField){
		if(confirm(areYouSureMoveFromArchive)){
			var  url= baseUrl+language+"/common/moveFromArchive/";
			var res = AJAX(url,'',tbl,primeryField,primeryVal,archiveField,deleteCache,elementTable,elementField,elementArchiveField);
			if(res){
				if(divId && divId !=''){
					$('#'+divId).remove();
				}
				else if(returnUrl){
					window.location.href=baseUrl+language+returnUrl;
				}
				else{
					refreshPge();
				}
			}else{
				alert('This project could not move from archive. please check!!');
			}
		}
	}else{
		alert('please check parameters');
	}
}

function deleteSupportedMedia(id,supportedSection){
	var del = deleteTabelRow('SupportLink','id',id,'','','#SupportingRow');
	if(del){
		$('#'+supportedSection+'entityid_from').val(0);
		$('#'+supportedSection+'elementid_from').val(0);
		$('#'+supportedSection+'Div').html('');
		$('#'+supportedSection+'SearchInputDiv').show();
	}
}

/* To activate full screen gallery on click */

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


/* State list for https request */

function generateStateList(divId1,val1,val2,val3){
	// alert(divId1+'---'+val1);return false;
		var url = baseUrl+language+'/membershipcart/stateList'		
		AJAX(url,divId1,val1,val2,val3);
}

//Add by amit to clipboard script
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



/*ADD BY AMIT TO HANDLE HTTPS IN POPUP*/		
function openLightBoxHttps(BoxWp,Container,URL,val1,val2,val3,val4,val5){	
	
var loc = new String(window.parent.document.location);
	if (loc.indexOf("https://")!= -1)
	 baseUrl; 
	else
	baseUrl=baseUrl.replace("http","http"); //https
		
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
				$('#'+Container).html(loader(Container));
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
function reArrangeRecordsOrder(currentdata,swapData,currentDiv,swapDiv){
	openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
	var url = baseUrl+language+'/common/reArrangeRecordsOrder';
	var returnFlag=AJAX(url,'',currentdata,swapData);
	if(returnFlag){
		refreshPge();
	}
	$('#popupBoxWp').trigger('close');
	$('#popup_box').hide();
	$('#defaultLoader').remove();
}



/*
 *************************** 
 * This function is used to make element image as project image  
 ****************************
 */  
   function makeProjectImage(elemetTable,projectID,elementId)
    {
		var sendData = {"elemetTable":elemetTable,"projectID":projectID,"elementId":elementId}
		
		openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
		
	    $.post(baseUrl+language+'/common/makeElementProjectImage',sendData, function(data) {
				if(data){	
					refreshPge();
				}else{
					$('#popupBoxWp').trigger('close');
					$('#popup_box').hide();
					$('#defaultLoader').remove();
				}
		}).fail(function() {
				$('#popupBoxWp').trigger('close');
				$('#popup_box').hide();
				$('#defaultLoader').remove();
				customAlert("This element image can not make project image.");
		  })
	}

	/*
	 ******************
	 * This function is used to show new confirm popup
	 * sendData object form = sendData{'userId':1}
	 ******************
	 */
	
	function confirmPopup(sendData){
		openLightBox('popupBoxWp','popup_box','/common/confirmPopup',sendData);
	}
	
	function open_window(url)
	{
		NewWindow = window.open(url,"_blank","toolbar=0,menubar=0,status=0,copyhistory=0,scrollbars=1,resizable=1,location=0,Width=600,Height=400,top=250,left=300") ;
		if (window.focus) {NewWindow.focus()}
		return false;
	}
	
	function loadssl()
	{
		$.ajax({
			  type:'POST',
			  data:{
				ajaxHit:1
			  },
			  url: baseUrl+language+'/common/loadssl',
			  beforeSend: function( ) {
				  $("#SSLDiv").html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
			  },
			  success: function(data){	
				if('#loadImg'){
					$("#loadImg").remove();
				}
				$("#SSLDiv").html(data);
			  },
			  error: function (xhr, ajaxOptions, thrownError) {
				alert(thrownError);
			  }
		});
	}


/*
 * This function is used to upload Advert files 
 */	
function uploadAdvertFiles(fileUploadPath,fileTypes,fileMaxSize,uniId,isMultipleForm,isReloadPage,norefresh,imgload,checksection,imgext)
{ 
	if(typeof(uniId)  == undefined){uniId='';}
	if(typeof(isReloadPage)  == undefined || isNaN(isReloadPage)){isReloadPage=1;}
	if(typeof(norefresh)  == undefined || isNaN(norefresh)){norefresh=0;}
	
	
	var relocate = false;
	var fileSrc='';
	var files_remaining=1;
	var org_filepath=fileUploadPath;
	
	var saveButton='#uploadFileByJquery'+uniId; 
	var flash_url=baseUrl+"templates/system/javascript/jquery-upload/plupload.flash.swf"; 
	fileUploadPath = fileUploadPath.replace(/\//g, "+");
	fileTypes = fileTypes.replace(/\|/g, ",");
	var fileExtension = '';
	var uploadedFileName = '';
	var adverttype = $('#setAdvertType'+uniId).val();

	var URL = baseUrl+language+"/common/JqueryUploadAdvertFile/"+fileUploadPath+"/1";
	
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
					$('#fileError'+uniId).html(fileNotSupportedMasg);
					uploaderId.stop();
					uploaderId.refresh(); 
				}
			});
		});
		
		uploaderId.bind('BeforeUpload', function(up, file) {
			var uploadPath =  $('#fileUploadPath'+uniId).val();
			var uploadAdvertOrder =  $('#uploadAdvertOrder').val();
			if(uploadPath){
					fileUploadPath = uploadPath.replace(/\//g, "+");
					up.settings.url=baseUrl+language+"/common/JqueryUploadAdvertFile/"+fileUploadPath+'/'+uploadAdvertOrder;
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
				
				isReloadPage =1;
				$('#advertMediaForm').submit();
				
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
					if(createWaterMarkFlag && createWaterMarkFlag == 1){}
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
				$("#redirectUrl").attr("href",baseUrl+language+"/membershipcart/addspace/"+userContainerId);
				lightBoxWithAjax('popupBoxWp','popup_box','/package/notEnoughSpace/',userContainerId,'');
			}
			else if(err.code == "-100")
			{
				$('#fileInput'+uniId).val('');
				$('#fileError'+uniId).html(err.message);
				
			}
			else
			{
				$('#fileInput'+uniId).val('');
				$('#fileError'+uniId).html(fileErrorMasg+ err.file.name);
			}
			uploaderId.stop();
			uploaderId.refresh(); // Reposition Flash/Silverlight
			
		});
		
	}
	// Check File unit drp down 
   function checkUnit() {
		var fileHeight = $('#fileHeight').val();
		var fileWidth = $('#fileWidth').val();  
	
		if(fileHeight==0 || fileHeight=='') {
			 //alert('Dimension should not be zero or blank'); 
			 setSeletedValueOnDropDown('fileUnit','');
			 
		}	 
		
		if(fileWidth==0 || fileWidth=='') {
			//alert('Dimension should not be blank'); 
			setSeletedValueOnDropDown('fileUnit','');
		}   
   }
