<?php

namespace App\SMS;

include_once __DIR__.'/zenoph/lib/Zenoph/Notify/AutoLoader.php';

use App\Models\Sms as SmsNotification;
use App\Sms\SMSConfig;
use Exception;
use Illuminate\Support\Facades\Auth;
use Zenoph\Notify\Request\CreditBalanceRequest;

class SMS
{
  static function send()
  {
    try {
      // initialise request
      $sms = SMSConfig::create(('Hello {$name}! Your balance is ${$balance}.'));
      $sms->setMessage('Hello {$name}! Your balance is ${$balance}.');
      // $sms = SMSConfig::create($data['message']);


      $data = [
        ['name' => 'Nathan', 'phone' => '0249149420', 'balance' => 59.45],
        ['name' => 'Luck', 'phone' => '0503894555', 'balance' => 984.45]
      ];

      foreach ($data as $payload) {
        $phone = $payload['phone'];
        $values = [
          $payload['name'],
          $payload['balance'],
        ];

        // logger('', ['payload' => $values, 'phone' => $phone]);

        $sms->addPersonalisedDestination($phone, false, $values);
      }

      // submit must be after the loop
      $response = $sms->submit();

      // self::createDatabaseSmsNotification([
      //   ...$data,
      //   'status' => $response ? 1 : 0,
      // ]);

      return response()->json(['message' => 'Message successfully sent']);
    } catch (Exception $ex) {
      return $ex;
    }
  }

  static function getBalance()
  {
    $request = new CreditBalanceRequest();

    SMSConfig::getConfig($request);

    $response = $request->submit();

    $balance = $response->getBalance();

    // return $balance;
    return response()->json(['balance' => $balance]);
  }

  private function createDatabaseSmsNotification(array $data) : void {
    $totalContacts = count($data['contacts']);
    $unitCost = (strlen($data['message']) >= 160 ? ceil(strlen($data['message']) / 153) : 1) * $totalContacts;

    SmsNotification::create([
      ...$data,
      'user_id' => Auth::user()->id,
      'contacts' => json_encode($data['contacts']),
      'units_used' => $unitCost,
      'sent_date' => now(),
      'bulk' => $totalContacts > 1
    ]);
  }
}
