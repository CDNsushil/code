<?php 
$id=(isset($pageContents->id)) ? $pageContents->id : 0; 
$body = (isset($pageContents->body)) ? $pageContents->body : '';
?>
<span class="editTag pageContentsEdit" title="Edit"></span>
<div class="modal fade" id="pageContentsEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog content-box">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Update Page Contents</h4>
          </div>
          <form action="<?php echo base_url('home/editPageContents/');?>" id="PCform" method="post" accept-charset="utf-8">
              <div class="modal-body">
                    <div class="form-group">
                        <div class="input">
                            <?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $body, 'rows'=>10, 'cols'=>40, 'class'=>'wysiwyg-advanced', 'required'=>'required')) ?>
                        </div>
                        <br>
                    </div>
              </div>
             
              <div class="modal-footer text-center">
                  <input type="hidden" name="id" value="<?php echo $id;?>">
                 <button type="button" class="btn btn-primary col-xs-12 btn-custom" data-dismiss="modal">Close</button>
                 <button type="button" class="btn btn-primary col-xs-12 btn-custom" onclick="formValidateSubmit('#PCform','#pageContents','.close','Updated successfully',0);" >Save</button>
              </div>
         </form>
    </div>
  </div>
</div>
<script>
    function formValidateSubmit(formId,divId,close,msg,refresh){
        var description = $('#description').val();
        description = description.trim();
        if(description == undefined || description == null || description == ''){
            alert('Please make sure you have putted valid contents.');
        }else{
            postFormGetHTML(formId,divId,close,msg,refresh);   
        }
    }
</script>

