<?php

declare(strict_types = 1);

namespace App\Dto\Request;

/**
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionCapacityList
{
    /**
     * @var ProductionCapacity[]
     */
    private $productionCapacities = [];

    /**
     * @return ProductionCapacity[]
     */
    public function getProductionCapacities(): array
    {
        return $this->productionCapacities;
    }

    /**
     * @param ProductionCapacity[] $productionCapacities
     */
    public function setProductionCapacities(array $productionCapacities): void
    {
        $this->productionCapacities = $productionCapacities;
    }

    /**
     * @param ProductionCapacity $productionCapacity
     */
    public function addProductionCapacity(ProductionCapacity $productionCapacity): void
    {
        $this->productionCapacities[] = $productionCapacity;
    }
}
