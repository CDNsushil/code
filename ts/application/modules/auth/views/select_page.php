<div class="poup_bx width560 shadow fshel_midum fs14">
   <div class="close_btn position_absolute " onclick="$(this).parent().trigger('close');" ></div>
   <h3 class="red fs21  text_alighC pb15"><?php echo $this->lang->line('welcome').'&nbsp;'.LoginUserDetails('firstName').'&nbsp;'.LoginUserDetails('lastName').'&nbsp;'?>  </h3>
   <div class="bdrb_afafaf"></div>
   <ul class="wilcom_pop pt10">
      <li>
         <span class="fl cnt_w">
            <h4><?php echo $this->lang->line('setshowcaseHomePage');?></h4>
            <p><?php echo $this->lang->line('setshowcaseHomePageInstruction');?> </p>
         </span>
         <span class=" defaultP">
         <input type="radio" name="type" value="1" class="ez-hide" checked="checked">
         </span>
      </li>
      <li>
         <span class="fl cnt_w">
            <h4><?php echo $this->lang->line('browseThroghSite');?></h4>
            <p><?php echo $this->lang->line('browseThroghSiteInstruction');?> </p>
         </span>
         <span class=" defaultP">
          <input type="radio" name="type" value="2" class="ez-hide">
         </span>
      </li>
      <li>
         <span class="fl cnt_w">
            <h4><?php echo $this->lang->line('checkOutTips');?></h4>
            <p> <?php echo $this->lang->line('checkOutTipsInstruction');?> </p>
         </span>
         <span class=" defaultP">
               <input type="radio" name="type" value="3" class="ez-hide">
         </span>
      </li>
      <li>
         <span class="fl cnt_w">
            <h4><?php echo $this->lang->line('whatsInMembership');?> </h4>
            <p><?php echo $this->lang->line('whatsInMembershipInstruction');?></p>
         </span>
         <span class=" defaultP">
            <input type="radio" name="type" value="4" class="ez-hide">
         </span>
      </li>
      <li>
         <span class="fl cnt_w">
            <?php echo $this->lang->line('latestUserBottomInstruction_1');?>
            <p class="underline"><?php echo $this->lang->line('latestUserBottomInstruction_2');?></p>
            <?php echo $this->lang->line('latestUserBottomInstruction_3');?>
         </span>
      </li>
   </ul>
   <span class="fl mt20 pt15"><a href="<?php echo base_url(lang().'/package/information')?>">Membership Information</a></span>
   <span class="fr"> <button type="button"  id="redirectButton"><?php echo $this->lang->line('start')?></button>
   <!--<button type="button" class="bg_ededed"   onclick="$(this).parent().trigger('close');"><?php echo $this->lang->line('cancel')?></button>-->
   </span>
</div>


<script type="text/javascript">
		
		
	$('#redirectButton').click (function (){
		
	        var val; 					
		    val =$(':radio:checked').val();	
		    
		   
		    if(!val || val=='')
		    {
				alert("You must select one option");
				return false;
				}		
					
			if(val==1) {	
				
				window.location.href = '<?php echo base_url('dashboard/loadPage/welcome_showcase');?>'; 

			} else if(val==2){
					
				window.location.href = '<?php echo base_url();?>'; 

			  } else if(val==3){
					
				  window.location.href = '<?php echo base_url('tips/front_tips');?>'; 

			    }	
			    else if(val==4){
					
				  window.location.href = '<?php echo base_url('package/information');?>'; 

			    }		
		
	});		
	
runTimeCheckBox();		
		
</script>



