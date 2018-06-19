<?php

declare(strict_types = 1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductionCapacity entity.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 *
 * @ORM\Entity()
 * @ORM\Table(name="production_capacity")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductionCapacity
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $amount;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $createdAt;
    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    private $updatedAt;

    /**
     * @var ProductionUnit
     *
     * @ORM\ManyToOne(targetEntity="ProductionUnit")
     * @ORM\JoinColumn(name="production_unit_id", referencedColumnName="id", nullable=false)
     */
    private $productionUnit;
    /**
     * @var TimeUnit
     *
     * @ORM\ManyToOne(targetEntity="TimeUnit")
     * @ORM\JoinColumn(name="time_unit_id", referencedColumnName="id", nullable=false)
     */
    private $timeUnit;
    /**
     * @var ProductGroup
     *
     * @ORM\ManyToOne(targetEntity="ProductGroup")
     * @ORM\JoinColumn(name="product_group_id", referencedColumnName="id", nullable=false)
     */
    private $productGroup;

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
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return self
     */
    public function setUpdatedAt(\DateTime $updatedAt): ProductionCapacity
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return ProductionUnit
     */
    public function getProductionUnit(): ProductionUnit
    {
        return $this->productionUnit;
    }

    /**
     * @param ProductionUnit $productionUnit
     *
     * @return self
     */
    public function setProductionUnit(ProductionUnit $productionUnit): ProductionCapacity
    {
        $this->productionUnit = $productionUnit;

        return $this;
    }

    /**
     * @return TimeUnit
     */
    public function getTimeUnit(): TimeUnit
    {
        return $this->timeUnit;
    }

    /**
     * @param TimeUnit $timeUnit
     *
     * @return self
     */
    public function setTimeUnit(TimeUnit $timeUnit): ProductionCapacity
    {
        $this->timeUnit = $timeUnit;

        return $this;
    }

    /**
     * @return ProductGroup
     */
    public function getProductGroup(): ProductGroup
    {
        return $this->productGroup;
    }

    /**
     * @param ProductGroup $productGroup
     *
     * @return self
     */
    public function setProductGroup(ProductGroup $productGroup): ProductionCapacity
    {
        $this->productGroup = $productGroup;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTime('now');
    }

    /**
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime('now');
    }
}
