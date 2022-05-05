<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'question_id', 'next_question_id'];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function next(){
        return $this->belongsTo(Question::class, 'next_question_id', 'id');
    }
}
