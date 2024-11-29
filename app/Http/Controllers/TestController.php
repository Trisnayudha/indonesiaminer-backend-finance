<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentSponsor;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        $data = PaymentSponsor::get();
        dd($data);
    }
}
