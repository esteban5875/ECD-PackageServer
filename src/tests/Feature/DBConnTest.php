<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DBConnTest extends TestCase
{
    public function test_repository_database_connects_to_existing_file(): void
    {
        $path = config('database.connections.repository.database');

        $this->assertFileExists($path, "Repository DB not found at [$path]. Run the init step first.");

        $this->assertNotNull(DB::connection('repository')->getPdo());
        $this->assertTrue(Schema::connection('repository')->hasTable('packages'));
    }
}