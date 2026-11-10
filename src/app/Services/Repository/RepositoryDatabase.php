<?php

namespace App\Services\Repository;

use App\Models\Package;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use RuntimeException;

class RepositoryDatabase
{
    private string $db;

    public function __construct(?string $db = null)
    {
        $this->db = $db ?? config('repository.db_path');
    }

    
    public function initialize(): void
    {
        $directory = dirname($this->db);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (!file_exists($this->db)) {
            touch($this->db);
        }

        config([
            'database.connections.repository.database' => $this->db
        ]);

        DB::purge('repository');
        DB::connection('repository')->getPdo();

        //Run a migration automatically
        $exitCode = Artisan::call('migrate', [
            '--database' => 'repository',
            '--path' => 'database/migrations/repository',
            '--force' => true,
        ]);

        if ($exitCode !== 0) {
            throw new RuntimeException(
                "Repository migration failed: " . Artisan::output()
            );
        }
    }

    public function addEntry(array $data): Package {
        return Package::create($data);
    }

    public function getEntry(string $id): ?Package {
        return Package::find($id);
    }

    public function getAllEntries() : Collection {
        return Package::all();
    }

    public function updateEntry(string $id, array $data): ?Package
    {
        $package = Package::find($id);

        if (!$package) {
            return null;
        }

        $package->update($data);

        return $package;
    }

    public function deleteEntry(string $id): ?Package {
        $package = Package::find($id);

        if (!$package) {
            return $package;
        }

        $package->delete();

        return $package;
    }

    public function exists(string $id): bool {
        return Package::whereKey($id)->exists();
    }
}
