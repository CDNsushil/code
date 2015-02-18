<div class="contentcontainer">
    <div class="headings altheading">
        <h2><?php echo $this->lang->line('manage_vulgar') ?></h2>
    </div>

    <div class="contentbox">
        <div class="fRight"></div>
        <div class="clear"></div>
        
        <h3><?php echo $vulgar->language ?></h3>
        <br>
        <p><font style="color:red;">Important!</font> Between words insert comma and space, example: "word1, word2, word3"</p>
        
        <form action="" method="post">
            <textarea name="words" style="width:95%; height:300px;"><?php echo $vulgar->words ?></textarea>
            <br>
            <input type="submit" value="Save" style="font-size: 16px;"/>
        </form>
        
    </div>
    <div class="fRight"></div>
</div>

