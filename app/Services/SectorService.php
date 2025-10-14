<?php

namespace App\Services;

class SectorService
{
  public static function getBlocks(): array
  {
    return collect(range(0, 25))->reduce(function (array $blocks = [], int $index) {
      $letter = chr(65 + $index);

      return $letter === 'I'
        ? $blocks
        : [...$blocks, "Block $letter" => "Block $letter"];
    }, []);
  }
}
