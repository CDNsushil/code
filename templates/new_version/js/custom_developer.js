    /**
    * @Description: run time checkbox create
    */
    
    function radioCheckboxRender(){
          //jquery checkbox 
          $('.defaultP input').ezMark();
          $('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'});
          $("SELECT").selectBox();  
    }
    
    /**
     * @Description: run time checkbox create
     */ 
    
    function runTimeCheckBox(){
        radioCheckboxRender();
    }
  
  
  /**
   * @Description: all new version js written in the file 
   * @auther: lokendra meena
   * @email: lokendrameeena@cdnsol.com
   * @created date: 8-aug-2014
   */ 

  $(document).ready(function() {

        //------------------------------------------------------------------------
        
        /**
         * @Description: All default required function load in this section
         */ 
          
        radioCheckboxRender();
        
        //-----------------------------------------------------------------------
        
        /**
         * @Description: This function is used to package selection 
         */ 
        
        $(".selectPackage").click(function(){
          var selectedPacakge = $(this).attr('id');
          $("#selectedPacakge").val(selectedPacakge)
        });
        
        //---------------------------------------------------------------------------------
        
        /**
         * @Description: This function is used to for term & condition showing
         */ 
        
        $(".content_3").mCustomScrollbar({
          scrollInertia:600,
          autoDraggerLength:false,
          callbacks:{
            whileScrolling:function(){
            var top_drag = $('.mCSB_dragger').position();
              if(top_drag.top >='285') {
                $('#termCondition').removeAttr('disabled');
                $('#termCondition').parent().css({ opacity: 1.5 });
				$('#termCondition').parent().css({ display: 'block' });
				$('#termBoxImg').hide();
              }
            }
          }
        });
        
        //--------------------------------------------------------------------------------
        
        /**
         * @Description: This function is used to term checkbox checked message hide 
         */ 
        
        $('#termCondition').click(function(){
          if($(this).is(":checked")){
            $('#term_error').hide();
            $('#termTopMsg').removeClass('termsTopTxtError');
          }else{
            $('#term_error').show();
          }
        });
        
        
        //---------------------------------------------------------------------------------
        
        /**
         * @Description: This function is used to checkbox disabled 
         */ 
        
        $('.chkDisabled').each(function(){
          $(this).parent().css('opacity','0.5');
          $(this).parent().css('display','none');
        })
        
        //---------------------------------------------------------------------------------
        
        /**
         * @Description: This function is use to price for annual and 3 year div 
         */ 
        
        $('.price_div').mouseover(function () {
            $(this).find('.up_list').css('opacity','1');
            $(this).find('.up_list').css('height','162px');
            $(this).find('.up_list').css('display','block');
        });  
        
        $('.price_div').mouseout(function () {
          $(this).find('.up_list').css('opacity','0');
          $(this).find('.up_list').css('height','0x');
          $(this).find('.up_list').css('display','none');
        });  
          
       //-----------------------------------------------------------------------
       
        $('.countriesList').change(function () {
             var countryid = $(this).val();
            //post url 
            url = "/common/getCountryStateList";//stage four first post url 
            $.ajax({
              type: 'POST',
              url: baseUrl + language + url,
              dataType: 'html',
              data: {
                val1: countryid,
                val2: 'stateList',
                val3: 'main_SELECT selectBox bg_f6f6f6 required',
                ajaxHit: 1
              },
              beforeSend: function() {
                //loader();
              },
              complete: function() {
              
              },
              success: function(data) {
                //$(".new_verion_loader").loaderHide();
                $('.stateListDiv').html(data);
              },
              error: function(xhr, ajaxOptions, thrownError) {
                $("#successMsg").html('');
                alert(thrownError);
              }
            });
            return false;
             
        });   
        
        //-----------------------cancel action--------------------------------
        
        $('.cancelaction').click(function(){
            var redirectUrl  =  $(this).attr('href');
            var searchStatus =  redirectUrl.search("javascript");
           
            // if not javascript void exit then redirect 
            if(searchStatus == -1){
                confirmBox("Do you really want cancel this process?", function () {
                    window.location = redirectUrl; // redirect on href page
                });
            }
            return false;
        });
        
        
          // History Back Function
        $('.backCall').click(function(){
       window.history.back();
        });
  
        
        
        //----------------------datepicker calendar--------------------------------
        
        $( ".calendar_picker" ).datepicker({ dateFormat: "d MM yy" });
        
        
        //---------preview mode message for invite -------//
        $('.previewmode').click(function(){
             customAlert('You cannot share in preview mode.');
        });
        
		//--------------------------------------------------------------------
		/**
		 * @Description: Manage portfolio description toggle
		 */
		var downbtn = $("#discrip.dactive");
		downbtn = $(".flex-direction-nav a");
	
		$("#discrip.active").click(function () {
			$(".flex-active-slide .discrip_content").slideDown();
			$(this).removeClass("display_block");
			$(this).next().addClass("display_block");
		});
			  
		$("#discrip.dactive").click(function () {
			$(".flex-active-slide .discrip_content").slideUp();
			$(this).removeClass("display_block");
			$(this).prev().addClass("display_block");
		});

    });
    
    
  
  
   //------------------------------------------------------------------------

    /**
    * @Description: This function is used to package stage 1 switch
    * @param: formId (string)
    * @param: post url (string)
    * @param: term& condition (boolean)
    * @return false
    */ 
    
    function packageStageSwitch(formId,postUrl,isTermCondition){
      $("#"+formId).submit(function(){
        
        isTermCondition = (isTermCondition==undefined)?false:true;
         
        //for action term & condition 
        if(isTermCondition==true){
          var  tremReadStatus  =   $(this).find('#termCondition').attr('disabled');
       
          if(tremReadStatus=="disabled"){
            $('#term_error').show();
            return false;
          }
         
          var  tremChckStatus  =   $(this).find('#termCondition').is(':checked');
          if(!tremChckStatus){
            $('#term_error').show();
            return false;
          }
        }
        
        var formData	 	 = $(this).serialize();
        //post url 
        url = postUrl;//stage first post url 
        $.ajax({
          type: 'POST',
          url: baseUrl + language + url,
          dataType: 'json',
          data: formData,
          beforeSend: function() {
            loader();
          },
          complete: function() {

          },
          success: function(data) {
            redirectToPage(data.redirecturl);
          },  
          error: function(xhr, ajaxOptions, thrownError) {
            $("#successMsg").html('');
            alert(thrownError);
          }
        });
        return false;
      });
    }

  //---------------------------------------------------------------------
   
  /**
   * @Description: This function is used to redirect to page dealy one second
   */ 
  
  function redirectDealy(pageUrl){
    setTimeout(function () {
      window.location = baseUrl+language+pageUrl;
    }, 1000); 
  }
     
  //---------------------------------------------------------------------
   
  /**
   * @Description: This function is used to redirect to page dealy one second
   */ 
  
  function redirectToPage(pageUrl){
    window.location = baseUrl+language+pageUrl;
  }

  //-------------------------------------------------------------------------------------

  /**
   * @Description: This function is used to do registration of user 
   */ 

  function doRegister(url,email,password,confirm_password,firstName,lastName,enterpriseName,countryId,cityName,selectedPacakge) {
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
        enterpriseName:enterpriseName,
        countryId:countryId,
        cityName:cityName,
        ajaxHit:1
      },
      beforeSend:function(){
        loader();
      },
      complete:function(){
        
      },
      success:function(data){
        $(".new_verion_loader").loaderHide();
        $("#emailAvailMsg").html('');
        if(data.success){

          if(selectedPacakge=="1"){
            redirectToPage('/package/freejoined');
          }else{
            redirectToPage('/package/membershipselected');
          }
        }
        else{
          if(data.errors.username){
            $("#emailAvailMsg").html(data.errors.username);
          }
          if(data.errors.email){
            $("#emailAvailMsg").html(data.errors.email);
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
  
  function hideShow(obj,showDiv,HideDiv,effect, menu,highlightClass)
  { 
    if(effect == undefined){
      effect = '';
    }
    if(showDiv == undefined){
      showDiv = '';
    }
    
    
    if(menu != undefined && highlightClass != undefined){
      $(menu).each(function(index){
        if(this.id != obj.id){
            $(this).removeClass(highlightClass)
        }else{
          if($(this).hasClass(highlightClass) == false){
            $(this).addClass(highlightClass)
          }
        }
      });
    }
    
    if(HideDiv != undefined){
      $(HideDiv).each(function(index){
        if('#'+this.id != showDiv){
          $('#'+this.id).hide();
        }
      });
    }
    if(showDiv != undefined){
      $(showDiv).show();
    }
  }
  
  function ajaxSave(url,DivID,val1,val2,val3,val4) {
  
    
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
        ajaxHit:1
      },		
      beforeSend:function(){
        if(DivID != ''){
            $(DivID).html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
          }
      },
      complete:function(){
        
      },
      success:function(response){
        
        
        returnFlag= true;
        
        if('#loadImg'){
          $("#loadImg").remove();
        }
        if(DivID != '')
        {
          $(DivID).html(response);
        }
        else
        {
          res = response;
          return res;
        }
      },
      async:false,
        error: function (xhr, ajaxOptions, thrownError) {
        alert(thrownError);
      }
    });
    return returnFlag;
  }


  function ajaxJson(url,DivID,val1,val2,val3,val4) {
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
        ajaxHit:1
      },
      beforeSend:function(){
      
      },
      complete:function(){
        
      },
      success:function(res){
        returnFlag= res;
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

	//-------------------------------------------------------------------------------------

   /**
	* @Description: get state list
	*/ 
	function getStateList(divId,val1,val2,val3,val4){
			var url = baseUrl+language+'/common/getStateList'		
			if(ajaxSave(url,divId,val1,val2,val3,val4)){
				$('SELECT').selectBox(); 
			}
	}
	
   //-------------------------------------------------------------------------------------

   /**
	* @Description: set option value as selected
	*/ 
	function setSeletedValueOnDropDown(selectBoxid, value){
			if(!(selectBoxid.indexOf("#") >= 0)){
				selectBoxid="#"+selectBoxid;
			}
			$(selectBoxid).selectBoxJquery('value', value);
	}
	
   //-------------------------------------------------------------------------------------

   /**
	* @Description: manage checkbo check uncheck events
	*/ 
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
	
	//-------------------------------------------------------------------------------------

   /**
	* @Description: manage checkbo check uncheck events
	*/ 
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
	
	//-------------------------------------------------------------------------------------

   /**
	* @Description: prepare user listing for emails
	*/ 
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
	
	//-------------------------------------------------------------------------------------

   /**
	* @Description: manage ajax 
	*/
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
	}

	function slideMenu(slider){
		 $(slider).slideToggle();
		 $(this).toggleClass("arrow_up");
	 }
     
     
    //add method for validate speical charater
    $.validator.addMethod("specialChar", function(value, element) {
        return this.optional(element) || /^[a-z0-9\-]+$/i.test(value);
    }, "Username must contain only letters, numbers, or dashes."); 
    
    
    function postFormGetHTML(formId,divID){
           var fromData=$(formId).serialize(); 
           var action=$(formId).attr('action'); 
           
           $.ajax({
              type: 'POST',
              url : action,
              dataType :'html',
              data : fromData,		
              beforeSend:function(){
                if(divID != undefined && divID != ''){
                    $(divID).html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
                }
              },
              success:function(data){
                if(data){
                    if(divID != undefined && divID != ''){
                        $(divID).html(data);
                    }
                }
              },
              async:false,
                error: function (xhr, ajaxOptions, thrownError) {
                alert(thrownError);
              }
            });
	}
    
    function postFormGetJSON(formId,divID){
       var fromData=$(formId).serialize(); 
       var action=$(formId).attr('action'); 
       var returnFlag = false;
       $.ajax({
          type: 'POST',
          url : action,
          dataType :'json',
          data : fromData,		
          beforeSend:function(){
            if(divID != undefined && divID != ''){
                $(divID).html('<img  class="ma ajax_loader" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
            }
          },
          success:function(res){
            returnFlag= res;
          },
          async:false,
            error: function (xhr, ajaxOptions, thrownError) {
            alert(thrownError);
          }
        });
        return returnFlag;
	}
    
    function postFormGetLightBox(formId){
        var fromData=$(formId).serialize(); 
        var action=$(formId).attr('action'); 
        $.ajax({
              type:'POST',
              data:fromData,
              url: action,
              cache: false,
              beforeSend: function( ) {
                  $('#popup_box').html(loader('popup_box'));
              },
              success: function(html){	
                $('#popup_box').show();
                $('#popup_box').html(html);
                $('#popupBoxWp').lightbox_me({
                    centered: true,
                    closeEsc:false,
                    closeClick:false,
                    onLoad: function(){}	
                });		
                $(this).parent;
              }
        });
    }
    
    function deleteRecord(tbl,field,id,divId){
        var ID = new Array();
        ID[0] = id;
        var url = baseUrl+language+'/common/deleteRecord';
        if(confirm(areYouSure)){
            var returnFlag=ajaxSave(url,divId,ID,tbl,field);
            if(returnFlag && divId != undefined){
                $(divId).remove();
            }
        }
    }
    
    
    //----------------------------------------------------------------------
    /**
     * @Description: Show comming soon message by comming_soon
     */ 
    
    $(document).ready(function(){
        $('.comming_soon').click(function(){
            customAlert('Comming Soon....','Message');
        });
    });
    
    //---------------------------------------------------------------------
    
    /**
     * @Description: This method is for anchor link disabled 
     */ 
    
    $(function () {
        $('.disable').on("click", function (e) {
            e.preventDefault();
        });
    });

    //--------------------------------------------------------------------
    /**
     * @Description: This method is use for selectBox popup
     */ 
    function  selectBox(){
        $("SELECT").selectBox();  
    }

    function toggleDivArrow(showDivId,obj)
	{
		$('#'+showDivId).slideToggle("slow");
        $(obj).toggleClass("arrow_up");
	}
	
	 //--------------------------------------------------------------------
    /**
     * @Description: This method is use manage url
     */ 
	function gotourl(thisUrl,addsiteurl) {
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
	
	 //--------------------------------------------------------------------
    /**
     * @Description: This method is use move data from archive status
     */ 
     
	function moveFromArchive(divId,tbl,primeryField,primeryVal,archiveField,returnUrl,deleteCache,elementTable,elementField,elementArchiveField){
		if(!deleteCache){deleteCache='';}
		if(!elementTable){elementTable='';}
		if(!elementField){elementField='';}
		if(!elementArchiveField){elementArchiveField='';}
		if(tbl && primeryField && primeryVal && archiveField){
			confirmBox(areYouSureMoveFromArchive, function () {
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
			});
		}else{
			alert('please check parameters');
		}
	}
	
	 //--------------------------------------------------------------------
    /**
     * @Description: This method is use to show message text in popup box
     */ 
     function messageBox(text) {
    
		var msgHtml = '<div class="poup_bx width329 shadow fshel_midum">';
		msgHtml += '<div class="close_btn position_absolute "  onclick="$(this).parent().trigger(\'close\');"></div>';
		msgHtml += '<P class="text_alighC lineH20 mt20 fs18 red" > '+text+'</P>';
		msgHtml += '<div class="fr mb10">';
		msgHtml += '<button type="button" class="bdr_bbb confirmyes" onClick="$(this).parent().trigger(\'close\');">Close</button>';
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
	}
	
		  
