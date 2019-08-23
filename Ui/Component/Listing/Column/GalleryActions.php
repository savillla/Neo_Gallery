<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Neo\Gallery\Ui\Component\Listing\Column;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;

/**
 * Class GalleryActions
 */
class GalleryActions extends Column
{
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'neogallery/gallery/edit';
    const URL_PATH_DELETE = 'neogallery/gallery/delete';
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;
    /**
     * Escaper.
     *
     * @var Escaper
     */
    private $escaper;
    /**
     * Constructor
     *
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $title = $this->getData('name');
                if (isset($item['image_id'])) {
                    $item[$title]['edit'] = [
                        'href' => $this->urlBuilder->getUrl(
                            static::URL_PATH_EDIT,
                            [
                                'image_id' => $item['image_id']
                            ]
                            ),
                        'label' => __('Edit')
                    ];
                }
            }
        }

        return $dataSource;
    }
    /**
     * Get instance of escaper.
     *
     * @return Escaper
     * @deprecated
     */
    private function getEscaper()
    {
        if (!$this->escaper) {
            $this->escaper = ObjectManager::getInstance()->get(Escaper::class);
        }
        return $this->escaper;
    }
}