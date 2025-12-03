<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\MOdels\Barang;

class CartController extends Controller
{
    public function index() {
        $cart = session()->get('cart', []);
        return view('cart.index');
    }
}
