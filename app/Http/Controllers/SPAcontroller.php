<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SPAcontroller extends Controller
{
    public function __invoke(){
        return view('backend.customers.index');
    }
}
