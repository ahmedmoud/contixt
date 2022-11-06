<?php

namespace App\Modules\Facades\Http;

class Facade extends \Illuminate\Support\Facades\Facade{

    protected static function getFacadeAccessor()
    {
        return 'App\Modules\Facades\Http\Http';
    }
}
