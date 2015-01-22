<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<?php
$totalRecords = $postQuery->num_rows();
$currentClass = $this->router->class;
if(strcmp($currentClass,'blogs')==0) $postlinkmethod = 'frontpost';
else $postlinkmethod = 'frontPostDetail';
?>
   <td class="bg_blog_container" valign="top">                
	 <div class="cell width_476 mr11 ml9 pt11 sub_col_1"  id="frontPostsInfo">
        <div class="row width_451 sub_col_middle  global_shadow_light " >  
					<div class="row post_sample_heading formTip" title="<?php echo $parentPost['postResults'][0]->postTitle;?>">					
						<?php echo $restrictedPostTitle = getSubString($parentPost['postResults'][0]->postTitle,60); ?>						
					</div>				
					
					<div id="pagingContent" >
					<?php
							if($totalRecords > 0)
							{	
								$flag =0;
									foreach($postResults as $row)
									{						
										if(LoginUserDetails('user_id') == $row->custId) $flag = 1; //give visiblity to edit delete button only if the post is posted by loggen in user
										else $flag=0
									?>
									<div class="all_list_item ">										
										<div class="row main_blog_box">
										<div class="row post_sample_heading">
											<?php echo $restrictedPostTitle = getSubString($row->postTitle,50); ?>
										</div>
										<?php										
										if(!isset($row->filePath) || @$row->filePath!=''){
											 $imagePathForPost = @$row->filePath.'/'.@$row->fileName;
											 $smallImg = addThumbFolder(@$imagePathForPost,'_s');
										}
										else $smallImg = '';

										$finalSmallImg = getImage($smallImg,$this->config->item('defaultBlogImg_s'));
										$postMediaSrc = '<img class="maxWidth165px maxHeight120px ma"  src="'.$finalSmallImg.'" alt="'.$restrictedPostTitle.'" />'."<br /><br />";
										
										?>							
										<div class="post_sample_right_box">				
											<div class="liquid_box_wrapper">												
												<table  border="0" cellspacing="0" cellpadding="0">
												<!-- TOP SHADOW IMAGE-->
												<tr>
												<td valign="top"><img src="<?php echo base_url()?>images/liquied_top1.png" /></td>
												<td class="liquid_top_mid1">&nbsp;</td>
												<td valign="top"><img src="<?php echo base_url()?>images/liquied_top3.png" /></td>
												</tr>
												<tr>
												<td class="liquid_mid1">&nbsp;</td>
												<td>
													<?php echo $postMediaSrc; ?>
												</td>
												<td class="liquid_mid2">&nbsp;</td>
												</tr>
												<!-- BOTTOM SHADOW IMAGE-->
												<tr>
												<td><img src="<?php echo base_url()?>images/liquied_bottom1.png" /></td>
												<td class="liquid_bottom_mid">&nbsp;</td>
												<td><img src="<?php echo base_url()?>images/liquied_bottom3.png" /></td>
												</tr>
												</table>
											<div class="liquid_box_shadow"></div>		
											</div><!--liquid_box_wrapper-->
										</div><!--post_sample_right_box-->

										<div class="cell summery_post_description">											
											<div class="industry_type_wrapper padding_0">
												<div class="summery_posted_date_wrapper margin_0">
													<?php echo $label['postedOn']; ?>  <b><?php echo date("l F d  Y", strtotime($row->dateCreated));?></b>
												</div><!--summery_posted_date_wrapper--->
												<div class="seprator_15"></div>

												<div class="row"><?php echo $restrictedPostOneLineDesc = getSubString($row->postOneLineDesc,130) ?></div>
												<div class="seprator_10"></div>
												<div class="row readmore"><?php echo anchor($currentClass.'/'.$postlinkmethod.'/'.$row->custId.'/'.$row->postId,'Read More ......'); ?></div>

											</div><!--industry_type_description-->
										</div> <!--summery_post_description-->
								
									<div class="clear"></div>
									</div>
									<div class="seprator_10"> </div>		
									</div><!-- End all_list_item -->
										
									<?php
								}//End For
							}//End If
							else 
							{
								echo '<div class="row main_blog_box">';
								echo '<div>';
								echo '<div class="norecordfound">'.$label['noPost'].'</div>';
								echo '</div>';
								echo '</div>';
							}
							?>
					</div><!-- End pagingContent -->
					<?php

						$post_page['record_num'] = 4;
						if($totalRecords > $post_page['record_num']) $this->load->view('pagination_view',$post_page);

					?>
					</div><!-- frontPostsInfo -->
			
		</div><!-- cell width_480 -->
		
	</td>
	<td class="bg_blog_container" valign="top">
	<?php
		$frontRightArray['userId']=$row->custId;
		$frontRightArray['blogId']=0;
		echo Modules::run("blogshowcase/frontRight",$frontRightArray);
	?>
                            
</td>


</div>
<script language="javascript" type="text/javascript">
function DeleteAction(work)
{	 
	var conBox = confirm("Are you sure you want to delete the selected record." );
	if(conBox){
		location.href = work;
	}
	else{
		return false;
	}	
}
</script>
