<?php
namespace Kalicr\BrandListing\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Kalicr\BrandListing\Model\BrandFactory;

class Save extends Action
{
    protected $brandFactory;

    public function __construct(Context $context, BrandFactory $brandFactory)
    {
        $this->brandFactory = $brandFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($data) {
            // Note: If you are dealing with image uploads, you need special logic here 
            // to process the file upload before setting data.

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