<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch latest 4 games and PCs to display on the storefront
        $latestGames = Product::where('type', 'game')->latest()->take(4)->get();
        $latestPCs = Product::where('type', 'pc')->latest()->take(4)->get();

        return view('home', compact('latestGames', 'latestPCs'));
    }
}
