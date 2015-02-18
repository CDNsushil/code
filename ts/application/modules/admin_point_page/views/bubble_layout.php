<style>
.no_bubble_background
{
background:none !important;
}
</style>
<?php 
if(count($page_content) > 0 ) 
{
	echo html_entity_decode($page_content[0]->content,ENT_QUOTES, 'UTF-8');
}

?>