<?php declare(strict_types=1);

namespace Kalicr\BrandListing\Api\Data;

interface BrandInterface
{
    const BRAND_ID = 'brand_id';
    const NAME = 'name';
    const SELECTOR_ID = 'selector_id';
    const IS_ACTIVE = 'is_active';

    /**
     * @return int|null
     */
    public function getBrandId(): ?int;

    /**
     * @param int|null $brandId
     * @return void
     */
    public function setBrandId(?int $brandId): void;

    /**
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * @param string|null $name
     * @return void
     */
    public function setName(?string $name): void;

    /**
     * @return string|null
     */
    public function getSelectorId(): ?string;

    /**
     * @param string|null $selectorId
     * @return void
     */
    public function setSelectorId(?string $selectorId): void;

    /**
     * @return bool|null
     */
    public function getIsActive(): ?bool;

    /**
     * @param bool|null $isActive
     * @return void
     */
    public function setIsActive(?bool $isActive): void;
}