<?php
namespace Kalicr\BrandListing\Model;

use Magento\Framework\Model\AbstractModel;

class Brand extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Kalicr\BrandListing\Model\ResourceModel\Brand::class);
    }
}