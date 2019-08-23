<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Neo\Gallery\Model\Gallery;

use Neo\Gallery\Model\ResourceModel\Gallery\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Neo\Gallery\Model\Gallery\FileInfo;
use Magento\Framework\App\ObjectManager;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    /**
     * @var fileInfo
     */
    private $fileInfo;
    /**
     * @var \Neo\Gallery\Model\ResourceModel\Gallery\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $galleryCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $galleryCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    ) {
        $this->collection = $galleryCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Neo\Gallery\Model\Gallery $gallery */
        foreach ($items as $gallery) {
            $gallery = $this->convertValues($gallery);
            $this->loadedData[$gallery->getImageId()] = $gallery->getData();
        }
        // Used from the Save action
        $data = $this->dataPersistor->get('neogallery_gallery');
        if (!empty($data)) {
            $gallery = $this->collection->getNewEmptyItem();
            $gallery->setData($data);
            $this->loadedData[$gallery->getId()] = $gallery->getData();
            $this->dataPersistor->clear('neogallery_gallery');
        }

        return $this->loadedData;
    }
    /**
     * Converts image data to acceptable for rendering format
     *
     * @param \Neo\Gallery\Model\Gallery $gallery
     * @return \Neo\Gallery\Model\Gallery $gallery
     */
    private function convertValues($gallery)
    {
        $fileName = $gallery->getImage();
        $image = [];
        if ($this->getFileInfo()->isExist($fileName)) {
            $stat = $this->getFileInfo()->getStat($fileName);
            $mime = $this->getFileInfo()->getMimeType($fileName);
            $image[0]['name'] = $fileName;
            $image[0]['url'] = $gallery->getImageUrl();
            $image[0]['size'] = isset($stat) ? $stat['size'] : 0;
            $image[0]['type'] = $mime;
        }
        $gallery->setImage($image);
        return $gallery;
    }
    /**
     * Get FileInfo instance
     *
     * @return FileInfo
     *
     * @deprecated 101.1.0
     */
    private function getFileInfo()
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }
        return $this->fileInfo;
    }
}
