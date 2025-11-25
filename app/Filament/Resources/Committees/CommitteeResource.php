<?php

namespace App\Filament\Resources\Committees;

use App\Enums\MeetingTypeEnum;
use App\Filament\Resources\Committees\Pages\ManageCommittees;
use App\Models\Committee;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class CommitteeResource extends Resource
{
  protected static ?string $model = Committee::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

  protected static ?string $recordTitleAttribute = 'Committees Members';

  public static function form(Schema $schema): Schema
  {
    return $schema
      ->components([
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
        TextInput::make('firstname')->required()->placeholder('Type in member\s firstname'),
        TextInput::make('lastname')->required()->placeholder('Type in member\s lastname'),
        // ])->columns(5),
        Select::make('panel')
          ->options([
            'SPC' => 'SPC',
            'TSC' => 'TSC',
          ])
          ->required(),
        TextInput::make('email')->required()->email()->placeholder('Type in member\s email address'),
        TextInput::make('designation')->required()->placeholder('Type in member\s designation'),
        Select::make('role')
          ->options([
            'Chairperson' => 'Chairperson',
            'Secretary' => 'Secretary',
            'Member' => 'Member',
            'Other' => 'Other',
          ])
          ->required(),
        TextInput::make('contact')->label('Phone number')->required()->placeholder('Type in member\s phone number'),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('Committees')
      ->columns([
        TextColumn::make('name')->label('Full name')
          ->default(fn(Model $member) => "{$member->title} {$member->firstname} {$member->lastname}")
          ->searchable(),
        TextColumn::make('contact')->label('Phone number')->searchable(),
        TextColumn::make('email')->label('Email')->searchable(),
        TextColumn::make('panel')
          ->badge()
          ->color(fn($state) => match ($state) {
            MeetingTypeEnum::TSC => 'info',
            MeetingTypeEnum::SPC => 'primary',
          })
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
      'index' => ManageCommittees::route('/'),
    ];
  }
}
