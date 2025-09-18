<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Sector::insert([
      [
        "blocks" => "[\"Block A\",\"Block B\",\"Block C\",\"Block D\"]",
        "id" => "07759894-9c62-4d86-b9c0-bc1c291ec05d",
        "initials" => "SEC 1",
        "locality_id" => "3335a18d-0885-48dd-80e7-b3e97da891b9",
        "name" => "Sector 1",
      ],
      [
        "blocks" => "[\"Block A\",\"Block B\",\"Block C\",\"Block D\",\"Block E\"]",
        "id" => "4f6020be-6574-4f70-bf39-6b3533e8069e",
        "initials" => "SEC 1",
        "locality_id" => "324d7e47-7d10-490a-b152-4cb1bfe4ffc7",
        "name" => "Sector 1",
      ]
    ]);
  }
}
