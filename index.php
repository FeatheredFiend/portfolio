<?php

use App\Kernel;

$_SERVER['APP_RUNTIME_OPTIONS'] = require __DIR__.'/config/runtime.php';
require_once __DIR__.'/vendor/autoload_runtime.php';

return static function (array $context) {
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
