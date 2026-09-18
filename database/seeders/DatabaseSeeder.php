<?php
namespace Database\Seeders; use App\Models\Category; use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder { public function run(): void { foreach(['National','International','Politics','Business','Technology','Sports','Community'] as $i=>$name) Category::firstOrCreate(['slug'=>str($name)->slug()],['name'=>$name,'sort_order'=>$i]); } }
