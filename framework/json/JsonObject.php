<?php
declare(strict_types=1);

namespace framework\json;

use ReflectionClass;
use ReflectionException;
use ReflectionObject;
use ReflectionProperty;


class JsonObject
{
    private object $object;

    private ReflectionObject $reflectionObject;

    private array $properties;

    /**
     * @throws JsonException
     */
    public function __construct(string|object $objectOrClass)
    {
        if (gettype($objectOrClass) === "string") {
            try {
                $this->object = (new ReflectionClass($objectOrClass))->newInstanceWithoutConstructor();
            } catch (ReflectionException $e) {
                throw new JsonException($e->getMessage(), $e->getCode());
            }
        } else {
            $this->object = $objectOrClass;
        }
        $this->reflectionObject = new ReflectionObject($this->object);

        foreach ($this->reflectionObject->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            $this->properties[$property->name] = new JsonProperty($this->object, $property);
        }
    }

    /**
     * 获取属性
     * @param string $name 属性名
     * @return JsonProperty|null
     */
    public function getProperty(string $name): ?JsonProperty
    {
        return $this->properties[$name] ?? null;
    }

    /**
     * 获取属性列表
     * @return JsonProperty[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }


    public function getObject(): object
    {
        return $this->object;
    }
}
