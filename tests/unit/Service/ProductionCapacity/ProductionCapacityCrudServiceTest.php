<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Service\ProductionCapacity;

use App\Entity\ProductionCapacity;
use App\Entity\TimeUnit;
use App\Service\ProductionCapacity\ProductionCapacityCrudService;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;

class ProductionCapacityCrudServiceTest extends Unit
{
    public function testCreate(): void
    {
        // Entity we want to test with.
        $entity = new ProductionCapacity();
        $entity
            ->setAmount(100);

        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
        $entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($entity)
            ->willReturnCallback(function (object $entity) {
                if ($entity instanceof ProductionCapacity) {
                    $entity->setId(1);
                }
            });
        $entityManager
            ->expects($this->once())
            ->method('flush');

        /** @var EntityManagerInterface $entityManager*/
        $service = new ProductionCapacityCrudService($entityManager);
        $service->create($entity);

        $this->assertNotNull($entity->getId());
    }

    public function testCreateWhenEntityNotSupported(): void
    {
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();

        $this->expectException(\InvalidArgumentException::class);

        /** @var EntityManagerInterface $entityManager*/
        $service = new ProductionCapacityCrudService($entityManager);
        $service->create(new TimeUnit());
    }
}
