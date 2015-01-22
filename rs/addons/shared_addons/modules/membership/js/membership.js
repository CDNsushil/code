
$( document).ready(function() {
	/*
	 *--------------------------------------------------------------------------------------- 
	 * This function is used to change feature
	 *---------------------------------------------------------------------------------------
	 */ 
	
	$('.select_feature').change(function(){
		var id=$(this).val();
		var option=$(".select_feature option[value="+id+"]").text();
		$('.feature_head').html(option);
			 $("#membership_type_form").attr("action",base_url+"membership/paypalPayment/"+id);
			$.ajax({
			  type: "POST",
			  url: base_url+'membership/getSelectMembership',
			  data: 'id='+id,
				success: function(data) {
					$('.feature_data').html(data);
					if(data==''){
						$('.feature_wrapper').hide();
						return true;
					}
					$('.feature_wrapper').show();
				}
			});
	});
});
