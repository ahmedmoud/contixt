<?php

namespace App\Http\Controllers\Admin;

//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SidebarController extends Controller
{
    public function __invoke()
    {
        return view('admin.sidebar.list');
    }
}
