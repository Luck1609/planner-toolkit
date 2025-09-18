<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Application extends Model implements HasMedia
{
  use HasUuids, InteractsWithMedia;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $casts = [
    'use' => 'array',
    'attachements' => 'array'
  ];

  protected $guarded = [];

  public function locality(): BelongsTo {
    return $this->belongsTo(Locality::class);
  }

  public function sector(): BelongsTo {
    return $this->belongsTo(Sector::class);
  }

  public function session(): BelongsToMany {
    return $this->belongsToMany(MonthlySession::class)->withPivot('status_id')->withTimestamps();
  }

  public function statuses(): BelongsToMany
  {
    return $this->belongsToMany(Status::class)->withPivot('monthly_session_id')->withTimestamps();
  }

  public function coordinates(): HasMany {
    return $this->hasMany(Coordinate::class);
  }
}
