<?php declare(strict_types=1);

namespace Kalicr\BrandListing\Model;

use Magento\Framework\Model\AbstractModel;
use Kalicr\BrandListing\Api\Data\BrandInterface;

class Brand extends AbstractModel implements BrandInterface
{
    protected function _construct()
    {
        $this->_init(\Kalicr\BrandListing\Model\ResourceModel\Brand::class);
    }

    public function getBrandId(): ?int
    {
        return $this->getData('entity_id') ? (int)$this->getData('entity_id') : null;
    }

    public function setBrandId(?int $brandId): void
    {
        $this->setData('entity_id', $brandId);
    }

    public function getName(): ?string
    {
        return $this->getData('name');
    }

    public function setName(?string $name): void
    {
        $this->setData('name', $name);
    }

    public function getSelectorId(): ?string
    {
        return $this->getData('selector_id');
    }

    public function setSelectorId(?string $selectorId): void
    {
        $this->setData('selector_id', $selectorId);
    }

    public function getIsActive(): ?bool
    {
        return $this->getData('is_active') === null ? null : (bool)$this->getData('is_active');
    }

    public function setIsActive(?bool $isActive): void
    {
        $this->setData('is_active', $isActive);
    }
}