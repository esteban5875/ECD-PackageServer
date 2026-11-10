<?php

namespace App\Services;

class FileStore
{
    public function __construct(private $storage_path = null)
    {
        $this->storage_path = $storage_path ?? config('repository.storage_path');
    }
}
