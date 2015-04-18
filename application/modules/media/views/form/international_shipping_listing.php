<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
// set base url
$baseUrl = formBaseUrl(); ?>
<div class="c_1"> 
<!-- <div class="c_1" id="IS_Container">-->
    <h3 class="red fs21 ">Edit or Delete an International Shipping Zone</h3>
    <div class="sap_40"></div>
    <?php if(count($interationalShipping)>0) { ?>
        <h4 class="fs18"> Edit or Delete a Shipping Zone</h4>
    <?php } ?>
    <ul>
        <li>
            <ul class=" fs12 ml30 open_semibold pt0 mt10 width100_per fl  clearb">
                <?php
                if(count($interationalShipping)>0) {
                    foreach($interationalShipping as $zone) { ?>
                        <li class="mb10 zoneLi"> <span class="bg_f9f9f9 " id="zoneLi_<?php echo $zone['spId'];?>">
                            <span class=" fl pl36 mr70 zone_name">Shipping <?php echo $zone['zoneTitle'];?></span>
                            <span class="zone_price"><?php echo currencySign().number_format($zone['amount'],2);?></span>
                            <span class="red pl58 pr5 fs12 fr">
                                <a href="<?php echo $baseUrl.'/addshippingzone/'.$projectId.'/'.$zone['spId'].'/'.$elementId;?>"> Edit</a> / <a href="javascript:void(0);" onclick="deleteGlobalShipping('<?php echo $zone['spId'];?>');";>Delete </a>
                            </span> 
                        </li>
                        <?php
                    } 
                }?>
            </ul>
        </li>
        <li class="mt36 fl clearb"> 
            <a href="<?php echo $baseUrl.'/addshippingzone/'.$projectId.'/0/'.$elementId;?>">
                <button class="red p10 bdr_a0a0a0 fshel_bold " type="button" >Add Another Shipping Zone</button>
            </a> 
        </li>
    </ul>
    <div class="sap_50"></div>
    <?php
    // set back url page name

    $data['backPage'] = 'shipping';
    if(!empty($elementId)) {
        $data['backPage'] = 'shippingcharge';
    }
    if(count($interationalShipping)>0 && empty($elementId)) {
        $data['nextUrl'] = $baseUrl.'/sellerconsumptiontax/'.$projectId;
    }  elseif(count($interationalShipping)>0 && !empty($elementId)) {
        $data['nextUrl'] = $baseUrl.'/uploadimageinfo/'.$projectId.'/'.$elementId;
    }
    $this->load->view('common_view/shipping_buttons',$data);
    ?>
</div>
	<!--</div>-->
	<script>
		function deleteGlobalShipping(spId) {
			confirmBox("Do you really want to delete this shipping zone?", function () {
				 var fromData='spId='+spId+'&isGlobal=1';
				 $.post(baseUrl+language+'/shipping/deleteGlobalShipping',fromData, function(data) {
					if(data.deleted){
						$("#zoneLi_"+spId).fadeOut("normal", function() {
							$(this).remove();
						});
						
						/*if(data.countResult == 0) {
							 $.post(baseUrl+language+'/shipping/globalShippingform/1','', function(htmlData) {
								if(htmlData) {
									window.location.href = '<?php echo $baseUrl.'/internationalshipping/'.$elementId ?>';
								}
							});
						}*/
						$('#messageSuccessError').html('<div class="successMsg"><?php echo $this->lang->line('deletedShippingZone');?></div>');
						timeout = setTimeout(hideDiv, 5000);	
					}
				},'json');
			});
		}
	</script>
