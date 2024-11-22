<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function contact()
    {
        return view('client.page.contact');  // Trang liên hệ
    }
}
