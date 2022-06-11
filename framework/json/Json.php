<?php
declare(strict_types=1);

namespace framework\json;

use DateTime;
use Exception;

class Json
{
    /**
     * @param string $json
     * @param object|string $target
     * @return mixed
     * @throws JsonException
     */
    public static function deserialize(string $json, object|string $target): mixed
    {

        /**
         * @throws JsonException
         */
        $deserialize = function (object|string $object, object|string $target) use (&$deserialize): object {

            $object = JsonFactory::object($object);
            $target = JsonFactory::object($target);

            foreach ($target->getProperties() as $targetProperty) {

                if (is_null($objectProperty = $object->getProperty($targetProperty->getName()))) {
                    if (!$targetProperty->hasDefaultValue() && $targetProperty->allowsNull()) {
                        $targetProperty->setValue(null);
                    }
                    continue;
                }

                switch ($objectProperty->getValueType()) {
                    case JsonType::Object:
                        $targetProperty->setValue($deserialize($objectProperty->getValue(), $targetProperty->getTypes()[0]));
                        break;
                    case JsonType::Array:

                        $array = [];
                        foreach ($objectProperty->getValue() as $value) {
                            $type = JsonType::resolve(gettype($value));
                            if ($targetProperty->getTypes()[0] == JsonType::Array) {
                                if (in_array($type, $targetProperty->getTypes())) {
                                    $array[] = $value;
                                } else {
                                    throw new JsonException(sprintf("field %s type should be %s[]", $targetProperty->getName(), $targetProperty->getTypes()[1]->name));
                                }
                            } else {
                                $array[] = $deserialize($value, $targetProperty->getTypes()[0]);
                            }
                        }
                        $targetProperty->setValue($array);
                        break;
                    case JsonType::String:
                    case JsonType::Int:
                        if ($objectProperty->getValueType() === JsonType::Array) {
                            if (!in_array($objectProperty->getValueType(), $targetProperty->getTypes())) {
                                throw new JsonException(sprintf("field %s error in type", $targetProperty->getName()));
                            }
                            $targetProperty->setValue($objectProperty->getValue());
                        } else if ($objectProperty->getValueType() == $targetProperty->getTypes()[0]) {
                            $targetProperty->setValue($objectProperty->getValue());
                        } else {

                            if (class_exists($targetProperty->getTypes()[0])) {
                                if ($targetProperty->getTypes()[0] == DateTime::class) {
                                    $datetime = $objectProperty->getValue();
                                    if ($objectProperty->getValueType() == JsonType::Int) {
                                        $datetime = sprintf("@%d", $objectProperty->getValue());
                                    }
                                    try {
                                        $targetProperty->setValue(new DateTime($datetime));
                                    } catch (Exception $e) {
                                        throw new JsonException(sprintf("%s time format resolution failed", $targetProperty->getName()));
                                    }
                                }
                            }
                            if (enum_exists($targetProperty->getTypes()[0])) {
                                $jsonEnum = JsonFactory::jsonEnum($targetProperty->getTypes()[0]);
                                if (is_null($enum = $jsonEnum->getEnum($objectProperty->getValue()))) {
                                    throw new JsonException(sprintf("%s case does not exist", $targetProperty->getName()));
                                }
                                $targetProperty->setValue($enum);
                            }
                        }
                        break;
                    case JsonType::Float:
                    case JsonType::Bool:
                    case JsonType::Null:
                        if (in_array($objectProperty->getValueType(), $targetProperty->getTypes())) {
                            $targetProperty->setValue($objectProperty->getValue());
                        }
                        break;
                    case JsonType::Unknown:
                        throw new JsonException('To be implemented');
                }

            }
            return $target->getObject();
        };

        $object = json_decode($json);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new JsonException(json_last_error_msg(), json_last_error());
        }
        return $deserialize($object, $target);
    }

}