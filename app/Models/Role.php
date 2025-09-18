<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
  protected $keyType = 'string';
  public $incrementing = false;

  protected $fillable = ['name', 'guard_name'];
}
