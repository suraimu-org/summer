<?php

namespace framework\validation;

use framework\validation\annotation\Length;
use framework\validation\annotation\NotEmpty;
use framework\validation\annotation\Pattern;
use framework\validation\annotation\PatternModifier;
use ReflectionAttribute;

class Validation
{
    protected mixed $value;

    /**
     * attribute
     * @param ReflectionAttribute[] $attributes
     * @return void
     */
    protected function attribute(ReflectionAttribute|array $attributes): void
    {
        foreach ($attributes as $attribute) {
            switch ($attribute->getName()) {
                case NotEmpty::class:
                    call_user_func([$this, "notEmpty"], $attribute->newInstance());
                    break;
                case Length::class:
                    call_user_func([$this, "Length"], $attribute->newInstance());
                    break;
                case Pattern::class:
                    call_user_func([$this, "pattern"], $attribute->newInstance());
                    break;
            }
        }
    }

    /**
     * @throws ValidationException
     */
    private function notEmpty(NotEmpty $notEmpty): void
    {
        if (empty($this->value)) {
            throw new ValidationException($notEmpty->message);
        }
    }

    /**
     * @throws ValidationException
     */
    private function Length(Length $length): void
    {
        $len = mb_strlen($this->value);
        if ($len < $length->min || $len > $length->max) {
            throw new ValidationException(str_replace(["{min}", "{max}"], [$length->min, $length->max], $length->message));
        }
    }

    /**
     * @throws ValidationException
     */
    private function pattern(Pattern $pattern): void
    {
        $modifier = match (gettype($pattern->modifiers)) {
            "object" => $pattern->modifiers->value,
            "array" => implode(array_map(function (PatternModifier $modifier) {
                return $modifier->value;
            }, $pattern->modifiers))
        };
        $regexp = sprintf("/%s/%s", $pattern->regexp, $modifier);

        $match = preg_match($regexp, $this->value);

        if ($match === 0) {
            throw new ValidationException(str_replace("{regexp}", $regexp, $pattern->message));
        } elseif ($match === false) {
            throw new ValidationException(preg_last_error_msg(), preg_last_error());
        }
    }

}