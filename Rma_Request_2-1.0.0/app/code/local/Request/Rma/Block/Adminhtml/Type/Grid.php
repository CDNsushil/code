<?php 
 
class Request_Rma_Block_Adminhtml_Type_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('typeGrid');
        // This is the primary key of the database
        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
 
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('rma/type')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
 
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('adminhtml')->__('ID'),
            'sortable' => true,
            'width' => '60',
            'index' => 'id'
        ));
        
        $this->addColumn('type', array(
            'header' => Mage::helper('adminhtml')->__('Type'),
            'sortable' => true,
            'width' => '60',
            'index' => 'type',
            'type'  => 'text'
        ));
 
       
        $this->addColumn('is_active', array(
 
            'header'    => Mage::helper('adminhtml')->__('Status'),
            'align'     => 'left',
            'width'     => '80px',
            'index'     => 'is_active',
            'type'      => 'options',
            'options'   => array(
                1 => 'Enable',
                0 => 'Disable',
                
            ),
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
