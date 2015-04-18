<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
 <div class="poup_bx">
   <div class="popup_close_btn" onclick="$(this).parent().trigger('close');"></div>
   <h3 class=""><?php echo $this->lang->line('rate');?></h3>
        <div class="rate_empty fr">
      <div id="imgMask"><img src="<?php echo base_url('images/rating_mask.png');?>" /></div>
      <div id="ratingBoxDiv">
         <div id="fillLayer"></div>
      </div>
   </div>
   <div class="bdrb_afafaf pt5 clearbox"></div>
   
   <div class="rate_bar mt5 ">
      <div id="ratingBar">
         <div id="baseBarDiv"></div>
         <div id="draggerDiv"></div>
      </div>
   </div>
   <div class="seprator_10"></div>
   <button type="button" >Rate</button>
   <div class="clear"></div>
</div>

               
<script>
	/*****************************/
	var baseBar = '#baseBarDiv';
	var dragger = '#draggerDiv';
	var maxValue = 5;
	var increament = 0.5;
	var isDisabled = false;
	
	// THIS WILL HELP IN CALCULATIONS
	var currentDragPos=0, posPercent=0, posValue = 0, actualDragArea, totalSteps;
	// GET THE OFFSET PROPERTY OF BASEBAR
	var baseBarOffset = $(baseBar).offset();
	// CALCULATE TOTAL STEPS
	totalSteps = 100/(maxValue/ increament);
	// CALCULATE ACTUAL AREA... BASEBAR WIDTH - DRAGGER WIDTH
	actualDragArea = ($(baseBar).width() - $(dragger).width());
	
				
	// SET INITIAL VALUE
	setPosition(0);
	
	
	$(function() {
			// TRIGGER DRAG EVENTS ON DRAGGER
			if(!isDisabled){
				
				// RISTRICT DRAGGING WITHIN BASEBAR
				$(dragger).draggable({containment: baseBar, scroll: false});
				
				// ADDING CALCULATION DURING DRAG AND STOP
				$(dragger).draggable({
						drag:function(){
							calculateValue();
							
						},
						stop:function(){
							snapPosition()
						}
					});	
			}
			
			// BASE BAR CLICK EVENT
			$(baseBar).click(function(e){
			  $(dragger).offset({left: e.pageX});
			  
			  calculateValue();
			  snapPosition();
		   }); 	
	});
	
	// CALCULATING VALUE DURING DRAGGING
	function calculateValue(){
		baseBarOffset = $(baseBar).offset();
		// COMPUTING CURRENT POSITION  (DRAGGER LEFT - BASEBASE LEFT)
		currentDragPos = $(dragger).offset().left - baseBarOffset.left;
		// COMPUTING POSITION PERCENTAGE 
		posPercent = Math.round ( ( currentDragPos / actualDragArea ) * 100 );
		// COMPUTING ACTUAL VALUE AS PER MAX VALUE PROPERTY DEFINED
		posValue = (posPercent/(100/maxValue))
		// SETTING TOP RATING ORANGE BOX
		setRatingBarPos(posValue);
		// PUTTING CALCULATED VALUES IIN CURRENTPOSITION INPUT FIELD		
		$('#currentPosition').val(currentDragPos + ", "+ posPercent+", "+ posValue);
	}
	
	// METHOD CALCULATES NEAREST SNAP POSITION.
	function snapPosition(){
		baseBarOffset = $(baseBar).offset();
		// COMPUTE NEAREST SNAP VALUE BASED ON TOTAL STEPS	
		snapTo = Math.round(posPercent/totalSteps)
		// CALCULATE ACTUAL POSITION AND SET THE DRAGGET TO THAT LOCATION.
		snapPos = baseBarOffset.left + ((actualDragArea * (snapTo*totalSteps))/100)
		$(dragger).offset({left:snapPos});
		// AFTER SNAPPING AGAIN CALCULATE THE VALUE TO UPDATE THE INPUT FIELDS
		calculateValue();
		//502.5, 250, 12.5,25, 502.5, 201
		$('#snapPosition').val($(baseBar).offset().left + ", "+currentDragPos + ", "+ posPercent+", "+ posValue+","+snapTo+", "+snapPos+", "+actualDragArea);
	}		
	
	// SET THE DRAGGER TO SUPPLIED VALUE, THIS SHOULD BE ACTUAL VALUE NOT PERCENTAGE.
	function setPosition(value){
		posValue = value;
		posPercent = (value/maxValue)*100;
		snapPosition();
		setRatingBarPos(posValue);
	}
	
	// MOVE THE TOP ORANGE RATING BAR AS PER POSITION VALUE.	
	function setRatingBarPos(posValue){
		var emptyAreaSize = 11; // 11px is a width of each empty box
		var marginBetweenBox = 5; // 5px is the space between each box
		
		var fillerPos = (emptyAreaSize*posValue)+Math.floor(posValue)*marginBetweenBox
		
		$('#fillLayer').css( 'margin-left', fillerPos - 80 );
	}
	function getRatingValue(){
		return posValue;
	}
	
/*new button function*/
</script>
