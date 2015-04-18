 <!-- server  <script src="//maps.google.com?file=api&amp;v=2.x&amp;key=AIzaSyDDQvz9R04N0Cl3LzjdAZTuTYOR5Py35qw" type="text/javascript"></script> 
<script src="//maps.google.com?file=api&amp;v=2.x&amp;key=AIzaSyDHgUzd3NvQkyv1ZXZQqS547SWxZW-Gj8w" type="text/javascript"></script> -->
<script type="text/javascript"src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<div class="contentcontainer">
	<div class="headings altheading">
		<h2><?php echo $this->lang->line('admin_state_map');?></h2>
	</div>
	<div class="contentbox">

	<script type="text/javascript" language="javascript">
		
		function initialize() {
			lat = 37.0902400;
			lng = -95.7128910;
			var myLatlng = new google.maps.LatLng(lat,lng);
			var myOptions = {
				zoom: 4,
				center: new google.maps.LatLng(lat, lng),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			};
			var map = new google.maps.Map(document.getElementById('map_canvas'),myOptions);
		    	
		   var i=0;
				<?php foreach($states as $state): ?>
				   // Get the Google Maps Object
                                    <?php if($state->latitude != ""): ?>    
                                        var point = new google.maps.LatLng(<?php echo $state->latitude; ?>,<?php echo $state->longitude;?>);
                                        <?php if($state->is_under_incentive_program == "1") { $marker_color="green"; } else { $marker_color="red"; } ?>
                                                createMarker(point, i + 1,'<?php echo $marker_color; ?>','<?php echo $state->state_name; ?>');
                                    <?php endif; ?>
                                    i++;
				<?php endforeach; ?>
				
		   function createMarker(point, number, marker_type,state_name){
				if(marker_type=='green') { 
					image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/green-dot.png";
				} else { 
					image = "http://www.google.com/intl/en_us/mapfiles/ms/micons/red-dot.png";
				}
				var marker = new google.maps.Marker({
				position: point,
				map: map,
				title:state_name,
				icon: image
				});
				
				var infowindow = new google.maps.InfoWindow({
					content: state_name,
					size: new google.maps.Size(50,50)
				});
				google.maps.event.addListener(marker, 'click', function() {
					infowindow.open(map,marker);
				});
			}//create marker	
		}//initialize
		
		</script>

	<body onload="initialize()">
	<div id="map_canvas" style="width: 960px; height: 480px"></div>
	</body>

	
	</div>
</div>
