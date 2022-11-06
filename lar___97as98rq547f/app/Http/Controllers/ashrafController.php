<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use UPerm;

class ashrafController extends Controller
{
    public function oneway(){
       
        $a = UPerm::simple_php_captcha();
        return '<img src="'.$a['image_src'].'" />';
    }
}