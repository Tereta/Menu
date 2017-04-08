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

namespace WSite\Menu\Model\Config\Source\Menu;

class Options implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var array
     */
    protected $_options;

    /**
     * @var \Magento\Framework\Locale\ListsInterface
     */
    protected $_localeLists;
    
    protected $_menuCollectionFactory;

    /**
     * @param \Magento\Framework\Locale\ListsInterface $localeLists
     */
    public function __construct(
        \WSite\Menu\Model\ResourceModel\Menu\CollectionFactory $menuCollectionFactory,
        \Magento\Framework\Locale\ListsInterface $localeLists
    ) {
        $this->_menuCollectionFactory = $menuCollectionFactory;
        $this->_localeLists = $localeLists;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        if (!$this->_options) {
            $this->_options = [0 => 'Use Categories'];
            
            $menuCollection = $this->_menuCollectionFactory->create();
            
            foreach ($menuCollection as $menuItem) {
                $this->_options[$menuItem->getId()] = $menuItem->getTitle();
            }
        }
        $options = $this->_options;
        return $options;
    }
}
