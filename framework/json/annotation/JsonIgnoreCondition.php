<?php
declare(strict_types = 1);

namespace framework\json\annotation;

/**
 * 如何忽略序列化和反序列化时的属性
 * <ul>
 * <li><b>Never</b> 不管 IgnoreNullValues 配置如何，都将始终序列化和反序列化属性</li>
 * <li><b>Always</b> 属性将始终被忽略。</li>
 * <li><b>WhenWritingDefault</b> 仅当为 null 时才会忽略属性。</li>
 * <li><b>WhenWritingNull</b> 如果值为 null，则在序列化过程中将忽略该属性。 这仅适用于引用类型属性和字段。</li>
 * </ul>
 */
enum JsonIgnoreCondition
{
    case Never;
    case Always;
    case WhenWritingDefault;
    case WhenWritingNull;
}