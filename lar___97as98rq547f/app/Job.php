<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = ['title'];
    protected $table = 'jobs';
    public $timestamps = false;
}
