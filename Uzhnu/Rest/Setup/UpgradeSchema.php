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

        if(version_compare($context->getVersion(), '0.1.5', '<')){
            $setup->getConnection()->addColumn(
                $tableName,
                'email',
                [
                    'type' =>  Table::TYPE_TEXT,
                    'nullable' => true,
                    'length' => 255,
                    'comment' => 'Email',
                ]
            );
        }
        $setup->endSetup();
    }
}
