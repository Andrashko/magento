<?php

namespace Astound\FirstVisitPopup\Setup;

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UninstallInterface;

/**
 * Class Uninstall
 *
 * @package Astound\FirstVisitPopup\Setup
 */
class Uninstall implements UninstallInterface
{
    /**
     * @inheritdoc
     */
    public function uninstall(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $tables = [
            InstallSchema::ASTOUND_FIRST_VISIT_POPUP_TABLE,
            InstallSchema::ASTOUND_FIRST_VISIT_POPUP_STORE_TABLE
        ];

        $setup->startSetup();
        foreach ($tables as $table) {
            $setup->getConnection()->dropTable($table);
        }
        $setup->endSetup();
    }
}
