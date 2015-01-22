<?php defined('BASEPATH') or exit('No direct script access allowed');
$userId=is_logged_in();
$pageContents = getPageContents($slug);
$body = (isset($pageContents->body))?$pageContents->body:'';
if($this->session->userData('group') == 'admin' && $pageContents){
    $this->load->view('page_contents_form', array('pageContents'=>$pageContents));
}
?>
<div class="row" id="pageContents">
    <?php 
        $sign_up_string='<a href="register" class="btn big_btn">Sign Up Now</a>';
        if((int)$userId > 0){
            $sign_up_string=''; 
        }
        echo str_replace("variables:sign_up",$sign_up_string,$body);
    ?>
</div>
