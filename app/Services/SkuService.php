<?php

namespace App\Services;

use Illuminate\Support\Str;

class SkuService
{
    public function generate(string $name): string
    {
        return strtoupper(
            Str::slug($name, '-')
        ).'-'.random_int(1000,9999);
    }
}
