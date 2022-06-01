<?php


namespace framework\validation\annotation;

use Attribute;

/**
 * 正则验证
 */
#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_PARAMETER | Attribute::IS_REPEATABLE)]
class Pattern
{
    /**
     * 正则表达式
     * @var string
     */
    public readonly string $regexp;
    /**
     * 正则修饰符
     * @var PatternModifier[]|PatternModifier
     */
    public readonly array|PatternModifier $modifiers;
    /**
     * 提示信息
     * @var string
     */
    public readonly string $message;

    /**
     * Construct Pattern
     * @param string $regexp 正则表达式
     * @param PatternModifier[]|PatternModifier $modifiers 正则修饰符
     * @param string $message 提示信息
     */
    public function __construct(string $regexp, array|PatternModifier $modifiers = [], string $message = "must match \"{regexp}\"")
    {
        $this->regexp = $regexp;
        $this->modifiers = $modifiers;
        $this->message = $message;

    }

}