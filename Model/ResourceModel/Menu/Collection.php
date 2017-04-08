<?php

namespace WSite\Menu\Model\ResourceModel\Menu;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @return void;
     */
    protected function _construct()
    {
        $this->_init(
            'WSite\Menu\Model\Menu',
            'WSite\Menu\Model\ResourceModel\Menu'
        );
    }
}
