<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Locality extends Model
{
  use HasUuids;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $guarded = [];

  public function sectors() : HasMany {
    return $this->hasMany(Sector::class);
  }
}
