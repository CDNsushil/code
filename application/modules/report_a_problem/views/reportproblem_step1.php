<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<div class="row content_wrap" >
   <div class=" pl45 pr25  bg_f3f3f3 fl title_head ">
      <h1 class="pt10 mb0  fl">Report a Problem</h1>
   </div>
   
   
    
   <div  class="clearb display_table  pl20 pt20 pr10 ">
        <div id="next_steps"></div> 
        
        <div  id="default_option" >
            
          <div class="width780	  text_alighL table_cell verti_top wizard_wrap">
             <div class="width_635 ml86">
                <h3 class="mt8">Please tell us why the media is Abusive or Inappropriate</h3>
                <div class="sap_40"></div>
                    <?php
                        $formAttributes = array(
                            'name'=>'abuseReportOptions',
                            'id'=>'abuseReportOptions',
                        );
                        echo form_open(base_url(lang().'/report_a_problem/reportproblem_step1'),$formAttributes);
                    ?>
                    
                    <div class="pl4">
                       <div class="defaultP">
                          <span class="fl pr25">
                           <input type="radio" checked id="abusiveForm" value="6" name="abusiveComplain">
                          </span>
                          Some of the materials / content published on the website seem to be<br />
                          unacceptable based on my own personal opinion.
                       </div>
                       <div class="sap_35"></div>
                       <div class="defaultP">
                            <span class="fl pr25" >
                                <input type="radio"  id="abusiveComplain" value="3" name="abusiveComplain">
                            </span>
                          In my opinion some of the materials / content published on the website<br />
                          are illegal / inappropriate according to law.
                       </div>
                       <div class="sap_65"></div>
                       <div class="btn_wrap mt40 clearb fr display_block ">
                          <button type="button" class="bg_ededed">Cancel</button>
                          <button name="submit" type="submit" id="nextButton" class="bg_f1592a">Next</button>
                       </div>
                    </div>
                
                 <?php echo form_close(); ?>
             </div>
          </div>
           
        </div>
        <div class="terms_advert verti_top table_cell bg_f7f7f7">
            <?php 
                if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
                    //Manage right side advert
                    $bannerRhsData =  Modules::run("advertising/getAdvertRecords", array('sectionId'=>$advertSectionId,'advertType'=>'2'));
                    if(!empty($bannerRhsData)) {
                        $this->load->view('common/advert',array('bannerData'=>$bannerRhsData,'advertType'=>'2','sectionId'=>$advertSectionId)); 
                    } else {
                        $this->load->view('common/adv_rhs');
                    } 
                }else{
                    $this->load->view('common/adv_rhs');
                }
            ?>
        </div>
   </div>

</div>


<?php 
	if(is_dir(APPPATH.'modules/advertising') && !empty($advertSectionId)){
		//manage auto advert params and js methods
		echo $advertChangeView;
	} ?>	
<script type="text/javascript">
/* Function to get reason form in abuse report */	
$(document).ready(function(){
	$("#abuseReportOptions").validate({
		submitHandler: function() {
			
			var fromData=$("#abuseReportOptions").serialize(); 	
			
			$('#next_steps').html('<img  class="ma" id="loadImg" align="absmiddle" src="'+baseUrl+'images/loading_wbg.gif" />');
			$.post(baseUrl+language+'/report_a_problem/report_step2',fromData, function(data) {
				if(data){
					$('#default_option').hide();
					$('#next_steps').show();	
					$('#next_steps').html(data);		
				}
			});
		}
	});
});

/* Function to step back in abuse report option form*/	
function selection_change() {
	$('#default_option').show();
	$('#next_steps').hide();		
}	
		
</script>

          
