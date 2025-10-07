<?php

namespace App\Filament\Resources\Minutes\Tables;

use App\Models\Minute;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MinutesTable
{
  public static function configure(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title'),
        TextColumn::make('date')->date(),
        TextColumn::make('time')->time('h:m A'),
        TextColumn::make('status')
          ->default(fn(Minute $record) => match ($record->status) {
            'draft' => 'Draft',
            'published' => 'Published',
          })
          ->badge(fn(Minute $record) => match ($record->status) {
            'draft' => 'warning',
            'published' => 'success',
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
