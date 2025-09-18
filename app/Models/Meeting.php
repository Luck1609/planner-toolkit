<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meeting extends Model
{
  use HasUuids;

  protected $keyType = 'string';
  public $incrementing = false;


  protected $casts = [
    'participants' => 'array',
  ];

  public function session(): BelongsTo
  {
    return $this->belongsTo(MonthlySession::class);
  }

  public function minutes(): HasMany
  {
    return $this->hasMany(Minute::class);
  }
}
