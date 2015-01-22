<?php 
if($this->session->userData('group') == 'admin' && $page && $page->slug != 'contact-Us'){
    $this->load->view('page_contents_form', array('pageContents'=>$page));
}
//echo $page->layout->body; 
echo $page->body; 

?>
<?php if (Settings::get('enable_comments') and $page->comments_enabled): ?>
<div id="comments">
	<div id="existing-comments">
		<h4><?php echo lang('comments:title') ?></h4>
		<?php echo $this->comments->display() ?>
	</div>
	<?php echo $this->comments->form() ?>
</div>
<?php endif ?>
