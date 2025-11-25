<?php

namespace App\Models;

use App\Enums\MeetingTypeEnum;
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


  protected $guarded = [];

  protected $casts = [
    'participants' => 'array',
    'type' => MeetingTypeEnum::class
  ];

  public function session(): BelongsTo
  {
    return $this->belongsTo(MonthlySession::class);
  }

  public function minutes(): HasMany
  {
    return $this->hasMany(Minute::class);
  }

  public function participants(): HasMany
  {
    return $this->hasMany(Participant::class);
  }
}
