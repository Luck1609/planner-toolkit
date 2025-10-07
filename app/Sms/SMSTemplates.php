<?php

namespace App\Sms;

use App\Models\Office;
use App\Models\OTP;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;




class SMSTemplates
{
  CONST STAFF_PASSWORD = 'Congratulations {$name}, your password to the toolkit application is {$password}';

  static function otp(): string {
    $otp = Str::upper(Str::random(6));
    $expiresIn = Setting::where('slug', 'otp')->first();

    OTP::create([
      'hash' => Hash::make($otp),
      'user_id' => Auth::user()->id,
      'expires_in' => Carbon::addHours(json_decode($expiresIn->values))
    ]);

    return $otp;
  }

  static function permitStatus(User $user, string $status) : string {
    $office = Office::first();
    $setting = Setting::where('slug', 'sms-templates')->first();

    if ($setting) return json_decode($setting->values)[$status];

    return match ($status) {
      'received' => "Hello $user->title  $user->lastname \nThis message is to acknowledge the receipt of your permit application submitted to $office->name \n\nFor any enquiries, please call $office->contact",
      'deferred' => "Hello $user->title  $user->lastname \nThis message is to acknowledge the receipt of your permit application submitted to $office->name has been deferred. \n\nFor any enquiries, please call $office->contact",
      'refused' => "Hello $user->title  $user->lastname \nThis message is to acknowledge the receipt of your permit application submitted to $office->name has been refused. \n\nFor any enquiries, please call $office->contact",
      'approved' => "Congratulations $user->title  $user->lastname \nThis message is to acknowledge the receipt of your permit application submitted to $office->name is ready for collection. \n\nFor any enquiries, please call $office->contact",
      'recommended' => "Congratulations $user->title  $user->lastname \nThis message is to acknowledge the receipt of your permit application submitted to $office->name has been recommended for approval. \n\nFor any enquiries, please call $office->contact"
    };

    // return $message;
  }
}
