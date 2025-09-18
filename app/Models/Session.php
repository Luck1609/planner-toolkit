<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
  use HasUuids;

  protected $table = 'monthly_sessions';
  protected $keyType = 'string';
  public $incrementing = false;

  // protected $fillable = [];
}
