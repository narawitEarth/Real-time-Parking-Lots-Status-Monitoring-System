<?php

namespace App\Http\Controllers;
use App\project;
use Illuminate\Http\Request;

class tarcontroller extends Controller
{
    function view(){
        $parking = project::orderBy('id','desc')->limit(1)->get();
        return view('view',[
            'park' => $parking
        ]);
    }
    function view2(){
        $parking = project::orderBy('id','desc')->limit(1)->get();
        return view('view2',[
            'park' => $parking
        ]);
    }
}
