<?php

namespace App\Sms;

include_once __DIR__ . '/zenoph/lib/Zenoph/Notify/AutoLoader.php';

use Zenoph\Notify\Enums\AuthModel;
use Zenoph\Notify\Enums\SMSType;
use Zenoph\Notify\Request\CreditBalanceRequest;
use Zenoph\Notify\Request\SMSRequest;

class SMSConfig
{
  const PERMIT = 'permit';
  const COMMITTE = 'committee';
  const OTP = 'otp';
  const CUSTOM = 'custom';
  const PASSWORD = 'password';

  static function create()
  {
    $sms = new SMSRequest();

    self::getConfig($sms);

    // $sms->setMessage($message, false);

    return $sms;
  }

  public static function getConfig(CreditBalanceRequest | SMSRequest $request): CreditBalanceRequest | SMSRequest
  {
    $request->setHost(env('SMS_GH_HOST'));

    $request->setAuthModel(AuthModel::API_KEY);
    $request->setAuthApiKey(env("SMS_GH_API_KEY"));

    if ($request instanceof SMSRequest) {
      $request->setSMSType(SMSType::GSM_DEFAULT);
      $request->setSender('PL_TOOLKIT'); // set to assembly's initials
    }

    return $request;
  }

  public static function getHeaders()
  {
    return [
      'POST' => 'https://api.smsonlinegh.com/v5/message/sms/send',
      'Content-Type' => 'application/json',
      'Accept' => 'application/json',
      'Host' => 'api.smsonlinegh.com',
      'Authorization' => 'key ' . env('SMS_GH_HOST')
    ];
  }
}
