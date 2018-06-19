<?php

declare(strict_types = 1);

namespace App\Tests\Functional;

use App\DataFixtures\ProductGroupFixtureLoader;
use App\DataFixtures\ProductionCapacityFixtureLoader;
use App\DataFixtures\ProductionUnitFixtureLoader;
use App\DataFixtures\TimeUnitFixtureLoader;
use App\Entity\ProductGroup;
use App\Entity\ProductionUnit;
use App\Entity\TimeUnit;
use FunctionalTester;

class ProductionCapacityCest
{
    /**
     * @var \App\Component\Doctrine\Common\DataFixtures\AbstractFixture
     */
    private $fixture;

    public function _before(FunctionalTester $I): void
    {
        $this->fixture = $I->loadFixture(ProductionCapacityFixtureLoader::class);
    }

    public function testBatchCreate(FunctionalTester $I): void
    {
        /** @var TimeUnit $timeUnit */
        $timeUnit = $this->fixture->getReference(TimeUnitFixtureLoader::REF_TIME_UNIT, 2);
        /** @var ProductionUnit $productionUnit */
        $productionUnit = $this->fixture->getReference(ProductionUnitFixtureLoader::REF_PRODUCTION_UNIT, 1);
        /** @var ProductGroup $productGroup */
        $productGroup = $this->fixture->getReference(ProductGroupFixtureLoader::REF_PRODUCT_GROUP, 3);

        $data = [
            [
                'timeUnitId' => $timeUnit->getId(),
                'productionUnitId' => $productionUnit->getId(),
                'productGroupId' => $productGroup->getId(),
                'amount' => 150,
            ],
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/production-capacities', $data);

        $I->seeResponseCodeIs(207);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'statusCode' => 201,
                'message' => 'Production capacity resource successfully created.',
                'resource' => $data[0],
            ]
        ]);
    }

    public function testBatchCreateFewResources(FunctionalTester $I): void
    {
        /** @var TimeUnit $timeUnit */
        $timeUnit = $this->fixture->getReference(TimeUnitFixtureLoader::REF_TIME_UNIT, 2);
        /** @var ProductionUnit $productionUnit1 */
        $productionUnit1 = $this->fixture->getReference(ProductionUnitFixtureLoader::REF_PRODUCTION_UNIT, 1);
        /** @var ProductionUnit $productionUnit2 */
        $productionUnit2 = $this->fixture->getReference(ProductionUnitFixtureLoader::REF_PRODUCTION_UNIT, 2);
        /** @var ProductGroup $productGroup */
        $productGroup = $this->fixture->getReference(ProductGroupFixtureLoader::REF_PRODUCT_GROUP, 3);

        $data = [
            [
                'timeUnitId' => $timeUnit->getId(),
                'productionUnitId' => $productionUnit1->getId(),
                'productGroupId' => $productGroup->getId(),
                'amount' => 150,
            ],
            [
                'timeUnitId' => $timeUnit->getId(),
                'productionUnitId' => $productionUnit2->getId(),
                'productGroupId' => $productGroup->getId(),
                'amount' => 200,
            ],
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/production-capacities', $data);

        $I->seeResponseCodeIs(207);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'statusCode' => 201,
                'message' => 'Production capacity resource successfully created.',
                'resource' => $data[0],
            ],
            [
                'statusCode' => 201,
                'message' => 'Production capacity resource successfully created.',
                'resource' => $data[1],
            ],
        ]);
    }

    public function testBatchCreateWithNotValidData(FunctionalTester $I): void
    {
        /** @var TimeUnit $timeUnit */
        $timeUnit = $this->fixture->getReference(TimeUnitFixtureLoader::REF_TIME_UNIT, 2);
        /** @var ProductGroup $productGroup */
        $productGroup = $this->fixture->getReference(ProductGroupFixtureLoader::REF_PRODUCT_GROUP, 3);

        $data = [
            [
                'timeUnitId' => $timeUnit->getId(),
                'productionUnitId' => null,
                'productGroupId' => $productGroup->getId() + 1000, // This entity definitely doesn't exists.
                'amount' => 150,
            ],
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/production-capacities', $data);

        $I->seeResponseCodeIs(207);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'statusCode' => 422,
                'message' => 'Production capacity resource is not valid.',
                'validationErrors' => [
                    'violations' => [
                        [
                            'propertyPath' => 'productionUnitId',
                            'title' => 'This value should not be null.',
                        ],
                        [
                            'propertyPath' => 'productGroupId',
                            'title' => 'This value should exist.',
                        ],
                    ],
                ],
            ]
        ]);
    }

    public function testBatchCreateFewResourcesButOneWithNotValidData(FunctionalTester $I): void
    {
        /** @var TimeUnit $timeUnit */
        $timeUnit = $this->fixture->getReference(TimeUnitFixtureLoader::REF_TIME_UNIT, 2);
        /** @var ProductionUnit $productionUnit1 */
        $productionUnit1 = $this->fixture->getReference(ProductionUnitFixtureLoader::REF_PRODUCTION_UNIT, 1);
        /** @var ProductionUnit $productionUnit2 */
        $productionUnit2 = $this->fixture->getReference(ProductionUnitFixtureLoader::REF_PRODUCTION_UNIT, 2);
        /** @var ProductGroup $productGroup */
        $productGroup = $this->fixture->getReference(ProductGroupFixtureLoader::REF_PRODUCT_GROUP, 3);

        $data = [
            [
                'timeUnitId' => $timeUnit->getId(),
                'productionUnitId' => $productionUnit1->getId(),
                'productGroupId' => $productGroup->getId(),
                'amount' => 150,
            ],
            [
                'timeUnitId' => $timeUnit->getId(),
                'productionUnitId' => $productionUnit2->getId(),
                'productGroupId' => $productGroup->getId() + 1000,
                'amount' => null,
            ],
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/production-capacities', $data);

        $I->seeResponseCodeIs(207);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            [
                'statusCode' => 201,
                'message' => 'Production capacity resource successfully created.',
                'resource' => $data[0],
            ],
            [
                'statusCode' => 422,
                'message' => 'Production capacity resource is not valid.',
                'validationErrors' => [
                    'violations' => [
                        [
                            'propertyPath' => 'amount',
                            'title' => 'This value should not be null.',
                        ],
                        [
                            'propertyPath' => 'productGroupId',
                            'title' => 'This value should exist.',
                        ],
                    ],
                ],
            ],
        ]);
    }
}
