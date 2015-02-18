<?php
if (! empty($gadget['error'])) {
  echo "<b>{$gadget['error']}</b>";
} else {
  if (! count($gadget)) {
    return;
  }

  $width = $gadget['width'];
  $view = $gadget['view'];
  $user_prefs = isset($gadget['user_prefs']) ? $gadget['user_prefs'] : array();

  // Fill in the default values of settings that haven't been 'set'
  $prefs = '';
  $settings = ! empty($gadget['settings']) ? unserialize($gadget['settings']) : array();
  foreach ($settings as $key => $setting) {
    if (! empty($key)) {
      $value = isset($user_prefs[$key]) ? $user_prefs[$key] : (isset($setting->default) ? $setting->default : null);
      if (isset($user_prefs[$key])) {
        unset($user_prefs[$key]);
      }
      $prefs .= '&up_' . urlencode($key) . '=' . urlencode($value);
    }
  }
  // Prepare the user preferences for inclusion in the iframe url
  foreach ($user_prefs as $name => $value) {
    // if some keys _are_ set in the db, but not in the gadget metadata, we still parse them on the url
    // (the above loop unsets the entries that matched
    if (! empty($value) && ! isset($appParams[$name])) {
      $prefs .= '&up_' . urlencode($name) . '=' . urlencode($value);
    }
  }
  
  // Create an encrypted security token, this is used by shindig to get the various gadget instance info like the viewer and owner
  $securityToken = BasicSecurityToken::createFromValues(
    isset($gadget['ownerid']) ? $gadget['ownerid'] : '2', // owner
    (isset($gadget['viwerid']) ? $gadget['viwerid'] : '18'),           // viewer
    $gadget['appid'],                                              // app id
    OpenappConfig::get('container'),  // domain key, shindig will check for php/config/<domain>.php for container specific configuration
    urlencode($gadget['url']),        // app url
    $gadget['mod_id'],                 // mod id
	'1'							//containerId
	);
  
     // echo "<pre>";print_r($securityToken);  echo "</pre>";die;
  $gadget_url_params = array();
  parse_str(parse_url($gadget['url'], PHP_URL_QUERY), $gadget_url_params);

  // Create the actual iframe URL, this containers a slew of query params that shindig requires to render the gadget, and for the gadget to be able to make social requests
  $iframe_url = OpenappConfig::get('gadget_server') . '/gadgets/ifr?' . "synd=" . OpenappConfig::get('container') . "&container=" . OpenappConfig::get('container') . "&viewer=" . (isset($_SESSION['user_user_id']) ? $_SESSION['user_user_id'] : '0') . "&owner=" . (isset($gadget['ownerid']) ? $gadget['ownerid'] : '2') . "&aid=" . $gadget['appid'] . "&mid=" . $gadget['mod_id'] . ((isset($_GET['nocache']) && $_GET['nocache'] == '0') || (isset($gadget_url_params['nocache']) && intval($gadget_url_params['nocache']) == 1) || isset($_GET['bpc']) && $_GET['bpc'] == '1' ? "&nocache=0" : '') . "&country=US" . "&lang=en" . "&view=" . $view . "&parent=" . urlencode("http://" . $_SERVER['HTTP_HOST']) . $prefs . (isset($_GET['appParams']) ? '&view-params=' . urlencode($_GET['appParams']) : '') . "&st=" . $securityToken->toSerialForm() . "&v=" . $gadget['version'] . "&url=" . urlencode($gadget['url']) . "#rpctoken=" . rand(0, getrandmax());

  // Create some chrome, this includes a header with a title, various button for varios actions, and the actual iframe
 //style="width:<?=$width px"
  ?>


<?php
  if ($view != 'canvas' && $view != 'preview') {
    ?> <!--<div class="gadgets-gadget-title-button-bar"><a
	href="<?php
   // echo OpenappConfig::get('web_prefix') . "/profile/application/{$vars['person']['id']}/{$gadget['id']}/{$gadget['mod_id']}"?>"
	title="View full screen"><span class="ui-icon ui-icon-carat-1-e"></span></div> --><?php
  }
  $title = ! empty($gadget['directory_title']) ? $gadget['directory_title'] : $gadget['title'];

  if ($view != 'preview' && $view != 'canvas') {
    $title = "<a href=\"" . OpenappConfig::get('web_prefix') . "/opensocial/application/".$gadget['appid']."/".$gadget['mod_id']."\">$title</a>";

    if (isset($_SESSION['id']) && $_SESSION['id'] == $vars['person']['id']) {
      if (is_object(unserialize($gadget['settings']))) {
        ?><div class="gadgets-gadget-title-button-bar"><a href="<?php echo OpenappConfig::get('web_prefix');?>/profile/appsettings/<?php echo $gadget['id']?>/<?php echo $gadget['mod_id']?>" class="gadgets-gadget-title-button"><span class="ui-icon ui-icon-wrench" /></a></div>
		<?php
      }
    } elseif (! isset($has_app) || ! $has_app )
    {
    ?><div class="gadgets-gadget-title-button-bar"><a href="<?php echo OpenappConfig::get('web_prefix'); ?>/profile/addapp?appUrl=<?php echo urlencode($gadget['url'])?>" title="Add application to your profile"><span class="ui-icon ui-icon-plus" /></span></a></div>
	<?php
    }
  }

  // Create the actual gadget element, the name and id are used by the javascript in partuza/html/js/container.js to perform the various RPC functions (set_title, set_width, set_pref and navigation)

  ?>
 <div class="gadgets-gadget-content">
		<iframe
			width="<?php echo '754';//($width - 6)?>"
        	scrolling="<?php echo $gadget['scrolling'] || $gadget['scrolling'] == 'true' ? 'yes' : 'no'?>"
        	height="<?php echo (isset($gadget['height']) && $gadget['height'] !='0' ) ? $gadget['height'] : '500'?>"
        	frameborder="no" src="<?php echo $iframe_url?>"
        	class="gadgets-gadget"
        	name="remote_iframe_<?php echo $gadget['mod_id']?>"
        	id="remote_iframe_<?php echo $gadget['mod_id']?>"></iframe> 
 
</div>
<?php
}
?>
