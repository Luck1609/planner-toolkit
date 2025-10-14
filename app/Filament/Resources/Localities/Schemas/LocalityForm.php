<?php

namespace App\Filament\Resources\Localities\Schemas;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LocalityForm
{
  public static function configure(Schema $schema): Schema
  {
    $hasCreatePage = Str::contains(request()->path(), 'create', true);

    $sectorForm = $hasCreatePage ? [
      Repeater::make('sectors')
        ->relationship('sectors')
        ->schema([
          Group::make([
            TextInput::make('name')->required()->columnSpan(2),
            TextInput::make('initials')->required(),
          ])
            ->columns(3),
          Select::make('blocks')
            ->options((new self())->getBlocks())
            ->multiple()
            ->required(),
        ])
        ->grid(2)
        ->columnSpanFull()
    ] : [];
    return $schema
      ->components([
        Section::make('locality')
          ->description('Create a new locality')
          ->schema([
            TextInput::make('name')
              ->required(),
            TextInput::make('initials')
              ->required(),
          ]),
        Section::make('sectors')
          ->description('Add all sectors under this locality')
          ->schema([

          ])
      ]);
  }
}
