<?php

declare(strict_types = 1);

namespace App\DataFixtures;

use App\Component\Doctrine\Common\DataFixtures\AbstractFixture;
use App\Entity\TimeUnit;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Loads five `TimeUnit` fixtures to database.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class TimeUnitFixtureLoader extends AbstractFixture
{
    public const REF_TIME_UNIT = 'TIME_UNIT';

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager): void
    {
        $this->loadWithReference($manager, self::REF_TIME_UNIT);
    }

    private function loadWithReference(ObjectManager $manager, string $ref): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            $timeUnit = new TimeUnit();
            $timeUnit
                ->setName($faker->unique()->word)
                ->setCreatedAt($faker->dateTimeBetween('-30 days', 'now'))
                ->setUpdatedAt($faker->dateTimeBetween($timeUnit->getCreatedAt(), 'now'));

            $manager->persist($timeUnit);

            $this->addReference($ref, $i, $timeUnit);
        }

        $manager->flush();
    }
}
