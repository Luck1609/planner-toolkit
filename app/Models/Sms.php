<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sms extends Model
{
  use HasUuids;

  protected $table = 'sms_notifications';

  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = [];
}
