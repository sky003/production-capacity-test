<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Dto\Assembler\ProductionCapacityAssembler;
use App\Dto\Request as RequestDto;
use App\Dto\Response as ResponseDto;
use App\Service\Exception\ServiceException;
use App\Service\ProductionCapacity\ProductionCapacityCrudService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * ProductionCapacityController.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionCapacityController
{
    /**
     * @var SerializerInterface
     */
    private $serializer;
    /**
     * @var ValidatorInterface
     */
    private $validator;
    /**
     * @var ProductionCapacityAssembler
     */
    private $assembler;
    /**
     * @var ProductionCapacityCrudService
     */
    private $crudService;

    public function __construct(SerializerInterface $serializer, ValidatorInterface $validator, ProductionCapacityAssembler $assembler, ProductionCapacityCrudService $crudService)
    {
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->assembler = $assembler;
        $this->crudService = $crudService;
    }

    /**
     * Batch creation of the production capacities.
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     *
     * @Route(
     *     path="/production-capacities",
     *     methods={"POST"},
     * )
     */
    public function batchCreateAction(Request $request): Response
    {
        /** @var RequestDto\ProductionCapacityList $requestList */
        $requestList = $this->serializer->deserialize(
            $request->getContent(),
            RequestDto\ProductionCapacityList::class,
            'json'
        );

        $responseList = new ResponseDto\ProductionCapacityList();
        foreach ($requestList->getProductionCapacities() as $key => $dto) {
            // Stage 1: validate
            $errors = $this->validator->validate($dto, null, ['OpCreate']);
            if (\count($errors) > 0) {
                $responseList->addProductionCapacityListItem(
                    new ResponseDto\ProductionCapacityListItem(
                        Response::HTTP_UNPROCESSABLE_ENTITY,
                        'Production capacity resource is not valid.',
                        null,
                        $errors
                    )
                );

                continue;
            }

            // Stage 2: write an entity
            $entity = $this->assembler->writeEntity($dto);

            // Stage 3: call the proper service to handle an entity
            try {
                $this->crudService->create($entity);
            } catch (ServiceException $e) {
                $responseList->addProductionCapacityListItem(
                    new ResponseDto\ProductionCapacityListItem(
                        Response::HTTP_INTERNAL_SERVER_ERROR,
                        'Error occurred while trying to create the production capacity resource.'
                    )
                );

                continue;
            }

            // Stage 4: write dto
            $dto = $this->assembler->writeDto($entity);

            $responseList->addProductionCapacityListItem(
                new ResponseDto\ProductionCapacityListItem(
                    Response::HTTP_CREATED,
                    'Production capacity resource successfully created.',
                    $dto
                )
            );
        }

        return new JsonResponse(
            $this->serializer->serialize(
                $responseList,
                'json'
            ),
            Response::HTTP_MULTI_STATUS,
            [],
            true
        );
    }
}
