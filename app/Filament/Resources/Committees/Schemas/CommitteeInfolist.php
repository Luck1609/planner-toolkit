<?php

namespace App\Filament\Resources\Committees\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class CommitteeInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextEntry::make('name')->label('Full name')
          ->default(fn(Model $member) => "{$member->title} {$member->firstname} {$member->lastname}"),
        TextEntry::make('contact')->label('Phone number'),
        TextEntry::make('email')->label('Email'),
        TextEntry::make('role')->label('Role'),
        TextEntry::make('designation')->label('Designation'),
        // TextEntry::make('panel')
        //   ->badge()
        //   ->color(fn(string $state) => match ($state) {
        //     'TSC' => 'info',
        //     'SPC' => 'primary',
        //   })
      ]);
  }
}
