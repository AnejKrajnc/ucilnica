<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

class PDFController extends Controller
{
    public createOrderBillPDFLink() {
        Order::where('blowfish', $request->blowfish)->firstOrFail();
        
    }
}
