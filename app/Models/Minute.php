<?php

namespace App\Models;

use App\Casts\AsJSON;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Minute extends Model
{
  use HasUuids;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $casts = [
    'content' => AsJSON::class,
    'participants' => AsJSON::class,
    'attendees' => AsJSON::class,
    'absentees' => AsJSON::class,
    'recorded_by' => AsJSON::class,
    'approved_by' => AsJSON::class,
  ];


  public function meeting(): BelongsTo
  {
    return $this->belongsTo(Meeting::class);
  }
}
