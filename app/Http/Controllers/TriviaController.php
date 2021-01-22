<?php

namespace App\Http\Controllers;

use App\Trivia;

class TriviaController extends Controller
{
    public function index(){
        return json_encode(Trivia::inRandomOrder()->first());
    }
}
