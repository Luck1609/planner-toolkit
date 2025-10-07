<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ManageRecords;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ManageUsers extends ManageRecords
{
  protected static string $resource = UserResource::class;

  protected function getHeaderActions(): array
  {
    return [
      CreateAction::make()
        ->using(function (array $data, string $model) {
          logger('', ['data' => $data, 'model' => $model]);
          $password = Str::password(8, true, true, false);

          $user = $model::create([
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
    ];
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
        // [
        //   'number' => '0249149420',
        //   'values' => ['Nathan', $this->password]
        // ],
        [
          'number' => '0503894555',
          'values' => ['Luck', $this->password]
        ],
      ]
    ]);

    logger('', ['response' => $response->json()]);
  }
}
