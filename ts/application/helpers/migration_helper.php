<?php
if(! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Function to get carrer detail from cc_carrier table
 */
if(!function_exists('import_data'))
{
	function import_data($schema)
	{
        $query = '';
        $handle = fopen($schema, "r");
        if ($handle) {
            $CI = & get_instance();
            while (!feof($handle)) {
                $query.= fgets($handle, 4096);
                if (substr(rtrim($query), -1) == ';') {
                    $CI->db->query($query);
                    $query = '';
                }
            }
            fclose($handle);
        }
	}
}