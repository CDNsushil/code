/**
 *--------------------------------------------------------------------------------------- 
 * This js file only for affiliate section
 *---------------------------------------------------------------------------------------
 **/ 

/*
 *--------------------------------------------------------------------------------------- 
 * This js file include for copy clipboard
 *---------------------------------------------------------------------------------------
 */
$(document).ready(function(){
	$('.btn-default').tooltip();
}); 
 
$(document).delegate('.payment_request','click',function(){
	var obj = $(this);
	
	bootbox.confirm("Do you really want to save send payment request?",function(result){if(result==true){savePaymentRequest(obj)}});
});

function savePaymentRequest(obj)
{
	var request_data = obj.parent().find('.request_data').val();
	
	$.ajax({
			url:baseUrl+"affiliate/save_affiliate_payment_request",
			type:'POST',
			dataType:'jSon',
			data:{request_data:request_data},
			success:function(result){
				if(result.status==true)
				{
					var btn='<button type="button" class="btn btn-default pending_btn" title="" data-toggle="tooltip" data-placement="left" name="button" data-original-title="Request Pending!">Pending!!</button>';
					obj.parent().html(btn);
				}
			}
		});
}
