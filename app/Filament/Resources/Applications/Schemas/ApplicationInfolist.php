<?php

namespace App\Filament\Resources\Applications\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;

class ApplicationInfolist
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextEntry::make('application_num'),
        TextEntry::make('session_num'),
        TextEntry::make('dev_permit_num')
          ->placeholder('-'),
        TextEntry::make('permit_num')
          ->placeholder('-'),
        TextEntry::make('name')->label('Full name')
          ->default(fn(Model $member) => "{$member->title} {$member->firstname} {$member->lastname}"),
        TextEntry::make('contact')->label('Phone number'),
        TextEntry::make('currentState')
        ->label('State')
        ->default(fn(Model $application) => $application->existing ? 'Regularization' : 'New')
        ->badge()
        ->color(fn(string $state) => match ($state) {
          'Regularization' => 'info',
          'New' => 'success',
        }),
        TextEntry::make('locality.name')
          ->label('Locality'),
        TextEntry::make('sector.name')
          ->label('Sector'),
        TextEntry::make('block'),
        TextEntry::make('plot_number'),
        TextEntry::make('shelf')->label('Shelf No.'),
      ]);
  }
}
