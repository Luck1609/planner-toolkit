<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use App\Filament\Tables\Columns\ColorDisplayColumn;
use App\Filament\Tables\Columns\DisplayColumn;
use Filament\Pages\Page;
use App\Models\Setting;
use App\Services\HelperService;
use App\Services\SettingsService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Schemas\Schema;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Support\Arr;
use UnitEnum;

class ApplicationStatus extends Page implements HasTable, HasActions
{
  use InteractsWithActions, InteractsWithTable;

  protected string $view = 'filament.clusters.settings.pages.application-status';

  protected static ?string $cluster = SettingsCluster::class;

  protected static string | UnitEnum | null $navigationGroup = 'Others';

  protected static string|BackedEnum|null $navigationIcon = 'icon-progress-help';
  protected static ?int $navigationSort = 2;

  private string $redirectUrl = '/settings/application-status';

  protected function getHeaderActions(): array
  {
    return [
      Action::make('add Status')
        ->icon(Heroicon::OutlinedPlus)
        ->modal()
        ->mountUsing(function (Schema $form) {
          $applicationStatus = Setting::where('name', 'application-status')->first()?->value ?: [];

          $form->fill([
            'name' => '',
            'sort_order' => count($applicationStatus) + 1
          ]);
        })
        ->schema(SettingsService::applicationStatusForm())
        ->action(function (array $data) {
          $applicationStatus = Setting::where('name', 'application-status')->first();

          $sortOrder = $applicationStatus?->value ? count($applicationStatus->value) + 1 : 1;
          $applicationStatus->update(['value' => [
            ...$applicationStatus->value ?: [],
            [
              ...$data,
              'sort_order' => $sortOrder
            ]
          ]]);

          HelperService::sendNotification(
            title: 'Status Created',
            body: 'Application status has been successfully updated'
          )
            ->send();

          return redirect($this->redirectUrl);
        })
        ->modalWidth(Width::ExtraLarge)
    ];
  }

  public function table(Table $table): Table
  {
    return $table
      ->columns([
        TextColumn::make('name')->searchable(),
        TextColumn::make('sort_order'),
        TextColumn::make('state')
          ->formatStateUsing(function ($state, array $record) {logger('', ['state' => $state, 'record' => $record]); return $state;}),
          // ->state(fn ),
        ColorDisplayColumn::make('color')
      ])
      ->records(function () {
        $settings = Setting::where('name', 'application-status')->first();
        return $settings->value;
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
            ...SettingsService::applicationStatusForm()
          ])
          ->action(function (array $data) {
            $applicationStatus = Setting::where('name', 'application-status')->first();

            $id = Arr::pull($data, 'current_name');

            $value = collect($applicationStatus->value)->reduce(fn($values, $value) => [
              ...$values,
              $value['name'] === $id
                ? $data
                : $value
            ], []);

            $applicationStatus->update(['value' => $value]);


            HelperService::sendNotification(
              title: 'Status Updated',
              body: 'Application status has been successfully updatedted'
            )
              ->send();

            return redirect($this->redirectUrl);
          })
          ->modalWidth(Width::Large),
        Action::make('Delete')
          ->icon(Heroicon::OutlinedTrash)
          ->color(Color::Red)
          ->requiresConfirmation()
          ->action(function ($record) {
            $settings = Setting::where('name', 'application-status')->first();

            // Remove the record from the JSON list
            $settings->value = collect($settings->value)
              ->reject(fn($item) => $item['name'] === $record['name'])
              ->values()
              ->toArray();

            $settings->save();

            HelperService::sendNotification(
              title: 'Status Deleted',
              body: 'Application status has been successfully deleted'
            )
              ->send();

            return redirect($this->redirectUrl);
          })
      ]);
  }
}
