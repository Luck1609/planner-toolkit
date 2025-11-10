<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
  use HasUuids;

  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = [
    'committee_id',
    'data',
  ];

  public function meeting(): BelongsTo
  {
    return $this->belongsTo(Committee::class);
  }
}
