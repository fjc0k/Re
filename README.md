```php
<?php

use Funch\ReStatic as Re;

$text = 1234;

echo Re::pattern('12')
    ->subject($text)
    ->replace(56); // 5634

print_r(
    Re::subject([
        $text,
        'hello, PHP'
    ])->replace([
        '/12/' => '00',
        '/php/i' => 'China'
    ])
);
// Array
// (
//     [0] => 0034
//     [1] => hello, China
// )
````