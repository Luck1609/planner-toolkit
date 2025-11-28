<?php

namespace App\Filament\Resources\Sessions;

use App\ActiveSessionTrait;
use App\DTO\ActiveSessionDTO;
use App\Filament\Resources\Sessions\Pages\ManageSessions;
use App\Models\Session;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SessionResource extends Resource
{
  use ActiveSessionTrait;

  protected static ?string $model = Session::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

  public static function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextInput::make('title')
          ->columnSpanFull()
          ->required(),
        DatePicker::make('start_date')
          ->required(),
        DatePicker::make('end_date')
          ->required(),
      ]);
  }

  public static function infolist(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextEntry::make('id')
          ->label('ID'),
        IconEntry::make('is_current')
          ->boolean(),
        TextEntry::make('title'),
        IconEntry::make('finalized')
          ->boolean(),
        TextEntry::make('start_date')
          ->date(),
        TextEntry::make('end_date')
          ->date(),
        TextEntry::make('deleted_by')
          ->placeholder('-'),
        TextEntry::make('created_at')
          ->dateTime()
          ->placeholder('-'),
        TextEntry::make('updated_at')
          ->dateTime()
          ->placeholder('-'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('title')
          ->searchable(),
        TextColumn::make('is_current')
          ->label('Status')
          ->formatStateUsing(fn ($state) => match ($state) {
              1 => 'Ongoing',
              0 => 'Completed',
            })
          ->badge()
          ->formatStateUsing(fn ($state) => match ($state) {
            1 => 'Ongoing',
            0 => 'Completed',
          })
          ->color(fn ($state) => match ($state) {
            1 => Color::Amber,
            0 => Color::Green,
          }),
        IconColumn::make('finalized')
          ->boolean(),
        TextColumn::make('start_date')
          ->date()
          ->sortable(),
        TextColumn::make('end_date')
          ->date()
          ->sortable(),
      ])
      ->filters([
        //
      ])
      ->recordActions([
        ActionGroup::make([
          ViewAction::make(),
          (new self())->sessionIsActive()
            ? [EditAction::make()]
            : [],
          Action::make('generate report')
            ->icon(Heroicon::OutlinedDocumentArrowDown)
            ->color(Color::Teal),
        ])
      ])
      ->toolbarActions([
        // BulkActionGroup::make([
          DeleteBulkAction::make(),
          BulkAction::make('generate report')
            ->icon(Heroicon::OutlinedDocumentArrowDown),
        // ]),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => ManageSessions::route('/'),
    ];
  }
}
