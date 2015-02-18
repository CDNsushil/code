<div class=" cell frm_element_wrapper pl12 ">
<div id="pagingContent">

<?php $count = 0; 

if(!empty($contactList)) {

foreach($contactList as $value)
{

$cont_id[] = $value['contId'];	
}

//print_r($cont_id);

$comma_separated = implode(",", $cont_id);

//echo $comma_separated;


	$count=count($contactList);
	
		foreach($contactList as $contacs) { 
			
	
	
		
			?>
		

		<div class="all_list_item">
			<div class="ver_contact_wp" style="cursor:pointer;" id="<?php echo $contacs['contId'];?>">
              	
                <?php 
                $profile_img = getContactUserProfileImage($contacs['emailId']);
                if($profile_img['ContactUserProfileImage']!="")
                {
					$user_image = getDefaultProfileTypeImage(@$contacs['UserContactId'],$profile_img['ContactUserProfileImage']);			
					?>
				<div class="ver_contact_user_pic_box">
					<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                  <td align="center" valign="middle"><a href="<?php echo base_url(); ?>showcase/index/<?php echo $contacs['contId']; ?>"><img src="<?php echo $user_image;?>" class="max_h_41 max_w_41"  /></a></td>
                      </tr>
                    </table>
					</div><!--ver_contact_user_pic_box-->
					<?php 
				}
				else
				{
					?>
					<div class="default_orange_user">
					<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                  <td align="center" valign="middle"><a href="<?php echo base_url(); ?>showcase/index/<?php echo $contacs['contId']; ?>"><img src="<?php echo base_url();?>images/var_user_img_default2.jpg" class="max_h_41 max_w_41" /></a></td>
                      </tr>
                    </table></div><!--default_orange_user-->
					<?php
				}
                ?>
                
                <div class="var_name_wp" onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $contacs['contId'].",".$comma_separated; ?>')">
					<div class="var_name_label">First Name</div><!--var_name_label-->                        
					<div class="var_name"><?php echo $contacs['firstName'];?></div><!--var_name_label-->                        
                </div><!--var_name_wp--> 
                
              
                <div class="var_lastname_wp" onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $contacs['contId'].",".$comma_separated;?>')">
					<div class="var_name_label">Last Name</div><!--var_name_label-->                        
					<div class="var_name"><?php if($contacs['lastName'] !=''){ echo $contacs['lastName'];}else {echo '&nbsp;';} ?></div><!--var_name_label-->                        
                </div><!--var_name_wp--> 
              
                
                <div class="var_mail_wp" onclick="openLightBox('contactBoxWp','contactContainer','/messagecenter/getUserContactDetail_forsearch/<?php echo $contacs['contId'].",".$comma_separated; ?>')">
					<div class="var_name_label">Email</div><!--var_name_label-->                        
					<div class="var_name"><?php echo $contacs['emailId'];?></div><!--var_name_label-->                        
                </div><!--var_name_wp--> 
                
                
                <div class="var_line_divider"></div><!--var_line_divider-->                
                
                <div class="tds-button-top" style="margin-top:7px; margin-right:3px;">
              <!-- Post Edit Icon -->
              
                  <!--<a class="mr6" href="#"><span><div class="projectEditIcon"></div></span></a>     
            
              <a class="mr6" href="#"><span><div class="projectDeleteIcon"></div></span></a>-->
               
              <?php
              $contId = $contacs['contId'];
							$editArr = array('title'=>'edit',
							'class'=>"formTip contId mr6",
							'id'=>"contId", 
							'firstName'=>$contacs['firstName'], 
							'lastName'=> $contacs['lastName'], 
							'emailId'=>$contacs['emailId'], 
							'profession'=>$contacs['profession'], 
							'company'=> $contacs['company'], 
							'toadsquareUrl'=> $contacs['toadsquareUrl'], 
							'address'=> $contacs['address'], 
							'phone'=>$contacs['phone'],
							"onclick"=>"populate(this)",
							'contId'=>$contacs['contId']
							);
							echo anchor('javascript://void(0);', '<span><div class="projectEditIcon"></div></span>',$editArr);

								$attr = array("title"=>'delete',"class"=>'formTip mr6',"onclick"=>"deleteRecord('".$contacs['contId']."')");

								echo anchor('javascript://void(0);','<span><div class="projectDeleteIcon"></div></span>',$attr);
							?>
            
          
              </div>
              
             </div><!--ver_contact_wp-->
             </div><!--all_list_item-->
<?php 
		} 
	}
	else 
	{ 
		//echo "<div align='center'>No record found</div> ";
	}
	?>                
                
</div><!--pagingContent-->                	
</div><!-- cell frm_element_wrapper pl12 -->

<?php //if(count($contactList) > 10) { $data['record_num'] = 10;
//$this->load->view('pagination_view',$data); } ?>
<input type="hidden" name="idToDelete" id='idToDelete' value="0" />
<?php //form_close();?>

<script type="text/javascript">
	$(".search_btn").click(function(){
		var search_text = $('#search_text_box').val();
			if(search_text == "")
			{
				alert('Please Enter a search term!');
				return false;
			}
			else
			{
				getSearchedList(search_text);
				return false;
			}
			return false;			
		}).css("cursor","pointer");
	
	$('#search_text_box').keypress(function(e) {
		if(e.which == 13) {
			var search_text = $('#search_text_box').val();
			if(search_text == "")
			{
				alert('Please Enter a search term!');
				return false;
			}
			else
			{
				getSearchedList(search_text);
				return false;
			}
			return false;			
		}
	});
	
function getSearchedList(letter)
{
	var letter = letter;
	$('#NEWSForm-Content-Box').slideUp('slow');
   $.post("<?php echo base_url();?>en/messagecenter/searchedContacts/", { letter: letter },
	 function(data){
	   if (data!='error') {
		   $("div#sorted_data").html(data);
			//$("#resultAjax").html(data);
			
	   }
	   else {
     alert("Process Error! Please try again.");	} 
   });
}
	
	function deleteRecord(id)
	{
		var base_url = "<?php echo base_url();?>";
		var conBox = confirm(areYouSure);
		if(conBox){
			$('#NEWSForm-Content-Box').slideUp('slow');
			$('#idToDelete').val(id);
			//document.listForm.submit();
			var parent = $("div#"+id);
			$.ajax
			({
				type: "GET",
				url: base_url+'en/messagecenter/deleteContact/'+id,
				async:false,
				success: function(msg)
				{	
					parent.fadeOut('500');	
					$("div#messageSuccessError").addClass('successMsg').css('display','block').text(msg);	
					setTimeout(function(){$("div#messageSuccessError").removeClass('successMsg').text('').css('display','block').fadeOut('1000');},4000);			
				}
			});
						
		}else{
			return false;
		}
	}
</script>


<div class="row">
	<div class="label_wrapper cell bg-non" style="height:25px"> </div>
<?php
if($count >  $this->lang->line('perPageRecord')){?>
	<div class=" cell frm_element_wrapper pl12 pt0 width_579 "  style="min-height:32px">
         	<div class="row mt25 mb25 mH25" style="min-height:30px">
				<?php
				$this->load->view('pagination_view',array('totalRecord'=>$count,'record_num'=>$this->lang->line('perPageRecord')));
				?>
			</div>
	</div>
	<?php
}?>
</div>

</div><!--sorted_data-->
<?php
/*
<div class="row">
          <div class="label_wrapper cell bg-non" style="height:25px"> </div>
          <!--label_wrapper-->
         <div class=" cell frm_element_wrapper pl12 pt0 "  style="min-height:32px">
         	<div class="row mt25 mb25" style="min-height:30px">
              <div class="pagination_wrapper">
                <div class="btn_prev_wrapper">
                  <div class="btn_prev"><a>Prev</a> </div>
                </div>
                <div class="pagination_mid">
                  <div class="no_box select_no"> <a>1</a> </div>
                  <!--no_box-->
                  <div class="no_box"> <a>2</a> </div>
                  <!--no_box-->
                  <div class="no_box margin-right0"> <a>3</a> </div>
                  <!--no_box-->
                </div>
                <!--pagination_mid-->
                <div class="btn_next_wrapper">
                  <div class="btn_next"> <a>Next</a></div>
                </div>
              </div>
              <!--pagination_wrapper-->
              <div class="left_site_dropdown">
                <div class="right_site_dropdown">
                  <div class="result_per_page_box">Results per page</div>
                  <div class="bg_sel" > <span class="abc">All</span>
                    <select id="myselect" class="single" name="myselect2"  >
                      <option selected="selected" >10</option>
                      <option  >20</option>
                      <option >30</option>
                    </select>
                  </div>
                  <!--bg_sel-->
                </div>
                <!--right_site_dropdown-->
              </div>
              <!--right_site_dropdown-->
            </div>
         </div><!--frm_element_wrapper-->
         
       <div class="clear"></div>
        </div>
      </div>
      <!--tab_wp-->
      <!--row-->
*/
?>

<div class="clear"></div>
</div>  <!--form_wrapper toogle frm_strip_bg-->
 
    </div>
<div class="row">

</div>

