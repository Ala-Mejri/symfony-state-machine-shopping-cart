<?php

namespace App\Tests\Unit\Application\CheckoutProcess\Trait;

use App\Shared\Domain\Primitive\Entity\Entity;
use ReflectionClass;
use ReflectionException;

trait EntityReflection
{
    /**
     * @throws ReflectionException
     */
    private function setEntityId(Entity $entity, int $id): Entity
    {
        return $this->setEntityProperty($entity, 'id', $id);
    }

    /**
     * @throws ReflectionException
     */
    private function setEntityProperty(Entity $entity, string $propertyName, mixed $value): Entity
    {
        $class = new ReflectionClass($entity);
        $property = $class->getProperty($propertyName);

        $property->setValue($entity, $value);

        return $entity;
    }
}