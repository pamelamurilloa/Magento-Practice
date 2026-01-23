<?php
namespace Kalicr\CustomCheckoutProcess\Block\Adminhtml\Logs;

use Magento\Backend\Block\Template;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Filesystem\Driver\File;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;

class View extends Template
{
    protected $directoryList;
    protected $fileDriver;
    protected $orderCollectionFactory;

    public function __construct(
        Template\Context $context,
        DirectoryList $directoryList,
        File $fileDriver,
        CollectionFactory $orderCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->directoryList = $directoryList;
        $this->fileDriver = $fileDriver;
        $this->orderCollectionFactory = $orderCollectionFactory;
    }

    public function getRecentOrders()
    {
        $collection = $this->orderCollectionFactory->create();
        $collection->addFieldToSelect(['increment_id', 'created_at'])
                   ->setOrder('created_at', 'DESC')
                   ->setPageSize(100);
        
        return $collection;
    }

    public function getLogContent()
    {
        $path = $this->directoryList->getPath(DirectoryList::VAR_DIR) . '/log/orders.log';
        
        if ($this->fileDriver->isExists($path)) {
            return $this->fileDriver->fileGetContents($path);
        }
        
        return "Log file not found at " . $path;
    }

    public function getDownloadUrl()
    {
        return $this->getUrl('customcheckoutprocess/logs/download');
    }
}