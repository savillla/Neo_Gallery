<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Neo\Gallery\Ui\Component\Listing\Column;

use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
{
    const ALT_FIELD = 'title';
    /**
     * Url path
     */
    const URL_PATH_EDIT = 'neogallery/gallery/edit';
    /**
     * @var \Neo\Gallery\Model\Gallery
     */
    protected $gallery;
    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param \Neo\Gallery\Model\Gallery $gallery
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        \Magento\Framework\UrlInterface $urlBuilder,
        \Neo\Gallery\Model\Gallery $gallery,
        array $components = [],
        array $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->urlBuilder = $urlBuilder;
        $this->gallery = $gallery;
    }
    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if ($item['image']) {
                    $gallery = new \Magento\Framework\DataObject($item);
                    $item[$fieldName . '_src'] = $this->gallery->getImageUrl($gallery['image']);
                    $item[$fieldName . '_orig_src'] = $this->gallery->getImageUrl($gallery['image']);
                    $item[$fieldName . '_link'] = $this->urlBuilder->getUrl(
                        self::URL_PATH_EDIT,
                        ['image_id' => $gallery['image_id']]
                    );
                    $item[$fieldName . '_alt'] = $gallery['title'];
                    
                }else{
                    // please place your placeholder image at pub/media/once/brand/placeholder/placeholder.jpg
                    $item[$fieldName . '_src'] = $this->gallery->getImageUrl('placecholder.jpg');
                    $item[$fieldName . '_alt'] = 'Place Holder';
                    $item[$fieldName . '_orig_src'] = $this->gallery->getImageUrl('placecholder.jpg');
                }
            }
        }
        return $dataSource;
    }
    /**
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: self::ALT_FIELD;
        return isset($row[$altField]) ? $row[$altField] : null;
    }
}