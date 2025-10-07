<?php

namespace App\Filament\Resources\Sessions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class SessionsTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title')->label('Session Name'),
        TextColumn::make('start_date')->date(),
        TextColumn::make('end_date')->date(),
        TextColumn::make('active')
          ->default(function (Model $session) {
            return $session->is_current ? 'Active' : 'Complete';
          })
          ->badge()
          ->color(fn(string $state) => match ($state) {
            'Active' => 'warning',
            'Complete' => 'success',
          }),
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
