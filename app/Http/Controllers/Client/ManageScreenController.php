<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManageScreenController extends Controller
{
    public function index(){
        return view('pages.client.frontscreen.managescreen');
    }
}
