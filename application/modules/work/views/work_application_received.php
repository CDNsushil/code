<div class="row form_wrapper"> 
<?php echo $header;?>
		<!-- TOP NAVIGATION-->
					<div class="row padding_top10 position_relative">
							<div class="cell shadow_wp strip_absolute">
								<table width="100%" cellspacing="0" cellpadding="0" border="0" height="940px">
									<tbody><tr>
									   <td height="271">	<img src="<?php echo base_url('images/shadow-top.png');?>"></td>
									</tr>
									<tr>
									  <td class="shadow_mid">&nbsp;</td>
									</tr>
									<tr>
									  <td height="271"><img src="<?php echo base_url('images/shadow-bottom.png');?>"></td>
									</tr>
									</tbody>
								</table>
								<div class="clear"></div>
						   </div>

								<div class="cell width_200"> 
								   <div class="seprator_112"> </div>
									<div class="Cat_wrapper">
									   <?php
										if(isset($workClassfied) && $workClassfied && is_array($workClassfied))
										{?>
									   <h1>Classifieds</h1>
										<ul>
											<?php
											
											foreach ($workClassfied as $work) {   ?> 		

											<li onclick="getWorkDetails('<?php echo $work->workId ?>');"><a class="clr_grey_888" id="classfied_<?php echo $work->workId ?>"><?php echo ucfirst(substr($work->workTitle,0,15)) ?></a></li>

											<?php  } ?>	
										</ul>
										<?php } ?>	
									</div>
								</div>

								<div class="cell width_569 pl20"> 
									<div id="applicationReceived">
											<?php 

											if(isset($workClassfied[0]->workId) && ($workClassfied[0]->workId!='')) {
											echo Modules::run("work/getReceivedData",$workClassfied[0]->workId); 

											}
											?>
									</div>

								  <div class="seprator_15"> </div>
								  <div class="seprator_20"> </div>
							</div>
					</div>			
</div>
<script type="text/javascript">	
	
$(function() {	
	$('.clr_grey_888').removeClass('clr_E76D34');
	$('#classfied_'+<?php echo $workClassfied[0]->workId ?>).addClass('clr_E76D34');	
});		
	
function getWorkDetails (workId) {					
				
		$.ajax
		({     
			type: "POST",
			url: "<?php echo base_url() ?>work/getReceivedData/"+workId,

			success: function(msg)
			{  
				$('.clr_grey_888').removeClass('clr_E76D34');				
				$('#classfied_'+workId).addClass('clr_E76D34');		
															
                $('#applicationReceived').html(msg)
			}

		});			
	}

</script>
