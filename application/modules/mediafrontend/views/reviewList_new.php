<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>

    <div id="showReviews">
       <?php
        $this->load->view('mediafrontend/reviewData_new',array('result'=>$result));
        ?>
    </div>

