<?php
namespace Kalicr\BrandListing\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Kalicr\BrandListing\Model\BrandFactory;
use Magento\Catalog\Model\ImageUploader;

class Save extends Action
{
    protected $brandFactory;
    protected $imageUploader;

    public function __construct(Context $context, BrandFactory $brandFactory, ImageUploader $imageUploader)
    {
        $this->brandFactory = $brandFactory;
        $this->imageUploader = $imageUploader;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            if (isset($data['logo']) && is_array($data['logo'])) {
                if (isset($data['logo'][0]['name']) && isset($data['logo'][0]['tmp_name'])) {
                    $data['logo'] = $data['logo'][0]['name'];
                    try {
                        $this->imageUploader->moveFileFromTmp($data['logo']);
                    } catch (\Exception $e) {
                    }
                } elseif (isset($data['logo'][0]['name'])) {
                    $data['logo'] = $data['logo'][0]['name'];
                }
            } else {
                $data['logo'] = null;
            }

            $id = $this->getRequest()->getParam('entity_id');
            $model = $this->brandFactory->create();
            
            if ($id) {
                $model->load($id);
                if (!$model->getId()) {
                    $this->messageManager->addErrorMessage(__('This brand no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the brand.'));
                
                // Logic for "Save and Continue Edit" button
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
                }
                
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        
        return $resultRedirect->setPath('*/*/');
    }
}