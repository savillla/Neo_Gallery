<?php

namespace Neo\Gallery\Controller\Adminhtml\Gallery;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Neo_Gallery::gallery_delete';

    /**
     * Delete Image
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $imageId = (int)$this->getRequest()->getParam('image_id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($imageId && (int) $imageId > 0) {
            try {
                $model = $this->_objectManager->create('Neo\Gallery\\Model\Gallery');
                $model->load($imageId);
                $model->delete();
                $this->messageManager->addSuccess(__('Image has been deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to the question grid
                return $resultRedirect->setPath('*/*/index');
            }
        }
        // display error message
        $this->messageManager->addError(__('Image doesn\'t exist any longer.'));
        // go to the question grid
        return $resultRedirect->setPath('*/*/index');
    }
}
