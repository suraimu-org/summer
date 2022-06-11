<?php

namespace framework\json;

/**
 * Json Factory
 */
class JsonFactory
{
    /**
     * Json Object Factory
     * @throws JsonException
     */
    public static function object(object|string $objectOrClass): JsonObject
    {
        return new JsonObject($objectOrClass);
    }

    /**
     * Json Enum Factory
     * @throws JsonException
     */
    public static function jsonEnum(object|string $objectOrClass): JsonEnum
    {
        return new JsonEnum($objectOrClass);
    }
}