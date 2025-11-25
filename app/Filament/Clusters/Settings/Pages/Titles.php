<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use Filament\Pages\Page;

class Titles extends Page
{
    protected string $view = 'filament.clusters.settings.pages.titles';

    protected static ?string $cluster = SettingsCluster::class;
}
