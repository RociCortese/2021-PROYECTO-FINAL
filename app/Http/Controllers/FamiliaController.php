<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FamiliaController extends Controller
{
    public function index()
    {    	
        return view('familia');
}
}