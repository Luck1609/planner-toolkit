<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SettingSeeder extends Seeder
{
  private $settings;

  public function __construct()
  {
    $this->settings = $this->loadData();
  }

  private function loadData()
  {
    return require 'data/settings.php';
  }

  public function run(): void
  {
    foreach ($this->settings as $setting) {
      Setting::create([
        ...$setting,
        'value' => $setting['value']
      ]);
    }
  }
}
