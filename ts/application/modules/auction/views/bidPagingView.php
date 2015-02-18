<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="widht545px pt15 pb5"> 
	<?php if(isset($bidList) && !empty($bidList)){ ?>
		<!--<div id="pagingContent" class="height400scrollY">-->
		<div id="pagingContent">
			<?php 
			foreach($bidList as $bidList){ 
				//Get users showcase details
				$getUserShowcase = showCaseUserDetails($bidList['userId']);
				//Set users image
				$userDefaultImage=($getUserShowcase['creative']=='t')?$this->config->item('defaultCreativeImg'):(($getUserShowcase['associatedProfessional']=='t')?$this->config->item('defaultAssProfImg'):(($getUserShowcase['enterprise']=='t')?$this->config->item('defaultEnterpriseImg'):''));
				if($getUserShowcase['userImage']!='') {
					$userImage=$getUserShowcase['userImage'];
				}
				$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$userDefaultImage);  	
				$userImage=getImage($userImage,$userDefaultImage);
				//Get users currency details
				$seller_currency=LoginUserDetails('seller_currency');
				$seller_currency=($seller_currency>0)?$seller_currency:0;
				$currencySign=$this->config->item('currency'.$seller_currency);
				//Set bit date formate
				$bidDate = date("d F Y", strtotime(substr($bidList['date'],0,-9)));
				?>
				<!--<a href="javascript://void(0)"  onclick="setAuctionWinners('<?php //echo $bidList['bidId'];?>','<?php //echo $bidList['userId'];?>');" >-->
					<div class="search_result_list_wrapper  ml35 mb10 minH60 widht490px">
						<div class="bg_white pt2 pb2 pl2 pr2 pr">
							<div class="bg_3e3e3e minH60">
								<div class="fl width60px bdrR_fff height_60">
									<div class="cell ml20 mt10 thumb_absolute01">
										<div class="AI_table">
											<div class="AI_cell"> 
												<img class="mH30 bdr_cecece max_w34_h41" src="<?php echo $userImage;?>">
											</div>
										</div>
									</div>
								</div>
								<div class="fl width385px ml5">
									<div class="bdr_f15921 font_opensansSBold clr_white ml12 mr17 pt3 pb3">
										<div class="fl font_size14 width250px"><?php echo  $getUserShowcase['userFullName'];?></div>
										<div class="fr font_size12"><?php echo $currencySign.''.$bidList['price'];?></div>
										<div class="clear"></div>
									</div>
									<div class="font_opensansSBold clr_white ml12 mr17 pt3 pb3 lH14">
										<div class="fl font_size12 width250px"><?php echo $bidDate;?><br/><?php echo date("h:i A",strtotime($bidList['date'])); ?></div>
										<div class="fr font_size12"><?php //echo ''; ?></div>
										<div class="clear"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!--</a>-->			
			<?php 
			} ?>
		</div>
	<?php 
	} else {
		echo '<div class="pt15 ml30 f16">';
		echo "No record found for the auction bids.";
		echo '</div>';
	}?>
</div>
<!-- load pagination data-->
<?php if($items_total >  $items_per_page) { ?>
	<div class="row pt10 pl15 pr16">
		<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"url"=>base_url(lang().'/auction/test'),"divId"=>"showBidList","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design')); ?>  
		<div class="clear"></div>
		<div class="seprator_10"></div>
	</div>
<?php } ?>
<div class="clear seprator_10"></div>

<script>
/* Function to save auctions winner */
function setAuctionWinners(bidId,userId)
{
	var BASEPATH = "<?php echo base_url().lang();?>";
	var form_data = {bidId: bidId,userId: userId,title: '<?php echo $projectTitle;?>'};
	openLightBoxWithoutAjax('popupBoxWp','popup_box'); 
	$.ajax
	({
		type: "POST",
		url: BASEPATH+"/auction/setAuctionWinners",
		data: form_data,
		success: function(data)
		{	
			$('#messageSuccessError').html('<div class="successMsg">'+data+'</div>');
			refreshPge();
		}
	});
	return false;	
}
</script>
