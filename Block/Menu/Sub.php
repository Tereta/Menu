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

namespace MagentoYo\Menu\Block\Menu;

class Sub extends \Magento\Framework\View\Element\Template
{
    protected $_modelMenuSubFactory;
    
    public function __construct(
        \MagentoYo\Menu\Block\Menu\SubFactory $modelMenuSubFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = array()
    ) {
        $this->_modelMenuSubFactory = $modelMenuSubFactory;
        
        parent::__construct($context, $data);
    }
    
    public function _construct() {
        $this->setTemplate('MagentoYo_Menu::menu/sub.phtml');
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
