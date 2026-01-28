<?php
namespace Kalicr\BrandListing\Model\ResourceModel\Brand;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'entity_id';
    protected $_eventPrefix = 'kalicr_brandlisting_brand_collection';
    protected $_eventObject = 'brand_collection';

    /**
     * Define the resource model & the model
     */
    protected function _construct()
    {
        $this->_init(
            \Kalicr\BrandListing\Model\Brand::class,
            \Kalicr\BrandListing\Model\ResourceModel\Brand::class
        );
    }
}