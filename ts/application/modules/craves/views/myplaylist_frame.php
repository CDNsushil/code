<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
$imagetype_xs = $this->config->item('musicNaudioImage_xs');	

 if($myPlaylistData && !empty($myPlaylistData) && getMyPlaylistCount($userId)){
		$i=1;
		foreach($myPlaylistData as $k=>$myPlaylist){
			
			$thumbImage = addThumbFolder($myPlaylist['imagePath'],'_xs');	
			$elementImage=getImage($thumbImage,$imagetype_xs);	
			
			// get audio file path
			$MainFilePath 	=	$myPlaylist['filePath'].$myPlaylist['fileName'];
			
			// check media  file exist
			if(file_exists($MainFilePath)) {
			
			$getFullFilePath =  base_url($MainFilePath);
			// get rating image
			$ratingAvg=roundRatingValue($myPlaylist['ratingAvg']);
			$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';
			?>
	
				<div class="ver_contact_wp_big_playlist" id="uncrave_<?php echo $i ?>">
				<div class="ptr" onclick="gotourl('<?php echo base_url('mediafrontend/myplaylist/'.$userId);?>',1);">
					<div class="ver_contact_user_pic_box mt11 ml11">
						<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td align="center" valign="middle"><img src="<?php echo $elementImage ?>" class="max_h_41 max_w_41"  /></td>
						  </tr>
						</table>
					</div><!--ver_contact_user_pic_box-->
					<div class="crave_admin_user_data width_340px">
							<span class="orange_color crave_data_heading1 gray_clr_hover"><?php echo getSubString($myPlaylist['title'],30);?></span>
					</div><!--crave_admin_user_data-->
				</div>
					<div class="var_line_divider"></div><!--crave_admin_divider-->
			
					<div class="crave_control_box minH66">
						<div class="rating_box_crave pt18">
							<img  src="<?php echo base_url($ratingImg);?>" />
						</div>
						
						<div class="crave_cross_wp pt10">
							<div class="tds-button-top">
								<a href="javascript:void(0);">
									<span onclick="removeMusic('<?php echo $myPlaylist['entityId'] ?>','<?php echo $myPlaylist['elementId'] ?>','<?php echo $myPlaylist['tdsUid'] ?>','<?php echo $i ?>')"><div class="projectDeleteIcon"></div></span>
								</a>
							</div>
						</div><!--crave_cross_wp-->
						
						<div class="clear"></div>
							<div class="blog_link3_box bdr_non height_42">
								<div class="icon_crave2_blog admin_cravedALL"> <?php echo $this->lang->line('craves');?> </div>
								<div class="blog_link3_point font_size11 fl pl5"> <?php echo $myPlaylist['craveCount'];?> </div>
							</div>
					</div><!--crave_control_box--> 
			
				</div><!--ver_contact_wp-->
		
			<?php $i++;
			}  
		}
		
		if(isset($items_total)  && isset($perPageRecord) && $items_total >  $perPageRecord){ ?>
			 <div class="row">
				<div class="cell width_569  pagingWrapper">
					<?php $this->load->view('pagination',array("pagination_links"=>$pagination_links,"items_total"=>$items_total,"items_per_page"=>$items_per_page,"perPageRecord"=>$perPageRecord,"url"=>base_url(lang().'/craves/myplaylist/'),"divId"=>"elementListingAjaxDiv","formId"=>0,"unqueId"=>"full","isShowNumber"=>true,"isShowDD"=>true,"pagingWpaerClass"=>'pagination_wrapper new_page_design new_page_design',"pagingDDDClass"=>'left_site_dropdown m0 new_page_design new_page_design')); ?>
				</div>
					<div class="clear"></div>
			</div>
			<?php
		}
		
}else{
	echo '<div class="mt20 b black pl20 pr20">'.$this->lang->line('noRecordFound').'</div>';
}?>

