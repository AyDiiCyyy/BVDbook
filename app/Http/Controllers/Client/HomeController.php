<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('client.page.index');
    }

    public function proCate($slug) {
        return view('client.page.productCategory');
    }
}
