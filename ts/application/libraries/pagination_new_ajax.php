<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pagination_new_ajax {

    var $items_per_page;
    var $items_total;
    var $current_page;
    var $num_pages;
    var $mid_range = 3;
    var $low;
    var $limit;
    var $offst;
    var $return;
    var $default_ipp;
    var $querystring;
    var $ipp_array;

    function Pagination_new_ajax()
    {
        $this->current_page = 1;
        //$this->mid_range = 3;
        $this->ipp_array = array(5,10,20,30,40,50,100,'All');
        $this->items_per_page = (isset($_REQUEST['ipp']) && $_REQUEST['ipp'] > 0) ? $_REQUEST['ipp']:$this->default_ipp;
    }

    function paginate($isShowButton=true,$isShowNumbers=true)
    {
        if(!isset($this->default_ipp)) $this->default_ipp=10;
        if(isset($_REQUEST['ipp']) && $_REQUEST['ipp'] == 'All')
        {
            $this->num_pages = 1;
        }
        else
        {
            if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
            $this->num_pages = ceil($this->items_total/$this->items_per_page);
        }
        $this->current_page = (isset($_REQUEST['page'])) ? (int) $_REQUEST['page'] : 1 ; // must be numeric > 0
        $prev_page = $this->current_page-1;
        $next_page = $this->current_page+1;
        if($_REQUEST)
        {
            $args = explode("&",$_SERVER['QUERY_STRING']);
            foreach($args as $arg)
            {
                $keyval = explode("=",$arg);
                if($keyval[0] != "page" And $keyval[0] != "ipp") $this->querystring .= "&" . $arg;
            }
        }

        if($_POST)
        {
            foreach($_POST as $key=>$val)
            {
                if($key != "page" And $key != "ipp") $this->querystring .= "&$key=$val";
            }
        }
        if($this->num_pages > 1)
        {
            if($isShowButton){
                $this->return ="<span class=\"prev butn_n ".$disableButton." \">";
                                            $disableButton=($this->current_page > 1 And $this->items_total >= $this->items_per_page) ?'':'disable_btn inactive';
                                            $isPrevDisabled=($this->current_page > 1 And $this->items_total >= $this->items_per_page) ?0:1;
                $this->return .= "<a data-isdisabled=\"$isPrevDisabled\" data-page=\"$prev_page\" data-ipp=\"$this->items_per_page\" class=\"paginate\" href=\"javascript://void(0)\">Prev</a>";
                $this->return .="</span>";
           }
           if($isShowNumbers){
                $this->return .="<span class=\"table_cell \">";
                $this->start_range = $this->current_page - floor($this->mid_range/2);
                $this->end_range = $this->current_page + floor($this->mid_range/2);

                if($this->start_range <= 0)
                {
                    $this->end_range += abs($this->start_range)+1;
                    $this->start_range = 1;
                }
                if($this->end_range > $this->num_pages)
                {
                    $this->start_range -= $this->end_range-$this->num_pages;
                    $this->end_range = $this->num_pages;
                }
                $this->range = range($this->start_range,$this->end_range);

                for($i=1;$i<=$this->num_pages;$i++)
                {
                    //if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= " ... ";
                    if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
                    {
                        //$this->return .= ($i == $this->current_page And @$_REQUEST['page'] != 'All') ? "<a data-isdisabled=\"1\" data-page=\"$i\" data-ipp=\"$this->items_per_page\" class=\"current Page_cont cont_sel\" href=\"javascript:void(0);\">$i</a> ":"<a data-isdisabled=\"0\" data-page=\"$i\" data-ipp=\"$this->items_per_page\" class=\"paginate Page_cont\" href=\"javascript:void(0);\">$i</a> ";
                        $this->return .= ($i == $this->current_page And @$_REQUEST['page'] != 'All') ? "<a data-isdisabled=\"1\" data-page=\"$i\" data-ipp=\"$this->items_per_page\" class=\" pagingActiveTab\" href=\"javascript:void(0);\"><span class=\" pagination\">$i</span></a> ":"<a data-isdisabled=\"0\" data-page=\"$i\" data-ipp=\"$this->items_per_page\" class=\"pagingButton\" href=\"javascript:void(0);\"><span class=\" pagination\">$i</span></a> ";
                    }
                    //if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= " ... ";
                }
                
                $this->return .="</span>";
          }
          if($isShowButton){ 
            
            $disableButton=(($this->current_page < $this->num_pages And $this->items_total >= $this->items_per_page) And (@$_REQUEST['page'] != 'All') And $this->current_page > 0) ?'':'disable_btn inactive';
            $isNextDisabled=(($this->current_page < $this->num_pages And $this->items_total >= $this->items_per_page) And (@$_REQUEST['page'] != 'All') And $this->current_page > 0)?0:1;
          
            $this->return .="<span class=\" butn_n next ".$disableButton."\">";
            
            $this->return .= "<a data-isdisabled=\"$isNextDisabled\" data-page=\"$next_page\" data-ipp=\"$this->items_per_page\" class=\"paginate\" href=\"javascript://void(0)\" id=\"nextButton\"> Next </a>\n";
            $this->return .="</span>";
          }
        }
        else
        {
            $this->return = "";
            /*for($i=1;$i<=$this->num_pages;$i++)
            {
                $this->return .= ($i == $this->current_page) ? "<a data-page=\"$i\" data-ipp=\"$this->items_per_page\" class=\"current Page_cont cont_sel\" href=\"javascript:void(0);\">$i</a> ":"<a data-page=\"$i\" data-ipp=\"$this->items_per_page\" class=\"paginate Page_cont\" href=\"javascript:void(0);\">$i</a> ";
            }*/
        }
        $this->low = ($this->current_page <= 0) ? 0:($this->current_page-1) * $this->items_per_page;
        if($this->current_page <= 0) $this->items_per_page = 0;
        $this->limit = (isset($_REQUEST['ipp']) && $_REQUEST['ipp'] == 'All') ? "":" $this->items_per_page";
        $this->offst = (isset($_REQUEST['ipp']) && $_REQUEST['ipp'] == 'All') ? "":" $this->low";
    }
    function display_items_per_page(){
        return "";
    }
    function display_jump_menu(){
       return "";
    }
    function display_pages(){
        return $this->return;
    }
}
