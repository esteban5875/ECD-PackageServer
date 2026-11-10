<?php

use App\Models\Package;
use App\Services\Repository\RepositoryDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class RepositoryDatabaseTest extends TestCase 
{  
    use RefreshDatabase;
    private RepositoryDatabase $repository;
    private string $path;
    public function setUp(): void
    {
        parent::setUp();
        $this->path = sys_get_temp_dir() . '/repo-test-' . uniqid() . '.sqlite';
        $this->repository = new RepositoryDatabase($this->path);
        $this->repository->initialize();
        Carbon::setTestNow();
        
    }

    protected function tearDown(): void
    {
        @unlink($this->path);
        parent::tearDown();
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

    public function test_get_all_entries(): void
{
        $created = collect(Package::factory()->count(3)->make()->toArray())
            ->map(fn (array $data) => $this->repository->addEntry($data));

        $all = $this->repository->getAllEntries();
        $this->assertCount(3, $all);
        $this->assertEqualsCanonicalizing(
            $created->pluck('id')->all(),
            $all->pluck('id')->all()
        );
    }

    public function test_update_entry(): void 
    {
        $packageData = Package::factory()->make()->toArray();

        Carbon::setTestNow('2026-01-01 10:00:00');
        $package = $this->repository->addEntry($packageData);

        Carbon::setTestNow('2026-01-01 10:05:00');
        $updated = $this->repository->updateEntry($package->id, ['description' => 'changed']);

        $this->assertEquals('2026-01-01 10:00:00', $package->created_at->toDateTimeString());
        $this->assertEquals('2026-01-01 10:05:00', $updated->updated_at->toDateTimeString());
        $this->assertEquals('2026-01-01 10:00:00', $updated->created_at->toDateTimeString());
        $this->assertEquals($updated->description, "changed");
    }

    public function test_delete_entry(): void {
        $packageData = Package::factory()->make()->toArray();
        $package = $this->repository->addEntry($packageData);
        $delete = $this->repository->deleteEntry($package->id);
        $this->assertInstanceOf(Package::class, $delete);
        $this->assertEquals($package->id, $delete->id);
    }

    public function test_package_exists(): void {
        $packageData = Package::factory()->make()->toArray();
        $package = $this->repository->addEntry($packageData);
        $this->assertTrue($this->repository->exists($package->id));
    }
}
