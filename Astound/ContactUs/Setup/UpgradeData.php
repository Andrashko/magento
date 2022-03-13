<?php

namespace Astound\ContactUs\Setup;

use Magento\Cms\Api\BlockRepositoryInterface;
use Magento\Cms\Model\BlockFactory;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\UpgradeDataInterface;

/**
 * Class UpgradeData
 *
 * @package Astound\ContactUs\Setup
 */
class UpgradeData implements UpgradeDataInterface
{
    /** @var \Magento\Cms\Model\BlockFactory */
    protected $blockFactory;

    /** @var \Magento\Cms\Api\BlockRepositoryInterface */
    protected $blockRepository;

    /**
     * UpgradeData constructor.
     *
     * @param \Magento\Cms\Model\BlockFactory           $blockFactory
     * @param \Magento\Cms\Api\BlockRepositoryInterface $blockRepository
     */
    public function __construct(BlockFactory $blockFactory, BlockRepositoryInterface $blockRepository)
    {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
    }

    /**
     * @inheritdoc
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $this->addDefaultContentBlockForContactUs($setup, $context);

        $setup->endSetup();
    }

    /**
     * Add default block for contact us page
     *
     * @param \Magento\Framework\Setup\ModuleDataSetupInterface $setup
     * @param \Magento\Framework\Setup\ModuleContextInterface   $context
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function addDefaultContentBlockForContactUs(
        ModuleDataSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        if (!version_compare($context->getVersion(), '0.2.0', '<')) {
            return;
        }

        $block = $this->blockFactory->create();

        $block->setIdentifier('ast_contactUs_main_content_default');
        $block->setContent('<p>We love hearing from you, our Launch2 customers. Please contact us about anything at all. Your latest passion, unique health experience or request for a specific product. We’ll do everything we can to make your Luma experience unforgettable every time. Reach us however you like.</p>');
        $block->setTitle('Contact us main content (default)');
        $block->setIsActive(true);
        $block->setStoreId([0]);

        $this->blockRepository->save($block);
    }
}
