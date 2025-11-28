<?php

namespace App\Services;

use App\Models\Setting;
use Filament\Notifications\Notification;

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

  public static function getTitles(): array
  {
    $titles = Setting::where('name', 'titles')->first()->value;
    return collect($titles)->reduce(fn($allTitles, $title) => [...$allTitles, $title => $title], []);
  }

  public static function getCommitteeRoles(): array
  {
    $roles = Setting::where('name', 'committee-roles')->first()->value;
    return collect($roles)->reduce(fn($allRoles, $role) => [...$allRoles, $role => $role], []);
  }

  public static function sendNotification(string $title, ?string $body, ?string $status = 'success') : Notification
  {
    return Notification::make()
      ->title($title)
      ->body($body)
      ->color($status)
      ->$status();
  }
}
