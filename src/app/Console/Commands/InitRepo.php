<?php

namespace App\Console\Commands;

use App\Services\Repository\RepositoryDatabase;
use Illuminate\Console\Command;

class InitRepo extends Command
{
    protected $signature = 'repo:init {--fresh : Drop and recreate the packages table}';

    protected $description = 'Create the repository SQLite database and run its migrations';

    public function handle(RepositoryDatabase $repository): int
    {
        $repository->initialize();

        $this->info('Repository database ready.');

        return self::SUCCESS;
    }
}