<?php
$articleInput = array(
		'id'	=> 'body',
		'name'	=> 'body',
		'class'	=> 'width556px rz required required',
		'rows' => 5,
		'cols' => 45,
		'value'=> ''
	);
$LabelAttributes = array(
'class'=>'orng width90px'
);

$formAttributes = array(
'name'=>'composeForm',
'id'=>'composeForm'
);
?>

<script type="text/javascript">
	/*
			bkLib.onDomLoaded(function() {
	var myNicEditor = new nicEditor({buttonList : ['bold','italic','underline','left','center','right','justify','ol','ul','indent','outdent','hr','subscript','superscript','link','unlink']});
	myNicEditor.panelInstance('body');
});
	*/
/* var d = new Date()
var gmtHours = -d.getTimezoneOffset()/60;
document.write("The local time zone is: GMT " + gmtHours); */

function cancelForm()
{
	//document.getElementById('NEWSForm-Content-Box').style.display = 'none';	
	document.getElementById('composeForm').reset();
	$("label.error").css("display","none");
	$("#subject").removeClass("error");
	$('#NEWS-Content-Box').slideToggle('slow');
	
}

$.validator.addMethod('cb_selectone', function(value,element){
    if(!checkCheckbox()){
		alert('Please select atlest one user to send message');
		return false;
	}else{
		return true;
	}
}, '');

$(document).ready(function(){	
$("#composeForm").validate({
				//submitHandler: function() {
				//alert('validate called');
				
				
			//}
		});	
		
		
		$(".projectToggleIcon").click(function () {

			var id =$(this).attr('id');	
				$('.projectToggleIcon').each(function(index){
					var tid =$(this).attr('toggleDivId');    

					var isd= this.id;	

					if(isd==id){
						
					   $('#'+tid).show();

					} else if(isd!=id){
						
					     $('#'+tid).hide();

					}              		          
			});	       
		});			
					
});
</script>


<div id="YesBoxWpOld" class="customAlert" style="display:none; width:260px;z-index:999999;">			
	<div class="row">
		<div class="cell mb20"><?php echo $this->lang->line('deletMsgAlert'); ?></div> 
	</div>
	<div class="row">
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteMail(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>"$(this).parent().trigger('close');",'onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div> 



<div id="YesNoBoxWp" class="customAlert" style="display:none; width:260px;">
	<div class="row">
		<div class="cell mb20"><?php echo $this->lang->line('deletMsgAlert'); ?></div> 
	</div>
	<div class="row">
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteInboxTmail(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>"$(this).parent().trigger('close');",'onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div>   



<div id="YesNoBoxWpSent" class="customAlert" style="display:none; width:260px;">
			
	<div class="row">
		<div class="cell mb20"><?php echo $this->lang->line('deletMsgAlert'); ?></div> 
	</div>
	<div class="row">
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteSentMail(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>'noGallerySent();','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div> 

<div id="YesNoBoxWpTrash" class="customAlert" style="display:none; width:260px;">
			
	<div class="row">
		<div class="cell mb20"><?php echo $this->lang->line('deletMsgAlert'); ?></div> 
	</div>
	<div class="row">
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>Yes</span>',array('onclick'=>'deleteSentTrash(\'t\');','onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
		<div class="cell ml20">
			<div class="tds-button floatRight">
				<?php echo anchor('javascript://void(0);', '<span>No</span>',array('onclick'=>"$(this).parent().trigger('close');",'onmousedown'=>'mousedown_tds_button(this);','onmouseup'=>'mouseup_tds_button(this);')); ?>
			</div>
		</div>
	</div>
</div> 






<div class="row form_wrapper">
    <div class="row">
      <div class="cell frm_heading">
        <h1>Tmail</h1>
      </div>
    
		<?php $this->load->view('tmail_common_button'); ?>
    
    
     </div>
    <div class="row tab_wp pt2">
   
   
       </div>
      <!--tab_wp-->
      <!--row-->
      <div class="clear"></div>
      <!--form_wrapper toogle frm_strip_bg-->
      <div class="clear"></div>
    </div>
    
   
    
    
    
    
    <div class="row tab_wp">
      <div class="row ">
        <div class="cell tab_left">
          <div class="tab_heading">Inbox </div>
          <!--tab_heading-->
        </div>
        <div class="cell tab_right"> 
          
     
          
          
          <div class="tab_btn_wrapper">            
            <div class="tds-button-top">
              <!-- Post Edit Icon -->            
              <a class="formTip"> <span>
              <div class="projectToggleIcon" toggleDivId="NEWS-Content-Box" onclick="viewInbox()" id='Inbox'></div>
              </span> </a> 
            </div>
          </div>
          
                 
          <div class="tds-button-inbox fr mt5 ml10"><a onmouseup="mouseout_big_button(this)" onmousedown="mousedown_big_button(this)" href="<?php echo base_url(lang().'/tmail/compose')?>"><span class="font_arial dash_link_hover">Compose
                  </span></a></div>
          
        </div>
      </div>
      <!--row-->
      <div class="clear"></div>
      <div class="form_wrapper toggle frm_strip_bg" id="NEWS-Content-Box" <?php echo ($show_div=='inbox')?'style="display:block;"':'style="display:none;"'; ?>>
      <div id="showInbox">
            <?php $this->load->view('inbox_view'); ?>
        </div>    
      </div>
      <!--tab_wp-->
      <!--row-->
      <div class="clear"></div>
      <!--form_wrapper toogle frm_strip_bg-->
      <div class="clear"></div>
    </div>
        
    
    <div class="row tab_wp">
      <div class="row ">
        <div class="cell tab_left">
          <div class="tab_heading">Sent</div>
          <!--tab_heading-->
        </div>
        <div class="cell tab_right"> 
          
          <div class="tab_btn_wrapper">
            <div class="tds-button-top">
              <!-- Post Edit Icon --> 
              <a class="formTip"> <span>
              <div class="projectToggleIcon" toggleDivId="NEWS-Content-Box2" onclick="viewSent();" id='Sent'></div>
              </span> </a>               
              </div>
          </div>
          
          
        </div>
      </div>
      <!--row-->
      <div class="clear"></div>
      <div class="form_wrapper toggle frm_strip_bg" id="NEWS-Content-Box2" <?php echo ($show_div=='sent')?'style="display:block;"':'style="display:none;"'; ?> >
        <div id="showSent"> 
          <?php $this->load->view('sent_view'); ?>        
        </div>
      </div>
      <!--tab_wp-->
      <!--row-->
      <div class="clear"></div>
      <!--form_wrapper toogle frm_strip_bg-->
      <div class="clear"></div>
    </div>
    
    
    <div class="row tab_wp">
      <div class="row ">
        <div class="cell tab_left">
          <div class="tab_heading">Trash</div>
          <!--tab_heading-->
        </div>
        <div class="cell tab_right"> 
          
          <div class="tab_btn_wrapper">
            <div class="tds-button-top">
              <!-- Post Edit Icon -->            
              <a class="formTip"> <span>
              <div class="projectToggleIcon" toggleDivId="NEWS-Content-Box3 " onclick="viewTrash();" id='Trash'></div>
              </span> </a>              
              </div>
          </div>
          
        </div>
      </div>
      <!--row-->
      <div class="clear"></div>
      <div class="form_wrapper toggle frm_strip_bg" id="NEWS-Content-Box3" <?php echo ($show_div=='trash')?'style="display:block;"':'style="display:none;"'; ?>>
		   <div id="showTrash">
				<?php $this->load->view('trash_view'); ?>       
          </div>
      </div>
      <!--tab_wp-->
      <!--row-->
      
       <div class="row">
			<div class="tab_shadow"></div>
		</div> 
      <div class="clear"></div>
      <!--form_wrapper toogle frm_strip_bg-->
      <div class="clear"></div>
    </div>
    
    <div class="seprator_5"></div>
    
    <script>

/* Reload data when click on Trash toggle */
function viewTrash(){
		
	var perPage = parseInt($("#perPageTrash").html());
			
				$.ajax
					({     
						type: "POST",
						url: "<?php echo base_url() ?>tmail/trash_view/"+perPage,																	
							
							success: function(msg)
								{																								
									$('#showTrash').html(msg);
									
								}

				 });
	
	
	
	}



/* Reload data when click on Inbox toggle */

function viewInbox() {
	  
	var perPage = parseInt($("#perPageInbox").html());			
		
		
				$.ajax
					({     
						type: "POST",
						url: "<?php echo base_url() ?>tmail/inbox_view/"+perPage,																	
							
							success: function(msg)
								{																								
									$('#showInbox').html(msg);
									
								}

				 });
	
	 runTimeCheckBox();
	}


/* Reload data when click on Sent toggle */

function viewSent () {
	 
	var perPage = parseInt($("#perPageSent").html());	
	
	//var perPage = 7;		
		
		
				$.ajax
					({     
						type: "POST",
						url: "<?php echo base_url() ?>tmail/sent_view/"+perPage,																	
							
							success: function(msg)
								{																								
									$('#showSent').html(msg);
									
								}

				 });
	
	
	}




$('.Left_side_menu ul li a').click(function(){
										   
		$(this).parent().addClass('LSM_select ');	
		$(this).parent().siblings().removeClass('LSM_select ');
		
		 })



$('.Main_btn_right a').click(function(){
						
		$(this).parent().parent().parent().addClass('Main_select ');
		$(this).parent().parent().parent().siblings().removeClass('Main_select ');
	 })
		
		
$('select').each(function(){
		var str = $(this).val();
		
		 $(this).parent().find('.abc').text(str );
	});	
	
		$('select').keyup(function(){
		var str = $(this).val();
		
		 $(this).parent().find('.abc').text(str );
	});
		
						   
	$('select').change(function(){
		var singleValues = $(this).val();	
		 $(this).parent().find('.abc').text(singleValues );
	});	
	






function mouseout_inputtmail(obj){
obj.style.backgroundPosition ='0px -0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_inputtmail(obj){
	obj.style.backgroundPosition ='-0px -33px';
	obj.firstChild.style.backgroundPosition ='right -33px';
}
















function mousedown_tds_button(obj){
obj.style.backgroundPosition ='0px -76px';
obj.firstChild.style.backgroundPosition ='right -76px';
}
function mouseup_tds_button(obj){
	obj.style.backgroundPosition ='0px -38px';
	obj.firstChild.style.backgroundPosition ='right -38px';
}

function mousedown_blog_button(obj){
obj.style.backgroundPosition ='0px -26px';
obj.firstChild.style.backgroundPosition ='right -26px';
}
function mouseup_blog_button(obj){
	obj.style.backgroundPosition ='0px -0px';
	obj.firstChild.style.backgroundPosition ='right -0px';
}









// for the category buttons

function mousedown_cat_button(obj){
obj.style.backgroundPosition ='0px -69px';
obj.firstChild.style.backgroundPosition ='right -69px';
}

function mouseovercat_button(obj){
obj.style.backgroundPosition ='0px -35px';
obj.firstChild.style.backgroundPosition ='right -35px';
}

function mouseup_cat_button(obj){
	obj.style.backgroundPosition ='0px -0px';
	obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseout_cat_button(obj){
	obj.style.backgroundPosition ='0px -0px';
	obj.firstChild.style.backgroundPosition ='right -0px';
}











// for the small buttons 

function mousedown_small_button(obj){
obj.style.backgroundPosition ='-0px -39px';
obj.firstChild.style.backgroundPosition ='right -39px';
}

function mouseover_small_button(obj){
obj.style.backgroundPosition ='-0px -20px';
obj.firstChild.style.backgroundPosition ='right -20px';
}


function mouseout_small_button(obj){
	
obj.style.backgroundPosition ='0px 0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_small_button(obj){
	obj.style.backgroundPosition ='0px -0px';
	obj.firstChild.style.backgroundPosition ='right -0px';
}



// for the big  buttons 

function mousedown_big_button(obj){
obj.style.backgroundPosition ='-0px -96px';
obj.firstChild.style.backgroundPosition ='right -96px';
}

function mouseover_big_button(obj){
obj.style.backgroundPosition ='-0px -20px';
obj.firstChild.style.backgroundPosition ='right -20px';
}


function mouseout_big_button(obj){
	
obj.style.backgroundPosition ='0px 0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_big_button(obj){
	obj.style.backgroundPosition ='0px -0px';
	obj.firstChild.style.backgroundPosition ='right -0px';
}


// for the comopose button 


function mousedown_com_button(obj){
obj.style.backgroundPosition ='-0px -61px';
obj.firstChild.style.backgroundPosition ='right -61px';
}

function mouseover_com_button(obj){
obj.style.backgroundPosition ='-0px -20px';
obj.firstChild.style.backgroundPosition ='right -20px';
}


function mouseout_com_button(obj){
	
obj.style.backgroundPosition ='0px 0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_com_button(obj){
	obj.style.backgroundPosition ='0px -0px';
	obj.firstChild.style.backgroundPosition ='right -0px';
}



function mouseout_inputtmail(obj){
obj.style.backgroundPosition ='0px -0px';
obj.firstChild.style.backgroundPosition ='right -0px';
}

function mouseup_inputtmail(obj){
	obj.style.backgroundPosition ='-0px -33px';
	obj.firstChild.style.backgroundPosition ='right -33px';
}


</script>


<script src="js/jquery.ezmark.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('.defaultP input').ezMark();
	$('.customP input[type="checkbox"]').ezMark({checkboxCls: 'ez-checkbox-green', checkedCls: 'ez-checked-green'})
});	
</script>

<script type="text/javascript">
	
	function showSpecificSection(obj,val){
		var showDiv = $(obj).attr('showDiv');
		$('.sss').each(function(index){
				$(this).hide();
		});
		$('.hm').each(function(index){
				$(this).attr('class','');
		});
		$(obj).attr('class','hm black');
		$('#'+showDiv).show();
		$('#isWrittenFileExternal').val(val);
	}	
</script>
