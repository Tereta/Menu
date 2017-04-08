<?php
namespace WSite\Menu\Model;

use \WSite\Articles\Helper\Data as HelperData;

class Menu extends \Magento\Framework\Model\AbstractModel
{
    protected $_urlModel;
    
    public function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\UrlInterface $urlModel,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = array()
    ) {
        $this->_urlModel = $urlModel;
        
        parent::__construct(
            $context,
            $registry,
            $resource,
            $resourceCollection,
            $data
        );
    }
    
    /**
     * @return void
     */
    protected function _construct()
    {
        parent::_construct();
        $this->_init('WSite\Menu\Model\ResourceModel\Menu');
    }
    
    public function getTree()
    {
        if (!$this->getData('data')) {
            return [];
        }
        
        $tree = json_decode($this->getData('data'));
        
        $this->_getTreeProcess($tree);
        
        return $tree;
    }
    
    protected function _getTreeProcess(&$tree)
    {
        foreach ($tree as &$treeItem) {
            $link = &$treeItem->dataItem->link;
            $link = $this->_getTreeProcessLink($link);
            
            if ($treeItem->dataTree) {
                $this->_getTreeProcess($treeItem->dataTree);
            }
        }
    }
    
    protected function _getTreeProcessLink($link) {
        if (substr($link, 0, 1) == '/') {
            return $link;
        }
        
        $matched = preg_match('/^([a-z]+):\/\/(.*)$/Usi', $link, $match);
        
        if (!$matched && strpos($link, '://') === false) {
            return $this->_urlModel->getUrl($link);
        }
        
        if (!$matched) {
            return $link;
        }
        
        if (!isset($match[1]) || !$match[1]) {
            return $link;
        }
        
        $protocol = $match[1];
        
        switch ($protocol) {
            case ('magentoUrl') :
                return $this->_urlModel->getUrl($match[2]);
                break;
            case ('url') :
                return $this->_urlModel->getUrl($match[2]);
                break;
            
            default :
                return $link;
                break;
        }
        
        return $link;
    }
}
