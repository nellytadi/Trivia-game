<?php

namespace App\Http\Controllers;

use App\Trivia;

class TriviaController extends Controller
{
    public function index(){
        return Trivia::inRandomOrder()->first()->toArray();
    }
}
