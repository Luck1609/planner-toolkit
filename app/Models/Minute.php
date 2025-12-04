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

  protected $guarded = [];

  protected $casts = [
    'content' => 'array',
    'participants' => 'array',
    'attendees' => 'array',
    'absentees' => 'array',
    'recorded_by' => 'array',
    'approved_by' => 'array',
  ];


  public function meeting(): BelongsTo
  {
    return $this->belongsTo(Meeting::class);
  }
}
