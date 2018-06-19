<?php

declare(strict_types = 1);

namespace App\Dto\Response;

/**
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionCapacityList
{
    /**
     * @var array
     */
    private $productionCapacityListItems;

    public function __construct()
    {
        $this->productionCapacityListItems = [];
    }

    /**
     * @return array
     */
    public function getProductionCapacities(): array
    {
        return $this->productionCapacityListItems;
    }

    /**
     * @param array $productionCapacityListItems
     *
     * @return self
     */
    public function setProductionCapacityListItems(array $productionCapacityListItems): ProductionCapacityList
    {
        $this->productionCapacityListItems = $productionCapacityListItems;

        return $this;
    }

    /**
     * @param ProductionCapacityListItem $productionCapacityListItem
     *
     * @return self
     */
    public function addProductionCapacityListItem(ProductionCapacityListItem $productionCapacityListItem): ProductionCapacityList
    {
        $this->productionCapacityListItems[] = $productionCapacityListItem;

        return $this;
    }
}
