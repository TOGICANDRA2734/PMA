<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PopulasiPlantController extends Controller
{
    public function index()
    {
        return view('plant.index');
    }
}
