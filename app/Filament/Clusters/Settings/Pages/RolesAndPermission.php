<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RolesAndPermission extends Page
{
  protected string $view = 'filament.clusters.settings.pages.roles-and-permission';

  protected static ?string $cluster = SettingsCluster::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserPlus;

  protected static ?int $navigationSort = 5;

}
