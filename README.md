# summer
PHP映射框架，虽有不足，值得一试。
> 名字由来 夏天开发的框架 起名summer。

理念追随简单，独立，不依赖大量第三方扩展库。
框架的每一个模块都可以单独运行，不会有太多的耦合。

目前处于开发阶段

点击链接加入群聊：[【PHP Summer 框架】](https://jq.qq.com/?_wv=1027&k=QrL9XZ8z)

![交流群](https://raw.githubusercontent.com/suraimu-org/summer/main/example/550756587.jpg)

校验使用示例
[校验使用示例图片]([https://jq.qq.com/?_wv=1027&k=QrL9XZ8z](https://github.com/suraimu-org/summer/blob/main/validation.md))

```php
<?php

use framework\validation\annotation\Length;
use framework\validation\annotation\NotEmpty;
use framework\validation\annotation\Pattern;

spl_autoload_register(function ($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $filePath = sprintf("%s%s%s.php", dirname(getcwd()), DIRECTORY_SEPARATOR, $class);
    if (is_readable($filePath)) {
        require_once $filePath;
        if (class_exists($class)) {
            return true;
        }
    }
    return false;
});

function test1(#[NotEmpty("密码不能为空")]
               #[Length(min: 6, max: 20, message: "请输入 {min} - {max} 个字符")]
               #[Pattern(regexp: "\d", message: "必须包含数字")]
               #[Pattern(regexp: "[a-z]", message: "必须包含小写字母")]
               #[Pattern(regexp: "[A-Z]", message: "必须包含大写字母")]
               string $string)
{

}

$s = new ReflectionFunction("test1");
try {
    new \framework\validation\ParameterValidation($s->getParameters()[0], "1122");
    
} catch (\framework\validation\ValidationException $e) {
    
    var_dump($e->getMessage());
}
```
