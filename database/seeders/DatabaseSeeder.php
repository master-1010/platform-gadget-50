<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['National', 'International', 'Politics', 'Business', 'Technology', 'Sports', 'Community'] as $index => $name) {
            Category::query()->firstOrCreate(
                ['slug' => str($name)->slug()->toString()],
                ['name' => $name, 'sort_order' => $index]
            );
        }
    }
}
