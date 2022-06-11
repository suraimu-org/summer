<?php
declare(strict_types=1);

namespace framework\json;

use ReflectionEnum;
use ReflectionException;

/**
 * Json类型枚举
 * <ul>
 * <li><b>Int</b> 整数</li>
 * <li><b>Float</b>  浮点数</li>
 * <li><b>String</b>  字符串</li>
 * <li><b>Bool</b>  布尔值</li>
 * <li><b>Array</b>  数组</li>
 * <li><b>Object</b>  对象</li>
 * <li><b>Null</b>  Null</li>
 * </ul>
 */
enum JsonType
{
    case Unknown;
    case Object;
    case Int;
    case Float;
    case String;
    case Bool;
    case Array;
    case Null;

    public static function resolve(string $type): JsonType
    {
        $type = str_replace(["NULL", "boolean", "integer", "double"], ["null", "bool", "int", "float"], $type);

        $reflectionEnum = new ReflectionEnum(JsonType::class);
        try {
            return $reflectionEnum->getCase(ucfirst($type))->getValue();
        } catch (ReflectionException $e) {
            return self::Unknown;
        }
    }
}