<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function create(){
        $friends=auth()->user()->friends;
        return view('indexpage',['friends'=> $friends]);
    }
}
