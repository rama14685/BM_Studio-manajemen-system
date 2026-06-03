<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['image_path', 'title', 'description'])]
class CarouselItem extends Model
{
    //
}
