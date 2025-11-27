<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;

class RolesAndPermission extends Page
{
  protected string $view = 'filament.clusters.settings.pages.roles-and-permission';

  protected static ?string $cluster = SettingsCluster::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserPlus;

  protected static ?int $navigationSort = 5;
}
