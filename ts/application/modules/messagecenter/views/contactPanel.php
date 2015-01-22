<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="row">
      <div class="cell frm_heading">
        <h1>Contacts</h1>
      </div>
	<div class="cell frm_element_wrapper pt1">						   
		<div class="tds-button-big Fright"><a href="<?php echo base_url(); ?>notifications/index" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span>Notifications</span></a></div>					   
			<div class="tds-button-big Fright"> 
				<a href="<?php echo base_url(); ?>tmail" onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)"><span>Tmail</span></a>  
			</div>
		<div class="row line1 mr3"></div>   								
	</div>
</div>

<div class="row pt2 ">
	<div class="cell tab_left">
	  <div class="tab_heading">Contacts List</div>
	  <!--tab_heading-->
	</div>
	<div class="cell tab_right"> 
	  <div class="tab_btn_wrapper width_100_per">          
		<div class="abc_wp">
						<a href="javascript:void(0);" id="A" onclick="getSearchedList('A')">A</a>
						<a href="javascript:void(0);" id="B" onclick="getSearchedList('B')">B</a>
						<a href="javascript:void(0);" id="C" onclick="getSearchedList('C')">C</a>
						<a href="javascript:void(0);" id="D" onclick="getSearchedList('D')">D</a>
						<a href="javascript:void(0);" id="E" onclick="getSearchedList('E')">E</a>
						<a href="javascript:void(0);" id="F" onclick="getSearchedList('F')">F</a>
						<a href="javascript:void(0);" id="G" onclick="getSearchedList('G')">G</a>
						<a href="javascript:void(0);" id="H" onclick="getSearchedList('H')">H</a>
						<a href="javascript:void(0);" id="I" onclick="getSearchedList('I')">I</a>
						<a href="javascript:void(0);" id="J" onclick="getSearchedList('J')">J</a>
						<a href="javascript:void(0);" id="K" onclick="getSearchedList('K')">K</a>
						<a href="javascript:void(0);" id="L" onclick="getSearchedList('L')">L</a>
						<a href="javascript:void(0);" id="M" onclick="getSearchedList('M')">M</a>
						<a href="javascript:void(0);" id="N" onclick="getSearchedList('N')">N</a>
						<a href="javascript:void(0);" id="O" onclick="getSearchedList('O')">O</a>
						<a href="javascript:void(0);" id="P" onclick="getSearchedList('P')">P</a>
						<a href="javascript:void(0);" id="Q" onclick="getSearchedList('Q')">Q</a>
						<a href="javascript:void(0);" id="R" onclick="getSearchedList('R')">R</a>
						<a href="javascript:void(0);" id="S" onclick="getSearchedList('S')">S</a>
						<a href="javascript:void(0);" id="T" onclick="getSearchedList('T')">T</a>
						<a href="javascript:void(0);" id="U" onclick="getSearchedList('U')">U</a>
						<a href="javascript:void(0);" id="V" onclick="getSearchedList('V')">V</a>
						
						<a href="javascript:void(0);" id="W" onclick="getSearchedList('W')">W</a>
						<a href="javascript:void(0);" id="X" onclick="getSearchedList('X')">X</a>
						<a href="javascript:void(0);" id="Y" onclick="getSearchedList('Y')">Y</a>
						<a href="javascript:void(0);" id="Z" onclick="getSearchedList('Z')">Z</a>
						<a href="javascript:void(0);" id="all" onclick="getSearchedList('#')">#</a>
					 </div><!--abc_wp-->  
		<div class="tds-button-top">
			<a class="formTip mr6" title="Import Contacts" onclick="showElement('importForm');" href="javascript://void(0);">
				<div class="projectimportIcon"></div>		
			</a>
			<a class="formTip mr6" title="Import CSV" onclick="showElement('importExportCSV');" href="javascript://void(0);">
				<div class="projectcsvIcon"></div>
			</a>
			<?php
				echo anchor('javascript://void(0);', '<span><div class="projectAddIcon"></div></span>',array('class'=>'formTip mr6','title'=>$label['add'],'onclick'=>'showNewsRelatedForm(\'NEWSForm-Content-Box\',\'News-No-Records\',\'firstName\',\'lastName\',\'profession\',\'company\',\'emailId\',\'phone\',\'toadsquareUrl\',\'address\',\'contId\');$(\'#NEWS-Content-Box\').slideDown(\'2000\');'));
			?>
		</div>
	  </div>
	</div>
</div>
      
<div class="clear"></div>
      
<div class="form_wrapper toggle frm_strip_bg">
	<div class="row">
	  <div class="tab_shadow"> </div>
	</div>  

	<div id="NEWS-Content-Box">
		<div id="emport-Content-Box" style="display:none">
			<?php
				echo Modules::run("messagecenter/contactImportForm"); 
			?>
			<div class="row seprator_20"></div>
		</div>
		<div id="upload-Content-Box" style="display:none;">
			<?php
				echo Modules::run("messagecenter/contactUploadForm"); 
			?>
			<div class="row seprator_20"></div>    
		</div>
		<?php
			$this->load->view('contactEntryForm');
			echo Modules::run("messagecenter/contactList"); 
		?>
	</div>
</div>

<script language="javascript" type="text/javascript">
	$(".search_btn").click(function(){
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
			return false;			
	}).css("cursor","pointer");

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
		var conBox = confirm(areYouSure);
		if(conBox){
			$('#NEWSForm-Content-Box').slideUp('slow');
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
		}else{
			return false;
		}
	}
	
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
}



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

		$('#firstName').val(firstName);
		$('#lastName').val(lastName);
		$('#profession').val(profession);
		$('#company').val(company);
		$('#emailId').val(emailId);
		//$('#toadsquareUrl').val(toadsquareUrl);
		$('#phone').val(phone);
		$('#address').val(address);
		$('#contId').val(contId);
		$('#NEWSForm-Content-Box').hide().fadeIn(2000);
		$('#emport-Content-Box').fadeOut('slow');
		$('#upload-Content-Box').fadeOut('slow');
	}

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
}
</script>

