<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- Define advert type input fields-->
	<input type="hidden" name="advertType1" id="advertType1" value="<?php if(isset($bannerType1)) { echo $bannerType1;} ?>">
	<input type="hidden" name="advertType2" id="advertType2" value="<?php if(isset($bannerType2)) { echo $bannerType2;} ?>">
	<input type="hidden" name="advertType3" id="advertType3" value="<?php if(isset($bannerType3)) { echo $bannerType3;} ?>">
	<input type="hidden" name="advertType4" id="advertType4" value="<?php if(isset($bannerType4)) { echo $bannerType4;} ?>">
	<input type="hidden" name="advertType5" id="advertType5" value="<?php if(isset($bannerType5)) { echo $bannerType5;} ?>">
	
<script type="text/javascript">
	/*-----------------------------------------------
	* Call auto change advert banner methode
	*------------------------------------------------*/
	/*
   ***************************************
   * comment by lokendra (11-08-2014) for continue hinting on 
   * server due to comment this code
   ***************************************
  var myVar = setInterval(function() {
		for(i=1;i<6;i++){ 
			var advertVal = $('#advertType'+i).val();
			if(advertVal) {
				changeAdverts(i)
			}
		}
	},<?php echo $this->config->item('advert_change_time');?>);
  */
	
	/*-----------------------------------------------
	* This function used to change advert as per advert types
	*------------------------------------------------*/
	function changeAdverts(advertType) {
		
		var BASEPATH = "<?php echo base_url(lang());?>";
		var form_data = {sectionId:<?php echo $sectionId;?>,advertType:advertType};
		$.ajax
		({
			type: "POST",
			url: BASEPATH+"/advertising/getAdvertRecords",
			data: form_data,
			success: function(data)
			{
				//Append ad view on advert blog		
				if(advertType==1) {
					$('#advert250_250').html(data);
				} else if(advertType==2) {
					$('#advert160_600').html(data);
				} else if(advertType==3) {
					$('#advert468_60').html(data);
				} else if(advertType==4) {
					$('#advert170_170').html(data);
				} else {
					$('#advert728_90').html(data);
				}
			}
		});
		return false;	
	}
</script> 
