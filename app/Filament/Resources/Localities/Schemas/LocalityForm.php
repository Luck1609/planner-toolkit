<?php

namespace App\Filament\Resources\Localities\Schemas;

use App\Services\SectorService;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;


const LIVEWIRE_UPDATE_URL = 'livewire/update';

class LocalityForm
{
  public static function configure(Schema $schema): Schema
  {
    // Current url changes on sector addition,
    // so request the previous url in case the current url matches the livewire update url
    $url = request()->path() === LIVEWIRE_UPDATE_URL ? url()->previous() : url()->current();

    $hasCreatePage = Str::contains($url, 'create');

    $sectorForm = [
      Repeater::make('sectors')
        ->relationship('sectors')
        ->schema([
          Group::make([
            TextInput::make('name')->required()->columnSpan(2),
            TextInput::make('initials')->required(),
          ])
            ->columns(3),
          Select::make('blocks')
            ->options(SectorService::getBlocks())
            ->multiple()
            ->required(),
        ])
        ->addable(true)
        ->grid(2)
        ->columnSpanFull()
    ];

    return $schema
      ->components([
        Section::make('locality')
          ->description('Create a new locality together with it\'s sectors')
          ->schema([
            Grid::make(2)
              ->schema([
                TextInput::make('name')
                  ->required(),
                TextInput::make('initials')
                  ->required(),
              ])
          ])->columnSpanFull(),

        ...$hasCreatePage
          ? [
            Section::make('Locality Sectors')
              ->description('Add all sectors under this locality')
              ->schema($sectorForm)
              ->columnSpanFull()
          ]
          : []
      ]);
  }
}
