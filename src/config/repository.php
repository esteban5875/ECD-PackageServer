<?php

return [
    'db_path'      => env('REPOSITORY_DB_PATH', dirname(base_path()) . '/repo/repository.sqlite'),
    'storage_path' => env('REPOSITORY_STORAGE_PATH', dirname(base_path()) . '/repo/packages'),
];