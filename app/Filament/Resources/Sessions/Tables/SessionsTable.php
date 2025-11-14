<?php

namespace App\Filament\Resources\Sessions\Tables;

use App\Models\MonthlySession;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        ActionGroup::make([
          ViewAction::make(),
          EditAction::make(),
          Action::make('schedule_meeting')
            ->icon('icon-calendar-time')
            ->action(function (MonthlySession $record) {
              Log::info('Finalize record', ['record' => $record]);
              $record->finalize = true;
              $record->save();
            }),
          DeleteAction::make()
        ])
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ]);
  }
}
