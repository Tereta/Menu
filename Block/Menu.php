<?php
namespace WSite\Menu\Block;

class Menu extends \Magento\Framework\View\Element\Template
{
    protected $_menuModel;
    protected $_menuSubModelFactory;
    
    public function __construct(
        \WSite\Menu\Model\MenuFactory $menuModelFactory,
        \WSite\Menu\Block\Menu\SubFactory $menuSubModelFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = array()
    ) {
        $this->_menuModel = $menuModelFactory->create();
        $this->_menuSubModelFactory = $menuSubModelFactory;
        parent::__construct($context, $data);
    }
    
    public function _construct() {
        $this->setTemplate('WSite_Menu::menu.phtml');
        parent::_construct();
    }
    
    protected $_items = null;
    
    public function getTitle()
    {
        return $this->getModel()->getTitle();
    }
    
    public function getModel()
    {
        if (!$this->_menuModel->getId()) {
            $identifier = $this->getData('identifier');
            $this->_menuModel->load($identifier, 'identifier');
        }
        
        return $this->_menuModel;
    }
    
    public function getItems()
    {
        if (is_null($this->_items)) {
            $this->_items = $this->getModel()->getTree();
        }
        
        return $this->_items;
    }
    
    public function getSubItems($item) {
        $menuSubModel = $this->_menuSubModelFactory->create();
        $menuSubModel->setDataArray($item);
        
        return $menuSubModel;
    }
}
