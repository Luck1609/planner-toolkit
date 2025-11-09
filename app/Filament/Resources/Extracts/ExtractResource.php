<?php

namespace App\Filament\Resources\Extracts;

use App\Filament\Resources\Extracts\Pages\ManageExtracts;
use App\Models\Extract;
use App\Models\Locality;
use App\Models\Sector;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExtractResource extends Resource
{
  protected static ?string $model = Extract::class;

  protected static string|BackedEnum|null $navigationIcon = 'icon-file-certificate';

  protected static ?string $recordTitleAttribute = 'Extracts';

  public static function form(Schema $schema): Schema
  {
    return $schema
      ->components([
        Group::make([
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
          TextInput::make('firstname')->required()->placeholder('Type in member\'s firstname')->columnSpan(2),
          TextInput::make('lastname')->required()->placeholder('Type in member\'s lastname')->columnSpan(2),
        ])
          ->columnSpanFull()
          ->columns(5),


        Group::make([
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
              logger('selected blocks', ['blocks' => $sector]);
              return $sector->blocks ?? [];
            })
            ->required()
            ->columnSpan(2),

          TextInput::make('plot_number')->required()->placeholder('Type in plot no.'),
        ])
          ->columnSpanFull()
          ->columns(7),


        Group::make([
          TextInput::make('phone_number')->label('Phone number')
            ->rules(['min:10', 'max:13'])
            ->required()
            ->tel()
            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
            ->placeholder('Type in phone number'),

          DatePicker::make('allocation_date')->required(),
          DatePicker::make('registration_date')->required()
        ])
          ->columnSpanFull()
          ->columns(3),
      ]);
  }

  public static function table(Table $table): Table
  {
    return $table
      ->recordTitleAttribute('Extracts')
      ->columns([
        TextColumn::make('name')->label('Full name')
          ->default(fn(Model $staff) => "{$staff->title} {$staff->firstname} {$staff->lastname}")
          ->searchable(),
        TextColumn::make('phone_number')->searchable(),
        TextColumn::make('locality.name')->searchable(),
        TextColumn::make('sector.name')->searchable(),
        TextColumn::make('block')->searchable(),
        TextColumn::make('plot_number')->searchable(),
        TextColumn::make('allocation_date')->date(),
        TextColumn::make('registration_date')->date(),
      ])
      ->filters([
        TrashedFilter::make(),
      ])
      ->recordActions([
        ActionGroup::make([
          ViewAction::make(),
          EditAction::make(),
          DeleteAction::make(),
          ForceDeleteAction::make(),
          RestoreAction::make(),
        ])
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
      'index' => ManageExtracts::route('/'),
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
