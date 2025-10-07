<?php

namespace App\Filament\Resources\Committees\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CommitteeForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        // Group::make([
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
}
