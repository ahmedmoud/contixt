<?php
/**
 * Created by PhpStorm.
 * User: salemcode8
 * Date: 5/11/18
 * Time: 8:43 PM
 */

namespace App\Presenters;


class Presenter
{
    public function __get($key){
        if(method_exists($this, $key)){
            return $this->$key();
        }
        return $this->key;
    }
}