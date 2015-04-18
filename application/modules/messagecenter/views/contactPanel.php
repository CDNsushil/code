<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row content_wrap" >
   
   <?php 
        //-----load common header of tmail-----//
        $dataArray= array(
            'tmailHeader'=>'Contacts',
            'actionMenu'=>'menu3',
        );
        $this->load->view('tmail/tmail_common_header',$dataArray);
    ?>
   
   <div class=" m_auto pt25 sc_album width950 ml38 display_table">
      <div class="clearbox">
         <span class="unread_msg fl width_160 bdr_L_ddd  ml25"> <b class="red"><?php echo $contactDataCount; ?></b> Contacts</span>
         <ul class="dis_nav fs14 mt2 fl ">
            <li  class="contactadd addeditnewcontact"><a href="javascript:void(0)">Add New Contact</a> </li>
            <li class="contactadd importcontacts"><a href="javascript:void(0)">Import Contacts</a></li>
            <li class="contactadd importcontactsFromFile"><a href="javascript:void(0)">Import CSV</a> </li>
         </ul>
      </div>
       
       
        <div class=" clearbox  pt15  mb10 fs12 font_bold color_999 ">
           <ul class="alpha_lsit fl ml205 width560">
                <li><a href="javascript:void(0);" id="A" onclick="getSearchedList('A')">A</a></li>
                <li><a href="javascript:void(0);" id="B" onclick="getSearchedList('B')">B</a></li>
                <li><a href="javascript:void(0);" id="C" onclick="getSearchedList('C')">C</a></li>
                <li><a href="javascript:void(0);" id="D" onclick="getSearchedList('D')">D</a></li>
                <li><a href="javascript:void(0);" id="E" onclick="getSearchedList('E')">E</a></li>
                <li><a href="javascript:void(0);" id="F" onclick="getSearchedList('F')">F</a></li>
                <li><a href="javascript:void(0);" id="G" onclick="getSearchedList('G')">G</a></li>
                <li><a href="javascript:void(0);" id="H" onclick="getSearchedList('H')">H</a></li>
                <li><a href="javascript:void(0);" id="I" onclick="getSearchedList('I')">I</a></li>
                <li><a href="javascript:void(0);" id="J" onclick="getSearchedList('J')">J</a></li>
                <li><a href="javascript:void(0);" id="K" onclick="getSearchedList('K')">K</a></li>
                <li><a href="javascript:void(0);" id="L" onclick="getSearchedList('L')">L</a></li>
                <li><a href="javascript:void(0);" id="M" onclick="getSearchedList('M')">M</a></li>
                <li><a href="javascript:void(0);" id="N" onclick="getSearchedList('N')">N</a></li>
                <li><a href="javascript:void(0);" id="O" onclick="getSearchedList('O')">O</a></li>
                <li><a href="javascript:void(0);" id="P" onclick="getSearchedList('P')">P</a></li>
                <li><a href="javascript:void(0);" id="Q" onclick="getSearchedList('Q')">Q</a></li>
                <li><a href="javascript:void(0);" id="R" onclick="getSearchedList('R')">R</a></li>
                <li><a href="javascript:void(0);" id="S" onclick="getSearchedList('S')">S</a></li>
                <li><a href="javascript:void(0);" id="T" onclick="getSearchedList('T')">T</a></li>
                <li><a href="javascript:void(0);" id="U" onclick="getSearchedList('U')">U</a></li>
                <li><a href="javascript:void(0);" id="V" onclick="getSearchedList('V')">V</a></li>
                <li><a href="javascript:void(0);" id="W" onclick="getSearchedList('W')">W</a></li>
                <li><a href="javascript:void(0);" id="X" onclick="getSearchedList('X')">X</a></li>
                <li><a href="javascript:void(0);" id="Y" onclick="getSearchedList('Y')">Y</a></li>
                <li><a href="javascript:void(0);" id="Z" onclick="getSearchedList('Z')">Z</a></li>
                <li><a href="javascript:void(0);" id="all" onclick="getSearchedList('#')">#</a></li>
           </ul>
        </div>
         
      
      <div class="fl  width765">
         
        <?php
            echo Modules::run("messagecenter/contactList"); 
        ?>

        <div class="sap_35"></div>
      
      </div>
       <?php $this->load->view('tmail/right_tmail_view',array('className'=>'')); ?>
   </div>
</div>



<script language="javascript" type="text/javascript">
    
    //add new contact popup open
    $(".addeditnewcontact").click(function(){
        
        var formObj = {
            "firstName":"",
            "lastName":"",
            "profession":"",
            "company":"",
            "emailId":"",
            "phone":"",
            "address":"",
            "contId":"0",
            "userBusinessName":"f",
            };
        openLightBox('popupBoxWp','popup_box','/messagecenter/addeditcontact',formObj);
    })
    
    
    //import contact functionality
    $(".importcontacts").click(function(){
        openLightBox('popupBoxWp','popup_box','/messagecenter/contactImportForm');
    })
    
     //import contact functionality from csv file
    $(".importcontactsFromFile").click(function(){
        openLightBox('popupBoxWp','popup_box','/messagecenter/contactUploadForm');
    })
    
    //menu selected or not selected section
    $(".contactadd").click(function(){
        $(".contactadd").removeClass("active");
        $(this).addClass("active");
    });
    
    $(".searchbtbbg").submit(function(){
       searchAction()
       return false; 
    });
    
	$(".searchbtbbg").click(function(){
        searchAction()
      	return false;			
	}).css("cursor","pointer");
    
    function searchAction(){
        var search_text = $('#contactSearchInput').val();
        if(!search_text){
            var search_text = '';
        }

        if(search_text == ""){
            alert('Please Enter a search term!');
            return false;
        }
        else{
            getSearchedList(search_text);
            return false;
        }
    }

	$('#search_text_box').keypress(function(e) {
		if(e.which == 13) {
		var search_text = $('#contactSearchInput').val();
		if(search_text == "")
		{
		alert('Please Enter a search term!');
		return false;
		}
		else
		{
		getSearchedList(search_text);
		return false;
		}
		return false;			
		}
	});

	function getSearchedList(letter){
		$('#NEWSForm-Content-Box').slideUp('slow');
		$.post("<?php echo base_url();?>en/messagecenter/contacts/", { letter: letter,ajaxHit:1 },
		function(data){
		if (data!='error') {
		$("div#sorted_data").html(data);
		//$("#resultAjax").html(data);

		}
		else {
		alert("Process Error! Please try again.");	} 
		});
	}

	function deleteRecord(id){
		var base_url = "<?php echo base_url();?>";
		 confirmBox("Are you sure you wish to delete?", function () {
        	$('#idToDelete').val(id);
			//document.listForm.submit();
			var parent = $("div#"+id);
			$.ajax({
				type: "GET",
				url: base_url+'en/messagecenter/deleteContact/'+id,
				async:false,
				success: function(msg)
				{	
				parent.fadeOut('500');	
				$("div#messageSuccessError").addClass('successMsg').css('display','block').text(msg);	
				setTimeout(function(){$("div#messageSuccessError").removeClass('successMsg').text('').css('display','block').fadeOut('1000');},4000);			
				}
			});
		});
	}

/*
function showNewsRelatedForm(showDiv,hideDiv,firstName,lastName,profession,company,emailId,phone,toadsquareUrl,address,contId){
	$('#NEWSForm-Content-Box').hide().fadeIn(2000);
	document.getElementById(firstName).value = '';
	document.getElementById(lastName).value = '';
	document.getElementById(profession).value = '';
	document.getElementById(company).value = '';
	document.getElementById(emailId).value = '';
	//document.getElementById(toadsquareUrl).value = '';
	document.getElementById(phone).value = '';
	document.getElementById(address).value = '';
	document.getElementById(contId).value = '';
	$('#emport-Content-Box').fadeOut('slow');
	$('#upload-Content-Box').fadeOut('slow');
}*/



function populate(obj){
    var firstName = $(obj).attr('firstName');
    var lastName = $(obj).attr('lastName');
    var profession = $(obj).attr('profession');
    var company = $(obj).attr('company');
    var emailId = $(obj).attr('emailId');
    //var toadsquareUrl = $(obj).attr('toadsquareUrl');
    var phone = $(obj).attr('phone');
    var address = $(obj).attr('address');
    var contId = $(obj).attr('contId');
    var userBusinessName = $(obj).attr('userBusinessName');

    var formObj = {
        "firstName":firstName,
        "lastName":lastName,
        "profession":profession,
        "company":company,
        "emailId":emailId,
        "phone":phone,
        "address":address,
        "contId":contId,
        "userBusinessName":userBusinessName,
        };
        
        
    openLightBox('popupBoxWp','popup_box','/messagecenter/addeditcontact',formObj);
}

/*
function showElement(elementID){
	if(elementID=='importForm'){		
			//$('#emport-Content-Box').slideToggle('slow');
			//$('#NEWSForm-Content-Box').slideUp('slow');
			//$('#upload-Content-Box').slideUp('slow');
			$('#emport-Content-Box').hide().fadeIn(2000);
			$('#NEWSForm-Content-Box').fadeOut('slow');
			$('#upload-Content-Box').fadeOut('slow');
			//document.getElementById(elementID).className = 'emport-Content-Box';	
	}
	if(elementID=='importExportCSV'){
			//$('#upload-Content-Box').slideToggle('slow');
			//$('#emport-Content-Box').slideUp('slow');
			//$('#NEWSForm-Content-Box').slideUp('slow');
			$('#upload-Content-Box').hide().fadeIn(2000);
			$('#emport-Content-Box').fadeOut('slow');
			$('#NEWSForm-Content-Box').fadeOut('slow');
			//document.getElementById(elementID).className = 'upload-Content-Box';				
	}
}*/

    <?php 
        $action = $this->input->get("action");
        if($action=="add"){ 
    ?>
        $(".addeditnewcontact").trigger( "click" );
    
    <?php  }    ?>
</script>
