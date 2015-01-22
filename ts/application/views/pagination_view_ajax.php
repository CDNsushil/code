<?php
// For breaking pages in chunks
$perPage=$perPage;
// For drop down
$per_page=$per_page;

$count =$count;
$pages = ceil($count/$perPage);


$pagination_wrapper = (isset($pagination_wrapper)) ? $pagination_wrapper :'pagination_wrapper';
$left_site_dropdown = (isset($left_site_dropdown)) ? $left_site_dropdown :'left_site_dropdown';
 
 
if($per_page >=20)
 $per_page=10;
 


?>

<div class="clearfix"></div>
<div class="clearfix"></div>
<!-- PAGINATION FRAME -->


			<div class="<?php echo $pagination_wrapper ?> new_page_design pl10">		

					<div class="pagination-button" id="pagination-button">
							<div class="btn_prev_wrapper">
								<a href="javascript://void(0)">
									<div class="pButton">   		 
									  <span id="prevButton" class="btn_prev prevButton disable_btn">Prev</span>
									</div>
								</a>
							</div>

							<div class="pagination_mid">

								<?php $a=0; for($k=1;$k<=$pages;$k++) { 

										// First page by default highlited

										$class = ($k==1) ? 'Page_cont cont_sel' : 'Page_cont'; 	?>

										<div id="page_<?php echo $k ?>" class="<?php echo $class ?>" onclick="selectPage('<?php echo $a ?>',<?php echo $k ?>)">
										  <?php echo $k ?>
										</div>

								<?php  $a = $a + $perPage; } ?>  
							</div>

							<div class=" btn_next_wrapper">
									<a href="javascript://void(0)">
										<div class="nButton">
										  <div id="nextButton" class="btn_next nextButton"> Next </div>
										</div>
									</a>
							</div>
					</div>

			</div> <!--pagination_wrapper-->

<!-- DROP DOWN START -->

		 <div class="<?php echo $left_site_dropdown ?> new_page_design pr10">
			<div class="right_site_dropdown dd_desiable">
				<div class="result_per_page_box">Results per page</div>
					<div class="bg_sel"> 

							<select onChange="changePage(this.value)" name="myselect2" class="single width_53" id="myselect">
							<?php
							$i=0;
							
							while($i <= $count){
							//echo $i.'---'.$perPage;
							$i=$i+$per_page;
							if($i==$perPage){
							$selected='selected';
							}else{
							$selected='';
							}
							echo '<option value="'.$i.'" '.$selected.'>'.$i.'</option>'; 
							if($i >= $count){
							$i++;
							}
							}
							?>

							</select>
					</div> <!--bg_sel-->
				</div> <!--right_site_dropdown-->
		</div> <!--left_site_dropdown-->

<!-- Drop Down End -->


   <div class="clear"></div>
 
 <!-- PAGINATION  END-->  

<script type="text/javascript">

	
	$(document).ready(function(){
		
		
  selectBox();
	
	 var records= parseInt( $('#records').val());
	 var count =parseInt($('#count').val());
	 var limit = parseInt($("#myselect").val());
     var pageUrl= "<?php echo $ajaxUrl ?>";
	 var container ="<?php echo $container ?>";
	 var formId = "<?php echo $formId ?>";  
	 //   var last= $('.Page_cont').last().html();	 
	 
	 
	 			if(records <=  (limit-1) )
				{  
					
					$('#nextButton').addClass('disable_btn');
					$('#nextButton').removeClass('nextButton');
					//$('.nButton').html('<div class="btn_next nextButton disable_btn"> Next </div>');
				}
				
				if(count ==  0 )
				{  // alert('prev dis');
					$('#prevButton').addClass('disable_btn');
            //  $('.pButton').html('<span id="prevButton" class="btn_prev disable_btn">Prev</span>');						
					
				}	
				
								 
	
		$(".nextButton").click(function () {
				
					//$('#showRecommend').fadeToggle("slow");                  
					var currentPage = $('#currentPage').val();
					var count=0;							
					var add =limit;
				
					var lastPage= $('.Page_cont').last().html();
					
						
					currentPage = parseInt(currentPage) + 1;	
					
									
					count =$('#count').val();
					if(count!='')
					{
					count= parseInt(count) + add;
					}
					var fromData=$("#"+formId).serialize() + "&offSet=" + count + "&perPage=" + limit ; 				
					  
						$.post(pageUrl,fromData, function(msg) {    
										
										
										if(msg)	{ 
																																							
												$('#'+container).html(msg);
 
												$('#prevButton').removeClass('disable_btn');
												$('#prevButton').addClass('prevButton');
												$('#count').val(count);
												$('#currentPage').val(currentPage);
												
												$('#page_1').removeClass('cont_sel');
												
												$('#page_'+ currentPage).addClass('cont_sel');
												 
												if(lastPage==currentPage)
													{ 														
													$('.nButton').html('<div class="btn_next disable_btn" id="nextButton"> Next </div>');															
														
													} 					 
												 
												
											}

							});
			        });	
			        
			        
		
		
		$(".prevButton").click(function () {	
				
					//var limit = parseInt($("#myselect").val());				
				
				    var currentPage = $('#currentPage').val();
					var count=0;							
					var subs =limit;				
					
					currentPage = parseInt(currentPage) - 1;	
					count =$('#count').val();
					
					if(count!='')
					{
            			 count= parseInt(count) - subs;
					}
					
					var fromData=$("#"+formId).serialize() + "&offSet=" + count + "&perPage=" + limit ; 					
					   
					$.post(pageUrl,fromData, function(msg) {     
																
										
										if(msg)	{ 
												
												$('#'+container).html(msg);
												$('#prevButton').removeClass('prevButton');
												
												if(count!=0)
												{
												  $('#prevButton').removeClass('disable_btn');
												  $('#prevButton').addClass('prevButton');												  										
												   
											    } 
											    
												
												$('#page_1').removeClass('cont_sel');
												$('#page_'+ currentPage).addClass('cont_sel');
												$('#count').val(count);
												$('#currentPage').val(currentPage);
												
											}
							      });					
			               });			          
			               
			               
			               
	});	
	
	
	// Drop Down On change Function 	               
			               
	function changePage(str)
	{	
		
		var offSet = 0;					
		var totalRecords = parseInt( $('#totalRecords').html());
		var pageUrl= "<?php echo $ajaxUrl ?>";
		var container ="<?php echo $container ?>";
		var formId = "<?php echo $formId ?>";
		
		var fromData=$("#"+formId).serialize() + "&offSet=" + offSet + "&perPage=" + str ;
		      		 
		   $.post(pageUrl,fromData, function(msg) {
			  if(msg){
						$('#'+container).html(msg);

							if(str == totalRecords) { 										 													
								 $('.nButton').html('<div class="btn_next disable_btn" id="nextButton"> Next </div>');														
							  }						 
						 } 		 
				
			   });		
	 }		               
			               

 // On Page click Function 
		
	function  selectPage(str,cPage)
	{	
		
		var perPage = parseInt($("#myselect").val());				
		var lastPage= $('.Page_cont').last().html();	
		var count=str;		
		var pageUrl= "<?php echo $ajaxUrl ?>";
		var container ="<?php echo $container ?>";
		var formId = "<?php echo $formId ?>";		
		 	
		var fromData=$("#"+formId).serialize() + "&offSet=" + str + "&perPage=" + perPage ;
						
				$.post(pageUrl,fromData, function(msg) {
					
					  if(msg){
						 
							$('#'+container).html(msg);								

								if(str!=0)	{ 
									$('#prevButton').removeClass('disable_btn');	
									$('#prevButton').addClass('prevButton');
								}
								
								$('#page_1').removeClass('cont_sel');
								$('#page_'+ cPage).addClass('cont_sel');
								$('#count').val(count);
								$('#currentPage').val(cPage);

								if(lastPage==cPage)	{ 		
										
								  $('.nButton').html('<div class="btn_next disable_btn" id="nextButton"> Next </div>');															

								} 
						 
						 
					  } 
				
			});
		}
	
		

</script>



