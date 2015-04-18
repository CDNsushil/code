<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<div class="right_box pl34 fl  width688" id="searchResultDiv">
    <?php
    if(is_array($craves) && !empty($craves)){
        $this->load->view('showcase/showcase/cravingme_list');
    }else{
        echo '<p>No Record Found.</p>';
    }?>
</div>
