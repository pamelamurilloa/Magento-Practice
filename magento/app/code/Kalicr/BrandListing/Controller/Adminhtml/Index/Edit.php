<?php
namespace Kalicr\BrandListing\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Kalicr\BrandListing\Model\BrandFactory;

class Edit extends Action
{
    protected $resultPageFactory;
    protected $brandFactory;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        BrandFactory $brandFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->brandFactory = $brandFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->brandFactory->create();

        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This brand no longer exists.'));
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Kalicr_BrandListing::brand_listing');
        
        $pageTitle = $id ? __('Edit Brand: %1', $model->getName()) : __('New Brand');
        $resultPage->getConfig()->getTitle()->prepend($pageTitle);

        return $resultPage;
    }
}