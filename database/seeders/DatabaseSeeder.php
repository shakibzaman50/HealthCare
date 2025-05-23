<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionTableSeeder::class,
            CreateAdminUserSeeder::class,
            UserWithProfileSeeder::class,
            FeelingListSeeder::class,
            SugarUnitSeeder::class,
            WaterUnitSeeder::class,
            WeightUnitSeeder::class,
            HeightUnitSeeder::class,
            MedicineUnitSeeder::class,
            MedicineTypeSeeder::class,
            SugarScheduleSeeder::class,
            ActivityLevelSeeder::class,
            MedicineScheduleSeeder::class,
            BsRecordSeeder::class,
            HeartRateUnitSeeder::class,
            BPUnitSeeder::class,
            PhysicalConditionSeeder::class,
        ]);
    }
}
