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

namespace MagentoYo\Menu\Plugin\Block;

use Magento\Catalog\Model\Category;
use Magento\Framework\Data\Collection;
use Magento\Framework\Data\Tree\Node;

/**
 * Plugin for top menu block
 */
class Topmenu extends \Magento\Catalog\Plugin\Block\Topmenu
{
    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

    protected $_scopeConfig;
    
    /**
     * @var \Magento\Catalog\Model\Layer\Resolver
     */
    private $layerResolver;
    

    protected $_menuModelFactory;
    
    public function __construct(
        \Magento\Catalog\Helper\Category $catalogCategory,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollectionFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\Layer\Resolver $layerResolver,
        \MagentoYo\Menu\Model\MenuFactory $menuModelFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        $this->_menuModelFactory = $menuModelFactory;
        $this->_storeManager = $storeManager;
        $this->_scopeConfig = $scopeConfig;
        
        parent::__construct(
            $catalogCategory,
            $categoryCollectionFactory,
            $storeManager,
            $layerResolver
        );
    }

    /**
     * Build category tree for menu block.
     *
     * @param \Magento\Theme\Block\Html\Topmenu $subject
     * @param string $outermostClass
     * @param string $childrenWrapClass
     * @param int $limit
     * @return void
     * @SuppressWarnings("PMD.UnusedFormalParameter")
     */
    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) {
        $menuId = $this->_scopeConfig->getValue(
            'magentoyo_menu/general/main_menu',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        
        if (!$menuId) {
            return parent::beforeGetHtml($subject, $outermostClass, $childrenWrapClass, $limit);
        }
        
        $storeId = $this->_storeManager->getStore()->getId();
        
        $menuModel = $this->_menuModelFactory->create();
        $menuModel->load($menuId);
        $menuTree = $menuModel->getTree();
        
        $parentMenuNode = $subject->getMenu();
        
        if (is_array($menuTree)) {
            $this->_beforeGetHtmlRequrentTree($parentMenuNode, $menuTree);
        }
    }

    protected function _beforeGetHtmlRequrentTree($parentMenuNode, $menuTree)
    {
        foreach ($menuTree as $menuItem) {
            $menuNode = new Node(
                $this->getMenuItemAsArray($menuItem),
                'id',
                $parentMenuNode->getTree(),
                $parentMenuNode
            );
            
            if (isset($menuItem->dataTree) && is_array($menuItem->dataTree)) {
                $this->_beforeGetHtmlRequrentTree($menuNode, $menuItem->dataTree);
            }
            
            $parentMenuNode->addChild($menuNode);
        }
    }
    
    /**
     * Convert category to array
     *
     * @param \Magento\Catalog\Model\Category $category
     * @param \Magento\Catalog\Model\Category $currentCategory
     * @return array
     */
    private function getMenuItemAsArray($menuItem)
    {
        return [
            'name' => $menuItem->dataItem->title,
            'id' => 'category-node-' . uniqId(),
            'url' => $menuItem->dataItem->link,
            'has_active' => false,
            'is_active' => false
        ];
    }
}

