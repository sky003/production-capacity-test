<?php

declare(strict_types = 1);

namespace App\Tests\Unit\Dto\Assembler;

use App\Dto\Assembler\ProductionCapacityAssembler;
use App\Dto\Request;
use App\Entity;
use Codeception\Test\Unit;
use Doctrine\ORM\EntityManagerInterface;

class ProductionCapacityAssemblerTest extends Unit
{
    public function testWriteEntity(): void
    {
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();
        $entityManager
            ->expects($this->any())
            ->method('getReference')
            ->willReturnCallback(function (string $entityName, int $id) {
                switch($entityName) {
                    case Entity\ProductionUnit::class:
                        return
                            (new Entity\ProductionUnit())
                                ->setId($id)
                                ->setName('ProductUnitName')
                                ->setCreatedAt(new \DateTime());
                    case Entity\TimeUnit::class:
                        return
                            (new Entity\TimeUnit())
                                ->setId($id)
                                ->setName('TimeUnitName')
                                ->setCreatedAt(new \DateTime());
                    case Entity\ProductGroup::class:
                        return
                            (new Entity\ProductGroup())
                                ->setId($id)
                                ->setName('ProductGroupName')
                                ->setCreatedAt(new \DateTime());
                    default:
                        $this->fail(
                            \sprintf(
                                'Unknown entity "%s" you want to get reference for. You probably need mock this entity.',
                                $entityName
                            )
                        );
                }
            });

        // DTO object we want to use for the test.
        $dto = new Request\ProductionCapacity();
        $dto
            ->setProductionUnitId(1)
            ->setTimeUnitId(5)
            ->setProductGroupId(10)
            ->setAmount(200);

        /** @var EntityManagerInterface $entityManager */
        $assembler = new ProductionCapacityAssembler($entityManager);
        $entity = $assembler->writeEntity($dto);

        $this->assertEquals($dto->getAmount(), $entity->getAmount());
        $this->assertNotNull($entity->getProductionUnit());
        $this->assertNotNull($entity->getTimeUnit());
        $this->assertNotNull($entity->getProductGroup());
        $this->assertNull($entity->getUpdatedAt());
    }

    public function testWriteDto(): void
    {
        $entityManager = $this->getMockBuilder(EntityManagerInterface::class)
            ->getMock();

        // Entity we want to use for the test.
        $entity = new Entity\ProductionCapacity();
        $entity
            ->setId(1)
            ->setProductionUnit(
                (new Entity\ProductionUnit())
                    ->setId(10)
            )
            ->setTimeUnit(
                (new Entity\TimeUnit())
                    ->setId(15)
            )
            ->setProductGroup(
                (new Entity\ProductGroup())
                    ->setId(22)
            )
            ->setAmount(100)
            ->setCreatedAt(new \DateTime());


        /** @var EntityManagerInterface $entityManager */
        $assembler = new ProductionCapacityAssembler($entityManager);
        $dto = $assembler->writeDto($entity);

        $this->assertEquals($entity->getAmount(), $dto->getAmount());
        $this->assertEquals($entity->getProductionUnit()->getId(), $dto->getProductionUnitId());
        $this->assertEquals($entity->getTimeUnit()->getId(), $dto->getTimeUnitId());
        $this->assertEquals($entity->getProductGroup()->getId(), $dto->getProductGroupId());
        $this->assertNull($dto->getUpdatedAt());
    }
}
