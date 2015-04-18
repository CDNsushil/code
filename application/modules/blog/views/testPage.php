<?php /*?><script language="javascript" type="text/javascript">
$(document).ready(function(){    
			$.ajax({
			cache: false,
				success: function(html){
					$("#driver").click(function(event){
					//alert('Gurutva');
					alert(window.parent.blogOneLineDesc.value);
					$('#wysiwyg').wysiwyg('setContent', 'gurutva');
					});
				}		
			});
		});


function insertvalue(){
	window.parent.opener.document.blog.blogOneLineDesc.value="Any value";
}
</script>
<div style="background-color:#FFFFFF; border:solid #000 1px">
<img src="<?=base_url();?>/images/Radio/images1.jpg" >
<input type="button" id="driver" value="Insert" />
<input type="button" id="replace" value="Insert Self Opener" onclick="insertvalue();" />

</div><?php */?>
<html>
<head>

<script langauge="javascript">
function post_value(){
//opener.document.blog.blogTitle.value = document.frm.c_name.value;
opener.document.blog.blogOneLineDesc.value = document.frm.c_name.value;
self.close();
window.opener.location.reload()
}
</script>

<title>(Type a title for your page here)</title>
</head>


<body >

<form name="frm" method=post action=''>
<table border=0 cellpadding=0 cellspacing=0 width=250>


<tr><td align="center"> Your name<input type="text" name="c_name" size=12 value=> <input type=button value='Submit' onclick="post_value();">
</td></tr>
</table></form>