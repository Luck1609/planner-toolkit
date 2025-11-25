<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use BackedEnum;
use Filament\Pages\Page;

class Storage extends Page
{
  protected string $view = 'filament.clusters.settings.pages.storage';

  protected static ?int $navigationSort = 3;

  protected static ?string $cluster = SettingsCluster::class;

  protected static string|BackedEnum|null $navigationIcon = 'icon-stack-push';
}
