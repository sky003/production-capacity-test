<?php

declare(strict_types = 1);

namespace App\Dto\Response;

/**
 * DTO object which represents a proper serialized json object.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionCapacity
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var int
     */
    private $productionUnitId;
    /**
     * @var int
     */
    private $timeUnitId;
    /**
     * @var int
     */
    private $productGroupId;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var \DateTime
     */
    private $createdAt;
    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): ProductionCapacity
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductionUnitId(): int
    {
        return $this->productionUnitId;
    }

    /**
     * @param int $productionUnitId
     *
     * @return self
     */
    public function setProductionUnitId(int $productionUnitId): ProductionCapacity
    {
        $this->productionUnitId = $productionUnitId;

        return $this;
    }

    /**
     * @return int
     */
    public function getTimeUnitId(): int
    {
        return $this->timeUnitId;
    }

    /**
     * @param int $timeUnitId
     *
     * @return self
     */
    public function setTimeUnitId(int $timeUnitId): ProductionCapacity
    {
        $this->timeUnitId = $timeUnitId;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductGroupId(): int
    {
        return $this->productGroupId;
    }

    /**
     * @param int $productGroupId
     *
     * @return self
     */
    public function setProductGroupId(int $productGroupId): ProductionCapacity
    {
        $this->productGroupId = $productGroupId;

        return $this;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     *
     * @return self
     */
    public function setAmount(int $amount): ProductionCapacity
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt): ProductionCapacity
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(?\DateTime $updatedAt): ProductionCapacity
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
