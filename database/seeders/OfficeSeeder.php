<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Office;
use App\Models\Region;
use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $regionId = Region::where('name', 'Bono Region')->first()->id;
    $districtId = District::where('name', 'Sunyani Municipal')->first()->id;

    $office = Office::create([
      "address" => "C/o Town and Country Planning, P. O. Box 239, Sunyani, Bono Region",
      "created_at" => "2025-04-25 22:16:40",
      "district_id" => $districtId,
      "initials" => "SMA",
      "name" => "Sunyani Municipal Assembly",
      "region_id" => $regionId,
      "server_id" => null,
      "shelves" => 10,
      "sms_balance" => 0,
      "updated_at" => "2025-04-25 22:16:40"
    ]);


    $office->contacts()->create(['phone_number' => '0503894555', 'is_primary' => true]);
  }
}
