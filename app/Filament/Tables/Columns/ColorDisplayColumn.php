<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\Column;

class ColorDisplayColumn extends Column
{
    protected string $view = 'filament.tables.columns.color-display-column';

  // The map
  protected array $colorMap = [
    'primary' => '#00BBA7',
    'success' => '#16a34a',
    'warning' => '#f59e0b',
    'danger'  => '#ef4444',
    'info'    => '#0ea5e9',
  ];

  public function mapColor(array $map): static
  {
    $this->colorMap = $map;

    return $this;
  }

  public function getMappedColor(): string
  {
    $state = $this->getState();

    return $this->colorMap[$state] ?? '#9ca3af';
  }
}
