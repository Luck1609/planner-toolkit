<?php

namespace App\Services;

use Filament\Forms\Components\TextInput;

class SettingsService
{
  public static function applicationStatusForm(): array
  {
    return [
      TextInput::make('name')
        ->placeholder('Status name (Approve, Defer ...)'),
      TextInput::make('sort_order')
        ->placeholder('Sort order')
        ->numeric(),
    ];
  }
}
