<?php
namespace Kalicr\CustomCheckoutProcess\Controller\Adminhtml\Logs;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    protected $resultPageFactory;

    public function __construct(
        Action\Context $context, // this appears to always be present, it constructs the page as the url is called
        PageFactory $resultPageFactory // this is needed to create the result page
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create(); // this loads the layout and other necessary elements for the admin page
        $resultPage->getConfig()->getTitle()->prepend(__('Order JSON Logs')); // set the page title
        return $resultPage;
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Kalicr_CustomCheckoutProcess::order_log'); // permission check to access this page
    }
}