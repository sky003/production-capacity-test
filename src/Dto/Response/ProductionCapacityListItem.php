<?php

declare(strict_types = 1);

namespace App\Dto\Response;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ProductionCapacityListItem
{
    /**
     * @var int
     */
    private $statusCode;
    /**
     * @var string
     */
    private $message;
    /**
     * @var ProductionCapacity
     */
    private $resource;
    /**
     * @var ConstraintViolationListInterface
     */
    private $validationErrors;

    public function __construct(int $statusCode, string $message, ?ProductionCapacity $resource = null, ?ConstraintViolationListInterface $validationErrors = null)
    {
        $this->statusCode = $statusCode;
        $this->message = $message;
        $this->resource = $resource;
        $this->validationErrors = $validationErrors;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return self
     */
    public function setStatusCode(int $statusCode): ProductionCapacityListItem
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     *
     * @return self
     */
    public function setMessage(string $message): ProductionCapacityListItem
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return ProductionCapacity
     */
    public function getResource(): ?ProductionCapacity
    {
        return $this->resource;
    }

    /**
     * @param ProductionCapacity $resource
     *
     * @return self
     */
    public function setResource(ProductionCapacity $resource): ProductionCapacityListItem
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * @return ConstraintViolationListInterface
     */
    public function getValidationErrors(): ?ConstraintViolationListInterface
    {
        return $this->validationErrors;
    }

    /**
     * @param ConstraintViolationListInterface $validationErrors
     *
     * @return self
     */
    public function setValidationErrors(ConstraintViolationListInterface $validationErrors): ProductionCapacityListItem
    {
        $this->validationErrors = $validationErrors;

        return $this;
    }
}
