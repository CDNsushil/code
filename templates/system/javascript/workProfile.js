function get_radio_value(val)
	{
	    val = val - 1;
	    for (var i=0; i < document.customForm.levels.length; i++){
		if(i==val){
			document.customForm.levels[i].checked = true;
			}
		}
		for (var i=0; i < document.customForm.levels.length; i++){
			if (document.customForm.levels[i].checked)
				{
					var rad_val = document.customForm.levels[i].value;
					//alert('if '+rad_val);
					document.getElementById(rad_val).style.display = "block";
				}
			else
				{
					//alert('else '+rad_val);
					var rad_val = document.customForm.levels[i].value;
					document.getElementById(rad_val).style.display = "none";
				}
		}
	}

//function editVisaInfo(k) {
	
		$('#addScntEdit').live('click', function() {
			$('div.visaInfoDiv').css('display','block');  // Again Display:block the visaInfoDiv Div
			var visa_count_old = $('#visa_count').html();
			
			//alert(visa_count_old);
			var test = Number($('#visaCountry_'+visa_count_old).html())+Number(1);
			visa_count = Number(visa_count_old)+Number(1);
			getCountries(visa_count);
			//alert(visa_count);
				$('<div class="removeIDEdit" id="removeIDEdit" style="float:left;"><div  style="float:left;"><div id="visaCountry_'+visa_count+'" class="profileDropDown"><select onclick="selectBox()" id="visaCountry" name="visaCountry"><option>Select Country</option></select></div></div><div style="float:left;"><input type="text" id="visaType_'+visa_count+'" size="26" name="visaType['+visa_count+']" value="" class="formTip Bdr4" style="margin-left:20px"/></div><div class="floatRight-ml20" id="remScntEdit"><a href="#" title="Remove" style="cursor:pointer" class="formTip"><div class="projectDeleteIcon"></div></a></div><span class="clear_seprator "></span></div></div>').appendTo($('#p_scentsEdit'));
				selectBox();
				$('#visa_count').html(visa_count);
		    });
				//$('#visaCountry_'+visa_count).children('span .abc').remove();
        
        $('#remScntEdit').live('click', function() {
				var conBox = confirm(areYouSure);
				if(conBox){
					var mycount =  $('.removeIDEdit').size();
					//alert(mycount);
					var mycountprojectDeleteIcon =  $('.projectDeleteIcon').size();
					//alert(mycountprojectDeleteIcon);
					 $(this).parents('div .removeIDEdit').remove();
					if(mycount == 1 && mycountprojectDeleteIcon <2){
						$('div.visaInfoDiv').css('display','none');
						// if last record than hide div visaInfoDiv.....
					}
					return false;
				}
				else{
					return false;
				}
        });
//}


function fnClk()
{
	$('#btnBowse').click();
}

function fnAssign(obj)
{
	//document.getElementById('txtflName').value = obj.value;
	$('#txtflName').attr({ value: obj.value});
}

function getCountries(visaCountId)
{
	$.ajax
	({
		type: "POST",
		url: baseurl+"workprofile/getCountryList/"+visaCountId,
		success: function(msg)
		{
			$('#visaCountry_'+visaCountId).html(msg);
		}
	});
}

function getYear(education_count)
{
	$.ajax
	({
		type: "POST",
		url: baseurl+"workprofile/getYear/"+education_count,
		success: function(msg)
		{
			$('#educationYearId_'+education_count).html(msg);
		}
	});
}

function confirmDelete()
{
	var conBox = confirm(areYouSure);
	if(conBox){
		return true;
	}
	else{
		return false;
	}
}

//This function returns the string with defined word length only removing extra stuff from the string

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
		}
	else { f = false; }
	ts += vs;
	}
return s;
}



$('#educationScntEdit').live('click', function() {
	$('div.educationInfoDiv').css('display','block');  // Again Display:block the visaInfoDiv Div
	var education_count_old = $('#education_count').html();
	
	//alert(visa_count_old);
	var test = Number($('#educationYear_'+education_count_old).html())+Number(1);
	education_count = Number(education_count_old)+Number(1);
	getYear(education_count);

		$('<div class="removeIDEditEducation" id="removeIDEditEducation" style="float:left;"><div style="float:left;"><div id="educationYearId_'+education_count+'" class="profileDropDown"><select id="educationYear" name="educationYear['+education_count+']"><option>Select Year</option></select></div></div><div style="float:left;"><input type="text" id="educationUniversity_'+education_count+'" size="12" name="educationUniversity['+education_count+']" class="formTip"  style="margin-left:10px"/></div><div style="float:left;text-align:right;margin-left:10px;"><input type="text" id="educationDegree_'+education_count+'" size="12" name="educationDegree['+education_count+']" class="formTip"/><span class="clear_seprator "></span></div><div class="floatRight-ml20" id="remEducationScntEdit"><a href="#" title="Remove" style="cursor:pointer" class="formTip"><div class="projectDeleteIconEducation"></div></a></div><span class="clear_seprator "></span></div></div>').appendTo($('#p_educationScentsEdit'));
		selectBox();
		$('#education_count').html(education_count);
	});
		//$('#educationYear_'+education_count).children('span .abc').remove();

$('#remEducationScntEdit').live('click', function() {
		var conBox = confirm(areYouSure);
		if(conBox){
			var mycount =  $('.removeIDEditEducation').size();
			//alert(mycount);
			var mycountprojectDeleteIcon =  $('.projectDeleteIconEducation').size();
			//alert(mycountprojectDeleteIcon);
			 $(this).parents('div .removeIDEditEducation').remove();
			if(mycount == 1 && mycountprojectDeleteIcon <2){
				$('div.educationInfoDiv').css('display','none');
				// if last record than hide div visaInfoDiv.....
			}
			return false;
		}
		else{
			return false;
		}
});
// -->


//Education InsertMode Delete Record

function removeEducationDetail(educationDetailId)
{
var conBox = confirm(areYouSure);
	if(conBox){
		var mycount =  $('.projectDeleteIconEducation').size();
		//alert('projectDeleteIconEducation   --  '+mycount);
		var mycountprojectDeleteIcon =  $('.educationDetailId_'+educationDetailId).size();
		//alert('mycountprojectDeleteIcon -- '+mycountprojectDeleteIcon);
		$('.educationDetailId_'+educationDetailId).remove();
		if(mycount == 1 && mycountprojectDeleteIcon <= 1){
			$('div.educationInfoDiv').css('display','none');
		}
		return true;
	}
	else{
		return false;
	}
}

// Visa Detail Insert Mode Remove the Row
function removeVisaDetail(visaDetailId)
{
var conBox = confirm(areYouSure);
	if(conBox){
		var mycount =  $('.projectDeleteIcon').size();
		//alert('projectDeleteIcon'+mycount);
		var myaccountVisaDetailId =  $('.visaDetailId_'+visaDetailId).size();
		//alert('myaccountVisaDetailId '+myaccountVisaDetailId);
		
		//var visaInfoDiv =  $('.visaInfoDiv_'+visaInfoDiv).size();
		//alert('visaInfoDiv '+visaInfoDiv);
		
		$('.visaDetailId_'+visaDetailId).remove();
		
		if(mycount == 1 && myaccountVisaDetailId <= 1){
		//alert('inside');
			$('div.visaInfoDiv').css('display','none');
		}
		return true;
	}
	else{
		return false;
	}
}

