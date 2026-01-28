<?php
namespace Kalicr\BrandListing\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Kalicr\BrandListing\Model\BrandFactory;

class Delete extends Action
{
    protected $brandFactory;

    public function __construct(Context $context, BrandFactory $brandFactory)
    {
        $this->brandFactory = $brandFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($id) {
            try {
                $model = $this->brandFactory->create();
                $model->load($id);
                $model->delete();

                $this->messageManager->addSuccessMessage(__('The brand has been deleted.'));
                return $resultRedirect->setPath('*/*/');

            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }

        $this->messageManager->addErrorMessage(__('We can\'t find a brand to delete.'));
        return $resultRedirect->setPath('*/*/');
    }
}