<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Redirection extends Model
{
    protected $fillable = ['fromURL','toURL','user_id'];
    protected $table = 'redirection';

    public function RedirectURL($fromURL){

        $fromURL = trim(urldecode($fromURL));
        $fromURL = parse_url($fromURL);
        $fromURL = $fromURL['path']. ( isset($fromURL['query']) ? '?'.$fromURL['query'] : '' );
        $fromURL = trim($fromURL,'/');

        $redirection = Redirection::select('toURL')->where('fromURL', $fromURL)->first();


        if( isset($_GET['ashraf']) ){
            dd( $redirection );
        }


        return $redirection ? redirect( url($redirection->toURL), 301 ) : abort(404);
    }

}