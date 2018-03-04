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

namespace MagentoYo\Menu\Ui\DataProvider\ListingDataProvider;

use MagentoYo\Menu\Model\ResourceModel\Menu\CollectionFactory;

class Form extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    protected $_loadedData;

    protected $_context;
    
    /**
     * Construct
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        \Magento\Framework\View\Element\UiComponent\ContextInterface $context,
        array $meta = [],
        array $data = []
    ) {
        $this->_context = $context;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
    
    public function getData()
    {
        if ($this->_loadedData !== null) {
            return $this->_loadedData;
        }

        $this->_loadedData = [];
        
        $dataCollection = $this->getCollection();
        
        foreach ($dataCollection as $item) {
            $this->_loadedData[$item['entity_id']] = $item->getData();
        }
        
        return $this->_loadedData;
    }
}
