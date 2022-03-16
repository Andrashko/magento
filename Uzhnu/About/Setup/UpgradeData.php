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

        if(version_compare($context->getVersion(), '0.1.5', '<')) {
            $data = [
                [
                    'name' => 'Yurii Andrashko',
                    'email' => "yurii.andrashko@uzhnu.edu.ua",
                ],
                [
                    'name' => 'Andrii Bryla',
                    'email' => "andrii.bryla@uzhnu.edu.ua",
                ],
            ];

            $setup
                ->getConnection()
                ->insertMultiple($tableName, $data);
        }
        $setup->endSetup();
    }
}
