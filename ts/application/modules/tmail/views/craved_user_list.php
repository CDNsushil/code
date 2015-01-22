	<div id="cravedList">
		<div class="popup_box">
	     <div onclick="$(this).parent().trigger('close');" class="popup_close_btn" id="popup_close_btn"></div>

		<div class="popup_gredient ">		

			<div class="row pt2 ">
				<div class="row ">
			<div class="cell tab_left width_202">
	<div class="tab_heading_global">Members Craving Me</div>
	<!--tab_heading-->
	</div>
		<div class="cell tab_right width_590">
			<div class="my_carve_bdc_box_new mt9 pl32">
				<a href="javascript:void(0);" id="A" onclick="getSortedUserList('A')">A</a>
				<a href="javascript:void(0);" id="B" onclick="getSortedUserList('B')">B</a>
				<a href="javascript:void(0);" id="C" onclick="getSortedUserList('C')">C</a>
				<a href="javascript:void(0);" id="D" onclick="getSortedUserList('D')">D</a>
				<a href="javascript:void(0);" id="E" onclick="getSortedUserList('E')">E</a>
				<a href="javascript:void(0);" id="F" onclick="getSortedUserList('F')">F</a>
				<a href="javascript:void(0);" id="G" onclick="getSortedUserList('G')">G</a>
				<a href="javascript:void(0);" id="H" onclick="getSortedUserList('H')">H</a>
				<a href="javascript:void(0);" id="I" onclick="getSortedUserList('I')">I</a>
				<a href="javascript:void(0);" id="J" onclick="getSortedUserList('J')">J</a>
				<a href="javascript:void(0);" id="K" onclick="getSortedUserList('K')">K</a>
				<a href="javascript:void(0);" id="L" onclick="getSortedUserList('L')">L</a>
				<a href="javascript:void(0);" id="M" onclick="getSortedUserList('M')">M</a>
				<a href="javascript:void(0);" id="N" onclick="getSortedUserList('N')">N</a>
				<a href="javascript:void(0);" id="O" onclick="getSortedUserList('O')">O</a>
				<a href="javascript:void(0);" id="P" onclick="getSortedUserList('P')">P</a>
				<a href="javascript:void(0);" id="Q" onclick="getSortedUserList('Q')">Q</a>
				<a href="javascript:void(0);" id="R" onclick="getSortedUserList('R')">R</a>
				<a href="javascript:void(0);" id="S" onclick="getSortedUserList('S')">S</a>
				<a href="javascript:void(0);" id="T" onclick="getSortedUserList('T')">T</a>
				<a href="javascript:void(0);" id="U" onclick="getSortedUserList('U')">U</a>
				<a href="javascript:void(0);" id="V" onclick="getSortedUserList('V')">V</a>
				<a href="javascript:void(0);" id="W" onclick="getSortedUserList('W')">W</a>
				<a href="javascript:void(0);" id="X" onclick="getSortedUserList('X')">X</a>
				<a href="javascript:void(0);" id="Y" onclick="getSortedUserList('Y')">Y</a>
				<a href="javascript:void(0);" id="Z" onclick="getSortedUserList('Z')">Z</a>
				<a href="javascript:void(0);" id="all" onclick="getSortedUserList('#')">#</a>
			</div>
		</div>

	</div>
	<!--row-->
	<div class="clear"></div>

	<div class="form_wrapper toggle pr5 minHeight500px"  id="NEWS-Content-Box2" >
		<div class="shadow_wp strip_absolute">
			<table width="100%" cellspacing="0" cellpadding="0" border="0" height="100%">
				<tbody>
					<tr>
						<td height="271"><img src="<?php echo base_url('images/shadow-top.png')?>"></td>
					</tr>
					<tr>
						<td class="shadow_mid">&nbsp;</td>
					</tr>
					<tr>
						<td height="271"><img src="<?php echo base_url('images/shadow-bottom.png')?>"></td>
					</tr>
				</tbody>
			</table>
		</div>

	<div class="row">
	<div class="tab_shadow tab_shadow_g"> </div>
	</div>

	<div class="shadow_sep row"> </div>
	<div class="clear"></div>
	<div class="seprator_10"> </div>

	<div class="row">

	<div class="cell"> <div class="search_box_wrapper ml20 wp_serch_box_wrapper">
<input id="searchCraveUser" type="text" name="searchCraveUser" class="search_text_box" value="<?php echo $this->lang->line('searchMembers');?>" placeholder="<?php echo $this->lang->line('searchMembers');?>" onclick="placeHoderHideShow(this,'<?php echo $this->lang->line('searchMembers');?>','hide')" onblur="placeHoderHideShow(this,'<?php echo $this->lang->line('searchMembers');?>','show')">		
	
	<div class="search_btn" onclick="getCravedSortedList();"> <img src="<?php echo base_url('images/btn_search_box.png')?>"> </div>
	</div></div>

	<div class="cell mr12 pl10">

	<?php
	if(isset($cravedList) && is_array($cravedList)  && count($cravedList) > 0 ){
		//echo "<pre>";
		//print_r($cravedList);die;
		foreach ($cravedList as $crave){ 
			if($crave->active!=2 && $crave->banned!=1){
				$creative=$crave->creative;
				$associatedProfessional=$crave->associatedProfessional;
				$enterprise=$crave->enterprise;
				
				$receiverName = $crave->firstName.' '. $crave->lastName;

				$getUserShowcase = showCaseUserDetails($crave->tdsUid);
				
				$isShowcaseCreated=true;
				
				if($crave->isPublished != 't'){
					$isShowcaseCreated=false;
					$imageType=$this->config->item('defaultMemberImg_xxs');
					$memberType='Member';
				}
				elseif($creative == 't'){
					$imageType=$this->config->item('defaultCreativeImg_xxs');
					$memberType='Creative';
				}elseif($associatedProfessional ==  't'){
					$imageType=$this->config->item('defaultAssProfImg_xxs');
					$memberType='Associated Professional';
					
				}elseif($enterprise == 't'){
					$imageType=$this->config->item('defaultEnterpriseImg_xxs');
					$receiverName = $crave->enterpriseName;
					$memberType='Enterprise';
					
				}else{
					$isShowcaseCreated=false;
					$imageType=$this->config->item('defaultMemberImg_xxs');
					$memberType='Member';
					
				}
				
				if($getUserShowcase['userImage']!='') {
								 $userImage=$getUserShowcase['userImage'];
								}
								$userImage=addThumbFolder($userImage,$suffix='_xxs',$thumbFolder ='thumb',$imageType);  	
								$userImage=getImage($userImage,$imageType);
						
				?>
				

				<a href="javascript://void(0)" onclick ="setValue('<?php echo $crave->tdsUid ?>','<?php echo $crave->email ?>','<?php echo $receiverName ?>');" >		
				<div class="search_result_list_wrapper ml2 bg_SRCreative mb10 minH60">
				<div class="bg_white pt2 pb2 pl2 pr2">
				<div class="bg_3e3e3e minH60">
				<div class="fl width_126 bdrR_fff height_60">
				<div class="cell recent_thumb_PApage thumb_absolute01">
				<div class="AI_table">
				<div class="AI_cell"> <img class="mH30 bdr_cecece max_w34_h41" src="<?php echo $userImage ?>"></div>
				</div>
				</div>
				</div>
				<div class="fl width_427 ml2">
				<div class="bdr_f15921 font_opensansSBold clr_white ml12 mr17 pt3 pb3">
				<div class="fl font_size14 width250px"><?php echo $receiverName ?></div>
				<div class="fr font_size12"><?php echo $memberType; ?></div>
				<div class="clear"></div>
				</div>

				<div class="seprator_7"></div>

				<div class="grdfor_cravepopup height_24 width_auto pl40">
					<?php
					if($isShowcaseCreated){
						 ?>
						<div class="fl">
							<div class="btn_review_icon mt3 fl"></div>
							<div class="mt3 fl"><?php echo $crave->reviewCount ?></div>
						</div>

						<span class=" cell blogS_view_btn mt3 ml15"><?php echo $crave->viewCount ?></span>
						<div class="cell blogS_crave_btn craveDiv49255 cravedALL mt3 minw_auto"><?php echo $crave->craveCount ?></div>

						<div class="fl ml5 mt4 ml10">
							<div class="cell mt5">
								<?php

								$ratingAvg = roundRatingValue($crave->ratingAvg);									 
								$ratingImg='images/rating/rating_0'.$ratingAvg.'.png';?>  

								<img  src="<?php echo base_url($ratingImg);?>" />																			

							</div>
						</div>

					<div class="fr mt2 mr14 font_opensansSBold clr_444 font_size13"><?php echo $labEl ?></div>
					<?php
				}
					 ?>
				</div>

				</div>
				</div>
				</div>
				</div>
				</a>		 
				<?php 
			}
		}
	} else { ?>	

	<div class="nocravebg nocravbg_commonshedow ml10"> 
	<div class="nocravebg_inner">
	<div class="font_opensansSBold font_size24 clr_f1592a bdrB_878688 width_267 mt22 ml160">No Record Found</div>
	</div>

	<div class="nocravebg_btm">
	</div>
	</div>

	<?php } ?>



	</div>              

	<div class="clear"></div>         
	</div>




	<!--from_element_wrapper-->

	</div> <!--tab_wp-->

	</div>


	</div> <!-- popup_gredient -->
	</div> <!-- popup_box -->
 </div>  
  <script type="text/javascript">
	 // SET VALUES IN COMPOSE FORM 
	function setValue(id,mail,name){		
		$('#recipientsId').val(id);
		$('#receiverMail').val(mail);
		$('#receiverName').val(name);
		$('#popup_close_btn').trigger('close');	
		
	}
	// GET SORTED LIST	
	function getSortedUserList(val){		
				
		if(!val || val =='<?php echo $this->lang->line('searchMembers'); ?>'){
			val = '';
		}
		var letter = val.toLowerCase();				
			$.ajax
			({     
				type: "POST",
				url: "<?php echo base_url() ?>tmail/getCravedUser/"+letter,
				
				success: function(msg){ 
					
					$('#cravedList').html(msg);
					$(".active").removeClass("active");			

					if(val!="#")  { 
					  $("#"+val).addClass("active");
					}

				}
			});			
	}	
	function getCravedSortedList(){
		var val =$('#searchCraveUser').val();
		
		if(!val || val =='<?php echo $this->lang->line('searchMembers'); ?>'){
			val = '';
		}		
				
		var letter = val;				
			$.ajax
			({     
				type: "POST",
				url: "<?php echo base_url() ?>tmail/getCravedUser/"+letter,
				
				success: function(msg){ 
					
					$('#cravedList').html(msg);
					$(".active").removeClass("active");			

					if(val!="#")  { 
					  $("#"+val).addClass("active");
					}

				}
			});			
	}		
  </script>
