<?php
namespace WSite\Menu\Model\ResourceModel;

class Menu extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('wsite_menu', 'entity_id');
    }
}
