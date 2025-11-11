<?php

namespace App\Filament\Resources\Applications;

use App\Filament\Resources\Applications\Pages\ManageApplications;
use App\Models\Application;
use App\Models\MonthlySession;
use App\Services\FormService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ApplicationResource extends Resource
{
  protected static ?string $model = Application::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

  protected static ?string $recordTitleAttribute = 'Applications';

  // public static function form(Schema $schema): Schema
  // {
  //   return $schema
  //     ->components(FormService::applicationForm());
  // }

  public static function table(Table $table): Table
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
        //
      ])
      ->recordActions([
        ActionGroup::make([
          ViewAction::make(),
          EditAction::make(),
          DeleteAction::make(),
        ])
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
        ]),
      ])
      ->headerActions([
        
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => ManageApplications::route('/'),
    ];
  }
}
