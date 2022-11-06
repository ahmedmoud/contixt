<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompetitionVotes extends Model
{
    protected $fillable = ['comp_id','user_id','data','sub_id'];
    protected $table = 'competitions_votes';

}