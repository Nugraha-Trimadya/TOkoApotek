<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingPageConntroller extends Controller
{
    public function index()
    {
       // return view : memanggil file blade
       //folder.file
       return view('home');
    }

       public function about()
    {
      //
    }

       public function contact()
   {
      //
   }

}
