<?php

use App\Models\Package;
use App\Services\Repository\RepositoryDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RepositoryDatabaseTest extends TestCase 
{  
    use RefreshDatabase;
    private RepositoryDatabase $repository;
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new RepositoryDatabase();
    }

    public function test_add_entry(): void
    {   
        $packageData = Package::factory()->make()->toArray();
        $package     = $this->repository->addEntry($packageData);
        $this->assertInstanceOf(Package::class, $package);
        Log::info("Data of package: ". $package->name, $package->toArray());
    }

    public function test_get_entry(): void
    {
        $packageData = Package::factory()->make()->toArray();
        $package     = $this->repository->addEntry($packageData);
        $foundPackage = $this->repository->getEntry($package->id);

        $this->assertInstanceOf(Package::class, $foundPackage);
        $this->assertEquals($package->name, $foundPackage->name);
        $this->assertEquals($package->id, $foundPackage->id);

        Log::info("Data of package: ". $package->name, $package->toArray());
    }

    
}