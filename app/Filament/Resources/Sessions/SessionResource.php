<?php

namespace App\Filament\Resources\Sessions;

use App\Filament\Resources\Sessions\Pages\CreateSession;
use App\Filament\Resources\Sessions\Pages\EditSession;
use App\Filament\Resources\Sessions\Pages\ListSessions;
use App\Filament\Resources\Sessions\Pages\ViewSession;
use App\Filament\Resources\Sessions\Schemas\SessionForm;
use App\Filament\Resources\Sessions\Schemas\SessionInfolist;
use App\Filament\Resources\Sessions\Tables\SessionsTable;
use App\Models\MonthlySession;
use App\Models\Session;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SessionResource extends Resource
{
  protected static ?string $model = MonthlySession::class;


  protected static ?string $navigationLabel = 'Sessions';

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

  public static function form(Schema $schema): Schema
  {
    return SessionForm::configure($schema);
  }

  public static function infolist(Schema $schema): Schema
  {
    return SessionInfolist::configure($schema);
  }

  public static function table(Table $table): Table
  {
    return SessionsTable::configure($table);
  }

  public static function getRelations(): array
  {
    return [
      //
    ];
  }

  public static function getPages(): array
  {
    return [
      'index' => ListSessions::route('/'),
      'create' => CreateSession::route('/create'),
      'view' => ViewSession::route('/{record}'),
      'edit' => EditSession::route('/{record}/edit'),
      'minute' => EditSession::route('/{record}/minute'),
    ];
  }
}
