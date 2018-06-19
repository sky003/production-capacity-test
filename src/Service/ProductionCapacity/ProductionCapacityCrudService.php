<?php

declare(strict_types = 1);

namespace App\Service\ProductionCapacity;

use App\Entity\ProductionCapacity;
use App\Service\CrudServiceInterface;
use App\Service\Exception\ServiceException;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Service that provides a basic CRUD operations for `ProductionCapacity` entity.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionCapacityCrudService implements CrudServiceInterface
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
     * @param int $id
     *
     * @return null|object
     * @throws ServiceException
     */
    public function get(int $id): ?object
    {
        throw new \BadMethodCallException(
            \sprintf('%s method is not implemented.', __METHOD__)
        );
    }

    /**
     * @param Criteria $criteria
     *
     * @return Collection
     * @throws ServiceException
     */
    public function getList(Criteria $criteria): Collection
    {
        throw new \BadMethodCallException(
            \sprintf('%s method is not implemented.', __METHOD__)
        );
    }

    /**
     * Handle creation of the new production capacity entity.
     *
     * @param object $entity
     *
     * @throws ServiceException
     */
    public function create(object $entity): void
    {
        $this->throwExceptionIfNotSupported($entity);

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param object $entity
     *
     * @throws ServiceException
     */
    public function update(object $entity): void
    {
        throw new \BadMethodCallException(
            \sprintf('%s method is not implemented.', __METHOD__)
        );
    }

    /**
     * @param int $id
     *
     * @throws ServiceException
     */
    public function delete(int $id): void
    {
        throw new \BadMethodCallException(
            \sprintf('%s method is not implemented.', __METHOD__)
        );
    }

    private function throwExceptionIfNotSupported(object $entity): void
    {
        if (!$entity instanceof ProductionCapacity) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Entity must be an instance of "%s" ("%s" given).',
                    ProductionCapacity::class,
                    \get_class($entity)
                )
            );
        }
    }
}
