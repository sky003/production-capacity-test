<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Component\Doctrine\Common\DataFixtures\AbstractFixture;
use App\Entity\ProductGroup;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Loads five `ProductGroup` fixtures to database.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductGroupFixtureLoader extends AbstractFixture
{
    public const REF_PRODUCT_GROUP = 'PRODUCT_GROUP';

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadWithReference($manager, self::REF_PRODUCT_GROUP);
    }

    private function loadWithReference(ObjectManager $manager, string $ref): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $productGroup = new ProductGroup();
            $productGroup
                ->setName($faker->unique()->word)
                ->setCreatedAt($faker->dateTimeBetween('-30 days', 'now'))
                ->setUpdatedAt($faker->dateTimeBetween($productGroup->getCreatedAt(), 'now'));

            $manager->persist($productGroup);

            $this->addReference($ref, $i, $productGroup);
        }

        $manager->flush();
    }
}
