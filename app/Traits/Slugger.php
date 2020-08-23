<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Slugger
{
    protected function slugify(string $toSlug)
    {
        $hash = Str::random(6);
        $string = Str::limit($toSlug, 40, null);

        return Str::slug($string . '-' . $hash);
    }
}
