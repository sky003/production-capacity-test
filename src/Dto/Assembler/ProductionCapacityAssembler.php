<?php

declare(strict_types = 1);

namespace App\Dto\Assembler;

use App\Dto\Request;
use App\Dto\Response;
use App\Entity;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Assembler implementation for the production capacity.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionCapacityAssembler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Write an entity object from the provided DTO object.
     *
     * @param Request\ProductionCapacity $dto
     *
     * @return Entity\ProductionCapacity
     * @throws \Doctrine\ORM\ORMException
     */
    public function writeEntity(Request\ProductionCapacity $dto): Entity\ProductionCapacity
    {
        /** @var Entity\ProductionUnit $productionUnit */
        $productionUnit = $this->entityManager->getReference(Entity\ProductionUnit::class, $dto->getProductionUnitId());
        /** @var Entity\TimeUnit $timeUnit */
        $timeUnit = $this->entityManager->getReference(Entity\TimeUnit::class, $dto->getTimeUnitId());
        /** @var Entity\ProductGroup $productGroup */
        $productGroup = $this->entityManager->getReference(Entity\ProductGroup::class, $dto->getProductGroupId());

        $entity = new Entity\ProductionCapacity();
        $entity
            ->setProductionUnit($productionUnit)
            ->setTimeUnit($timeUnit)
            ->setProductGroup($productGroup)
            ->setAmount($dto->getAmount());

        return $entity;
    }

    /**
     * Write DTO object from the provided entity object.
     *
     * @param Entity\ProductionCapacity $entity
     *
     * @return Response\ProductionCapacity
     */
    public function writeDto(Entity\ProductionCapacity $entity): Response\ProductionCapacity
    {
        $dto = new Response\ProductionCapacity();
        $dto
            ->setId($entity->getId())
            ->setProductionUnitId($entity->getProductionUnit()->getId())
            ->setTimeUnitId($entity->getTimeUnit()->getId())
            ->setProductGroupId($entity->getProductGroup()->getId())
            ->setAmount($entity->getAmount())
            ->setCreatedAt($entity->getCreatedAt())
            ->setUpdatedAt($entity->getUpdatedAt());

        return $dto;
    }
}
