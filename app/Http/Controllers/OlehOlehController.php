<?php

namespace App\Http\Controllers;

use App\Models\OlehOleh;

class OlehOlehController extends Controller
{
    public function index()
    {
        $olehOlehList = OlehOleh::orderBy('id')->get();

        return view('wisatawan.pasarDigital.oleh_oleh', compact('olehOlehList'));
    }
}