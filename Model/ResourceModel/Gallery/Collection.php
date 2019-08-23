<?php
namespace Neo\Gallery\Model\ResourceModel\Gallery;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'image_id';
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Neo\Gallery\Model\Gallery', 'Neo\Gallery\Model\ResourceModel\Gallery');
    }
}