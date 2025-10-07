<?php

namespace App\Filament\Resources\Applications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ApplicationsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')->label('Full name')
          ->default(fn(Model $member) => "{$member->title} {$member->firstname} {$member->lastname}"),
        TextColumn::make('contact')->label('Phone number'),
        TextColumn::make('currentState')
          ->label('State')
          ->default(fn(Model $application) => $application->existing ? 'Regularization' : 'New')
          ->badge()
          ->color(fn(string $state) => match ($state) {
            'Regularization' => 'info',
            'New' => 'success',
          }),
        TextColumn::make('locality.name')->label('Locality'),
        TextColumn::make('sector.name')->label('Sector'),
        TextColumn::make('block'),
        TextColumn::make('plot_number'),
        TextColumn::make('shelf')->label('Shelf No.'),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        ViewAction::make(),
        EditAction::make(),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
