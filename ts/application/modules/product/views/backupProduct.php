<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/*  echo "<pre>";
	print_r($constant);
	echo "</pre>"; 
	echo "<pre>";
	print_r($products);
	echo "</pre>";  die; */
	
	
	//$this->load->helper('myupload');
	//getUploadPlugin();
?>
<div class="Main_btn_wp">
	<div class="Main_btn_box  <?php echo $productType=='sale'?'Main_select':'';?>" style="padding-left:20px;">
		<div class="Main_btn_left">
			<div class="Main_btn_right">
				<?php echo anchor('product/sale',  'Products for Sale');?>
			</div><!--Main_btn_right-->
		</div><!--Main_btn_left-->
	</div><!--main_btn_wp-->
	 <div class="Main_btn_box <?php echo $productType=='wanted'?'Main_select':'';?>">
		<div class="Main_btn_left">
			<div class="Main_btn_right">
				<?php echo anchor('product/wanted', 'Product Wanted');?>
			</div><!--Main_btn_right-->
		</div><!--Main_btn_left-->
	</div><!--main_btn_wp-->

	<div class="Main_btn_box <?php echo $productType=='freeStuff'?'Main_select':'';?>">
		<div class="Main_btn_left">
			<div class="Main_btn_right">
				<?php echo anchor('product/freeStuff', 'Free Stuff');?>
			</div><!--Main_btn_right-->
		</div><!--Main_btn_left-->
	</div><!--main_btn_wp-->
</div><!--Main_btn_wp-->

	<div class="projectSection">

		<!-- TOP NAVIGATION-->
		<div class="tds-button floatRight" > <a class="comingSoon" href="javascript:void:none" onmousedown="mousedown_tds_button(this);" onmouseup="mouseup_tds_button(this);"><span><?php echo $constant['project_newProject']?></span></a> <a class="comingSoon" href="javascript:void:none" onmousedown="mousedown_tds_button(this);" onmouseup="mouseup_tds_button(this);"><span><?php echo $constant['project_archive']?></span></a> </div>

		<div class="clearfix"> </div>

		<!-- TITLE BAR -->
			


		<!--MAIN CONTENT AREA -->
		<div class="border0 black">
			<div class="frm_wp">
				<?php
				if($products){
					foreach($products as $key=>$product)
					{
							$previeLink='product/'.$constant['project_preview'].'/'.$product['productId'];
							?>
						<div style="display:inline-table;float:left;">
							<img src="<?php echo getImage($product['productImage']);?>" alt="" width="90" />
						</div>
						<div style="display:inline-table;float:left; padding-left:5px;" >             
							<div class="title-content">
								<div class="title-content-left">
									<div class="title-content-right">
										<div class="title-content-center">
											<div class="title-content-center-label">
												<?php echo '<b>'.$constant['project_title'].'</b>';?> - <?php echo $product['productTitle']; ?>
											</div>
											<div class="tds-button-top">
												<?php 
													//Work Edit Icon
													echo anchor('javascript:void(0)', '<span><div class="comingSoon projectEditIcon" ></div></span>');						
													
													//Work Preview Icon						
													echo anchor('javascript:void(0)', '<span><div class="projectPreviewIcon   comingSoon" ></div></span>');				
													
													//Work Delete Icon
													echo anchor('javascript:void(0)', '<span><div class="projectDeleteIcon  comingSoon" ></div></span>');

												?>
											</div><!--End tds-button-top-->
											<div class="clearfix" > </div>
										</div><!--End title-content-center-label-->
									</div><!--End title-content-center-->
								</div><!--title-content-right-->
							</div><!--End title-content-left-->
						
						<div><!--Detail Section for Work Description,Tag Words,Craves etc-->
						<div style="display:inline-table;vertical-align:middle;width:432px;padding-left:5px"> 
						<?php echo $product['productOneLineDesc']; ?><br />
						<?php echo '<b>'.$constant['project_tags'].'</b>'; echo '&nbsp;'.$product['productTagWords']; ?>     
						</div>
								<div style="display:inline-table;  text-align:center; float:right; padding-top:5px;"> <!-- Start for count div -->
								<div  align="center" style="display:inline-table; width:50px;"> 
									<img class="formTip" title="Craves" height="16" width="16" alt="Craves" src="<?php echo base_url();?>images/icons/1317210972_star_red.png"><br /><?php print($product['craveCount'] == '' ? '0' : $$product['craveCount'] ); ?>
								</div>
								<div  align="center" style="display:inline-table; width:50px;"> 
									<img class="formTip" title="Views" height="16" width="16" alt="Views" src="<?php echo base_url();?>images/icons/group.png"><br /><?php print($product['viewCount'] == '' ? '0' : $product['viewCount'] );?>
								</div>
								<div align="center" style="display:inline-table; width:50px;"> 
									<img  class="formTip" title="Reviews" height="16" width="16" alt="Reviews" src="<?php echo base_url();?>images/icons/1320404576_date_previous.png"><br />
									<?php 
										$workPostedDate = date("d.m.y", strtotime($product['productDateCreated']));
										echo $workPostedDate; //work posted on date'
									?>
								</div>
								<div  align="center" style="display:inline-table; width:50px;"> 
									<img class="formTip" title="Post Count" height="16" width="16" alt="Post Count" src="<?php echo base_url();?>images/icons/unit-completed.png"><br />
									<?php 	
										$workExpiryDate = date("d.m.y", strtotime($product['productExpiryDate']));
										echo $workExpiryDate; //date on which work get expired
									?>
								</div>
						</div>
						</div><!--End title-content-->
						<div class="clearfix"></div>
						
					</div>
						<div class="clearfix"></div>
						<?php
					} //End For
				} //End IF for count If no record
				else{ 
						echo $constant['project_noRecordFound'];
					}
					?>
			</div>
		  
			  
		</div>
		<div class="clearfix"></div>




		<br/>
		<!-- PAGINATION FRAME -->
		<?php /* <div class="pagination-content">
		  <div class="pagination-content-left">
			<div class="pagination-content-right">
			  <div class="pagination-content-center">
				<div class="pagination-button"> <a href="#" class="selected"><span>1</span></a> <a href="#"><span>2</span></a> <a href="#"><span>3</span></a> <a href="#"><span>4</span></a>
				  <div class="clearfix"> </div>
				</div>
			  </div>
			</div>
		  </div>
		</div> */?>

	</div>
 <?php
/* End of file product.php */
/* Location: ./application/module/product/view/product.php */
/* Wriiten By Sushil Mishra */
?>
