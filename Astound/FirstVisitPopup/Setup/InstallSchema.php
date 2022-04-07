<?php

namespace Astound\FirstVisitPopup\Setup;

use Astound\BaseEntity\Api\Data\BaseDataInterface;
use Magento\Framework\DB\Adapter\AdapterInterface;
use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class InstallSchema
 *
 * @package Astound\FirstVisitPopup\Setup
 */
class InstallSchema implements InstallSchemaInterface
{
    /**#@+
     * First visit popup tables
     */
    const ASTOUND_FIRST_VISIT_POPUP_TABLE = 'astound_first_visit_popup';
    const ASTOUND_FIRST_VISIT_POPUP_STORE_TABLE = 'astound_first_visit_popup_store';
    /**#@-*/

    /**
     * {@inheritdoc}
     * @throws \Zend_Db_Exception
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        $this->createMainTable($setup, $context);
        $this->createStoreRelationTable($setup, $context);
        $setup->endSetup();
    }

    /**
     * Creates astound_first_visit_popup table
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    protected function createMainTable(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $tableName = $setup->getTable(self::ASTOUND_FIRST_VISIT_POPUP_TABLE);

        if ($setup->getConnection()->isTableExists($tableName)) {
            return;
        }

        $table = $setup->getConnection()
            ->newTable($tableName)
            ->addColumn(BaseDataInterface::ENTITY_ID, Table::TYPE_SMALLINT, null, [
                'identity' => true,
                'unsigned' => true,
                'nullable' => false,
                'primary' => true,
            ])
            ->addColumn('title', Table::TYPE_TEXT, 255, [
                'nullable' => true,
            ], 'Title')
            ->addColumn('content', Table::TYPE_TEXT, null, [
                'nullable' => true,
            ], 'Content')
            ->addColumn('content_width', Table::TYPE_TEXT, null, [
                'nullable' => true,
            ], 'Content width')
            ->addColumn('status', Table::TYPE_BOOLEAN, null, [
                'nullable' => true,
                'default' => null
            ], 'Status')
            ->addColumn('created_at', Table::TYPE_TIMESTAMP, null, [
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT
            ], 'Created At')
            ->addColumn('updated_at', Table::TYPE_TIMESTAMP, null, [
                'nullable' => false,
                'default' => Table::TIMESTAMP_INIT_UPDATE
            ], 'Updated At')
            ->addIndex(
                $setup->getIdxName($tableName, 'status'),
                'status'
            );

        $setup->getConnection()->createTable($table);
    }

    /**
     * Creates astound_first_visit_popup_store table
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     *
     * @throws \Zend_Db_Exception
     */
    protected function createStoreRelationTable(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $tableName = $setup->getTable(self::ASTOUND_FIRST_VISIT_POPUP_STORE_TABLE);

        if ($setup->getConnection()->isTableExists($tableName)) {
            return;
        }

        $table = $setup->getConnection()
            ->newTable($tableName)
            ->addColumn(
                BaseDataInterface::ENTITY_ID,
                Table::TYPE_SMALLINT,
                null,
                ['nullable' => false, 'primary' => true,'unsigned' => true],
                'First visit popup ID'
            )->addColumn(
                'store_id',
                Table::TYPE_SMALLINT,
                null,
                ['unsigned' => true, 'nullable' => false, 'primary' => true],
                'Store ID'
            )->addIndex(
                $setup->getIdxName($tableName, ['store_id']),
                ['store_id']
            )->addForeignKey(
                $setup->getFkName($tableName, BaseDataInterface::ENTITY_ID,
                    self::ASTOUND_FIRST_VISIT_POPUP_TABLE, BaseDataInterface::ENTITY_ID),
                BaseDataInterface::ENTITY_ID,
                $setup->getTable(self::ASTOUND_FIRST_VISIT_POPUP_TABLE),
                BaseDataInterface::ENTITY_ID,
                Table::ACTION_CASCADE
            )->addForeignKey(
                $setup->getFkName($tableName, 'store_id', 'store', 'store_id'),
                'store_id',
                $setup->getTable('store'),
                'store_id',
                Table::ACTION_CASCADE
            )->setComment(
                'First Visit Popup To Store Linkage Table'
            );
        $setup->getConnection()->createTable($table);
    }
}
