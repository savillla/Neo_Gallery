<?php
namespace Neo\Gallery\Block\Gallery;

use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Framework\View\Element\Template {

    /**
     * @var resultPageFactory
     */
    protected $resultPageFactory;
    /**
     * @var galleryFactory
     */
    protected $galleryFactory;
    /**
     * @var _template
     */
	protected $_template = 'Neo_Gallery::gallery_index_index.phtml';
    /**
     * @var fileInfo
     */
    protected $_filterProvider;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Neo\Gallery\Model\GalleryFactory $galleryFactory,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
		\Magento\Framework\View\Result\PageFactory $resultPageFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->galleryFactory = $galleryFactory;
        $this->_filterProvider = $filterProvider;
        $this->_objectManager = \Magento\Framework\App\ObjectManager::getInstance();
		$this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Prepare layout
     */
    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Neo Gallery Page'));
        return parent::_prepareLayout();
    }
    /**
     * Get Gallery Collection
     */
    public function getImageGallery()
    {
        $collection = $this->galleryFactory->create()->getCollection();
        $collection->addFieldToFilter('status',1);
        return $collection;
    }

}