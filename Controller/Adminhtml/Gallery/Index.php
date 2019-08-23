<?php

namespace Neo\Gallery\Controller\Adminhtml\Gallery;

class Index extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Neo_Gallery::neo_gallery';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }
    /**
     * Index action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        /**
		 * Set active menu item
		 */
		$resultPage->setActiveMenu("Neo_Gallery::manage_image");
        $resultPage->getConfig()->getTitle()->prepend(__('Neo Gallery'));
        
        /**
		 * Add breadcrumb item
		 */
		$resultPage->addBreadcrumb(__('Images'),__('Images'));
		$resultPage->addBreadcrumb(__('Manage Images'),__('Manage Images'));
        return $resultPage;
    }
}