<?php
declare(strict_types=1);

namespace framework\json;

use ReflectionProperty;

class JsonProperty
{
    private object $object;
    private ReflectionProperty $reflectionProperty;

    /**
     * @var string|JsonType[]
     */
    private array $types = [];

    public function __construct(object $object, ReflectionProperty $reflectionProperty)
    {
        $this->object = $object;
        $this->reflectionProperty = $reflectionProperty;

        if ($this->reflectionProperty->hasType()) {
            $type = $this->reflectionProperty->getType();
            switch (get_class($type)) {
                case "ReflectionNamedType":
                    if ($type->isBuiltin()) {
                        $this->types[] = JsonType::resolve($type->getName());
                    } else {
                        $this->types[] = $type->getName();
                    }
                    if ($type->allowsNull()) {
                        $this->types[] = JsonType::Null;
                    }
                    break;
                case "ReflectionUnionType":
                    $types = $type->getTypes();
                    foreach ($types as $type) {
                        if ($type->isBuiltin()) {
                            $this->types[] = JsonType::resolve($type->getName());
                        } else {
                            $this->types[] = $type->getName();
                        }
                    }
                    break;
            }
        } else {
            $this->types[] = JsonType::Unknown;
        }
    }

    public function getName(): string
    {
        return $this->reflectionProperty->getName();
    }

    /**
     * @return JsonType[]|string
     */
    public function getTypes(): array|string
    {
        return $this->types;
    }

    public function getValue(): mixed
    {
        return $this->reflectionProperty->getValue($this->object);
    }

    public function getValueType(): JsonType
    {
        if ($this->isInitialized()) {
            return JsonType::resolve(gettype($this->getValue()));
        }
        return JsonType::Unknown;
    }

    public function setValue(mixed $value): void
    {
        $this->reflectionProperty->setValue($this->object, $value);
    }

    public function hasDefaultValue(): bool
    {
        return $this->reflectionProperty->hasDefaultValue();
    }

    public function isInitialized(): bool
    {
        return $this->reflectionProperty->isInitialized($this->object);
    }

    public function allowsNull(): bool
    {
        return in_array(JsonType::Null, $this->types);
    }

    public function isDefault(): bool
    {
        return $this->reflectionProperty->isDefault();
    }

    public function getModifiers(): int
    {
        return $this->reflectionProperty->getModifiers();
    }

}