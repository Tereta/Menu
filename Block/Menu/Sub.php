<?php
namespace WSite\Menu\Block\Menu;

class Sub extends \Magento\Framework\View\Element\Template
{
    protected $_modelMenuSubFactory;
    
    public function __construct(
        \WSite\Menu\Block\Menu\SubFactory $modelMenuSubFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = array()
    ) {
        $this->_modelMenuSubFactory = $modelMenuSubFactory;
        
        parent::__construct($context, $data);
    }
    
    public function _construct() {
        $this->setTemplate('WSite_Menu::menu/sub.phtml');
        parent::_construct();
    }
    
    public function getItems()
    {
        return $this->getDataArray();
    }
    
    public function getSubItems($item) {
        $menuSubModel = $this->_modelMenuSubFactory->create();
        $menuSubModel->setDataArray($item);
        
        return $menuSubModel;
    }
}
