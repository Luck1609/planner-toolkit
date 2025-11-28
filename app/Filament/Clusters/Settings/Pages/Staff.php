<?php

namespace App\Filament\Clusters\Settings\Pages;

use App\Filament\Clusters\Settings\SettingsCluster;
use App\Models\User;
use App\Services\HelperService;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Staff extends Page implements HasTable, HasActions
{
  use InteractsWithActions, InteractsWithTable;

  protected static ?string $model = User::class;

  protected string $view = 'filament.clusters.settings.pages.staff';

  protected static ?string $cluster = SettingsCluster::class;

  protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

  protected static ?int $navigationSort = 3;


  protected function getHeaderActions(): array
  {
    return [
      Action::make('Add staff member')
        ->icon(Heroicon::OutlinedPlus)
        ->modal()
        ->schema($this->getUserForm())
        ->action(function (array $data) {
          $password = Str::password(8, symbols: false);

          $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => $password
          ]);

          $user->contacts()->create([
            'phone_number' => $data['contact'],
            'is_default' => true
          ]);

          // Todo - Send password via SMS to user
        })
        ->modalWidth(Width::ThreeExtraLarge)
    ];
  }



  public function table(Table $table): Table
  {
    return $table
      ->query(User::query()->where('email', '!=', 'nathanielobeng0@gmail.com'))
      ->columns([
        TextColumn::make('name')->label('Full name')
          ->searchable()
          ->default(fn(Model $staff) => "{$staff->title} {$staff->firstname} {$staff->lastname}"),
        TextColumn::make('contact')
          ->label('Phone number')
          ->default(function (Model $staff) {
            $contact = $staff->contacts()->where('is_primary', true)->first();

            return $contact?->phone_number ?: 'Not available';
          }),
        TextColumn::make('email')->label('Email'),
      ])
      ->filters([
        TrashedFilter::make(),
      ])
      ->recordActions([
        ActionGroup::make([
          ViewAction::make(),
          EditAction::make()
            ->schema($this->getUserForm()),
          DeleteAction::make(),
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


  protected function afterCreate(): void
  {
    $user = $this->record;

    $user->contacts()->create([
      'phone_number' => $this->contact,
      'is_primary' => true
    ]);

    // Send sms containing the password here
    $response = Http::withHeaders([
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Host' => env('SMS_GH_HOST'),
      'Authorization' => 'key ' . env('SMS_GH_API_KEY')
    ])->post('https://api.smsonlinegh.com/v5/message/sms/send', [
      'text' => 'Hello {$name}. Your current balance is ${$balance}.',
      'type' => 0,
      'sender' => 'Homesteller',
      'destinations' => [
        [
          'number' => '0503894555',
          'values' => ['Luck', $this->password]
        ],
      ]
    ]);
  }

  private function getUserForm(): array
  {
    return [
      Grid::make(3)
        ->columnSpanFull()
        ->schema([
          Select::make('title')
            ->options(HelperService::getTitles())
            ->required(),
          TextInput::make('firstname')->required()->placeholder('Type in member\'s firstname'),
          TextInput::make('lastname')->required()->placeholder('Type in member\'s lastname'),
          TextInput::make('email')->required()->email()->placeholder('Type in member\'s email address'),
          TextInput::make('contact')->label('Phone number')
            ->rules(['min:10', 'max:13'])
            ->required()
            ->tel()
            ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
            ->placeholder('Type in member\s phone number'),
        ])
    ];
  }
}
