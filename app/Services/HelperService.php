<?php

namespace App\Services;

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
}
