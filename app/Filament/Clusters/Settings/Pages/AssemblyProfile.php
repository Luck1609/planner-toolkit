<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Concerns\InteractsWithFormActions;
use Filament\Pages\Page;
use Filament\Schemas\Components\Form;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AssemblyProfile extends Page
{
  use InteractsWithFormActions;

  protected static ?string $title = 'Assembly Profile';

  protected static ?int $navigationSort = 2;

  protected string $view = 'filament.clusters.settings.pages.assembly-profile';

  protected static ?string $cluster = SettingsCluster::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingLibrary;


  public function form(Schema $schema): Schema
  {
    return $schema
      ->schema([
        Section::make('Basic Info')
          ->description('Update the assembles information here')
          ->schema([
            Group::make([
              TextInput::make('name')->label('Name')->placeholder('Assembly name'),
              TextInput::make('email')->label('Email')->placeholder('Assembly email'),
            ])
              ->columns(2)
              ->columnSpanFull(),


            // Group::make([
            TextInput::make('address')
              ->label('Address')
              ->placeholder('Assembly address')
              ->columnSpan(2),
            TextInput::make('name')->label('Name')->placeholder('Assembly name'),
            // ])
            //   ->columns(2)
            //   ->columnSpanFull(),

            Select::make('region')
              ->options([])
              ->label('Name')
              ->placeholder('Select region'),

            Select::make('district')
              ->options([])
              ->label('District')
              ->placeholder('Select district'),
            TextInput::make('initials')->label('Initials')->placeholder('Assembly initials'),

          ])
          ->columns(3),

        Section::make('Logo')
          ->schema([
            SpatieMediaLibraryFileUpload::make('logo')
              ->label('Select logo to upload')

          ])

      ])
      // ->model($this->record)
      ->operation('edit');
  }

  public function save(): void {}
}
