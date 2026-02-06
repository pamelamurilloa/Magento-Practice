<?php declare(strict_types=1);

namespace Kalicr\BrandListing\Model;

use Kalicr\BrandListing\Api\BrandManagementInterface;
use Kalicr\BrandListing\Api\Data\BrandInterface;
use Kalicr\BrandListing\Model\BrandFactory;
use Kalicr\BrandListing\Model\ResourceModel\Brand as ResourceBrand;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class BrandManagement implements BrandManagementInterface
{
    private $brandFactory;
    private $resource;

    /**
     * BrandManagement constructor.
     * @param BrandFactory $brandFactory
     * @param ResourceBrand $resource
     */
    public function __construct(BrandFactory $brandFactory, ResourceBrand $resource) {
        $this->brandFactory = $brandFactory;
        $this->resource = $resource;
    }

    /**
     * @param BrandInterface $brand
     * @return BrandInterface
     */
    public function save(BrandInterface $brand): BrandInterface
    {
        if (!$brand->getName()) {
            throw new CouldNotSaveException(__('The "name" field is required by the database schema.'));
        }

        try {
            $this->resource->save($brand);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $brand;
    }

    /**
     * @param int $brandId
     * @return BrandInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $brandId): BrandInterface
    {
        $brand = $this->brandFactory->create();
        $this->resource->load($brand, $brandId);
        if (!$brand->getEntityId()) {
            throw new NoSuchEntityException(__('Brand with ID "%1" does not exist.', $brandId));
        }
        return $brand;
    }

    /**
     * @param int $brandId
     * @return bool
     */
    public function deleteById(int $brandId): bool
    {
        $brand = $this->getById($brandId);
        $this->resource->delete($brand);
        return true;
    }
}