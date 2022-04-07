<?php

namespace Astound\FirstVisitPopup\Model\UiComponent\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class PopupActions
 *
 * @package Astound\FirstVisitPopup\Model\UiComponent\Listing\Column
 */
class PopupActions extends Column
{
    /** @var UrlInterface */
    protected $urlBuilder;

    /**
     * @var UrlInterface
     */
    protected $frontUrlBuilder;

    /**
     * PopupActions constructor.
     *
     * @param \Magento\Framework\View\Element\UiComponent\ContextInterface $context
     * @param \Magento\Framework\View\Element\UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param UrlInterface $frontUrlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        \Magento\Framework\UrlInterface $frontUrlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->frontUrlBuilder = $frontUrlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (!isset($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            if (!isset($item['entity_id'])) {
                continue;
            }
            $item[$this->getData('name')] = [
                'edit'   => [
                    'href'  => $this->getUrl('astound_firstVisitPopup/popup/edit', $item['entity_id']),
                    'label' => __('Edit')
                ],
                'delete' => [
                    'href'    => $this->getUrl('astound_firstVisitPopup/popup/delete', $item['entity_id']),
                    'label'   => __('Delete'),
                    'confirm' => [
                        'title'         => __('Delete "${ $.$data.title }"'),
                        'message'       => __('Are you sure you wan\'t to delete a "${ $.$data.title }" record ?'),
                        '__disableTmpl' => ['title' => false,'message' => false],
                    ]
                ],
                'duplicate' => [
                    'href'    => $this->getUrl('astound_firstVisitPopup/popup/duplicate', $item['entity_id']),
                    'label'   => __('Duplicate')
                ],
                'preview' => [
                    'href'    => $this->getFrontendUrl('astound_firstVisitPopup/popup/preview', $item['entity_id']),
                    'label'   => __('Preview')
                ]
            ];
        }

        return $dataSource;
    }

    /**
     * Build url by requested path and id
     *
     * @param string $path
     * @param int    $id
     *
     * @return string
     */
    private function getUrl(string $path, int $id): string
    {
        return $this->urlBuilder->getUrl($path, ['id' => $id]);
    }

    /**
     * Build frontend url by requested path and id
     *
     * @param string $path
     * @param int    $id
     *
     * @return string
     */
    private function getFrontendUrl(string $path, int $id): string
    {
        return $this->frontUrlBuilder->getUrl($path, ['id' => $id]);
    }
}
