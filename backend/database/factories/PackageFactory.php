<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Package>
 */
class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        $name = fake()->slug(2);
        $version = fake()->semver();

        return [
            'name' => $name,
            'version' => $version,
            'description' => fake()->sentence(),
            'filename' => "{$name}-{$version}.tar.gz",
            'checksum' => fake()->sha256(),
            'size' => fake()->numberBetween(1024, 50_000_000),
            'uploaded_at' => now(),
        ];
    }
}