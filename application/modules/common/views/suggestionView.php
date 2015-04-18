<?php
$loggedUserId=isloginUser();
$userInfo = showCaseUserDetails($loggedUserId,'frontend');

//print_r($userInfo);
$beforeSuggetion=$this->lang->line('beforeSuggetionLoggedIn');
        if($loggedUserId > 0){									  							  
            
                $sendSuggestions=$this->load->view('common/send_suggestions',array('userId'=>$loggedUserId), true);
                echo "<script>var sendSuggestion =".json_encode($sendSuggestions)."</script>";
                $functionSendSuggest="if(checkIsUserLogin('".$beforeSuggetion."')){loadPopupData('popupBoxWp','popup_box',sendSuggestion)}";
            }
        
        else{
            
            
            $functionSendSuggest="openLightBox('popupBoxWp','popup_box','/auth/login','".$beforeSuggetion."')";
        }
        ?>




<a href="javascript:void(0)" onclick="<?php echo $functionSendSuggest?>"><?php echo $this->lang->line('suggestions&Requests');?> </a>             

<div class="clear"></div>
