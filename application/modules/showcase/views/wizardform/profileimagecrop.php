<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

$baseUrl = base_url(lang().'/showcase/');
?>
<div class="poup_bx w_580 shadow fs14">
    <form action="<?php base_url_lang('showcase/profileimagecroppost') ?>" name="cropimageform" id="cropimageform" method="post">
       <div class=" position_absolute "></div>
       <h3 class="">Crop Your Profile Image</h3>
            <div class="w_580 display_table mt10  position_relative">
                <div class="table_cell">
                      <img alt="" src="<?php echo $userImage;?>" id="cropbox">
                </div>
            </div>
        <span class="fr">
        <button type="button"  class="imagecrop">Crop Image</button>
       </span> 
       
        <input type="hidden" id="x" name="x" />
        <input type="hidden" id="y" name="y" />
        <input type="hidden" id="w" name="w" />
        <input type="hidden" id="h" name="h" />
		<input type="hidden" id="dirUploadProfileMedia" name="dirUploadProfileMedia" value="<?php echo $dirUploadMedia; ?>" />
        <input type="hidden" id="imagename" name="imagename" value="<?php echo $profileImageName; ?>" />
    </form>
</div>
           
<script type="text/javascript">

  $(function(){

    $('#cropbox').Jcrop({
      aspectRatio: 1,
      minSize: [175, 175],
      maxSize: [175, 175],
       bgOpacity:   .4,
      setSelect:   [ 100, 100, 50, 50 ],
      onSelect: updateCoords,
      onChange: updateCoords
    });

  });

  function updateCoords(c)
  {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
  };

    $(".imagecrop").click(function(){
            
            //check validation
            var width =  $('#w').val();
            if(width==""){
                alert("Please select and crop  image.");
                return false;
            }
            
            var fromData = $("#cropimageform").serialize();
            var url = '<?php echo $baseUrl;?>'+'/profileimagecroppost';
            $.post(url,fromData, function(data) {
                if(data){
                   window.location.href = "<?php echo $nextUrl; ?>";
                }
            },"json");
            
            return false;
    });
  

</script>
