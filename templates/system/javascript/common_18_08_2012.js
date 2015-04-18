/*---------------------------*/	
var isuploading=false;		
var fileMaxSize='';		
var fileTypes='';		
function customAlert(msg,obj){
		$("#customAlert .customeMessage").html(msg);
		$('#customAlert').lightbox_me({
					centered: true, 
					closeEsc:false,
					closeClick:false,
					appearEffect:"fadeIn"
				});
				obj.preventDefault();
		}						
/*---------------------------*/		

/*---------------------------*/		
//ajay//
function loader(Container){
	
	baseUrl1 = baseUrl+"templates/system/images/loading.gif";
	 
	var img_url = $("<div><img src='" + baseUrl1 + "' style=\"margin-left: auto; margin-right: auto;\" alt=\"Loading...\" title=\"Loading...\"/></div>");


     return img_url.appendTo('#'+Container);
	//return $('#'+Container).html(img_url);
	//var imgElement = img_url.find("img");
}
/*---------------------------*/	

/*---------------------------*/		
function openLightBox(BoxWp,Container,URL,val1,val2,val3){
	
	
	$('#'+Container).html('');
    $('#'+BoxWp).lightbox_me({
		centered: true, 
		closeEsc:false,
		closeClick:false,
		onLoad: function() {
		 
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
			  beforeSend: function( ) {
				$('#'+Container).html(loader(Container));
			  },
			  success: function(html){				  
				$('#'+Container).html(html);
			
				if(val1){
					if($('#email')){
						$('#email').val(val1);
					}
				}
			  }
			});
		}	
	});			
}
function openLightBoxWithoutAjax(BoxWp,Container){
	$('#'+Container).html('');
    $('#'+BoxWp).lightbox_me({
		centered: true, 
		closeEsc:false,
		closeClick:false,
		onLoad: function() {
			
		}	
	});			
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
    $('#'+BoxWp).lightbox_me({
		centered: true,
		closeEsc:false,
		closeClick:false,
		onLoad: function() {
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
				$('#'+Container).html(html);
			  }
			});
		}	
	});	
}
/*---------------------------*/		
function viewgallery(){
	$("#postGalleryBoxWp #postGalleryFormContainer").html('');
			   $('#postGalleryBoxWp').lightbox_me({
					centered: true, 
					closeEsc:false,
					closeClick:false,
					
					onLoad: function() {
						$.ajax({
						  type:'GET',
						  data:'ajaxHit=1',
						  url: baseUrl+language+"/"+"blog/viewGallery",
						  cache: false,
						  beforeSend: function( ) {
							
						  },
						  success: function(html){
							$("#postGalleryBoxWp #postGalleryFormContainer").html(html);
						  }
						});
					}	
				});			
}
/*---------------------------*/	

/*---------------------------*/		
function workreview(){
	$("#reviewBoxWp #reviewFormContainer").html('');
	   $('#reviewBoxWp').lightbox_me({
			centered: true, 
			closeEsc:false,
			closeClick:false,
			onLoad: function() {
				$.ajax({
				  type:'GET',
				  data:'ajaxHit=1',
				  url: baseUrl+language+"/"+"work/reviews",
				  cache: false,
				  beforeSend: function( ) {
				  },
				  success: function(html){
					$("#reviewBoxWp #reviewFormContainer").html(html);
				  }
				});
			}	
		});			
}
/*---------------------------*/	

/*---------------------------*/		
function addCompanyHistory(Id,EmpHistoryId,Action){
	$("#companyHistoryBoxWp #companyHistoryFormContainer").html('');
			   $('#companyHistoryBoxWp').lightbox_me({
					centered: true, 
					closeEsc:false,
					closeClick:false,
					onLoad: function() {
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
						  }
						});
					}	
				});			
}

function AJAX(url,DivID,val1,val2,val3,val4,val5,val6,val7,val8,val9,val10,append) {
	
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
			ajaxHit:1
		},
		beforeSend:function(){
			
			if(DivID != '' && (DivID =='catInfo'|| DivID =='educationInfo'|| DivID =='visaTypeInfo')){
			
				if(DivID != '' && val4!='loadImg'){
					$("#"+DivID).html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading.gif" />');
				}
			}
			else
			{
				if(DivID != ''){
					if(append){
						$("#"+DivID).prepend('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading.gif" />');
					}else{
						$("#"+DivID).html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading.gif" />');
					}
					
					
				}
			}
		},
		complete:function(){
			
		},
		success:function(HTML){
			
			
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
					if(append){
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
        error: function () {
            alert(someInternalProblem);
           
        }
	});
}
function AJAX_json(url,DivID,val1,val2,val3,val4,val5,val6,val7,val8) {
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
		success:function(data){
			res = data;
			//alert(DivID);
			if(res.crtId > 0){
				if(val1>0){
					var str ='<div class="cell pro_title">'+val2+'&nbsp;</div><div class="cell pro_name">'+val3+'&nbsp;</div><div class="cell pro_name">'+val4+'&nbsp;</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteAssociative(this)" EEID="'+val7+'" crtId="'+val1+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editAssociative(this)" EEID="'+val7+'" crtId="'+val1+'" crtDesignation="'+val2+'" crtName="'+val3+'" crtEmail="'+val4+'"><div class="cat_smll_edit_icon"></div></a></div></div>';
					$("#"+DivID).html(str);
				}else{
					var str ='<li id="row'+res.crtId+'"><div id="rowData'+res.crtId+'" class="pro_li_content_wp"><div class="cell pro_title">'+val2+'&nbsp;</div><div class="cell pro_name">'+val3+'&nbsp;</div><div class="cell pro_name">'+val4+'&nbsp;</div><div class="pro_btns"><div class="small_btn"><a href="javascript:void(0)" onclick="deleteAssociative(this)" EEID="'+val7+'" crtId="'+res.crtId+'" ><div class="cat_smll_plus_icon"></div></a></div><div class="small_btn"><a javascript:void(0)" onclick="editAssociative(this)" EEID="'+val7+'" crtId="'+res.crtId+'" crtDesignation="'+val2+'" crtName="'+val3+'" crtEmail="'+val4+'"><div class="cat_smll_edit_icon"></div></a></div></div></div></li>';
					$("#"+DivID).prepend(str);
				}
			}
			if(res.SpId > 0){
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
        error: function () {
            alert(someInternalProblem);
        }
	});
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

function deleteTabelRow(tbl,field,id,divId,checkbox,removeRow,fileId,filePath,isLogSummery,deleteCache,reloadPage){
	if(!deleteCache){
		deleteCache='';
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
	var url =baseUrl+language+'/common/deleteTabelRow';
	var ID = new Array();
	if(id>0){
		ID[0] = id;
	}else{
		ID = checkCheckbox(checkbox);
	}
	if(ID){
		if(confirm(areYouSure)){
			AJAX(url,divId,ID,tbl,field,fileId,filePath,isLogSummery,deleteCache);
				$.each(ID, function(key, value) { 
				  $(removeRow+value).remove();
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
		
	}else{
		alert(atleastSelect);
	}
}

function changeStatus(url,divId,tbl,conditionField,conditionvalue,field,value){
	AJAX(url,divId,tbl,conditionField,conditionvalue,field,value);
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

function getIndustryList(divId1,val1,val2,val3){
	  //alert(divId1+'='+val1+'-'+val2+'-'+val3);
		var url = baseUrl+language+'/common/getIndustryList'		
		AJAX(url,divId1,val1,val2);
		//setSeletedValueOnDropDown('IndustryList','');
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
			$("#successMsg").html('<img  class="ma" align="absmiddle"src="'+baseUrl+'images/loading.gif" />');
		},
		complete:function(){
			
		},
		success:function(data){
			$("#successMsg").html('');
			$("#usernameMsg").html('');
			$("#emailMsg").html('');
			if(data.success){
				$("#successMsg").html(data.success);
				$("#dataStorage").html('');
			}
			else{
				if(data.errors.username){
					$("#usernameMsg").html(data.errors.username);
				}
				if(data.errors.email){
					$("#emailMsg").html(data.errors.email);
				}
			}
		},
        error: function () {
			$("#successMsg").html('');
            alert(someInternalProblem);
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
				$("#successMsg").html('<img  class="ma" align="absmiddle"src="'+baseUrl+'images/loading.gif" />');
			},
			complete:function(){
				
			},
			success:function(data){
				$("#successMsg").html('');
				if(data.emaiExist){
					openLightBox('loginLightBoxWp','loginFormContainer','/auth/emailAlreadyExist',email);
				}
				else{
					openLightBox('loginLightBoxWp','loginFormContainer','/auth/register',email);
				}
			},
			error: function () {
				$("#successMsg").html('');
				alert(someInternalProblem);
			}
		});
	}else{
		openLightBox('loginLightBoxWp','loginFormContainer','/auth/register',email);
	
	}

}

function doLogin(url,login,password,remember,captcha) {
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
			$("#successMsg").html('<img  class="ma" align="absmiddle"src="'+baseUrl+'images/loading.gif" />');
		},
		complete:function(){
			
		},
		success:function(data){
			$("#successMsg").html('');
			$("#passwordMsg").html('');
			$("#emailMsg").html('');
			$("#captchaMsg").html('');
			if(data.success){
				if(data.last_visit==false){
					openLightBox('loginLightBoxWp','loginFormContainer','/auth/selectPage',data.email);
				}else{
					window.location.href=baseUrl+language+'/dashboard/';
				}
			}
			else{
				if(data.errors.password){
					$("#passwordMsg").html(data.errors.password);
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
        error: function () {
			$("#successMsg").html('');
            alert(someInternalProblem);
        }
	});
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
			$("#successMsg").html('<img  class="ma" align="absmiddle"src="'+baseUrl+'images/loading.gif" />');
		},
		complete:function(){
			
		},
		success:function(data){
			$("#successMsg").html('');
			$("#emailMsg").html('');
			if(data.success){
				$("#successMsg").html(data.success);
				$("#dataStorage").html('');
			}
			else{
				if(data.errors.login){
					$("#emailMsg").html(data.errors.login);
				}
			}
		},
        error: function () {
			$("#successMsg").html('');
            alert(someInternalProblem);
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
		$('#'+id4).attr('class','black');
	}
	
	if(id5){
		$('#'+id5).val(value);
	}
}

function changeUploadMediyaFormValue(data)
{ 	
	fileMaxSize=$('#availableRemainingSpace').val();
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
	
	if($('#wordCount') && data.wordCount){
		$('#wordCount').val(data.wordCount);
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
	if($('#wordCount') && data.wordCount)
		$('#wordCount').val(data.wordCount);
	
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
		$('#uploadNewsReviewsSection').show();
		$('#writeButton').show();
		$('#writeArticle').show();
			
		if(data.isWrittenFileExternal==2){
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
	if($('#fileType') && (data.fileType))
		$('#fileType').val(data.fileType);
	if($('#fileInput'))
		$('#fileInput').val('');
	
	if(data.rawFileName !=null && data.rawFileName.length>4){
		
		if($('#rawFileName'))
			$('#rawFileName').val(data.rawFileName);
		
		if($('#rawFileNameContainerDiv'))
			$('#rawFileNameContainerDiv').show()
		
		if($('#rawFileNameDiv'))
			$('#rawFileNameDiv').html(data.rawFileName);setSeletedValueOnDropDown
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
	
	if($('#embbededURL'))
		$('#embbededURL').val(data.embbededURL);
	if($('#fileLength'))
		$('#fileLength').val(data.fileLength);
	
	if($('#downloadPrice')){
		$('#downloadPrice').val(data.downloadPrice);
		$('#isDownloadPrice').attr('price',data.downloadPrice);
		if(data.isDownloadPrice=='t'){
			
			$('#downloadPrice').attr("class",'price_input number required');
			$('#isDownloadPrice').attr("checked", true);
			$('#downloadPrice').attr("min",0.1);
			$('#downloadPrice').removeAttr("readonly");
		}else{
			$('#downloadPrice').attr("class",'price_input_disable number');
			$('#isDownloadPrice').attr("checked", false);
			$('#downloadPrice').attr("readonly",true);
			$('#downloadPrice').removeAttr("min");
		}
	}
	if($('#perViewPrice')){
		$('#perViewPrice').val(data.perViewPrice);
		$('#isPerViewPrice').attr('price',data.perViewPrice);
		if(data.isPerViewPrice=='t'){
			
			$('#perViewPrice').attr("class",'price_input number required');
			$('#isPerViewPrice').attr("checked", true);
			$('#downloadPrice').attr("min",0.1);
			$('#downloadPrice').removeAttr("readonly");
		}else{
			
			$('#perViewPrice').attr("class",'price_input_disable number');
			$('#isPerViewPrice').attr("checked", false);
			$('#perViewPrice').attr("readonly",true);
			$('#perViewPrice').removeAttr("min");
		}
	}
	if($('#price')){
		$('#price').val(data.price);
		$('#isPrice').attr('price',data.price);
		if(data.isPrice=='t'){
			
			$('#price').attr("class",'price_input number required');
			$('#isPrice').attr("checked", true);
			$('#price').attr("min",0.1);
			$('#price').removeAttr("readonly");
		}else{
			$('#price').attr("class",'price_input_disable number required');
			$('#isPrice').attr("checked", false);
			$('#price').attr("readonly",true);
			$('#price').removeAttr("min");
		}
	}
	
	if($('#elementId')){
		$('#elementId').val(data.elementId);
		
		if(data.elementId > 0){
			
			$('#fileInput').attr('class','width480px ');
		}else{
			$('#fileInput').attr('class','width480px required');
		}
		
	}
	if($('#mediaTypeId'))
		$('#mediaTypeId').val(data.mediaTypeId);
	if($('#fileId'))
		$('#fileId').val(data.fileId);
	if($('#isDefaultElement') && data.isDefaultElement)
		$('#isDefaultElement').val(data.isDefaultElement);
	runTimeCheckBox();
}

function setSeletedValueOnDropDown(selectBoxid, value){
		$("#"+selectBoxid).selectBoxJquery('value', value);
}

function hideDiv(){
	if($('.successMsg')){
		$('.successMsg').remove();
	}
	if($('.errorMsg')){
		$('.errorMsg').remove();
	}
}

/*---------------------------*/	



$(document).ready(function() {
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
			
	})*/
	
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
				AJAX(url,'',ID);
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
		
		if(toggleDivVisible == true){
			$('#'+toggleDivForm).slideToggle("slow");
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


//dynamically render page-height, select-input, checkbox-input and raido input
	function renderMaxHeight(){
	/* for the left and right, sub leff and sub right */	

		sub_col_1 = $('.sub_col_1').height();
		sub_col_2 = $('.sub_col_2').height();
		left_coloumn = $('.left_coloumn').height();
		right_coloumn = $('.right_coloumn ').height();
		
		var array = [sub_col_2, left_coloumn, right_coloumn];
		var largest = Math.max.apply(Math, array);
		
		//alert(sub_col_1+', '+sub_col_2+', '+left_coloumn+', '+right_coloumn+', '+largest);	
		if(sub_col_1!='null')
		$('.sub_col_1').css('min-height',left_coloumn);
		
		if(sub_col_2!='null')
		$('.sub_col_2').css('min-height',left_coloumn);	

		$('.right_coloumn').css('min-height',left_coloumn);
		
		//$(".right_coloumn").equalHeights();
		
	/* for the left and right, sub leff and sub right */	
	}

	function selectBox(){
		$("SELECT").selectBoxJquery();
		/*$("select").multiselect({multiple: false,header: false,	noneSelectedText: "Select an Option",selectedList: 1,minWidth:263,height:147});					   
		$('.tds_ui-multiselect-checkboxes').each(function(){
			size=$(this).children('li').length;				
			if(parseInt(size)<5)
			$(this).addClass('heightAuto');
			dd_width = $('.tds_ui-multiselect-menu').width();
			minus_width = dd_width-1;
			$('.tds_ui-multiselect-menu').width(minus_width);
		}); */
	}

	function runTimeCheckBox(){
		$('.defaultP input').ezMark();
		$('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'})	
	}
//dynamically render page-height, select-input, checkbox-input and raido input


// buttons proptirty in event like mouseup, mousedown mouseover and mouseout
	
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
		obj.firstChild.style.backgroundPosition ='right -76px';
	}
	function mouseup_tds_button(obj){
		obj.style.backgroundPosition ='0px -38px';
		obj.firstChild.style.backgroundPosition ='right -38px';
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
// buttons proptirty in event like mouseup, mousedown mouseover and mouseout


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
			  if(attributeValue != null && attributeValue != "" && attributeValue != "undefined"){
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

	function hideRelationDiv(showDivId)
	{
		$('#'+showDivId).slideToggle("slow");
		
	}

	function hideAllRelationDiv()
	{
		$(".shareLinkEmail").hide();
		$(".getshortlinkPage").hide();
		
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
		$('#addEditIcon'+EEID).attr('class','cat_edit_icon');
		$('#cancelIcon'+EEID).show();
	}

	function cancelIcon(obj){
		var EEID = $(obj).attr('EEID');
		$('#crtId'+EEID).val(0);
		$('#crtDesignation'+EEID).val('');
		$('#crtName'+EEID).val('');
		$('#crtEmail'+EEID).val('');
		$('#addEditIcon'+EEID).attr('class','cat_plus_icon');
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
	
// Shipping Charges Section
	function editShippingCharges(obj){
		var EEID = $(obj).attr('EEID');
		var SpId = $(obj).attr('SpId');
		var SpCountry = $(obj).attr('SpCountry');
		var SpAmount = $(obj).attr('SpAmount');
		$('#SpId'+EEID).val(SpId);
		$('#SpCountry'+EEID).val(SpCountry);
		$('#SpAmount'+EEID).val(SpAmount);
		$('#addEditIcon'+EEID).attr('class','cat_edit_icon');
		$('#cancelIcon'+EEID).show();
		selectBox();
	}

	function cancelIconShipping(obj){
		var EEID = $(obj).attr('EEID');
		$('#SpId'+EEID).val(0);
		$('#SpCountry'+EEID).val('');
		$('#SpAmount'+EEID).val('');
		$('#addEditIcon'+EEID).attr('class','cat_plus_icon');
		selectBox();
		$(obj).hide();
	}

	function deleteShippingCharges(obj){
		var SpId = $(obj).attr('SpId');
		var EEID = $(obj).attr('EEID');
		deleteTabelRow('ProjectShipping','SpId',SpId,'');
		var lenth = $(".liData"+EEID).length;
		if(lenth < 1){
			$('#noRecord'+EEID).show();
		}
	}

	function publishUnpulish(obj,tbl,pulishField,field,fieldValue,currentStatus,changeStatus,isFARF,deleteCache){
		if(isFARF==0){
				alert(notPublishMsg);
		}else{
			if(!deleteCache){
				deleteCache='';
			}
			/*var classCurrent = $(obj).attr('class');
			if(classCurrent=='btn_yes'){
				var classChange='btn_no';
				var htmlChange='Unpublish';
				
			}else{
				var classChange='btn_yes';
				var htmlChange='Publish';
			}*/
			
			var msg=''
			var htmlCurrent = $(obj).html();
			
			if(htmlCurrent == currentStatus){
				htmlChange = changeStatus;
			}else{
				htmlChange = currentStatus;
			}
			
			if(htmlChange==publish){
				msg = publishMsg;
			}else{
				msg = hideMsg;
			}
			
			if(confirm(msg)){
				var url = baseUrl+language+'/common/publishUnpulish/'
				AJAX(url,'',tbl,pulishField,field,fieldValue,deleteCache);
				//$(obj).attr('class',classChange);
				$(obj).html(htmlChange);
			}
		}
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

/* Upload heavy files Added by gurutva July 16 2012 */
		function uploadMediaFiles(fileUploadPath,allowFileTypes,fileMaxSize,uniId,isMultipleForm,isReloadPage)
		{ 
			//alert(allowFileTypes);
			if(!isNaN(fileMaxSize)){
				var fileSizeMsg = fileSizeErrorMasg+((fileMaxSize/1048576).toFixed(2))+' MB';
			}else{
				var fileSizeMsg = fileSizeErrorMasg+fileMaxSize;
			}
			window.onbeforeunload = function() {
			  if(isuploading){
				  return leavePageMasg;
			  }
			}
			if(isMultipleForm==1){
				var saveButton='#uploadFileByJquery'+uniId; 
			}else{
				var saveButton='#uploadFileByJquery'; 
			}
			
			
			//alert(saveButton); saveButtonPPV
			
			fileUploadPath = fileUploadPath.replace(/\//g, "+");
			fileTypes = allowFileTypes.replace(/\|/g, ",");
			  
			
			  
			  //alert(fileUploadPath);
			// alert(fileUploadPath+'::'+fileTypes+'::'+saveButton);
			
			 var uploaderId= new plupload.Uploader({                    
                    //runtimes: 'html5,flash,gears,browserplus,silverlight,html4',  
                    runtimes: 'html5,flash,gears,browserplus,silverlight,html4',  
                    url:baseUrl+language+"/common/JqueryUploadMediaFile/"+fileUploadPath,
                    browse_button : "browsebtn"+uniId,
                    button_browse_hover : true,
                    drop_element : "dropArea"+uniId,
                    autostart : true,
                    max_file_size: fileMaxSize,
                    container: "FileContainer"+uniId,
                    chunk_size: '1mb',
                    unique_names: true                   
                });                

				/*var fileTypes = 'all';*/
                //var fileTypesFilter = 'allow';
				var fileTypesFilter = 'notallow';
                var $body = $("body");
                var $dropArea = $("#dropArea"+uniId);

                uploaderId.init();
                uploaderId.bind('FilesAdded', function(up, files) {
						
						$dropArea.removeClass();
						$.each(files, function(i, file) {
							 
							//Checks a comma delimted list for allowable file types set file types to allow for all
							var fileExtension = file.name.substring(file.name.lastIndexOf(".")+1, file.name.length).toLowerCase();
							//alert(fileExtension);
							var supportedExtensions = fileTypes.split(",");
							//alert(supportedExtensions);
							var supportedFileExtension = ($.inArray(fileExtension, supportedExtensions) >= 0);
							//alert(supportedFileExtension);
							if(fileTypesFilter == "allow")
							{
								supportedFileExtension = !supportedFileExtension
							}

							if((fileTypes == "all") || supportedFileExtension)
							{
								//$('#fileError'+uniId).removeClass('error');
								$('#fileError'+uniId).html('');
								var filename = file.name;
								/*if(filename.length > 25){
									filename = filename.substring(0,25)+"...";       
								}*/
							
							//Add div block for each file uploaded
							//alert(file.toSource());
							
					  //Added by vikas 14 aug 2012
					  var fileSrc=baseUrl+"/"+fileUploadPath+file.id;
					  //$("#galImg_253").attr("src",fileSrc);
						//alert($("#galImg_253").attr("src"));
					  
							if('#fileName'+uniId)
								$('#fileName'+uniId).val(file.id+'.'+fileExtension);
							if('#fileInput'+uniId)
								$('#fileInput'+uniId).val(filename);
							if('#FileField'+uniId)
								$('#FileField'+uniId).val(filename);
							if('#fileSize'+uniId){
								//$('#fileSize'+uniId).val(plupload.formatSize(file.size));
								$('#fileSize'+uniId).val(file.size);
							}
							
							
							//Fire Upload Event
							up.refresh(); // Reposition Flash/Silverlight
							//Bind cancel click event
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
								
								if(($('#Uploadvideo'+uniId).is(":visible")) && (errorlength==0) && (inputFileExtension!='' && filename==inputFilename))
								{	
									uploaderId.start();
									if(isReloadPage==1){
										openLightBoxWithoutAjax('contactBoxWp','contactContainer'); 
									}							
								}					
							});
							
						}
						else
						{
							$('#fileInput'+uniId).val('');
							$('#fileError'+uniId).html(fileNotSupportedMasg);
							uploaderId.stop();
							uploaderId.refresh(); 
						}
                    });
                });

                uploaderId.bind('UploadProgress', function(up, file) {
					isuploading=true;
					$("#progressBar"+uniId).show();
					$("#plupload_progress_bar"+uniId).attr("style", "width:"+ file.percent + "%");
					$("#percentComplete"+uniId).html(file.percent+"%");
					
					if(file.percent == 100){
						 isuploading=false;
						 $('#progressBar'+uniId).hide() ;
						 $('#percentComplete'+uniId).html('') ;
						 
						 if(isReloadPage==1){
							$('#contactContainer').parent().trigger('close');
							timeout = setTimeout(refreshPge, 500);
						}
						
					}
                });

               uploaderId.bind('Error', function(up, err) {
					
					$errorPanel = $("div.error:first");
					//-600 means the file is larger than the max allowable file size on the uploader thats set in the options above.
					if(err.code == "-600")
					{
						$('#fileInput'+uniId).val('');
						$('#fileError'+uniId).html(fileSizeMsg);
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
	
	function refreshPge()
	{ 
		window.location.href=window.location.href;
	}
	
	function copyStr (id,str)
	{ 
		$(id).zclip({
			path:baseUrl+'swf/zeroClipboard.swf',
			copy:str
		});
	}
	
	
	//Added by vikas on 13 aug 2012
	
	/*function deleteTabelRowMedia(tbl,field,id,divId,checkbox,removeRow,fileId,filePath,isLogSummery,deleteCache,isMain,promoFieldId,tableName,promoFieldVal){
	
	
	if(!deleteCache){
		deleteCache='';
	}
	
	var isMain = $('#imgIsMain'+fileId).val();
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
		
			AJAX(url,divId,ID,tbl,field,fileId,filePath,isLogSummery,deleteCache,isMain,promoFieldId,tableName,promoFieldVal);
				$.each(ID, function(key, value) { 
				  $(removeRow+value).remove();
				  
				});
				
				if($('#uploadElementForm')){
					if($('#uploadElementForm').is(":visible")){
						$("#uploadElementForm").slideToggle('slow');
					}
				}
				
			
		}
		
	}else{
		alert(atleastSelect);
	}
}
 */
 
 
 	//Added by vikas on 13 aug 2012
	
	function deleteTabelRowMedia(mediaData){



	var tbl=mediaData.tableName;
	var field=mediaData.elementFieldId;
	var id=mediaData.mediaId;
	var divId=mediaData.divId;
	var checkbox=mediaData.checkbox;
	var removeRow='#imgRow';
	var fileId=mediaData.fileId;
	var isLogSummery=mediaData.isLogSummery;
	var deleteCache=mediaData.deleteCache;
	var promoFieldId=mediaData.fieldName;
	var tableName=mediaData.tableName;
	var promoFieldVal=mediaData.fieldValue;
	var filePath=mediaData.filePathImage;
	
	
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
		
			AJAX(url,divId,ID,tbl,field,fileId,filePath,isLogSummery,deleteCache,isMain,promoFieldId,tableName,promoFieldVal);
				$.each(ID, function(key, value) { 
					
				  $(removeRow+fileId).remove();
				  
				});
				
				if($('#uploadElementForm')){
					if($('#uploadElementForm').is(":visible")){
						$("#uploadElementForm").slideToggle('slow');
					}
				}
				
			
		}
		
	}else{
		alert(atleastSelect);
	}
}
