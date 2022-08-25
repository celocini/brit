<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Edmarr2\D4sign\Facades\D4Sign;

class D4SignController extends Controller
{
    public function index() {
        $docs = (string) D4Sign::templates()->find()->getBody();
        $doc = (array)json_decode($docs);
        dd($doc);
        dd($doc[1]->name);
    }
}
