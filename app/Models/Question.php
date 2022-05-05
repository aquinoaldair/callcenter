<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['script_id', 'question', 'description' ,'first', 'type'];

    public function options(){
        return $this->hasMany(Option::class);
    }

    public function files(){
        return $this->morphMany(File::class, 'fileable');
    }
}
