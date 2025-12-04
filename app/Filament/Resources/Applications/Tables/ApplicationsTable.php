<?php

namespace App\Filament\Resources\Applications\Tables;

use App\ActiveSessionTrait;
use App\Enums\SettingNameEnum;
use App\Models\Setting;
use App\Services\ApplicationService;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ApplicationsTable
{
  use ActiveSessionTrait;

  public static function configure(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('Applications')
      ->columns([
        TextColumn::make('name')->label('Full name')
          ->default(fn(Model $member) => "{$member->title} {$member->firstname} {$member->lastname}")
          ->searchable(),
        TextColumn::make('contact')->label('Phone number')
          ->searchable(),
        TextColumn::make('currentState')
          ->label('State')
          ->default(fn(Model $application) => $application->existing ? 'Regularization' : 'New')
          ->badge()
          ->color(fn(string $state) => match ($state) {
            'Regularization' => 'info',
            'New' => 'success',
          })
          ->searchable(),
        TextColumn::make('locality.name')->label('Locality')
          ->searchable(),
        TextColumn::make('sector.name')->label('Sector')
          ->searchable(),
        TextColumn::make('block')->searchable(),
        TextColumn::make('plot_number')
          ->searchable(),
        TextColumn::make('shelf')->label('Shelf No.'),
      ])
      ->filters([
      ])
      ->headerActions([
        ExportAction::make(),
        Action::make('export')
      ])
      ->recordActions([
        ActionGroup::make([
          ViewAction::make(),
          EditAction::make()
            ->visible(!(new self())->sessionIsFinalized()),
          DeleteAction::make()
            ->visible(!(new self())->sessionIsFinalized()),
          ...!(new self())->sessionMeeting()->tsc
            ? collect(
              Setting::where('name', SettingNameEnum::APPLICATION_STATUS)
                ->first()
                ->value ?: []
            )->map(
              fn($status) => ApplicationService::showConfirmation(
                session: (new self())->session,
                status: $status,
                isBulkAction: false,
              )
                ->visible((new self())->sessionIsFinalized())
            )
            ->all()
            : []
        ])
      ])
      ->toolbarActions(
        !(new self())->sessionMeeting()->tsc
          ? collect(
            Setting::where('name', SettingNameEnum::APPLICATION_STATUS)
              ->first()
              ->value ?: []
          )->map(
            fn($status) => ApplicationService::showConfirmation(
              session: (new self())->session,
              status: $status,
            )
          )
          ->all()
          : []
      )
      ->headerActions([]);
  }
}
