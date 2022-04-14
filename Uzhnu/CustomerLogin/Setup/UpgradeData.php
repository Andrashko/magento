<?php

namespace  Uzhnu\CustomerLogin\Setup;

use Magento\Customer\Setup\CustomerSetup;
use \Magento\Framework\Setup\UpgradeDataInterface;
use \Magento\Framework\Setup\ModuleContextInterface;
use \Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Customer\Model\Customer;
use Magento\Eav\Model\Entity\Attribute\Set  as AttributeSet;
use  Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;


class UpgradeData implements UpgradeDataInterface
{

    protected  CustomerSetupFactory  $customerSetupFactory;

    protected AttributeSetFactory $attributeSetFactory;

    public  function  __construct(
        CustomerSetupFactory  $customerSetupFactory,
        AttributeSetFactory $attributeSetFactory
    ){
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributeSetFactory = $attributeSetFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $customerSetup = $this->customerSetupFactory->create(["setup" => $setup]);

        if (!$this->hasAttribute( $customerSetup,"login_status"))
            $this->addAttribute(
                $customerSetup,
                "login_status",
                1000,
                "Blocked",
                "Magento\Eav\Model\Entity\Attribute\Source\Boolean",
                "0",
                "boolean",
                "int",
                ""
            );

        if (!$this->hasAttribute( $customerSetup,"reason"))
            $this->addAttribute(
                $customerSetup,
                "reason",
                1100,
                "Reason",
                "Uzhnu\CustomerLogin\Model\Customer\Attribute\Source\Reason",
                "0",
                "select",
                "varchar",
                ""
            );

        $setup->endSetup();
    }

    protected function hasAttribute(
        CustomerSetup $customerSetup,
        string  $attributeName
    )
    {
        if ($customerSetup->getAttribute(Customer::ENTITY,  $attributeName))
            return true;
        return false;
    }

    protected  function addAttribute(
        CustomerSetup $customerSetup,
        string $attributeName,
        int $sortOrder,
        string $attributeLabel,
        string $source,
        string $default,
        string $inputType,
        string $type,
        string $backend
    )
    {
        $customerEntity = $customerSetup->getEavConfig()->getEntityType(Customer::ENTITY);
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        $attributeSet = $this->attributeSetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);
        $customerSetup->addAttribute(
            Customer::ENTITY,
            $attributeName,
            [
                "type" => $type,
                "label" => $attributeLabel,
                "input" => $inputType,
                "sort_order" => $sortOrder,
                "position" => $sortOrder,
                "default" => $default,
                "backend" => $backend,
                "source" => $source,
                "required" => false,
                "visible" => true,
                "user_defined" => true,
                "system" => 0,
                "is_used_in_grid" => true,
                "is_visible_in_grid" => true,
                "is_html_allowed_on_front" => false,
                "visible_on_front" => true,
            ]
        );

        $attribute = $customerSetup->getEavConfig()->getAttribute(
            Customer::ENTITY,
            $attributeName
        )-> addData(
            [
                "attribute_set_id" => $attributeSetId,
                "attribute_group_id" => $attributeGroupId,
                "used_in_forms" => ["adminhtml_customer"]
            ]
        );
        $attribute->save();
    }
}
