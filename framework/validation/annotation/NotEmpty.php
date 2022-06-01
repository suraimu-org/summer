<?php


namespace framework\validation\annotation;

use Attribute;

/**
 * 校验 注解 不能为空
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER)]
class NotEmpty
{
    /**
     * 提示信息
     * @var string
     */
    public readonly string $message;

    /**
     * Construct NotEmpty
     * @param string $message 提示信息
     */
    public function __construct(string $message = "must not be empty")
    {
        $this->message = $message;
    }
}