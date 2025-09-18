<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Status extends Model
{
  use HasUuids;

  protected $keyType = 'string';
  public $incrementing = false;

  public function applications(): BelongsToMany
  {
    return $this->belongsToMany(Application::class)
      ->withPivot('monthly_session_id')
      ->withTimestamps();
  }
}
