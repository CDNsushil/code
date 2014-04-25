<?php  
 /*
  * Class: Request_Rma_Block_Adminhtml_Request_Grid
  * Author: Sushil Mishra
  *  
  */
class Request_Rma_Block_Adminhtml_Request_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('requestGrid');
        // This is the primary key of the database
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
		
		
		$attributeTable = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'warranty_period')->getBackend()->getTable();
		$attributeId = Mage::getSingleton('eav/config')->getAttribute('catalog_product', 'warranty_period')->getAttributeId();

		$collection = Mage::getModel('rma/items')->getCollection();
		
		
		$customer = Mage::getSingleton("core/resource")->getTableName('customer_entity'); 
		$sales_order = Mage::getSingleton("core/resource")->getTableName('sales/order'); 
		$rma = Mage::getSingleton("core/resource")->getTableName('rma');
		$catalog_product_entity = Mage::getSingleton("core/resource")->getTableName('catalog_product_entity');
		$pName  = Mage::getResourceSingleton('catalog/product')->getAttribute('name'); 
		
		$firstname = Mage::getResourceSingleton('customer/customer')->getAttribute('firstname');     
		$lastname  = Mage::getResourceSingleton('customer/customer')->getAttribute('lastname'); 
		
		

		$collection->getSelect()
			->join(array('rma' => $rma), 'rma.id=main_table.rma_id AND rma.is_submitted=1')
			->joinLeft(
				array('c1' => $lastname->getBackend()->getTable()),
				'c1.entity_id = main_table.customer_id AND c1.attribute_id = '.(int) $lastname->getAttributeId() . '',
				 array('lastname'=>'c1.value')
			 )
			 ->joinLeft(
				array('c2' =>$firstname->getBackend()->getTable()),
				'c2.entity_id = main_table.customer_id AND c2.attribute_id = '.(int) $firstname->getAttributeId() . '',
				//array('customer_name' => "CONCAT(c2.value, ' ', c1.value)")
				array('c2.value' => 'c2.value')
			 )
			 ->joinLeft(
				array('c3' =>$customer), 'c3.entity_id = main_table.customer_id',
				array('group_id' => 'c3.group_id')
			 )
			 ->joinLeft(
				array('cpe' =>$catalog_product_entity),
				'cpe.sku = main_table.sku_number',
				array('cpe_entity_id' => 'cpe.entity_id')
			 )
			 ->joinLeft(
				array('prod' =>$pName->getBackend()->getTable()),
				'prod.entity_id = cpe.entity_id AND prod.attribute_id = '.(int) $pName->getAttributeId() . '',
				array('prod.value' => 'prod.value')
			 );
			 
			 if(is_numeric($attributeId) && $attributeId > 0){
			 
				 $collection->getSelect()->joinLeft(
					 array('attr' => $attributeTable),
					 'prod.entity_id = attr.entity_id AND attr.attribute_id = '.$attributeId.'', 
					 array('warranty_period' => 'attr.value')
				 )->joinLeft(
					array('so' =>$sales_order), 'so.entity_id = rma.order_id',
					array('pDate' => 'so.created_at')
				 );
			 }
		$this->setCollection($collection);
		return parent::_prepareCollection(); 


    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('pName', array(
            'header' => Mage::helper('rma')->__('Item'),
            'sortable' => true,
            'width' => '150',
            'index' => 'prod.value'
        ));
        $this->addColumn('customer_name', array(
            'header' => Mage::helper('rma')->__('Customer'),
            'sortable' => true,
            'width' => '150',
            'index' => 'c2.value'
        ));
        $this->addColumn('pDate', array(
            'header' => Mage::helper('rma')->__('Sold within 1 year'),
            'sortable' => true,
            'width' => '50',
            'index' => 'pDate',
            'renderer' => new Request_Rma_Block_Adminhtml_Renderer_Date(),
        ));
        
        $this->addColumn('warranty_period', array(
            'header' => Mage::helper('rma')->__('Warrenty Period'),
            'sortable' => true,
            'width' => '50',
            'index' => 'warranty_period',
            'renderer' => new Request_Rma_Block_Adminhtml_Renderer_Warranty(),
        ));
        
         $groups = Mage::getResourceModel('customer/group_collection')
            ->addFieldToFilter('customer_group_id', array('gt'=> 0))
            ->load()
            ->toOptionHash();
        $this->addColumn('group_id', array(
            'header'    =>  Mage::helper('customer')->__('Customer Type'),
            'width'     =>  '50',
            'index'     =>  'group_id',
            'type'      =>  'options',
            'options'   =>  $groups,
        ));
        
		 $this->addColumn('created', array(
			'header'=> Mage::helper('rma')->__('Request Date'),
			'sortable' => true,
			'width'=> '50px',
			'index'=> 'created',
			'type'=> 'datetime',
		));
		
        $this->addColumn('status', array(
            'header'    => Mage::helper('rma')->__('Action'),
            'align'     => 'left',
            'width'     => '100px',
            'index'     => 'status',
            'renderer' => new Request_Rma_Block_Adminhtml_Renderer_Status(),
			'filter'=> false,
			'sortable'=> false,
        ));
        
        return parent::_prepareColumns();
    }
 
    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
 
    public function getGridUrl()
    {
      return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}
