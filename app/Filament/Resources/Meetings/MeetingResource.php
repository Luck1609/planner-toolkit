<?php

namespace App\Filament\Resources\Meetings;

use App\DTO\MeetingTypeDTO;
use App\Enums\MeetingTypeEnum;
use App\Filament\Resources\Meetings\Pages\ManageMeetings;
use App\Filament\Resources\Meetings\Pages\Minutes;
use App\Filament\Resources\Minutes\MinuteResource;
use App\Models\Meeting;
use App\Models\Minute;
use App\Models\Participant;
use App\Services\FormService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class MeetingResource extends Resource
{
  protected static ?string $model = Meeting::class;

  protected static string|BackedEnum|null $navigationIcon = 'icon-calendar-time';

  protected static ?string $recordTitleAttribute = 'Meetings';

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title')->searchable(),
        TextColumn::make('venue')->searchable(),
        TextColumn::make('date')->date()->searchable(),
        TextColumn::make('type')
          ->badge()
          ->color(fn($state) => match ($state) {
            MeetingTypeEnum::TSC => Color::Teal,
            MeetingTypeEnum::SPC => Color::Blue,
            default => Color::Red,
          }),
        TextColumn::make('participants')
          ->alignCenter()
          ->default(fn(Model $meeting) => Participant::where('meeting_id', $meeting->id)->count()),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        ActionGroup::make([
          ViewAction::make(),
          Action::make('minutes')
            ->icon('icon-file-description')
            ->color(Color::Blue)
            ->url(fn (Model $record) => MeetingResource::getUrl('minutes', ['record' => $record->minute->id])),
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
      'minutes' => Minutes::route('/{record}/minutes'),
    ];
  }
}
