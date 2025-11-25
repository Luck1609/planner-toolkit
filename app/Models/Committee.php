<?php

namespace App\Models;

use App\Enums\MeetingTypeEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Committee extends Model
{
  use HasUuids, HasFactory;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $guarded = [];

  protected $casts = [
    'panel' => MeetingTypeEnum::class
  ];

  public function participants(): HasMany
  {
    return $this->hasMany(Participant::class);
  }

  public function minute(): HasOne
  {
    return $this->hasOne(Minute::class);
  }
}
