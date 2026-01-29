<?php
namespace Kalicr\BrandListing\Block\Widget;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Kalicr\BrandListing\Model\ResourceModel\Brand\CollectionFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;

class BrandSlider extends Template implements BlockInterface
{
    // Point to our frontend template
    protected $_template = "widget/brand_slider.phtml";

    protected $collectionFactory;
    protected $storeManager;

    public function __construct(
        Template\Context $context,
        CollectionFactory $collectionFactory,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * Get the collection of Active Brands
     */
    public function getBrands()
    {
        $limit = $this->getData('brands_limit') ? (int)$this->getData('brands_limit') : 0;

        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('is_active', 1)
                   ->addFieldToFilter('logo', ['notnull' => true])
                   ->setOrder('name', 'ASC');

        if ($limit > 0) {
            $collection->setPageSize($limit);
        }

        return $collection;
    }

    /**
     * Helper to get the full image URL
     */
    public function getLogoUrl($filename)
    {
        $mediaUrl = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
        return $mediaUrl . 'brand/logo/' . $filename;
    }
}