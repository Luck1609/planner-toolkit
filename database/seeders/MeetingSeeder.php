<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MeetingSeeder extends Seeder
{
  private $meetings;

  public function __construct()
  {
    $this->meetings = $this->loadData();
  }

  private function loadData()
  {
    return require 'data/meeting.php';
  }

  public function run(): void
  {
    foreach ($this->meetings as $meeting) {
      Meeting::create($meeting);
    }
  }
}
