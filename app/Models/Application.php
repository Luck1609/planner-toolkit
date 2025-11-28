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

  public function sessions(): BelongsToMany {
    return $this->belongsToMany(MonthlySession::class, 'application_statuses', 'application_id', 'monthly_session_id')->withPivot('status')->withTimestamps();
  }

  public function coordinates(): HasMany {
    return $this->hasMany(Coordinate::class);
  }
}
