<?php declare(strict_types=1);

namespace Kalicr\BrandListing\Api;

use Kalicr\BrandListing\Api\Data\BrandInterface;

interface BrandRepositoryInterface extends BrandManagementInterface
{
    /**
     * @param \Kalicr\BrandListing\Api\Data\BrandInterface $brand
     * @return \Kalicr\BrandListing\Api\Data\BrandInterface
     */
    public function save(BrandInterface $brand): BrandInterface;

    /**
     * @param int $brandId
     * @return \Kalicr\BrandListing\Api\Data\BrandInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById(int $brandId): BrandInterface;

    /**
     * @param int $brandId
     * @return bool
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function deleteById(int $brandId): bool;
}