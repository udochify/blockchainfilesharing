<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BlockchainRegistration;

class EmailController extends Controller
{
    public function send() {
        Mail::to(auth()->user())->send(new BlockchainRegistration("your key"));
    }
}
