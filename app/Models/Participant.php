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
    'firstname',
    'lastname',
    'phone_number',
    'email',
    'designation',
    'meeting_id',
    'committee_id',
  ];

  public function meeting(): BelongsTo
  {
    return $this->belongsTo(Meeting::class);
  }

  public function committee(): BelongsTo
  {
    return $this->belongsTo(Committee::class);
  }
}
