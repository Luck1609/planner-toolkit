<?php

namespace Database\Seeders;

use App\Models\Locality;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalitySeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Locality::insert([
      [
        "id" => "3335a18d-0885-48dd-80e7-b3e97da891b9",
        "initials" => "AR1",
        "name" => "Area 1",
      ],
      [
        "id" => "324d7e47-7d10-490a-b152-4cb1bfe4ffc7",
        "initials" => "AR2",
        "name" => "Area 2",
      ]
    ]);
  }
}
