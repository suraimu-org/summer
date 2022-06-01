<?php

namespace framework\validation;

use ReflectionParameter;

class ParameterValidation extends Validation
{
    public function __construct(ReflectionParameter $reflectionParameter, mixed $value)
    {
        $this->value = $value;
        $this->attribute($reflectionParameter->getAttributes());
    }
}