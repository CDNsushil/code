<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- =================Consumption Tax==================-->
<div id="consumption_tax_div" > 
    <?php $this->load->view('media/form/consumption_tax');?>	
</div>
<div id="charge_consumption_tax_div" class="dn"> 
    <?php $this->load->view('media/form/charge_consumption_tax');?>	
</div>
<div id="consumption_state_tax_div" class="dn"> 
    <?php $this->load->view('media/form/consumption_state_tax');?>	
</div>
