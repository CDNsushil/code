<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Chatching Menu URL Helper File
 *
 * Manage active_anchor
 *
 * @Category	Helper
 * @Author		CDN Solutions
 */

if(! function_exists('active_anchor'))
{
	/**
	 * @Input: $url current url, $title menu link title, $key link url, $params additional classes
	 * @Output: Returns Menu links with active state (if match with current url)
	 * @Access: public
	 * Comment: This function takes current url and link parameters and returns links (with active if match with current url) 
	 */
    function active_anchor($url = NULL, $title = NULL, $key = NULL, $params = array())
    {
        if ($url && $key)
        {
            if($key == $url)
            {
                if (array_key_exists ('class' , $params))
                {
                    $params['class'] .= ' active';
                }
                else
                {
                    $params['class'] = 'active';
                }
            }
        }
        return anchor($key, $title, $params);
    }
}
/* End of file menu_url_helper.php */
/* Location: ./application/helpers/menu_url_helper.php */
?>