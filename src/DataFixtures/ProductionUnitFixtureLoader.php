<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Component\Doctrine\Common\DataFixtures\AbstractFixture;
use App\Entity\ProductionUnit;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Loads five `ProductionUnit` fixtures to database.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionUnitFixtureLoader extends AbstractFixture
{
    public const REF_PRODUCTION_UNIT = 'PRODUCTION_UNIT';

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadWithReference($manager, self::REF_PRODUCTION_UNIT);
    }

    private function loadWithReference(ObjectManager $manager, string $ref): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $productionUnit = new ProductionUnit();
            $productionUnit
                ->setName($faker->unique()->word)
                ->setCreatedAt($faker->dateTimeBetween('-30 days', 'now'))
                ->setUpdatedAt($faker->dateTimeBetween($productionUnit->getCreatedAt(), 'now'));

            $manager->persist($productionUnit);

            $this->addReference($ref, $i, $productionUnit);
        }

        $manager->flush();
    }
}
