<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use App\Models\Setting;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class Titles extends Page implements HasTable, HasActions
{
  use InteractsWithTable, InteractsWithActions;

  protected string $view = 'filament.clusters.settings.pages.titles';

  protected static ?string $cluster = SettingsCluster::class;

  protected static string|BackedEnum|null $navigationIcon = 'icon-rosette-discount-check';

  protected function getHeaderActions(): array
  {
    return [
      Action::make('add title')
        ->icon(Heroicon::OutlinedPlus)
        ->modal()
        ->schema([
          TextInput::make('name')
            ->placeholder('Title name (Mr. Dr. Esq...)')
        ])
        ->action(function (array $data) {
          $titles = Setting::where('name', 'titles')->first();

          $this->refresh();

          return $titles->update(['value' => [...$titles->value, ...$data]]);
        })
        ->modalWidth(Width::Large)
    ];
  }

  public function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')->searchable()
      ])
      ->records(function () {
        $settings = Setting::where('name', 'titles')->first();

        return collect($settings->value)
          ->map(fn($title) => ['name' => $title])
          ->toArray();
      })
      ->recordActions([
        Action::make('Edit')
          ->icon(Heroicon::OutlinedPencilSquare)
          ->modal()
          ->mountUsing(fn(Schema $form, array $record) => $form->fill([
            'current_name' => $record['name'],
            ...$record
          ]))
          ->schema([
            Hidden::make('current_name'),
            TextInput::make('name')
              ->placeholder('Title name (Mr. Dr. Esq...)')
          ])
          ->action(function (array $data) {
            logger('edit-data', $data);
            $titles = Setting::where('name', 'titles')->first();

            $value = collect($titles->value)->reduce(fn($values, $value) => [
              ...$values,
              $value === $data['current_name'] ? $data['name'] : $value
            ], []);

            $this->refresh();
            return $titles->update(['value' => $value]);
          })
          ->modalWidth(Width::Large),
        Action::make('Delete')
          ->icon(Heroicon::OutlinedTrash)
          ->color(Color::Red)
          ->requiresConfirmation()
          ->action(function ($record) {
            $settings = Setting::where('name', 'titles')->first();

            // Remove the record from the JSON list
            $settings->value = collect($settings->value)
              ->reject(fn($item) => $item === $record['name'])
              ->values()
              ->toArray();

            $settings->save();
          })
      ]);
  }
}
