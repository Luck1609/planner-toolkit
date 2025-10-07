<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $user = User::create([
      'firstname' => 'Nathaniel',
      'lastname' => 'Obeng',
      'email' => 'nathanielobeng0@gmail.com',
      'password' => Hash::make('1234')
    ]);

    $user->contacts()->create(['phone_number' => '0503894555', 'is_primary' => true]);
  }
}
