<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['fileable_id', 'fileable_type', 'extension', 'path'];

    protected $appends = ['fullPath'];

    public function fileable()
    {
        return $this->morphTo();
    }

    public function getFullPathAttribute()
    {
        return ($this->path) ? asset("storage/{$this->path}")  : "";
    }

}
