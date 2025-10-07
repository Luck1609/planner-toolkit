<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
  protected static ?string $model = User::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

  protected static ?string $recordTitleAttribute = 'name';

  public static function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Grid::make(3)
          ->columnSpanFull()
          ->schema([
            Select::make('title')
              ->options([
                'Mr' => 'Mr',
                'Mrs' => 'Mrs',
                'Miss' => 'Miss',
                'Dr' => 'Dr',
                'Prof' => 'Prof',
                'Eng' => 'Eng',
                'Pln' => 'Pln',
                'Esq' => 'Esq',
              ])
              ->required(),
            TextInput::make('firstname')->required()->placeholder('Type in member\'s firstname'),
            TextInput::make('lastname')->required()->placeholder('Type in member\'s lastname'),
            TextInput::make('email')->required()->email()->placeholder('Type in member\'s email address'),
            TextInput::make('contact')->label('Phone number')
              ->rules(['min:10', 'max:13'])
              ->required()
              ->tel()
              ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
              ->placeholder('Type in member\s phone number'),
          ])
      ]);
  }

  public static function infolist(Schema $schema): Schema
  {
    return $schema
      ->components([
        TextEntry::make('name'),
        TextEntry::make('email'),
        TextEntry::make('contact')
          ->label('Phone number'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('name')
      ->columns([
        TextColumn::make('name')->label('Full name')
          ->searchable()
          ->default(fn(Model $staff) => "{$staff->title} {$staff->firstname} {$staff->lastname}"),
        TextColumn::make('contact')
          ->label('Phone number')
          ->default(function (Model $staff) {
            $contacts = $staff->contacts;

            return $contacts->phone_number ?? 'Not available';
          }),
        TextColumn::make('email')->label('Email'),
      ])
      ->filters([
        TrashedFilter::make(),
      ])
      ->recordActions([
        ViewAction::make()
          ->tooltip('View')
          ->label(''),
        EditAction::make()
          ->tooltip('Edit')
          ->label(''),
        DeleteAction::make()
          ->tooltip('Delete temporarily')
          ->label(''),
        ForceDeleteAction::make()
          ->tooltip('Delete permanently')
          ->label(''),
        RestoreAction::make()
          ->tooltip('Restore')
          ->label(''),
      ])
      ->toolbarActions([
        BulkActionGroup::make([
          DeleteBulkAction::make(),
          ForceDeleteBulkAction::make(),
          RestoreBulkAction::make(),
        ]),
      ]);
  }

  public static function getPages(): array
  {
    return [
      'index' => ManageUsers::route('/'),
    ];
  }

  public static function getRecordRouteBindingEloquentQuery(): Builder
  {
    return parent::getRecordRouteBindingEloquentQuery()
      ->withoutGlobalScopes([
        SoftDeletingScope::class,
      ]);
  }
}
