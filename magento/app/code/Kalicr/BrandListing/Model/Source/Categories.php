<?php
namespace Kalicr\BrandListing\Model\Source;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class Categories implements OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Get categories as an option array for the dropdown
     *
     * @return array
     */
    public function toOptionArray()
    {
        $collection = $this->collectionFactory->create();
        
        $collection->addAttributeToSelect('name')
                   ->addAttributeToFilter('is_active', 1);

        $options = [];

        foreach ($collection as $category) {
            $options[] = [
                'label' => $category->getName(), 
                'value' => $category->getId()
            ];
        }

        return $options;
    }
}