<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Neo\Gallery\Model;

use Neo\Gallery\Model\Gallery\FileInfo;
use Magento\Framework\App\ObjectManager;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Neo Gallery model
 *
 * @method Gallery setStoreId(array $storeId)
 * @method array getStoreId()
 */
class Gallery extends \Magento\Framework\Model\AbstractModel
{
    /**
     * Neo Gallery cache tag
     */
    const CACHE_TAG = 'neo_gallery';

    /**#@+
     * Block's statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    /**
     * Store manager
     *
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;
    /**#@-*/

    /**#@-*/
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'neo_gallery';

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Neo\Gallery\Model\ResourceModel\Gallery::class);
    }
    /**
     * Retrieve the Image URL
     *
     * @param string $imageName
     * @return bool|string
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getImageUrl($imageName = null)
    {
        $url = '';
        $image = $imageName;
        if (!$image) {
            $image = $this->getData('image');
        }
        if ($image) {
            if (is_string($image)) {
                $url = $this->_getStoreManager()->getStore()->getBaseUrl(
                    \Magento\Framework\UrlInterface::URL_TYPE_MEDIA
                ).FileInfo::ENTITY_MEDIA_PATH .'/'. $image;
            } else {
                throw new \Magento\Framework\Exception\LocalizedException(
                    __('Something went wrong while getting the image url.')
                );
            }
        }
        return $url;
    }
    /**
     * Prepare gallry image's statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Publish'), self::STATUS_DISABLED => __('Unpublish')];
    }
    /**
     * Get StoreManagerInterface instance
     *
     * @return StoreManagerInterface
     */
    private function _getStoreManager()
    {
        if ($this->_storeManager === null) {
            $this->_storeManager = ObjectManager::getInstance()->get(StoreManagerInterface::class);
        }
        return $this->_storeManager;
    }
}
