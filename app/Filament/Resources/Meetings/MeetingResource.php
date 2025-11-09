<?php

namespace App\Filament\Resources\Meetings;

use App\Filament\Resources\Meetings\Pages\ManageMeetings;
use App\Models\Meeting;
use App\Services\FormService;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MeetingResource extends Resource
{
  protected static ?string $model = Meeting::class;

  protected static string|BackedEnum|null $navigationIcon = 'icon-calendar-time';

  protected static ?string $recordTitleAttribute = 'Meetings';

  public static function form(Schema $schema): Schema
  {
    $isModal = true;
    return $schema
      ->components(FormService::meetingForm($isModal));
  }

  public static function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('Meetings')
      ->columns([
        TextColumn::make('title')->searchable(),
        TextColumn::make('venue')->searchable(),
        TextColumn::make('date')->date()->searchable(),
        TextColumn::make('participant')
          ->label('Meeting Participants')
          ->default(fn(Model $meeting) => count($meeting->participants)),
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
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => ManageMeetings::route('/'),
    ];
  }
}
