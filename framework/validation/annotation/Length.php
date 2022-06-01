<?php


namespace framework\validation\annotation;

use Attribute;

/**
 * 校验 注解 字符串长度在否在给定的范围之内
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class Length
{
    /**
     * 最小长度
     * @var int
     */
    public readonly int $min;
    /**
     * 最大长度
     * @var int
     */
    public readonly int $max;
    /**
     * 提示信息
     * @var string
     */
    public readonly string $message;

    /**
     * Construct Length
     * @param int $min 最小长度
     * @param int $max 最大长度
     * @param string $message 提示信息
     */
    public function __construct(int $min = 0 , int $max = PHP_INT_MAX , string $message = "length must be between {min} and {max}")
    {
        $this->min = $min;
        $this->max = $max;
        $this->message = $message;
    }
}