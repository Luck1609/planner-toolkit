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

  protected $fillable = [
    'is_current',
    'title',
    'finalized',
    'start_date',
    'end_date'
  ];

  public function applications(): BelongsToMany
  {
    return $this->belongsToMany(Application::class)->withPivot('status');
  }

  public function meetings(): HasMany
  {
    return $this->hasMany(Meeting::class);
  }
}
