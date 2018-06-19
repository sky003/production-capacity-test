<?php

declare(strict_types = 1);

namespace App\Component\Validator\Constraints;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

/**
 * Validator for `ExistEntity` constraint.
 *
 * @author Anton Pelykh <anton.pelykh.dev@gmail.com>
 */
class ExistEntityValidator extends ConstraintValidator
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
     * {@inheritdoc}
     */
    public function validate($value, Constraint $constraint): void
    {
        if (!$constraint instanceof ExistEntity) {
            throw new UnexpectedTypeException($constraint, __NAMESPACE__.'\ExistEntity');
        }

        if (null === $value) {
            return;
        }

        /** @var $class \Doctrine\ORM\Mapping\ClassMetadata */
        $class = $this->entityManager->getClassMetadata($constraint->entityClass);

        if (!$class->hasField($constraint->property)) {
            throw new ConstraintDefinitionException(
                \sprintf(
                    'The field "%s" is not mapped by Doctrine, so it cannot be validated for existence.',
                    $constraint->property
                )
            );
        }

        $criteria[$constraint->property] = $value;
        $repository = $this->entityManager->getRepository($constraint->entityClass);
        $result = $repository->{$constraint->repositoryMethod}($criteria);

        if (0 !== \count($result)) {
            return;
        }

        $this->context->buildViolation($constraint->message)

            ->setCode(ExistEntity::NOT_EXIST_ERROR)
            ->addViolation();
    }
}
