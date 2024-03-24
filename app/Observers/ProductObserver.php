<?php

namespace App\Observers;

use App\Models\Product;
use Illuminate\Support\Str;

class ProductObserver
{
    public function creating(Product $product): void
    {
        $product->slug = Str::slug($product->name);
    }

    public function updating(Product $product): void
    {
        $product->slug = Str::slug($product->name);
    }
}
