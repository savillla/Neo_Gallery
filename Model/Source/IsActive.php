<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Neo\Gallery\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
/**
 * Class Status
 */
class IsActive implements OptionSourceInterface
{
    /**
     * @var \Neo\Gallery\Model\Gallery
     */
    protected $gallery;
    /**
     * Constructor
     *
     * @param \Neo\Gallery\Model\Gallery $gallery
     */
    public function __construct(\Neo\Gallery\Model\Gallery $gallery)
    {
        $this->gallery = $gallery;
    }
    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->gallery->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}