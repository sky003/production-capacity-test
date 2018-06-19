<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Component\Doctrine\Common\DataFixtures\AbstractFixture;
use App\Entity\ProductGroup;
use App\Entity\ProductionCapacity;
use App\Entity\ProductionUnit;
use App\Entity\TimeUnit;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Loads five `ProductionCapacity` fixtures to database.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionCapacityFixtureLoader extends AbstractFixture implements DependentFixtureInterface
{
    public const REF_PRODUCTION_CAPACITY = 'PRODUCTION_CAPACITY';

    /**
     * {@inheritdoc}
     */
    public function getDependencies(): array
    {
        return [
            ProductionUnitFixtureLoader::class,
            TimeUnitFixtureLoader::class,
            ProductGroupFixtureLoader::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadWithReference($manager, self::REF_PRODUCTION_CAPACITY);
    }

    private function loadWithReference(ObjectManager $manager, string $ref): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            /** @var ProductionUnit $productionUnit */
            $productionUnit = $this->getReference(ProductionUnitFixtureLoader::REF_PRODUCTION_UNIT, $i);
            /** @var TimeUnit $timeUnit */
            $timeUnit = $this->getReference(TimeUnitFixtureLoader::REF_TIME_UNIT, $i);
            /** @var ProductGroup $productGroup */
            $productGroup = $this->getReference(ProductGroupFixtureLoader::REF_PRODUCT_GROUP, $i);

            $productionCapacity = new ProductionCapacity();
            $productionCapacity
                ->setProductionUnit($productionUnit)
                ->setTimeUnit($timeUnit)
                ->setProductGroup($productGroup)
                ->setAmount($faker->randomNumber())
                ->setCreatedAt($faker->dateTimeBetween('-30 days', 'now'))
                ->setUpdatedAt($faker->dateTimeBetween($productionCapacity->getCreatedAt(), 'now'));

            $manager->persist($productionCapacity);

            $this->addReference($ref, $i, $productionCapacity);
        }

        $manager->flush();
    }
}
