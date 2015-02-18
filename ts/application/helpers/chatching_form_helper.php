<?php
/**
 * chatching_from_helper.php
 * @author Muhit Mohidul
 */

function chatching_form_input($name, $id, $type, $class, $value = '', $custom = array())
{
    $data = array(
        'name'		=> $name,
        'id'	    => $id,
        'type'		=> $type,
        'class'		=> $class,
        'value'		=> $value,
    );
    return form_input(array_merge($data, $custom));
}
function render_autocomplete_input($defaults, $name = 'interest', $multiple = true)
{
    if(!empty($defaults))
    {
        $defaults = is_array($defaults) ? $defaults: (($multiple) ? explode(',', $defaults) : array($defaults));
        foreach($defaults as $val)
        {
            echo "<span class=\"userclass\">$val<span class=\"delUser\"></span><input class=\"txtTo\" type=\"hidden\" value=\"$val\" name=\"{$name}\"></span>";
         }
    }
}
function chatching_autocomplete_input($name, $id, $type, $class, $value = array(), $custom = array())
{

}
function chatching_set_value($group, $index, $field, $value)
{
    return isset($POST[$group][$index][$field]) ? $POST[$group][$index][$field] : $value;
}
function years_for_dropdown()
{
    $start_year['0'] = "select";
    for($j=1950;$j<=2012;$j++){
        $start_year[$j]=$j;
    }
    return $start_year;
}
/* End of file chatching_from_helper.php */
/* Location: ${FILE_PATH}/chatching_from_helper.php */ 