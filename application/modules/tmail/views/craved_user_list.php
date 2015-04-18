<div class="serach_get_data">
<div class="poup_bx pr50 bgfafafa  shadow">
   <div class="close_btn position_absolute " id="popup_close_new_btn" onclick="$(this).parent().trigger('close');"></div>
   <h3 class="">Select Members to Tmail</h3>
   <div class="sap_35"></div>
   <div class="fl ">
      <div class="fl width192 mr20 ">
        <form action="<?php base_url_lang('tmail/getCravedUser')?>" name="craved_search" id="craved_search" method="post">
             <h4 class="pb10" >Search</h4>
             <div class="position_relative ff_arial font_weight fl">
                <input class="font_wN width170 fs13 pt4 pb4 bg_fff" type="text" name="keyWords" id="keyWords" placeholder="keyWords" value="<?php echo $keyWords; ?>" onclick="placeHoderHideShow(this,'Keywords','hide')" onblur="placeHoderHideShow(this,'Keywords','show')">
                <input class="searchbtbbg" type="submit" value="Submit" name="Submit">
             </div>
             <div class="bdr_bbb mt10 fl shadow_down  p10 bg_fff width100_per">
                <ul class="defaultP listpb5">
                    <li>
                       <input type="radio" class="fl" name="userType" value="all" <?php  echo ($userType=="all")?'checked="true"':''; ?> />
                       <span class="fl pt3"> All </span>
                    </li>
                    <li>
                       <input type="radio" class="fl" name="userType" value="creative" <?php  echo ($userType=="creative")?'checked="true"':''; ?>/>
                       <span class="fl pt3"> Creative </span>
                    </li>
                    <li>
                       <input type="radio" class="fl" name="userType" value="professionals"  <?php  echo ($userType=="professionals")?'checked="true"':''; ?>/>
                       <span class="fl pt3"> Professionals </span>
                    </li>
                    <li>
                       <input type="radio" class="fl" name="userType" value="business"  <?php  echo ($userType=="business")?'checked="true"':''; ?>/>
                       <span class="fl pt3"> Business </span>
                    </li>
                    <li>
                       <input type="radio" class="fl" name="userType" value="fans"  <?php  echo ($userType=="fans")?'checked="true"':''; ?>/>
                       <span class="fl pt3"> Fans </span>
                    </li>
                </ul>
             </div>
             <button type="submit" class="red mt15  bg_fffN">Search</button>
         </form>
         
      </div>
      <div class="fr width645 ">
         <div class="mb8 fl clearbox">
            <div class="defaultP">
               <input type="checkbox" name="selectall" id="selectall" class="selectall" />
               <span class="pl10 pt3 ">  Select All </span>
            </div>
         </div>
         <div class="selct_box_wrap  creaved_scroll clearbox" >
           
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
                                <!-- start wrap 1  -->
                                <div class="fl select_tmail shadow_ldown ">
                                   <div class="defaultP fl">
                                      <div class="width20 pb6 pt5 font_bold text_alignC">1</div>
                                      <input type="checkbox" <?php echo (in_array($crave->tdsUid,$selectedUser))?'checked="true"':""; ?>  name="creavedUser[]" value="<?php echo $crave->tdsUid ?>" useremail= "<?php echo $crave->email ?>" username="<?php echo $receiverName ?>" class="case" />
                                   </div>
                                   <div class=" display_table fl  text_alighC craved_list_tmail">
                                      <div class="table_cell"> <img alt="" src="<?php echo $userImage ?>" > </div>
                                   </div>
                                   <div class="fl mt8 mb8 width186 pl10  blc4c4c4">
                                      <div class="width100_per fl bb_d7d7 "> <span class="fs14 font_bold"><?php echo $receiverName ?></span> </div>
                                      <p class="fs13 pt3 fl"><?php echo $memberType; ?></p>
                                   </div>
                                </div>
                            <?php 
                        }
                    }
                } ?>	
            
           
        
         </div>
         <button class="red mt15 bg_fffN selecteduser">Select</button>
         <!-- End wrap 1  --> 
      </div>
   </div>
</div>
</div>
<script type="text/javascript">
    //new rendered checkbox and radio button show
    radioCheckboxRender();
    
    //selected all
    $(".selectall").click(function () {
        if($(this).is(":checked")){
            $('.case').attr('checked', 'checked');
        }else{
            $('.case').removeAttr('checked');
        }
        radioCheckboxRender();
    });
    
    //craved serach
    $("#craved_search").submit(function(){
        var fromData = $("#craved_search").serialize(); 
        $.post('<?php echo base_url_lang('tmail/getCravedUser');?>',fromData, function(data) {
                if(data){
                   $(".serach_get_data").html(data);
                }
        });
       
       return false; 
    });
    
    //selected user for tmail sending
    $(".selecteduser").click(function(){
        var isBoxSelected = false;
        var userId    = "";
        var userName  = "";
        var userEmail = "";
        $('.case').each(function(){
            if($(this).is(":checked")){
                isBoxSelected = true;
                userId +=  $(this).val()+", ";
                userName +=  $(this).attr("username")+", ";
                userEmail +=  $(this).attr("useremail")+", ";
            }
        });
        
        //set value in field
        $('#recipientsId').val(userId);
		$('#receiverMail').val(userEmail);
		$('#receiverName').val(userName);
        
        if(isBoxSelected){
            $('#popup_close_new_btn').trigger('close');
        }else{
            alert("Please selecte user.");
        }
        
    });
    
    
    
    
</script>
