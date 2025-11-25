<?php

namespace Database\Seeders;

use App\Models\Committee;
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
      RegionSeeder::class,
      OfficeSeeder::class,
      LocalitySeeder::class,
      SectorSeeder::class,
      UserSeeder::class,
      SettingSeeder::class,
      CommitteeSeeder::class
      // MeetingSeeder::class,
    ]);
  }
}
