<?php

namespace  Uzhnu\About\Setup;

use \Magento\Framework\Setup\UpgradeDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;


class UpgradeData implements UpgradeDataInterface
{


    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $tableName = $setup->getTable('uzhnu_about_author');

        $data = [
                [
                    'name' => 'Yurii Andrashko'
                ],
                [
                    'name' => 'Andrii Bryla'
                ],
        ];

        $setup
                ->getConnection()
                ->insertMultiple($tableName, $data);

        $setup->endSetup();
    }
}
