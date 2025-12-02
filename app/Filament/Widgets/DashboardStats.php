<?php

namespace App\Filament\Widgets;

use App\Models\Application;
use App\Models\User;
use Carbon\Carbon;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
  protected function getStats(): array
  {
    logger('Current year', ['year' => Carbon::now()->year]);
    return [
      Stat::make('Staff Members', User::count())
        ->icon(Heroicon::Users),
      Stat::make('Applications Received', Application::query()->whereYear('created_at', Carbon::now()->year)->count())
        ->icon(Heroicon::RectangleStack),
      Stat::make('SMS Balance', '312')
        ->icon(Heroicon::OutlinedDevicePhoneMobile),
    ];
  }

  protected function getHeading(): ?string
  {
    return 'Analytics';
  }

  protected function getDescription(): ?string
  {
    return 'An overview of some analytics.';
  }
}
