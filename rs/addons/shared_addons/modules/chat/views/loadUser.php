<div class="chat_new_user" id="chat_user-<?php echo $user_id;?>">

    <div id="chatTopBar" class="rounded">
		<span class="name"><?php echo ucwords($userName);?></span>
		<a class="close_user_chat rounded" href="javascript:void(0)">x</a>
	</div>
    
    <div id="chatLineHolder">
		<?php if(!empty($data)){
			foreach($data['chats'] as $userdata){?>
			<div class="chat chat-<?php echo $userdata->chat_id;?> rounded">
				<span class="gravatar">
					<img width="23" height="23" onload="this.style.visibility='visible'" src="test">
				</span>
				<span class="author"><?php echo ucwords($userdata->authorName);?></span>
				<span class="text"><?php echo $userdata->text;?></span>
				<span class="time">13:14</span></div>
		<?php }}?>
    </div>
    
    <div id="chatBottomBar" class="rounded">
    	<div class="tip"></div>
        
        <form id="loginForm" method="post" action="">
           
        </form>
        
        <form id="submitForm" class="submitForm" method="post" action="">
            <input id="chatText" name="chatText" class="rounded" maxlength="255" autocomplete="off"/>
            <input type="hidden" value="<?php echo $user_id;?>" name="to_user_id" class="to_user_id">
         <!--   <input type="submit" class="blueButton" value="Submit" /> -->
        </form>
        
    </div>
    
</div>
