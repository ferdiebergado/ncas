<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ModelCoder
{
    public function codify(string $toCode)
    {
        $code = '';
        $words = explode(' ', $toCode);
        $count = count($words);
        $position = 0;

        if ($count > 1) {
            $first = true;
            foreach ($words as $word) {
                $length = 1;
                if ($first) {
                    $length = 2;
                }
                $code .= Str::substr($word, $position, $length);
                $first = false;
            }
        } else {
            $code = Str::substr(head($words), $position, 1);
        }

        // $hash = Str::random(8);

        // $first = '';

        // if (isset($prefix)) {
        //     $first = $prefix . '-';
        // }

        return Str::upper($code);
    }
}
