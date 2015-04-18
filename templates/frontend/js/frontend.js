function ajaxFrontEnd(url,dataType,val1,val2,val3,val4,val5) {
	/*dataType: json | html*/
	var result =false;
	$.ajax({
		type: 'POST',
		url : baseUrl+language+url,
		dataType :dataType,
		data : {
			val1:val1,
			val2:val2,
			val3:val3,
			val4:val4,
			val5:val5,
			ajaxHit:1
		},
		beforeSend:function(){
			$('#contactContainer').html(loader('contactContainer'));
			openLightBoxWithoutAjax('contactBoxWp','contactContainer'); 
		},
		complete:function(){
			$('#contactContainer').html('');
			$('#contactContainer').parent().trigger('close');
		},
		success:function(data){
			$('#contactContainer').html('');
			$('#contactContainer').parent().trigger('close');
			result = data
			
		},
		async:false,
        error: function () {
			$('#contactContainer').html('');
			$('#contactContainer').parent().trigger('close');
            alert(someInternalProblem);
        }
	});
	return result;
}
