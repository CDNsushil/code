/*
 * Translated default messages for the jQuery validation plugin.
 * Locale: CA
 */
	var atleastSelect = 'Please select atleast one record';
	var noMessagae = 'No message found.';
	var areYouSure = 'If you delete this, it will be deleted immediately.';
	var moveInArchiveMsg = 'If you delete this, it will be stored in Deleted & Expired Tools for one month.\n\nIf you wish, you can delete it immediately from there.';
	var areYouSureMoveFromArchive = 'Are you sure you wish to restore this?';
	var shippingDisablConfirm = 'Do you really want to disable this shipping zone information?';
	var shippingEnableConfirm = 'Do you really want to enable this shipping zone information?';
	var someInternalProblem = "There was a problem; please try again.";
	//var limitError1 = "You have exceeded the ";
	//var limitError2 = " word limit.";
	var limitError1 = "There is a limit of ";
	var limitError2 = " words.";
	var endDateCheck = "End Date must be greater than Start Date";
	var fillEndDate = 'Please fill End Date';
	var fillStartDate = 'Please fill Start Date';
	var releaseDateCheck = "Release Date must be greater than today's date!";
	var selectFileMsg = 'You did not select a file to upload';
	var imageFileCheck = 'Only gif, png, jpg, jpeg extensions are allowed';
	var playAgain = "click to play again";
	var morethanfive = 'Cannot add more than 5 records.';
	
	var sureHalf = 'Are you sure you want to';
	var selectedRecordHalf = ' the selected record.';
	var publish = 'Publish';
	var hide = 'Hide';
	var publishMsg = 'Are you sure you want to publish this?';
	var hideMsg = 'Are you sure you want to hide this?';
	var notPublishMsg = 'You cannot publish this until you have filled in all the Required Fields.';
	var notPublishElementMsg = 'You cannot publish this until project is not published either you have filled in all the required fields.';
	var leavePageMasg = 'This page is asking you to confirm that you want to leave - data you have entered may not be saved.';
	//var fileSizeErrorMasg = '<div class="cell frm_element_wrapper p0"><div class="cell pr10 mt8">You need to Add Space to this Tool to upload this file.</div><div class="tds-button"> <a href="'+baseUrl+language+'/package/buytools" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold width_63  dash_link_hover" style="min-width:75px">Add Space</span></a> </div></div>';
	var fileSizeErrorMasg = '<div class="cell frm_element_wrapper p0 pr10"><div class="tds-button"> <a id="redirectUrl"  href="javascript:void(0)" onmouseup="mouseup_tds_button(this)" onmousedown="mousedown_tds_button(this)"><span class="font_size12 font_opensansSBold width_63  dash_link_hover" style="min-width:75px">Add Space</span></a> </div></div>';
	var fileErrorMasg = 'There was an error uploading your file ';
	var fileNotSupportedMasg = 'The file you selected is not supported in this section ';
	var requiredMasg = 'This is a required field.';
	var emailPasswordInvalid = 'Please make sure your email address and password are correct.';
	
jQuery.extend(jQuery.validator.messages, {
	required: "This is a required field.",
	remote: "Please fix this field.",
	email: "Please enter a valid email address.",
	url: "Please enter a valid URL.",
	date: "Please enter a valid date.",
	dateISO: "Please enter a valid date (ISO).",
	number: "Please enter a number",
	digits: "Please enter only digits.",
	creditcard: "Please enter a valid credit card number.",
	equalTo: "Please enter the same value again.",
	accept: "Please enter a value with a valid extension.",
	maxlength: $.validator.format("Please enter no more than {0} characters."),
	minlength: $.validator.format("Please enter at least {0} characters."),
	rangelength: $.validator.format("Please enter a value between {0} and {1} characters long."),
	woedlength: $.validator.format("Please enter a words between {0} and {1} ."),
	range: $.validator.format("Please enter a value between {0} and {1}."),
	max: $.validator.format("Please enter a value less than or equal to {0}."),
	min: $.validator.format("Please enter a value greater than or equal to {0}.")
});
