<?php

namespace App\Services;

use App\Models\MonthlySession;
use App\Models\Setting;

class HelperService
{
  public static function getBlocks()
  {
    return collect(range(0, 25))->reduce(function (array $blocks = [], int $index) {
      $letter = chr(65 + $index);

      return $letter === 'I'
        ? $blocks
        : [...$blocks, "Block $letter" => "Block $letter"];
    }, []);
  }

  public static function getTitles(): array
  {
    $titles = Setting::where('name', 'titles')->first()->value;
    return collect($titles)->reduce(fn($allTitles, $title) => [...$allTitles, $title => $title], []);
  }
}
