<?php

namespace Neo\Gallery\Controller\Adminhtml\Gallery;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\Inspection\Exception;
use Neo\Gallery\Model\Gallery\ImageUploader;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    /**
     * @var ImageUploader
     */
    protected $imageUploader;
    /**
     * @param Context $context
     * @param DataPersistorInterface $dataPersistor
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        DataPersistorInterface $dataPersistor,
        ImageUploader $imageUploader
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }
    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('image_id');
            if (empty($data['image_id'])) {
                $data['image_id'] = null;
            }
            //set image type and image size
            $imageName = ''; $imageSize=""; $imageType="";
            if (!empty($data['image'])) {
                $imageName = $data['image'][0]['name'];
                $imageSize = $data['image'][0]['size'];
                $imageType = $data['image'][0]['type'];
                $imageSize = (int)$imageSize/1024;
                $imageSize = round($imageSize);
                $data['image_size'] = $imageSize."KB";
                $data['image_type'] = $imageType;
            }
            /** @var \Neo\Gallery\Model\Gallery $model */
            $model = $this->_objectManager->create('Neo\Gallery\Model\Gallery')->load($id);
            if (!$model->getImageId() && $id) {
                $this->messageManager->addError(__('This image no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            $model->setData($data);
            try {
                $model->save();
                if ($imageName) {
                    $this->imageUploader->moveFileFromTmp($imageName);
                }
                $this->messageManager->addSuccess(__('You saved the image.'));
                $this->dataPersistor->clear('neogallery_gallery');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['image_id' => $model->getImageId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the image.'));
            }
            $this->dataPersistor->set('neogallery_gallery', $data);
            return $resultRedirect->setPath('*/*/edit', ['image_id' => $this->getRequest()->getParam('image_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    /**
     * Authorization level of a basic admin session
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Neo_Gallery::gallery_update') || $this->_authorization->isAllowed('Neo_Gallery::gallery_create');
    }
}