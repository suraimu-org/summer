<?php

namespace framework\validation;

use ReflectionObject;

class PropertyValidation extends Validation
{
    public function __construct(ReflectionObject $reflectionParameter, mixed $value)
    {
        $this->value = $value;
        $this->attribute($reflectionParameter->getAttributes());
    }
}