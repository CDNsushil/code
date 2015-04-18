<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

    $methodName     =   $this->uri->segment(3);
    $salesActive    =   "";
    $cartActive     =   "";
    $purchaseActive =   "";
    switch($methodName)
    {
        case 'salesinformation':
        case 'sales_order':
        case 'mysales':
             $salesActive ='class="active"'; 
        break;
        case 'sales_record':
        case 'mypurchases':
           $purchaseActive ='class="active"'; 
        break;
        default;
             $cartActive ='class="active"'; 
        break;
    }
    
?>

<ul class="dis_nav fs16 mt25 fr pr30">
    
    <?php if($wishlistCount > 0){ ?>
        <li  <?php echo $cartActive; ?>> 
            <a  href="<?php echo base_url('cart/mywishlist'); ?>" >Wish List</a>
        </li>
    <?php } ?>
    
    <?php if($purchaseCount > 0){ ?>
        <li  <?php echo $purchaseActive; ?>>
            <a href="<?php echo base_url('cart/mypurchases'); ?>" >Purchases</a>
        </li>
    <?php } ?>
    
    <?php if($salesCount > 0){ ?>
        <li  <?php echo $salesActive; ?>>
            <a  href="<?php echo base_url('cart/mysales'); ?>" >Sales</a>
        </li>
    <?php } ?>
</ul>