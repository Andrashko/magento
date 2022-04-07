<?php
declare(strict_types=1);

namespace Astound\FirstVisitPopup\Setup\Patch\Data;

use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Model\BlockRepository;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\Setup\Patch\DataPatchInterface;

/**
 * Class CreateFirstVisitSampleCMSBlock
 * @package Astound\FirstVisitPopup\Setup\Patch\Data
 */
class CreateFirstVisitSampleCMSBlock implements DataPatchInterface
{
    /**
     * @const string
     */
    private const FIRST_VISIT_CMS_BLOCK_CONTENT = <<<HTML
<div class="newsletter-image-container">
    <img src="{{media url=&quot;astound/samples/first_visit_sample.jpg&quot;}}" alt="Welcome" />
</div>
<div class="newsletter-inner-content">
    <h2>Sign Up For Emails - Get a Special Welcome Gift</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Fusce pellentes risus in enim porta aliquam aenean at felis.
        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce pellentes risus in enim porta.
    </p>
    {{widget type="Astound\FirstVisitPopup\Block\Widget\Newsletter" title="Welcome!" template="widget/newsletter.phtml"}}
</div>
HTML;

    /**
     * @var BlockRepository
     */
    private $blockRepository;

    /**
     * @var BlockFactory
     */
    private $blockFactory;
    /**
     * @var Reader
     */
    private $moduleReader;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var File
     */
    private $ioFile;

    /**
     * CreateFirstVisitSampleCMSBlock constructor.
     * @param BlockRepository $blockRepository
     * @param BlockFactory    $blockFactory
     * @param Reader          $moduleReader
     * @param Filesystem      $filesystem
     * @param File            $ioFile
     */
    public function __construct(
        BlockRepository $blockRepository,
        BlockFactory $blockFactory,
        Reader $moduleReader,
        Filesystem $filesystem,
        File $ioFile
    ) {
        $this->blockRepository = $blockRepository;
        $this->blockFactory    = $blockFactory;
        $this->moduleReader    = $moduleReader;
        $this->filesystem      = $filesystem;
        $this->ioFile          = $ioFile;
    }

    /**
     * @inheritDoc
     */
    public function apply()
    {
        try {
            $this->copyImageToMedia();
        } catch (\Exception $e) {
            echo PHP_EOL;
            echo 'ERROR. Cannot copy image to media dir. Original exception - ' . $e->getMessage();
            echo PHP_EOL;
        }
        /** @var \Magento\Cms\Model\Block $firstVisitBlock */
        $firstVisitBlock = $this->blockFactory->create();
        $firstVisitBlock->setIdentifier('ast_first_visit')
            ->setTitle('First Visit Pop-up')
            ->setContent(self::FIRST_VISIT_CMS_BLOCK_CONTENT)
            ->setStoreId(\Magento\Store\Model\Store::DEFAULT_STORE_ID)
            ->setStores([\Magento\Store\Model\Store::DEFAULT_STORE_ID]);
        $this->blockRepository->save($firstVisitBlock);

        return $this;
    }

    /**
     * @return $this
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    private function copyImageToMedia()
    {
        $imageName = 'first_visit_sample.jpg';
        $sourceImagePath = $this->moduleReader->getModuleDir(
                \Magento\Framework\Module\Dir::MODULE_ETC_DIR,
                'Astound_FirstVisitPopup'
            ) . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $imageName;

        $mediaWrite = $this->filesystem->getDirectoryWrite(
            \Magento\Framework\App\Filesystem\DirectoryList::MEDIA
        );
        $targetPath = 'astound' . DIRECTORY_SEPARATOR . 'samples';
        $targetImagePath = $mediaWrite->getAbsolutePath() . $targetPath
            . DIRECTORY_SEPARATOR . $imageName;
        $mediaWrite->create('astound' . DIRECTORY_SEPARATOR . 'samples');

        if (!$mediaWrite->isExist($targetPath)) {
            $mediaWrite->create($targetPath);
        }

        $this->ioFile->cp(
            $sourceImagePath,
            $targetImagePath
        );

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getAliases()
    {
        return [];
    }

    /**
     * @inheritDoc
     */
    public static function getDependencies()
    {
        return [];
    }
}
