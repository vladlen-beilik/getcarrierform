<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

class Model
{
    /**
     * @return Collection
     */
    public static function get(): Collection
    {
        return collect(json_decode(File::get(public_path('model.json'))));
    }
}
