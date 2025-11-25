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
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use UnitEnum;

class MemberRole extends Page implements HasTable, HasActions
{
  use InteractsWithTable, InteractsWithActions;

  protected static ?string $title = 'Committee Roles';

  protected string $view = 'filament.clusters.settings.pages.member-role';

  protected static ?string $cluster = SettingsCluster::class;

  protected static string | UnitEnum | null $navigationGroup = 'Others';

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserPlus;

  protected function getHeaderActions(): array
  {
    return [
      Action::make('Create role')
        ->icon(Heroicon::OutlinedPlus)
        ->modal()
        ->schema([
          TextInput::make('name')
            ->label('Role name')
            ->placeholder('Type in role name')
        ])
        ->action(function (array $data) {
          $roles = Setting::where('name', 'committee-roles')->first();

          $this->refresh();

          return $roles->update(['value' => [...$roles->value, ...$data]]);
        })
        ->modalWidth(Width::Medium)
    ];
  }



  public function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')->searchable()
      ])
      ->records(function () {
        $roles = Setting::where('name', 'committee-roles')->first()->value;

        return collect($roles)
          ->map(fn($role) => ['name' => $role])
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
            $roles = Setting::where('name', 'committee-roles')->first();

            $value = collect($roles->value)->reduce(fn($values, $value) => [
              ...$values,
              $value === $data['current_name'] ? $data['name'] : $value
            ], []);

            $this->refresh();
            return $roles->update(['value' => $value]);
          })
          ->modalWidth(Width::Large),
        Action::make('Delete')
          ->icon(Heroicon::OutlinedTrash)
          ->color(Color::Red)
          ->requiresConfirmation()
          ->action(function ($record) {
            $settings = Setting::where('name', 'committee-roles')->first();

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
