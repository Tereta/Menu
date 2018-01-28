<?php
/**
 * ╔╗╔╗╔╦══╦══╦══╦════╦═══╗╔══╦═══╦═══╗
 * ║║║║║╠═╗║╔═╩╗╔╩═╗╔═╣╔══╝║╔╗║╔═╗║╔══╝
 * ║║║║║╠═╝║╚═╗║║──║║─║╚══╗║║║║╚═╝║║╔═╗
 * ║║║║║╠═╗╠═╗║║║──║║─║╔══╝║║║║╔╗╔╣║╚╗║
 * ║╚╝╚╝╠═╝╠═╝╠╝╚╗─║║─║╚══╦╣╚╝║║║║║╚═╝║
 * ╚═╝╚═╩══╩══╩══╝─╚╝─╚═══╩╩══╩╝╚╝╚═══╝
 * 
 * Examples and documentation at the: http://w3site.org
 * 
 * @copyright   Copyright (c) 2015-2016 Tereta Alexander. (http://www.w3site.org)
 * @license     http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace MagentoYo\Menu\Block;

class Menu extends \Magento\Framework\View\Element\Template
{
    protected $_menuModel;
    protected $_menuSubModelFactory;
    
    public function __construct(
        \MagentoYo\Menu\Model\MenuFactory $menuModelFactory,
        \MagentoYo\Menu\Block\Menu\SubFactory $menuSubModelFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = array()
    ) {
        $this->_menuModel = $menuModelFactory->create();
        $this->_menuSubModelFactory = $menuSubModelFactory;
        parent::__construct($context, $data);
    }
    
    public function _construct() {
        $this->setTemplate('MagentoYo_Menu::menu.phtml');
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
