<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {
        $data = [
            'page_title' => 'Welcome to AltHealth'
        ];
        return view('welcome')->with($data);
    }
}
