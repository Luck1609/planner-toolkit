<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use BackedEnum;
use Filament\Pages\Page;

class SmsTemplate extends Page
{
  protected string $view = 'filament.clusters.settings.pages.sms-template';

  protected static ?string $cluster = SettingsCluster::class;
  
  protected static string|BackedEnum|null $navigationIcon = 'icon-sms';
}
