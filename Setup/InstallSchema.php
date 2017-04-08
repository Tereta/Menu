<?php
/**
 * Copyright © 2016 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace WSite\Menu\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();

        /**
         * Create table 'wsite_articles_category'
         */
        $table = $installer->getConnection()
            ->newTable($installer->getTable('wsite_menu'))
            ->addColumn(
                'entity_id',
                \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
                null,
                ['identity' => true, 'unsigned' => true, 'nullable' => false, 'primary' => true],
                'Entity ID'
            )
            ->addColumn(
                'identifier',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                64,
                [],
                'Identifier'
            )
            ->addColumn(
                'title',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                254,
                [],
                'Title'
            )
            ->addColumn(
                'data',
                \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                null,
                [],
                'Data'
            )
            ->addColumn(
                'status',
                \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
                null,
                [],
                'Status'
            )
            ->setComment('List of Menus');
        $installer->getConnection()->createTable($table);
        
        $installer->endSetup();
    }
}
