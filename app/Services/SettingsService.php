<?php

namespace App\Services;

use App\Enums\SettingNameEnum;
use App\Models\Setting;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Str;

class SettingsService
{
  public static function applicationStatusForm(): array
  {
    return [
      Group::make([
        TextInput::make('name')
          ->placeholder('Status name (Approve, Defer ...)')
          ->columnSpan(2),
        Select::make('color')
          ->options([
            'primary' => '<div class="flex text-teal-500 space-x-2 items-center">
              <span class="block h-5 w-5 rounded-full border border-teal-500 bg-teal-500"></span>
              <span class="">Primary</span>
            </div>',
            'success' => '<div class="flex text-green-500 space-x-2 items-center">
              <span class="block h-5 w-5 rounded-full border border-green-500 bg-green-500"></span>
              <span class="">Success</span>
            </div>',
            'danger' => '<div class="flex text-rose-500 space-x-2 items-center">
              <span class="block h-5 w-5 rounded-full border border-rose-500 bg-rose-500"></span>
              <span class="">Danger</span>
            </div>',
            'warning' => '<div class="flex text-amber-500 space-x-2 items-center">
              <span class="block h-5 w-5 rounded-full border border-amber-500 bg-amber-500"></span>
              <span class="">Warning</span>
            </div>',
            'info' => '<div class="flex text-blue-400 space-x-2 items-center">
              <span class="block h-5 w-5 rounded-full border border-blue-400 bg-blue-400"></span>
              <span class="">Info</span>
            </div>',
          ])
          ->native(false)
          ->allowHtml(),
        TextInput::make('state')
          ->label('Status')
          ->placeholder('Eg. approved,deferred...')
          ->formatStateUsing(fn($state, Get $get) => Str::slug(strtolower($state ?: $get('name'))))
          ->columnSpan(2),
        TextInput::make('sort_order')
          ->placeholder('Sort order')
          ->numeric(),
      ])->columns(3)
    ];
  }

  public static function getSettings(SettingNameEnum $name): Setting
  {
    return Setting::where('name', $name->value)->first();
  }
}
