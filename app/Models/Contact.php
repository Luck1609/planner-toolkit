<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Contact extends Model
{
  use HasUuids;


  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = [
    'phone_number',
    // 'contactable_id',
    // 'contactable_type',
    'is_primary',
  ];

  public function contactable(): MorphTo
  {
    return $this->morphTo();
  }
}
