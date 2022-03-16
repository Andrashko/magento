<?php

namespace  Uzhnu\About\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\SchemaSetupInterface;
use \Magento\Framework\DB\Ddl\Table;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        //if(version_compare($context->getVersion(), '0.1.2', '<'))
        $tableName = $setup->getTable('uzhnu_about_author');
        if (!$setup->getConnection()->isTableExists($tableName)){
            $table = $setup
                ->getConnection()
                ->newTable($tableName)
                ->addColumn(
                    'id',
                    Table::TYPE_INTEGER,
                    null,
                    [
                        'identity' => true,
                        'unsigned' => true,
                        'nullable' => false,
                        'primary' => true
                    ],
                    'ID'
                )
                ->addColumn(
                    'name',
                    Table::TYPE_TEXT,
                   255,
                    ['nullable' => false],
                    'Name'
                );
            $setup->getConnection()->createTable($table);
        }
        $setup->endSetup();
    }
}
