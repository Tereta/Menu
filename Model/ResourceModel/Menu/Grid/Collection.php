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

namespace MagentoYo\Menu\Model\ResourceModel\Menu\Grid;

use Magento\Framework\Api\Search\SearchResultInterface;
use MagentoYo\Menu\Model\ResourceModel\Menu\Collection as CatalogCollection;

class Collection extends CatalogCollection implements SearchResultInterface
{
    protected $aggregations;

    protected function _construct()
    {
        $this->_init(
            'Magento\Framework\View\Element\UiComponent\DataProvider\Document',
            'MagentoYo\Menu\Model\ResourceModel\Menu'
        );
    }
    
    public function getSearchCriteria()
    {
        return null;
    }
    
    public function setSearchCriteria(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria = null)
    {
        return $this;
    }
    
    public function getAggregations()
    {
        return $this->aggregations;
    }

    public function setAggregations($aggregations)
    {
        $this->aggregations = $aggregations;
    }
    
    public function setItems(array $items = null)
    {
        return $this;
    }
    
    public function getTotalCount()
    {
        return $this->getSize();
    }

    public function setTotalCount($totalCount)
    {
        return $this;
    }
}
