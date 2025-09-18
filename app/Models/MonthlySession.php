<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MonthlySession extends Model
{
  use HasUuids;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = [];

  public function applications(): BelongsToMany
  {
    return $this->belongsToMany(Application::class)->withPivot('status_id');
  }

  public function meetings(): HasMany
  {
    return $this->hasMany(Meeting::class);
  }
}
