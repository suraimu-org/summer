<?php

namespace framework\json;

use ReflectionEnum;
use ReflectionException;
use UnitEnum;

class JsonEnum
{
    private ReflectionEnum $reflectionEnum;

    /**
     * @throws JsonException
     */
    public function __construct(object|string $objectOrClass)
    {
        try {
            $this->reflectionEnum = new ReflectionEnum($objectOrClass);
        } catch (ReflectionException $e) {
            throw new JsonException($e->getMessage(), $e->getCode());
        }
    }

    public function getEnum(int|string $value): ?UnitEnum
    {
        if ($this->reflectionEnum->isBacked()) {
            foreach ($this->reflectionEnum->getCases() as $case) {
                if ($case->getBackingValue() == $value) return $case->getValue();
            }
            return null;
        } else {
            try {
                return $this->reflectionEnum->getCase($value)->getValue();
            } catch (ReflectionException $e) {
                return null;
            }
        }
    }
}
