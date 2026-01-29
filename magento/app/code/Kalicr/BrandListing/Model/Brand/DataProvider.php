<?php
namespace Kalicr\BrandListing\Model\Brand;

use Kalicr\BrandListing\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->storeManager = $storeManager;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $items = $this->collection->getItems();
        foreach ($items as $brand) {
            $data = $brand->getData();
            
            if (isset($data['logo'])) {
                $imageName = $data['logo'];
                unset($data['logo']);
                $data['logo'][0] = [
                    'name' => $imageName,
                    'url' => $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA) . 'brand/logo/' . $imageName,
                    'type' => 'image',
                ];
            }

            $this->loadedData[$brand->getId()] = $data;
        }

        return $this->loadedData ?? [];
    }
}