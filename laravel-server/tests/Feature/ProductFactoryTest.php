<?php

use App\Models\Product;

test('product factory generates unique slugs', function () {
    $slugs = Product::factory()->count(10)->make()->pluck('slug')->all();

    expect(count($slugs))->toBe(count(array_unique($slugs)));
});
