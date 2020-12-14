<?php

require __DIR__ . '/vendor/autoload.php';

echo 'Using PHP extensions: ';

if (getenv('USE_PHP_EXTENSIONS') === 'false') {
    define('NO_PHP_EXTENSIONS', true);
    echo 'NO';
} else {
    echo 'YES';
}

echo PHP_EOL;
