<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>

<div class="row form_wrapper">
	
	<?php echo $this->load->view('advertHeader',array('campaignId'=>$campaignId)); ?>
	
	<div class="row position_relative">	
			
		<?php $this->load->view("common/strip");
			
			// load advert form view
			$dataAdvert = array('arraryData'=>$arrayData);
			echo $this->load->view('advertsForm',$dataAdvert); 
			 
			// load upload advert form view 
			echo $this->load->view('uploadAdvertList',$dataAdvert); 
		?>  
	</div>
</div>


