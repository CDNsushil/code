<?php
if(isset($record_num) && $record_num>0)
$perPageRecord = $record_num;
else
$perPageRecord = $this->lang->line('perPageRecord');
?>
<div class="clearfix"></div>
<div class="clearfix"></div>
<!-- PAGINATION FRAME -->
<div class="row">
<div class="pagination_wrapper">	
		
   <div id="pagination-button" class="pagination-button"></div>
   
</div> <!--pagination_wrapper-->

<div class="left_site_dropdown dn">
                <div class="right_site_dropdown dd_desiable">
                  <div class="result_per_page_box">Results per page</div>
                  <div class="bg_sel" > <span class="abc">00</span>
                    <select id="myselect" class="single" name="myselect2" onChange="showNoRecord(this.value)"  >
                      <option selected="selected" >01</option></select>
                  </div> <!--bg_sel-->
                  
                </div> <!--right_site_dropdown-->
                
              </div> <!--right_site_dropdown-->

</div> <!--row-->

<script type="text/javascript">
	var pager = new Imtech.Pager();
	$(document).ready(function() {
			pager.paragraphsPerPage = <?php echo $perPageRecord;?>; 
			pager.pagingControlsContainer = "#pagination-button"; // set amount elements per page
			pager.pagingContainer = $('#pagingContent'); // set of main container
			pager.paragraphs = $('.all_list_item', pager.pagingContainer); 
			pager.pagingContainerPath	= "#pagingContent";// set of required containers
			pager.showPage(1);
	});
	
	
	/**
	  * Show no of records per page 
	  * @return void
	**/
	function showNoRecord(siz){
	     pager.perPage(siz);
     }
    
    /**
	  * Select box 
	  * 
	**/
    
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
    
   	
</script>
