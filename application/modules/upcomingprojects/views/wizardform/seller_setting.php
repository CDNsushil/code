<?php if (!defined('BASEPATH')) exit('No direct script access allowed');?>
<!-- =================Consumption Tax==================-->
<div id="consumption_tax_div" > 
    <?php $this->load->view('upcomingprojects/wizardform/consumption_tax');?>	
</div>
<div id="charge_consumption_tax_div" class="dn"> 
    <?php $this->load->view('upcomingprojects/wizardform/charge_consumption_tax');?>	
</div>
<div id="consumption_state_tax_div" class="dn"> 
    <?php $this->load->view('upcomingprojects/wizardform/consumption_state_tax');?>	
</div>
