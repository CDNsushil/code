<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autoajax {
 
  function __construct()  {
    $this->ci =& get_instance();
  }
 
  function gen_output() {
    if($this->ajax() && $this->ci->input->post('auto_ajax'))  {
      $xml_string = simplexml_load_string($this->ci->output->get_output());
      $results = array();
      $elements = explode(',',$this->ci->input->post('auto_ajax'));
      foreach($elements as $element)  {
        $pieces = explode(':',$element);
        if(empty($pieces[0]))
          $query = "//*";
        else
          $query = "//".$pieces[0];
        if(count($pieces) > 1) {
          if(empty($pieces[1]))
            $query .= "[@*]";
          else
            $query .= "[@".$pieces[1]."]";
        }
        if(count($pieces) > 2) {
          if(!empty($pieces[2]))  {
            $replace = "='".$pieces[2]."']";
            $query = str_replace(']',$replace,$query);
          }
        }
        $xpath = $xml_string->xpath($query);
        foreach($xpath as $x) {
          $results[] = array(
                  'input'=>implode(':',$pieces),
                  'query'=>$query,
                  'content'=>$x->asXML()
                  );
        }
      }
      echo json_encode($results);
    } else {
      echo $this->ci->output->get_output();
    }
  }
 
  function ajax() {
    if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}
?>