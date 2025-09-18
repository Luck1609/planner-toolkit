<?php

namespace Database\Seeders;

use App\Models\Region;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
  private $regions;

  public function __construct()
  {
    $this->regions = $this->loadData();
  }

  private function loadData()
  {
    return require 'data/regions.php';
  }

  public function run(): void
  {
    foreach ($this->regions as $region) {
      $savedRegion = Region::create(['name' => $region['name']]);
      $savedRegion->districts()->createMany($region['districts']);
    }
  }
}
