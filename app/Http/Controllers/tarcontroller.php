<?php

namespace App\Http\Controllers;
use App\project;
use App\project2;
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
        $parking2 = project2::orderBy('id','desc')->limit(1)->get();
        return view('view2',[
            'park2' => $parking2
        ]);
    }

    function fetchData(){
        $parkingA = project::orderBy('id','desc')->limit(1)->get();
        // return view('view',[
        //     'park' => $parkingA
        // ]);
        return response()->json($parkingA);

    }
}
