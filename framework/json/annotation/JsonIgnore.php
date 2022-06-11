<?php
declare(strict_types = 1);

namespace framework\json\annotation;

use Attribute;

/**
 * 阻止对属性进行序列化或反序列化
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class JsonIgnore
{
    /**
     * 在忽略属性之前必须满足的条件
     * @var JsonIgnoreCondition
     */
    public readonly JsonIgnoreCondition $condition;

    public function __construct(JsonIgnoreCondition $condition = JsonIgnoreCondition::Always)
    {
        $this->condition = $condition;
    }
}