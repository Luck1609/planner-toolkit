<?php

namespace App\Filament\Resources\Applications\Schemas;

use App\Models\Locality;
use App\Models\Sector;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ApplicationForm
{
  public static function configure(Schema $schema): Schema
  {
    return $schema
      ->components([
        Section::make('Applicant\'s Information')
          ->schema([
            Select::make('title')
              ->placeholder('Select title')
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
            TextInput::make('firstname')
              ->required()
              ->placeholder('Aplicant\'s firstname')
              ->columnSpan(2),
            TextInput::make('lastname')
              ->required()
              ->placeholder('Aplicant\'s lastname')
              ->columnSpan(2),
            TextInput::make('contact')->required()->placeholder('Aplicant\'s phone number')
              ->columnSpan(2),
            TextInput::make('house_no')->required()->placeholder('Aplicant\'s house number')
              ->columnSpan(3),
            Textarea::make('address')->required()->placeholder('Aplicant\'s address')
              ->columnSpan(4),
          ])
          ->description('The applicant\'s basic information')
          ->columns(5)
          ->columnSpan(2),

        Section::make('Plot Information')
          ->schema([
            Select::make('locality_id')
              ->options(Locality::all()->pluck('name', 'id'))
              ->required()
              ->columnSpan(2)
              ->live(),

            Select::make('sector_id')
              ->options(function (Get $get) {
                return Sector::where('locality_id', $get('locality_id'))->get()->pluck('name', 'id');
              })
              ->required()
              ->columnSpan(2)
              ->live(),

            Select::make('block')
              ->options(function (Get $get): array {
                $sector = Sector::find($get('sector_id'));
                return $sector->blocks ?? [];
              })
              ->required()
              ->columnSpan(1),

            TextInput::make('plot_number')->required()->placeholder('Type in plot no.')->live(),
          ])
          ->description('Fill in the information relating to the plot')
          ->columnSpan(1)
          ->columns(2),

        Group::make([
          Section::make('Building Information')
            ->description('Information relating to the building')
            ->schema([
              Radio::make('type')
                ->options([
                  'single' => 'Single storey',
                  'multi' => 'Multi storey',
                ])
                ->label('Height of building')
                ->live()
                ->columns(3)
                ->maxWidth('50%'),

              // Group::make([
              Radio::make('existing')
                ->options([1 => 'Existing building', 0 => 'New building'])
                ->label('Property state')
                ->columns(3),

              TextInput::make('height')
                ->integer()
                ->placeholder('Height of building')
                ->visible(fn(Get $get) => $get('type') === 'multi'),
              // ])

            ])
            ->columnSpan(1),

          Section::make('Land Use')
            ->description('Land use information')
            ->schema([
              CheckboxList::make('use')
                ->options([
                  'residential' => 'Residential',
                  'commercial' => 'Commercial',
                  'civic_&_culture' => 'Civic & Culture',
                  'Education' => 'Education',
                  'industrial' => 'Industrial',
                  'open space' => 'Open Space',
                  'sanitation' => 'Sanitation',
                ])
                ->label('Land use')
                ->columns(3),
            ])
            ->columnSpan(1),

          Section::make('Storage Information')
            ->description('Information relating to the building')
            ->schema([
              TextInput::make('shelf')->integer()->placeholder('Shelf no.')->label('Shelf number'),
              TextInput::make('application_num')->placeholder('SMA/SEC 1/AR1/01/25')->label('Application number'),
            ])
            ->columnSpan(1),

          Section::make('Cordinate Information')
            ->description('Information relating to the building')
            ->schema([
              Repeater::make('coordinates')
                ->label('')
                ->relationship('coordinates')
                ->schema([
                  TextInput::make('longitude')
                    ->placeholder('Longitude')
                    ->label('Longitude')
                    ->regex('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'),
                  TextInput::make('latitude')
                    ->placeholder('Latitude')
                    ->regex('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/')
                    ->label('Latitude')
                ])
                ->addActionLabel('Add New Coordinates')
                // ->columns(2)
                ->grid(3)
                ->itemLabel('Coordinates')

            ])
            ->columnSpanFull(),

          SpatieMediaLibraryFileUpload::make('attachements')
            ->multiple()
            ->columnSpanFull()
          // ->acceptedFileTypes([])
        ])
          ->columns(2)
          ->columnSpanFull(),
      ])->columns(3);
  }
}
