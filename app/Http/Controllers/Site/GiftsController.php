<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;

class GiftsController extends Controller
{
    public function __invoke()
    {
        $products = Product::query()
            ->where('active', true)
            ->orderBy('sort')
            ->select([
                'id',
                'title',
                'slug',
                'description',
                'price_cents',
                'min_cents',
                'max_cents',
                'cover_image',
            ])
            ->get();

        return view('gifts', compact('products'));
    }
}
