<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php $url = base_url()."templates/system/slider"?>
<script type="text/javascript" src="<?php echo $url?>/js/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo $url?>/css/jquery.lightbox-0.5.css" media="screen" />
<div class="row form_wrapper">
<?php include('navigationMenu.php');?>
<div class="row position_relative">	

<?php 
	if(strcmp($location5,'promotional_image')!=0)
		echo Modules::run("common/strip"); 
		
	echo form_open('product/deleteProduct',"name='product'");
	echo form_hidden('productId','');
	echo form_hidden('productType','');
?>

	<div id="pagingContent" >
		<?php
	
		if($products){
		$count=0;
		foreach($products as $key=>$product)
		{
			//echo $product['productId'];
			$count++;
			$previeLink='product/'.$label['project_preview'].'/'.$product['productId'];
			$sliderImages = getProductImages('ProductPromotionMedia','prodId',$product['productId'],1, 'isMain');
			if(!empty($sliderImages)){
				foreach($sliderImages as $image){
					if($productType=='freeStuff')
					{
						$product['productImage'] = $image->filePath.$image->fileName;

					}else{
						$product['productImage'] = $image->filePath.$image->fileName;
					}
				}
			}
			
						
		if(isset($product['productDateCreated']) && $product['productDateCreated'] != '')
		{
			$FirstSaved = date("l, d F Y", strtotime($product['productDateCreated']));
			
		}

		$ExpiryDate = date('l, F d  Y',(strtotime($product['productDateCreated'])+(60*60*24*30*6)));
		?>
		<div class="all_list_item">
		<div class="row"></div>    
		<div class="blog_box_wrapper">
			<div class="row">
				<div class=" cell width_200 Cat_wrapper">
				<?php 
				$defaultImage='images/work_stock_image.jpg';
				echo Modules::run("common/imageSlider",$sliderImages,$count,$defaultImage);
				?>
				</div><!-- End Cat_wrapper -->
			</div><!-- End row -->
			<div class="cell width_569 margin_left_16">
				<div class="row blog_wrapper new_theme_blog_box_gray">
					
					
					<div class="blog_box bg-non-color">
					<div class="one_side_small_shadow">
					<table width="100%"  height="100% "border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td height="97"><img src="<?php echo base_url('images/published_shadow_top.png');?>"/></td>
					  </tr>
					  <tr>
						<td class="publish_shad_mid">&nbsp;</td>
					  </tr>
					  <tr>
						<td height="97"><img src="<?php echo base_url('images/published_shadow_bottom.png');?>"/></td>
					  </tr>
					 </table>
				   </div><!--one_side_small_shadow-->
						<div class="cell blog_left_wrapper width_395  pr16">
							
							<div class="row"> 
							<div class="published_box_wp ">
                    		<div class="published_heading"><?php echo $this->lang->line('FirstSaved');?></div> 
                            <div class="published_date"><?php echo $FirstSaved;?></div>
                            
                             <div class="clear"></div>
                             
                            <div class="published_heading"><?php echo $this->lang->line('Expires');?></div> 
                            <div class="published_date"><?php echo $ExpiryDate;?></div>
                            
                             <div class="clear"></div>
                             
                            <div class="published_heading">Free space</div> 
                            <div class="published_date">2.45Gb</div>
                            <div class="clear"></div>
                            
                            <div class="tds-button renew_btn"> <a onmousedown="mousedown_tds_button(this)" onmouseup="mouseup_tds_button(this)" href="#"><span>Renew</span></a> </div>
                    </div><!--published_box_wp-->
                    </div>
                  <div class="seprator_10 row"></div>
							<div class="row">
								<div class="cell width_100_per"><b class="orange_color">Title</b> <span class="event_organiser_name"><?php echo getSubString($product['productTitle'], 67);?></span></div>
								</div>
		
							<div class="seprator_10 row"></div>
							<div class="row"> <b class="orange_color">								
								<?php echo $this->lang->line('project_logLineDescription');?></b>	
								<p><?php echo getSubString($product['productOneLineDesc'], 67);?></p>
								<div class="seprator_10"></div>
							<b class="orange_color"><?php echo  $this->lang->line('project_tags');?></b>
							<p><?php echo getSubString($product['productTagWords'], 125);?></p>
							</div>						
						
				</div>
				<div class="cell blog_right_wrapper">
					<div class="blog_link2_wrapper">
						<div class="post_text"></div>
						<div class="tds-button-top modifyBtnWrapper">
							
												<?php 
												if($this->uri->segment(3)!='deletedItems'){

												//$renewArr = array('title'=>'Renew','class'=>"formTip");?>
												<!--<a href="javascript:void(0);">
													<span><div class="projectRefreshIcon"></div></span>
												</a>-->
												<?php
												$editArr = array('title'=>$label['editRecord'],'class'=>"formTip");
												echo anchor('product/'.getProductCategoryName($product['catId']).'/'.$product['productId'].'/description', '<span><div class="projectEditIcon"></div></span>',$editArr);

												$previewUrl = '/product/previewProduct/'.$product['productId'].'/'.$productType;
												echo anchor('javascript://void(0);','<span><div class="projectPreviewIcon"></div></span>',array('class'=>'formTip','title'=>$label['preview'],'onclick'=>'openUserLightBox(\'productLightBoxWp\',\'productFormContainer\',\''.$previewUrl.'\',\''.encode($product['productId']).'\');'));

												//Product Delete Icon
												$attr = array("onclick"=>"DeleteAction('".encode($product['productId'])."','".$productType."')","title"=>$label['delete'],'class'=>'formTip');
												echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);
											}else{
												$restoreAttr = array("onclick"=>"restoreRecord('".$product['productId']."','".$productType."')","title"=>'Restore');
												echo anchor('javascript://void(0);','<span><div class="restoreIcon" ></div></span>',$restoreAttr);

												$deletePermanentlyAttr = array("onclick"=>"DeletePermanentlyAction('".$product['productId']."','".$productType."')","title"=>'Delete Permanently');
												echo anchor('javascript://void(0);','<span><div class="deletePermanentlyIcon" ></div></span>',$deletePermanentlyAttr);
											}?>
						</div>
						</div>
										<div class="clear"></div>
										
										

					<div class="rating_box_wrapper padding_top10">
						<?php /* Commented on 1 aug as per client's req.
						<div class="rating_box"> </div>
						<div class="rating_box"> </div>
						<div class="rating_box"> </div>
						<div class="rating_box"> </div>
						<div class="rating_box"> </div>
						*/?>
						<div class="orange">
						<?php 

						$industryName=getIndustry($product["productIndustryId"]);
							echo $industryName;
						//echo $indsArr[$insId]->IndustryName;
						?>
						</div>
					</div><!--rating_box_wrapper--> 
										<div class="clear"></div>
					<div class="blog_link3_wrapper">
						<div class="blog_link3_box">
							<div class="icon_crave2_blog"> Craves </div>
							<div class="blog_link3_point">0</div>
						</div>
						<div class="blog_link3_box">
							<div class="icon_view2_blog"> Views </div>
							<div class="blog_link3_point">0</div>
						</div>
						
						<div class="blog_link3_box">
							<div class="icon_lastview2_blog"> 
								Last Viewed<br>
								<b>01 Aug 2012</b>
							</div>
						<div class="blog_link3_box">
							<div class="icon_post2_blog lH12">Price<br>
								<b><?php echo $product['productPrice'];?></b>
							</div>
							
						</div>
						</div>
						
					</div>
									
  
				</div>
				<div class="row blog_links_wrapper">
							<?php
					if($this->uri->segment(4)!='deletedItems'){
						$currentStatus=$product['isPublished']=='t'?$this->lang->line('Publish'):$this->lang->line('hide');
						$changeStatus=$product['isPublished']=='t'?$this->lang->line('hide'):$this->lang->line('Publish');
						
						$publisButton=array('currentStatus'=>$currentStatus,'changeStatus'=>$changeStatus,'isPublished'=>$product['isPublished'],'tabelName'=>'Product','pulishField'=>'isPublished','field'=>'productId','fieldValue'=>$product['productId'],'deleteCache'=>$this->router->fetch_method(), 'view'=>'publishUnpublish');
						echo Modules::run("common/formInputField",$publisButton);
						
					}
					?>  
							<span>
						<?php 
						
							if($this->uri->segment(4)!='deletedItems'){
						 $url = base_url().$this->uri->uri_string;
						$urlToShare = encode($url);//we have pass the encoded url for security purpose
						echo Modules::run("share/shareButton",$urlToShare);
								}	
								?>
								</span>
								
									
						</div><!--blog_links_wrapper-->
				<div class="clear"></div>
				<div class="clear"></div>

			</div><!--blog_box-->
			
		</div>					<div class="shadow_blog_box"> </div>
		</div><!--width_569-->
		</div>
		</div><!-- End blog_box_wrapper -->
		</div><!-- End all_list_item -->
		<?php 
			} 
		
		} //End IF for count If no record
		else {
				$location = $productType.'/0/description';
				if($productType=='sell' && ($this->uri->segment(3)!='deletedItems')){
					echo "<div align='center' class='empty_msg_psell'>".$label['addSaleProduct1']."<a class='b' href='".$location."'>".$label['clickHere']."</a> ".$label['addSaleProduct2']."</div>";
				}else if($productType=='wanted' && ($this->uri->segment(3)!='deletedItems')){
					echo "<div align='center' class='empty_msg'>".$label['addWantedProduct1']."<a class='b' href='".$location."'>".$label['clickHere']."</a> ".$label['addWantedProduct2']."</div>";
					$location = 'product/addMoreWanted/0';
				}else if($productType=='freeStuff' && ($this->uri->segment(3)!='deletedItems')){
					echo "<div align='center' class='empty_msg_free_Stuff'>".$label['addFreeStuff1']."<a class='b' href='".$location."'>".$label['clickHere']."</a> ".$label['addFreeStuff2']."</div>";
					$location = 'product/addMoreInformation/0/'.$productType;
				}
				else if(($this->uri->segment(3)=='deletedItems'))
				{
					 echo "<span class='tac'>".$label['noRecordFound']."</span>";
				}
				else {
					$location = 'product/addMoreInformation/0/'.$productType;
				}
				
			}?>
	</div><!-- Paging Content-->
	<div class="row">
		<div class=" cell width_200 Cat_wrapper">&nbsp;</div>
		<div class="cell width_569 margin_left_16 pagingWrapper">
			<div class="row">
				<?php 
				//print_r($data);
				$data['record_num']=3;
				$count=count($products);
				if($count >3)
				{ 
			  //$this->load->view('pagination_view',$data); 
				$this->load->view('pagination_view',array('totalRecord'=>$count,'record_num'=>$this->lang->line('perPageRecord')));
				}
				?>
			</div>
		</div><!--width_569-->
	</div>

	<div class="clear"></div>
</div><!--summery_post_wrapper-->
</div>

<?php if($this->uri->segment(3)=='deletedItems'){echo '</div>';}?>

	<div class="clearfix"></div>
	<div class="productLightBoxWp" id="productLightBoxWp" style="display:none">
		<div id="close-postPreviewBox" class="tip-tr close-customAlert" original-title="Close it"></div>
		<div class="productFormContainer" id="productFormContainer"></div>
	</div>
	<div class="videoLightBoxWp" id="videoLightBoxWp" style="display:none;">
		<div id="close-productVideoBox" class="tip-tr close-customAlert" original-title="Close it"></div>
		<div class="productFormContainer1" id="productFormContainer1"></div>
	</div>

<script language="javascript" type="text/javascript">
function DeleteAction(productId,productType)
{
	var conBox = confirm(areYouSure);
	if(conBox){
		document.product.productId.value = productId;
		document.product.productType.value = productType;
		document.product.submit();
	}else{
		return false;
	}
}

function previewProduct(productId,productType)
{
	location.href=baseUrl+language+"/product/previewProduct/"+productId+"/"+productType;
}

function playSlider(productId)
{
	location.href=baseUrl+language+"/product/playSlider/"+productId;
}

function DeletePermanentlyAction(productId,productType)
{
	var conBox = confirm(areYouSure);
	if(conBox){
		location.href=baseUrl+language+"/product/deletePermanently/"+productId+'/'+productType;
	}else{
		return false;
	}
}

function restoreRecord(productId,productType)
{
	var conBox = confirm('Are you sure to restore this record?');
	if(conBox){
		location.href=baseUrl+language+"/product/restoreRecord/"+productId+'/'+productType;
	}else{
		return false;
	}
}

</script>
