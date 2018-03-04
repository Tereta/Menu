<?php
/**                                                                                                  
 *                                                                                                   
 *  /$$$$$$$$                              /$$                      /$$$$$$  /$$                     
 * |__  $$__/                             | $$                     /$$__  $$| $$                     
 *    | $$  /$$$$$$   /$$$$$$   /$$$$$$  /$$$$$$    /$$$$$$       | $$  \ $$| $$  /$$$$$$  /$$   /$$ 
 *    | $$ /$$__  $$ /$$__  $$ /$$__  $$|_  $$_/   |____  $$      | $$$$$$$$| $$ /$$__  $$|  $$ /$$/ 
 *    | $$| $$$$$$$$| $$  \__/| $$$$$$$$  | $$      /$$$$$$$      | $$__  $$| $$| $$$$$$$$ \  $$$$/  
 *    | $$| $$_____/| $$      | $$_____/  | $$ /$$ /$$__  $$      | $$  | $$| $$| $$_____/  >$$  $$  
 *    | $$|  $$$$$$$| $$      |  $$$$$$$  |  $$$$/|  $$$$$$$      | $$  | $$| $$|  $$$$$$$ /$$/\  $$ 
 *    |__/ \_______/|__/       \_______/   \___/   \_______/      |__/  |__/|__/ \_______/|__/  \__/ 
 *                                                                                                   
 * @copyright   Copyright © 2017 Tereta Alexander, tereta@mail.ua. All rights reserved.              
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
