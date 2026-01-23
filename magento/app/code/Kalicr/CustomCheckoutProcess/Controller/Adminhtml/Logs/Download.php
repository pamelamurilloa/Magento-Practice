<?php
namespace Kalicr\CustomCheckoutProcess\Controller\Adminhtml\Logs;

use Magento\Backend\App\Action;
use Magento\Framework\App\Response\Http\FileFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

class Download extends Action
{
    protected $fileFactory;

    public function __construct(
        Action\Context $context,
        FileFactory $fileFactory
    ) {
        parent::__construct($context);
        $this->fileFactory = $fileFactory;
    }

    public function execute()
    {
        // Define the file path relative to var/ folder
        $fileName = 'log/orders.log'; 

        try {
            return $this->fileFactory->create(
                'orders.log',
                [
                    'type'  => 'filename',
                    'value' => $fileName,
                    'rm'    => false,
                ],
                DirectoryList::VAR_DIR
            );
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Error downloading file: %1', $e->getMessage()));
            return $this->_redirect('*/*/index');
        }
    }
}