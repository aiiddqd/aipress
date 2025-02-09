# AIPress

AI for WordPress https://github.com/aiiddqd/aipress

powered by https://openrouter.ai

inspired by https://github.com/deepseek-php/deepseek-laravel

roadmap and changes https://github.com/aiiddqd/aipress/pulls

# Examples

```php
<?php

use function AIPress\prompt;

/**
 * simple example
 */
echo prompt('hello world');

/**
 * example with context and system message
 */
$prompt = '
        какие категории программного обеспечения являются наиболее распространенными для бизнеса в сфере ресторанов?
    ';

    $params = [
        'model' => 'deepseek/deepseek-chat',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'You are a helpful assistant who understands services, applications and software for business and automation, and speaks French.'
            ],
            [
                'role' => 'user',
                'content' => $prompt
            ],
        ]
    ];
    // var_dump($params); exit;

echo prompt($prompt, $params);

```
