<?php

namespace App\Models;

use App\Traits\Mutator\GenUid2;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Argambar extends Model
{
    use HasFactory, GenUid2;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
       'user_id','judul', 'image', 'konten'
    ];

    /**
     * getImageAttribute
     *
     * @param  mixed $image
     * @return void
     */
    public function getImageAttribute($image)
    {
        return url('storage/Argambars/' . $image);
    }
}