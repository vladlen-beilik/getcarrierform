<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class Zip
{
    /**
     * @return Collection
     */
    public static function get(): Collection
    {
        return collect(json_decode(File::get(public_path('zip.json'))));
    }
}
